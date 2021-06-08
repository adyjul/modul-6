<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AdidasController;
use App\Http\Controllers\NikeController;
use App\Http\Controllers\PumaController;
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

Route::prefix('v1')->group(function(){
    Route::prefix('auth')->group(function(){
        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);
        Route::post('logout',[AuthController::class,'logout']);
        Route::post('refresh',[AuthController::class,'refresh']);
        Route::post('me',[AuthController::class,'me']);
    });
    Route::middleware('jwt.verify')->group(function(){
        Route::apiResource('adidas', AdidasController::class, [
            'as'=>'api'
         ]);
        // Route::apiResource('nike', NikeController::class, [
        //     'as'=>'api'
        // ]);
        Route::apiResource('puma', PumaController::class, [
            'as'=>'api'
        ]);
    });
});

Route::any('{any}', function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Resourcenotfound'], 404);
})->where('any', '.*');