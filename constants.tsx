
import React from 'react';
import { SchemaTable, IndexExplanation } from './types';

export const SCHEMA_TABLES: SchemaTable[] = [
  {
    name: 'plans',
    description: 'SaaS Tiers defining feature access and usage limits.',
    isTenantScoped: false,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'name', type: 'string', unique: true },
      { name: 'slug', type: 'string', unique: true },
      { name: 'price_monthly', type: 'decimal' },
      { name: 'features', type: 'json', comment: 'Array of enabled module keys' },
      { name: 'limits', type: 'json', comment: 'Quota definitions (e.g., whatsapp_messages: 5000)' }
    ]
  },
  {
    name: 'mosques',
    description: 'Central tenant registry holding branding and domain configuration.',
    isTenantScoped: false,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'name', type: 'string' },
      { name: 'slug', type: 'string', unique: true, index: true },
      { name: 'status', type: 'enum', comment: 'active, suspended, trialing' },
      { name: 'custom_domain', type: 'string', unique: true, nullable: true },
      { name: 'plan_id', type: 'bigint', foreignKey: { table: 'plans', on: 'id' } },
      { name: 'created_by_user_id', type: 'bigint', nullable: true, foreignKey: { table: 'users', on: 'id' } },
      { name: 'settings', type: 'json', comment: 'UI colors, prayer calculation methods' }
    ]
  },
  {
    name: 'usage_counters',
    description: 'Real-time tracking of tenant usage against plan limits.',
    isTenantScoped: true,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'mosque_id', type: 'bigint', index: true },
      { name: 'feature_name', type: 'string', index: true },
      { name: 'current_usage', type: 'integer', default: '0' },
      { name: 'reset_date', type: 'date', index: true }
    ]
  },
  {
    name: 'webhook_logs',
    description: 'History of incoming webhooks from external providers.',
    isTenantScoped: true,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'mosque_id', type: 'bigint', nullable: true, index: true },
      { name: 'provider', type: 'string', index: true },
      { name: 'verified', type: 'boolean', default: 'false' },
      { name: 'payload', type: 'json' },
      { name: 'error_message', type: 'text', nullable: true },
      { name: 'received_at', type: 'timestamp' }
    ]
  },
  {
    name: 'audit_logs',
    description: 'Platform-wide activity log for security and compliance.',
    isTenantScoped: false,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'mosque_id', type: 'bigint', nullable: true, index: true },
      { name: 'user_id', type: 'bigint', index: true },
      { name: 'event', type: 'string', index: true },
      { name: 'old_values', type: 'json', nullable: true },
      { name: 'new_values', type: 'json', nullable: true },
      { name: 'ip_address', type: 'string', nullable: true }
    ]
  },
  {
    name: 'mosque_feature_overrides',
    description: 'Granular per-tenant feature toggles ignoring plan defaults.',
    isTenantScoped: true,
    fields: [
      { name: 'id', type: 'bigint', unsigned: true, primary: true },
      { name: 'mosque_id', type: 'bigint', index: true },
      { name: 'feature_name', type: 'string' },
      { name: 'enabled', type: 'boolean' },
      { name: 'custom_limits', type: 'json', nullable: true }
    ]
  }
];

export const IMPORTANT_INDEXES: IndexExplanation[] = [
  {
    columns: ['mosque_id', 'feature_name', 'reset_date'],
    reason: 'Enforces idempotency and speeds up usage increment operations.'
  },
  {
    columns: ['status', 'plan_id'],
    reason: 'Optimizes mosque discovery for global billing and maintenance tasks.'
  },
  {
    columns: ['provider', 'received_at'],
    reason: 'Speeds up webhook auditing for high-volume message delivery reports.'
  },
  {
    columns: ['created_by_user_id'],
    reason: 'Required for reseller-scoped multi-tenancy access control.'
  }
];

export const MODULE_CODE = {
  PLATFORM_ROUTING: `Route::prefix('platform-admin')
    ->middleware(['auth:platform', 'can:access-platform'])
    ->group(function() {
        Route::get('/', [DashboardController::class, 'index']);
        Route::resource('mosques', MosquesController::class);
        Route::resource('plans', PlansController::class);
        Route::get('logs/webhooks', [LogsController::class, 'webhooks']);
        Route::post('mosques/{mosque}/suspend', [MosquesController::class, 'suspend']);
    });`,

  USAGE_ENFORCEMENT: `public function canUse(string $feature): bool 
{
    $limit = $this->plan->limits[$feature] ?? 0;
    $override = $this->overrides()->where('feature', $feature)->first();
    
    if ($override && $override->custom_limit !== null) {
        $limit = $override->custom_limit;
    }

    $usage = UsageCounter::where('mosque_id', $this->id)
        ->where('feature_name', $feature)
        ->where('reset_date', '>=', now()->startOfMonth())
        ->sum('current_usage');

    return $usage < $limit;
}`,

  RESELLER_SCOPING: `// App/Models/Mosque.php
protected static function booted()
{
    static::addGlobalScope('reseller_scoping', function (Builder $builder) {
        if (auth()->user()?->isReseller()) {
            $builder->where('created_by_user_id', auth()->id());
        }
    });
}`,

  DOCKER_STACK: `services:
  app:
    build: .
    volumes:
      - .:/var/www/html
    environment:
      - APP_ENV=production
  worker:
    command: php artisan queue:work --queue=high,default,notifications --tries=3
  cron:
    command: php artisan schedule:work
  redis:
    image: redis:alpine
  db:
    image: mysql:8.4`,

  NGINX_SAAS: `server {
    listen 80;
    server_name *.mosquesaas.com;
    root /var/www/html/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \\.php$ {
        fastcgi_pass app:9000;
        include fastcgi_params;
    }
}`,

  SUPERVISOR_CONF: `[program:saas-worker]
command=php artisan queue:work --tries=3 --max-time=3600
user=www-data
numprocs=8
autostart=true
autorestart=true`,

  TENANT_ISOLATION: `abstract class BaseTenantModel extends Model {
    protected static function booted() {
        static::addGlobalScope('mosque_isolation', function (Builder $builder) {
            $context = app(TenantContext::class);
            if ($context->id()) {
                $builder->where('mosque_id', $context->id());
            }
        });
    }
}`,

  WHATSAPP_BROADCAST: `class EnqueueBroadcastJob implements ShouldQueue {
    public function handle() {
        $subscribers = $segment->subscribers()->where('status', 'active')->get();
        foreach ($subscribers as $sub) {
            WhatsAppMessage::create([...]);
            SendWhatsAppMessageJob::dispatch($msg->id);
        }
    }
}`,

  WISH_MONEY_GATEWAY: `class WishMoneyGateway {
    public function createPayment(Donation $donation) {
        return Http::withToken($this->apiKey)
            ->post($this->url, [
                'merchant_id' => $this->merchantId,
                'amount' => $donation->amount,
                'callback_url' => route('webhook.wish'),
            ])->json('checkout_url');
    }
}`,

  PRAYER_SERVICE: `class PrayerTimesService {
    public function getTimes(Mosque $mosque, Carbon $date) {
        return Cache::remember("prayer_times_{$mosque->id}", 3600, function() {
            return Adhan::calculate($mosque->settings['method']);
        });
    }
}`,

  ROUTING_BLUEPRINT: `Route::middleware(['tenant.resolve'])->group(function() {
    // Public Worshipper Facing
    Route::get('/', [HomeController::class, 'index']);

    // Admin Protected
    Route::middleware(['auth:tenant', 'module:whatsapp'])
         ->prefix('admin')
         ->group(base_path('routes/tenant_admin.php'));
});`
};
