<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'position' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'primary_contact' => $this->faker->boolean(),
            'phone' => $this->faker->phoneNumber(),
            'active' => $this->faker->boolean(),
            'last_login_at' => Carbon::now(),
            'organisation_id' => 1,
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'client_id' => Client::factory(),
        ];
    }
}
