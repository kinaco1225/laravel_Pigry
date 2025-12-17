<?php

namespace Database\Factories;

use App\Models\WeightLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = WeightLog::class;


    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 45, 80),
            'calories' => $this->faker->numberBetween(1200, 3000),
            'exercise_time' => $this->faker->time('H:i'),
            'exercise_content' => $this->faker->sentence(),  
        ];
    }
}
