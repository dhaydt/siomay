<?php

use App\Http\Controllers\Api\Auth\LoginController;
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

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function () {
    Route::get('testing', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'API Working good',
        ], 200);
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', [LoginController::class, 'login']);
    });
});
