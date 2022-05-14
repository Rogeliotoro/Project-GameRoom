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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Game
Route::get('/games', [GameController::class, 'getAllGames']);
Route::get('/games/{id}', [GameController::class, 'getGameById']);
Route::post('/games', [GameController::class, 'createGame']);
Route::patch('/games/{id}', [GameController::class, 'updateGame']);
Route::delete('/games/{id}', [GameController::class, 'deleteGame']);
