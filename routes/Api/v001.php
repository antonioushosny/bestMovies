<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V001\MovieController;
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
Route::prefix('/v001')->name('v001.')->group(function () {
    Route::group(['middleware' =>['cors','check_secret_key']], function () {

        Route::get('movies', [MovieController::class, 'index']);
        Route::get('movies/{id}', [MovieController::class, 'show']);
        Route::post('movies', [MovieController::class, 'store']);
        Route::put('movies/{id}', [MovieController::class, 'update']);
        Route::delete('movies/{id}', [MovieController::class, 'destroy']);
        Route::post('movies/{id}/favorite', [MovieController::class, 'favorite']);
    });

});
