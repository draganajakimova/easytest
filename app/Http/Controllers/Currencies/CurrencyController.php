<?php

namespace App\Http\Controllers\Currencies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    protected $service;
    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function getAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency' => 'filled|string|exists:currencies,code'
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        return $this->service->getAll($request->all());
    }
}
