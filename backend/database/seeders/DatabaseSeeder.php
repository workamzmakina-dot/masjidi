<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Plan;
use App\Models\Mosque;
use App\Models\User;
use App\Models\MosqueUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $platformAdmin = User::create([
            'name' => 'Platform Admin',
            'email' => 'admin@mosquesaas.com',
            'password' => bcrypt('password')
        ]);

        $features = collect([
            ['name' => 'prayer_times', 'display_name' => 'Prayer Times'],
            ['name' => 'lectures', 'display_name' => 'Lectures'],
            ['name' => 'events', 'display_name' => 'Events'],
            ['name' => 'fatwas', 'display_name' => 'Fatwas'],
            ['name' => 'campaigns', 'display_name' => 'Campaigns'],
            ['name' => 'donations', 'display_name' => 'Donations'],
            ['name' => 'whatsapp', 'display_name' => 'WhatsApp Notifications'],
            ['name' => 'ramadan', 'display_name' => 'Ramadan Settings'],
            ['name' => 'announcements', 'display_name' => 'Announcements'],
            ['name' => 'qrcodes', 'display_name' => 'QR Codes'],
            ['name' => 'branding', 'display_name' => 'White-label Branding'],
        ])->map(fn ($feature) => Feature::create($feature));

        $basic = Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price_monthly' => 29.00,
            'limits' => ['whatsapp_messages' => 100]
        ]);

        $premium = Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price_monthly' => 99.00,
            'limits' => ['whatsapp_messages' => 5000]
        ]);

        $basic->features()->attach($features->whereIn('name', ['prayer_times', 'announcements', 'events'])->pluck('id'));
        $premium->features()->attach($features->pluck('id'));

        $mosque = Mosque::create([
            'name' => 'Al-Markaz Mosque',
            'slug' => 'al-markaz',
            'plan_id' => $premium->id,
            'settings' => ['primary_color' => '#065f46'],
            'status' => 'active'
        ]);

        MosqueUser::create([
            'mosque_id' => $mosque->id,
            'name' => 'Mosque Admin',
            'email' => 'admin@al-markaz.org',
            'password' => bcrypt('password')
        ]);

        $this->call(Step3DemoSeeder::class);
    }
}
