<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// out auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

// Users 🙋
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/users', [UserController::class, 'getAllusers']);
    Route::get('/users/{id}', [UserController::class, 'getusersById']);
    Route::post('/users', [UserController::class, 'createNewUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUserById']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);
});

// Parties Room 🤪
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/party', [PartyController::class, 'createPartyRoom']);
    Route::get('/parties', [PartyController::class, 'getAllPartiesRoom']);
    Route::get('/party/{id}', [PartyController::class, 'getPartyRoomById']);
    Route::put('/party/{id}', [PartyController::class, 'updatePartyRoom']);
    Route::delete('/party/{id}', [PartyController::class, 'deletePartyRoom']);
});

//Game🎮🕹️
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::get('/games/{id}', [GameController::class, 'getGameById']);
    Route::post('/games', [GameController::class, 'createGame']);
    Route::get('/game/name/{name}', [GameController::class, 'gameByname']);  
    Route::patch('/games/{id}', [GameController::class, 'updateGame']);
    Route::delete('/games/{id}', [GameController::class, 'deleteGame']);
});

//chat👩‍💻 
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/chat/{id}', [ChatController::class, 'newchat']);    
Route::get('/chats', [ChatController::class, 'getchats']); // all messages of user loged
Route::put('/message/{id}', [ChatController::class, 'updateChat']); //message id, only can edit the owner of message
Route::delete('/message/{id}', [ChatController::class, 'deleteChat']);
});