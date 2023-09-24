<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        User::factory(100)->create();
        Event::factory(20)->create();
        $events = Event::all();
        foreach ($events as $event) {
            $count_relation = random_int(1, 10);
            $user_ids = User::query()
                ->whereNot('id', $event->user_id)
                ->inRandomOrder()->take($count_relation)->get();
            $event->users()->toggle($user_ids);
        }
    }
}
