<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->any('/fixer/{url}', 'Fixer\FixerController@proxy');

    $api->group(['prefix' => 'currencies'], function ($api) {
        $api->get('/', 'Currencies\CurrencyController@getAll');
    });

    $api->group(['prefix' => 'convert'], function ($api) {
        $api->post('/', 'Conversion\ConversionController@convertCurrency');
    });
});
