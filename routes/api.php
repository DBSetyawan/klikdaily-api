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

Route::post('/register', 'App\Http\Controllers\API\AuthControllers@register');
Route::post('/login', 'App\Http\Controllers\API\AuthControllers@login');

Route::get('/klikdaily/stocks', 'App\Http\Controllers\API\Stocks@getAllStocks')->middleware('auth:api');
Route::post('/klikdaily/adjustment', 'App\Http\Controllers\API\Adjustment@Adjusted')->middleware('auth:api');
Route::get('/klikdaily/logs/{location_id}', 'App\Http\Controllers\API\logs@getByLogs')->middleware('auth:api');
