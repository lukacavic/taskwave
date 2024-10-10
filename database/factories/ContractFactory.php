<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'contract_value' => $this->faker->numberBetween(100, 12000),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'user_id' => 1,
            'subject' => $this->faker->text(20),
            'description' => $this->faker->text(),
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type_id' => ContractType::factory(),
        ];
    }
}
