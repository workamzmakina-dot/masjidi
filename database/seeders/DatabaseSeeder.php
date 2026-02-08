
<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Mosque;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Platform Super Admin
        User::create([
            'name' => 'Platform Admin',
            'email' => 'admin@mosquesaas.com',
            'password' => bcrypt('password')
        ]);

        // 2. Plans
        $basic = Plan::create([
            'name' => 'Basic',
            'features' => ['prayer_times', 'announcements'],
            'limits' => ['whatsapp_messages' => 100]
        ]);

        $premium = Plan::create([
            'name' => 'Premium',
            'features' => ['donations', 'whatsapp', 'bookings', 'ai_assistant'],
            'limits' => ['whatsapp_messages' => 5000]
        ]);

        // 3. Demo Mosque
        Mosque::create([
            'name' => 'Al-Markaz Mosque',
            'slug' => 'al-markaz',
            'plan_id' => $premium->id,
            'settings' => ['primary_color' => '#065f46']
        ]);
    }
}
