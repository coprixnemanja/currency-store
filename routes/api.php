<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('currency/{id}', [CurrencyController::class,'show']);
Route::get('currency/{id}/calculate-price', [CurrencyController::class,'calculatePrice']);
Route::post('currency/{id}/buy', [CurrencyController::class,'buy']);
