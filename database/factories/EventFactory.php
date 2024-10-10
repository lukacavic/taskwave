<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        $startHour = $this->faker->numberBetween(0, 23);
        $startDate = Carbon::parse($date)->hour($startHour);
        $endDate = Carbon::parse($date)->hour($startHour + 2);

        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'user_id' => 1,
            'color' => $this->faker->hexColor(),
            'public' => $this->faker->boolean(40),
            'organisation_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
