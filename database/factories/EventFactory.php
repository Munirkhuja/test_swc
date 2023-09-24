<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        $count_user = User::query()->count();
        return [
            'title' => fake()->text(50),
            'text' => fake()->realText(),
            'user_id' => random_int(1, $count_user),
        ];
    }
}
