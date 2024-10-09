<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'client_id' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'start_at' => Carbon::now(),
            'end_at' => Carbon::now(),
            'status_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'organisation_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
