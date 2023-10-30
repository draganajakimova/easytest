<?php

namespace Database\Factories;

use App\Http\Controllers\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->text,
        ];
    }
}
