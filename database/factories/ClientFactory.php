<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'website' => $this->faker->word(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'zip_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'user_id' => 1,
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
