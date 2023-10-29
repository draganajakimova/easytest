<?php

namespace App\Http\Controllers\Currencies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected $service;
    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function getAll(Request $request)
    {
        return $this->service->getAll();
    }
}
