<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'subject' => $this->faker->text(20),
            'message' => $this->faker->text(),
            'show_to_clients' => $this->faker->boolean(50),
            'show_to_users' => $this->faker->boolean(50),
            'user_id' => 1,
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
