<?php

namespace Database\Factories;

use App\Http\Controllers\Conversion\Models\Conversion;
use App\Http\Controllers\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversionFactory extends Factory
{
    protected $model = Conversion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'source_currency_value' => $this->faker->randomFloat(),
            'target_currency_value' => $this->faker->randomFloat(),
            'source_currency_id' => Currency::factory()->create()->id,
            'target_currency_id' => Currency::factory()->create()->id,
            'exchange_rate' => $this->faker->randomFloat()
        ];
    }
}
