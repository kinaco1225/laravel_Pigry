<?php

namespace Database\Factories;

use App\Models\WeightTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightTargetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = WeightTarget::class;

    public function definition()
    {
        return [
            'target_weight' => $this->faker->randomFloat(1, 45, 75),
        ];
    }
}
