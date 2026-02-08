<?php

namespace Database\Seeders;

use App\Models\Mosque;
use App\Models\MosqueUser;
use App\Models\Speaker;
use App\Models\Lecture;
use App\Models\Event;
use App\Models\FatwaCategory;
use App\Models\FatwaQuestion;
use App\Models\Campaign;
use App\Models\Alert;
use App\Models\PrayerSetting;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Step3DemoSeeder extends Seeder
{
    public function run()
    {
        $mosques = Mosque::all();

        foreach ($mosques as $mosque) {
            // Context binding for Step 3 logic (BaseTenantModel scopes)
            app()->instance(Mosque::class, $mosque);

            // 1. Prayer Settings
            PrayerSetting::create([
                'mosque_id' => $mosque->id,
                'method' => 'MWL',
                'timezone' => 'Asia/Beirut',
                'latitude' => 33.8938,
                'longitude' => 35.5018,
                'iqama_offsets' => ['fajr' => 25, 'dhuhr' => 15, 'asr' => 15, 'maghrib' => 10, 'isha' => 15]
            ]);

            // 2. Speaker
            $speaker = Speaker::create([
                'mosque_id' => $mosque->id,
                'name' => 'Sheikh Dr. Abdullah Ahmad',
                'title' => 'Head Imam',
                'bio' => 'A scholar with 20 years of experience in Fiqh and Hadith.'
            ]);

            // 3. 10 Lectures
            for ($i = 1; $i <= 10; $i++) {
                Lecture::create([
                    'mosque_id' => $mosque->id,
                    'speaker_id' => $speaker->id,
                    'title' => "Understanding Chapter {$i} of the Quran",
                    'type' => $i % 2 == 0 ? 'video' : 'audio',
                    'external_url' => 'https://youtube.com/watch?v=demo',
                    'is_public' => true,
                    'recorded_at' => Carbon::now()->subDays($i)
                ]);
            }

            // 4. 10 Announcements / Lessons
            for ($i = 1; $i <= 10; $i++) {
                Event::create([
                    'mosque_id' => $mosque->id,
                    'title' => "Community Lesson #{$i}",
                    'description' => "Join us for a spiritual gathering discussing community values.",
                    'start_at' => Carbon::now()->addDays($i)->setHour(18),
                    'end_at' => Carbon::now()->addDays($i)->setHour(20),
                    'location' => 'Main Hall'
                ]);
            }

            // 5. 10 Q&A (Fatwa)
            $cat = FatwaCategory::create(['mosque_id' => $mosque->id, 'name' => 'General Fiqh']);
            $adminUser = MosqueUser::where('mosque_id', $mosque->id)->first();

            for ($i = 1; $i <= 10; $i++) {
                FatwaQuestion::create([
                    'mosque_id' => $mosque->id,
                    'category_id' => $cat->id,
                    'user_name' => "Brother {$i}",
                    'question' => "What is the ruling on action #{$i} during prayer?",
                    'answer' => $i > 5 ? "The ruling is that it is permissible under these conditions..." : null,
                    'status' => $i > 5 ? 'published' : 'pending',
                    'is_public' => true,
                    'answered_by' => $i > 5 ? ($adminUser->id ?? null) : null,
                ]);
            }

            // 6. 3 Campaigns
            for ($i = 1; $i <= 3; $i++) {
                Campaign::create([
                    'mosque_id' => $mosque->id,
                    'title' => "Project #{$i}: New Roof Renovation",
                    'description' => "Help us keep our community dry during the winter season.",
                    'goal_amount' => 5000 * $i,
                    'current_amount' => 1200,
                    'is_active' => true
                ]);
            }

            // 7. 1 Emergency Alert
            Alert::create([
                'mosque_id' => $mosque->id,
                'message' => 'Winter storm warning: Jumaa prayers will be held at limited capacity.',
                'type' => 'warning',
                'starts_at' => now(),
                'ends_at' => now()->addDays(2),
                'is_active' => true
            ]);
        }
    }
}