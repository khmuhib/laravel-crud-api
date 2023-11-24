<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DummyApiController;
use App\Http\Controllers\Api\StudentApiController;
use App\Models\User;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dummy', [DummyApiController::class, 'index']);

//protected route
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/student', [StudentApiController::class, 'index']);
    Route::post('/student', [StudentApiController::class, 'store']);
    Route::get('/student/{id}', [StudentApiController::class, 'show']);
    Route::put('/student/{id}', [StudentApiController::class, 'update']);
    Route::delete('/student/{id}', [StudentApiController::class, 'destroy']);
    Route::get('/student/search/{name}', [StudentApiController::class, 'search']);
});



Route::post('/login', [User::class, 'login']);
