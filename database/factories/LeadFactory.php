<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'position' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'mobile' => $this->faker->word(),
            'lost' => $this->faker->boolean(),
            'company' => $this->faker->company(),
            'status_id' => 1,
            'source_id' => 1,
            'country' => $this->faker->country(),
            'website' => $this->faker->word(),
            'assigned_user_id' => User::factory(),
            'description' => $this->faker->text(),
            'important' => $this->faker->boolean(),
            'last_contact_at' => Carbon::now(),
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
