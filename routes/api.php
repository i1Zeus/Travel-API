<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TravelController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth\LoginController;

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

//* get all travel
Route::get('travels', [TravelController::class, 'index']);

//* get all tours for a travel
Route::get('travels/{travel:slug}/tours', [TourController::class, 'index']);

//* Admin routes
Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {

    //* create a travel
    Route::post('travels', [Admin\TravelController::class, 'store']);

    //* create a tour for a travel
    Route::post('travels/{travel}/tours', [Admin\TourController::class, 'store']);
});

//* Login
Route::post('login', LoginController::class);
