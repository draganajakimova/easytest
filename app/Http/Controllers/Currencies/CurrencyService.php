<?php

namespace App\Http\Controllers\Currencies;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Currencies\Models\Currency;

class CurrencyService
{
    protected $model;
    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    public function getAll(array $request_data)
    {
        $currencies = $this->model::query();

        if (isset($request_data['currency'])) {
            $currencies->where('code', $request_data['currency']);
        }

        return $currencies->select('uuid', 'code', 'name')->get();
    }
}
