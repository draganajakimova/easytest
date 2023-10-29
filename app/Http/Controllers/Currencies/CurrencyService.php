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

    public function getAll()
    {
        return $this->model->select('uuid', 'code', 'name')->get();
    }
}
