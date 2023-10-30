<?php

namespace Tests\Feature;

use App\Http\Controllers\Currencies\Models\Currency;
use App\Http\Controllers\Fixer\FixerService;
use Tests\TestCase;

class ConversionTest extends TestCase
{
    public function testConversionSucceeds()
    {
        // Defining the test input data
        $requestData = [
            'source_currency' => 'USD',
            'target_currency' => 'EUR',
            'value' => 100,
        ];

        // Creating a sample exchange rate
        $exchangeRateData = [
            'success' => true,
            'rates' => [
                'USD' => 1.05
            ]
        ];

        // Mocking the FixerService to return the exchange rate data
        $this->app->bind(FixerService::class, function () use ($exchangeRateData) {
            $fixerService = $this->createMock(FixerService::class);
            $fixerService->method('proxy')->willReturn($exchangeRateData);

            return $fixerService;
        });

        // Testing the convertCurrency method
        $response = $this->postJson(config('url').'/api/convert', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Successfully converted!',
                'converted_amount' => 95.24,
            ]);

        // Checking if the conversion record is created in the database
        $this->assertDatabaseHas('conversion_info', [
            'source_currency_id' => Currency::where('code', 'USD')->value('id'),
            'target_currency_id' => Currency::where('code', 'EUR')->value('id'),
            'source_currency_value' => 100,
            'target_currency_value' => 95.24,
            'exchange_rate' => 1.05
        ]);


        // Testing the validation
        $requestData = [
            'source_currency' => 'EUR',
            'target_currency' => 'USD',
            'value' => 100,
        ];

        $response = $this->postJson(config('url').'/api/convert', $requestData);

        $response->assertStatus(422)
            ->assertJson([
                "errors" => [
                    "The target currency must be EUR."
                ]
            ]);
    }
}
