<?php

namespace App\Http\Controllers\Conversion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConversionController extends Controller
{
    protected $service;
    public function __construct(ConversionService $service)
    {
        $this->service = $service;
    }

    public function convertCurrency(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source_currency' => 'required|string|exists:currencies,code',
            'target_currency' => 'required|string|in:EUR', // the target currency can only be EUR because it's the only one accessible by the free fixer.io subscription
            'value' => 'required|numeric'
        ], [
            'target_currency.in' => 'The target currency must be EUR.',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        return $this->service->convertCurrency($request->all());
    }
}
