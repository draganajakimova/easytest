<?php

namespace App\Http\Controllers\Fixer;

use Illuminate\Support\Facades\Http;

class FixerService
{
    public function proxy($request_method, $path, $data = null)
    {
        $fixer_url = config('app.fixer_url');
        $fixer_api_key = config('app.fixer_api_key');

        switch ($request_method) {
            case 'GET': {
                $response = Http::get($fixer_url. $path .'?access_key='.$fixer_api_key);
                return $response->json();
            }
            case 'POST': {
                $response = Http::post($fixer_url. $path .'?access_key='.$fixer_api_key, $data);
                return $response->json();
            }
            default:
                break;
        }
    }
}
