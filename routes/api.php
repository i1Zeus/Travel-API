<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TravelController;
use App\Http\Controllers\Api\V1\TourController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('travels', [TravelController::class, 'index']);

// Route::get('travels/{slug}/tours', [TourController::class, 'getToursByTravelSlug']);
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);
// 
