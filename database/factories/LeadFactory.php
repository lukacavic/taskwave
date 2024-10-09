<?php

namespace Database\Factories;

use App\Models\Lead;
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
            'client_id' => $this->faker->randomNumber(),
            'client_converted_at' => Carbon::now(),
            'status_id' => $this->faker->randomNumber(),
            'source_id' => $this->faker->randomNumber(),
            'country' => $this->faker->country(),
            'website' => $this->faker->word(),
            'assigned_user_id' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'important' => $this->faker->boolean(),
            'last_contact_at' => Carbon::now(),
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
