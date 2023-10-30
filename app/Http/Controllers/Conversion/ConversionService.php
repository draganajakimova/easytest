<?php

namespace App\Http\Controllers\Conversion;

use App\Http\Controllers\Conversion\Models\Conversion;
use App\Http\Controllers\Currencies\Models\Currency;
use App\Http\Controllers\Fixer\FixerService;

class ConversionService
{
    protected $conversionModel, $currencyModel, $fixerService;
    public function __construct(Conversion $conversionModel, Currency $currencyModel, FixerService $fixerService)
    {
        $this->conversionModel = $conversionModel;
        $this->currencyModel = $currencyModel;
        $this->fixerService = $fixerService;
    }

    public function convertCurrency(array $request_data)
    {
        $sourceCurrency = $request_data['source_currency']; // This is only for better readability
        $targetCurrency = $request_data['target_currency'];
        $sourceCurrencyValue = $request_data['value'];

        // Fetch the exchange rate from the Fixer API
        $exchangeRate = $this->fetchExchangeRate($sourceCurrency, $targetCurrency);

        if ($exchangeRate) {
            $targetCurrencyValue = round($sourceCurrencyValue / $exchangeRate, 2);

            // Create a new conversion record
            $this->createConversionRecord($sourceCurrency, $targetCurrency, $sourceCurrencyValue, $targetCurrencyValue, $exchangeRate);

            // Return a formatted response
            return response()->json([
                'message' => 'Successfully converted!',
                'converted_amount' => $targetCurrencyValue
            ], 201);
        }

        return null;
    }

    private function fetchExchangeRate($sourceCurrency, $targetCurrency)
    {
        $exchangeRateData = $this->fixerService->proxy('GET', "latest&base=$targetCurrency&symbols=$sourceCurrency");

        if ($exchangeRateData['success']) {
            return $exchangeRateData['rates'][$sourceCurrency];
        }

        return null;
    }

    private function createConversionRecord($sourceCurrency, $targetCurrency, $sourceCurrencyValue, $targetCurrencyValue, $exchangeRate)
    {
        Conversion::create([
            'source_currency_id' => $this->currencyModel->where('code', $sourceCurrency)->value('id'),
            'target_currency_id' => $this->currencyModel->where('code', $targetCurrency)->value('id'),
            'source_currency_value' => $sourceCurrencyValue,
            'target_currency_value' => $targetCurrencyValue,
            'exchange_rate' => $exchangeRate
        ]);
    }
}
