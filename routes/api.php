<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ApiController Routes

Route::post("register", [ApiController::Class, 'register']);
Route::post("login", [ApiController::Class, 'login']);

Route::group([
    "middleware" => "auth:api"
], function(){
    Route::get("profile", [ApiController::Class, 'profile']);
    Route::get("refreshToken", [ApiController::Class,'refreshToken']);
    Route::get("logout", [ApiController::Class, 'logout']);
});

