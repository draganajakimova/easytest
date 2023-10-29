<?php

namespace App\Http\Controllers\Conversion;

use App\Http\Controllers\Controller;
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
        $source_currency = $request_data['source_currency'];
        $target_currency = $request_data['target_currency'];
        $source_currency_value = $request_data['value'];

        $source_currency_rate = $this->fixerService->proxy('GET', 'latest&base='.$target_currency.'&symbols='.$source_currency);

        if ($source_currency_rate['success']) {
            $exchange_rate = $source_currency_rate['rates'][$source_currency];

            $target_currency_value = $source_currency_value / $exchange_rate;

            Conversion::create([
                'source_currency_id' => $this->currencyModel->where('code', $request_data['source_currency'])->value('id'),
                'target_currency_id' =>  $this->currencyModel->where('code', $request_data['target_currency'])->value('id'),
                'source_currency_value' => $source_currency_value,
                'target_currency_value' => $target_currency_value,
                'exchange_rate' => $exchange_rate
            ]);

            // Return formatted with relevant information response
            return response()->json([
                'message' => 'Successfully converted!',
                'converted_amount' => round($target_currency_value, 2)
            ],201);
        }

        return null;
    }
}
