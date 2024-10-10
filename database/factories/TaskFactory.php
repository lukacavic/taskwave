<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'user_id' => 1,
            'related_id' => 1,
            'related_type' => Client::class,
            'priority_id' => $this->faker->numberBetween(1, 3),
            'status_id' => $this->faker->numberBetween(1, 5),
            'completed_at' => Carbon::now(),
            'start_at' => Carbon::now(),
            'deadline_at' => Carbon::now(),
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
