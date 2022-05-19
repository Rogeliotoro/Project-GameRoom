<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function getAllGames()
    {
        try {
            Log::info('init get all games');
            $userId = auth()->user()->id;
            $games = User::find($userId)->games;
            //$games = Game::find(1)->user;
            $games = Game::where('id_user', $userId)->get()->toArray();
            if (empty($games)) {
                return response()->json(["sucess" => "game no exits"], 404);
            }
            return response()->json($games, 200);
        } catch (\Throwable $th) {
            Log::error('ha ocurrido un error->' . $th->getMessage());
            return response()->json(["error" => "upps"], 500);
        }
    }

    public function gameById($id)
    {
        try {
            $userId = auth()->user()->id;
            $game = DB::table('games')->where('id_user', $userId)->where('id_user', $id)->get();
            if (empty($game)) {
                return response()->json(
                    ["error" => "We do not have this game"],
                    400
                );
            };

            return response()->json($game, 200);
        } catch (\Throwable $th) {
            Log::error('Fail, can not get game by id -> ' . $th->getMessage());

            return response()->json(['error' => 'Error, try again!'], 500);
        }
    }

    public function gameByName($name) // By Title, 
    {
        try {
            Log::info('Get a game by name');
            $game = DB::table('games')->where('name', $name)->get();
            if (empty($game)) {
                return response()->json(
                    ["error" => "this game no exists"],400);
            };

            return response()->json($game, 200);
        } catch (\Throwable $th) {
            Log::error('Fail, can not get game by name -> ' . $th->getMessage());
            return response()->json(['error' => 'Error, try again!'], 500);
        }
    }

    public function createGame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $userId = auth()->user()->id;
        $newGame = new Game();
        $newGame->name = $request->name;
        $newGame->category = $request->category;
        $newGame->id_user = $userId;

        $newGame->save();
        //$contact=$request->all();
        //$newContact= Contact::create($contact);

        return response()->json(["success" => $newGame, 200]);
    }

    public function updateGame(Request $request, $id)
    {
        $game = Game::where('id', $id)->where('id_user', 1)->first();

        if (empty($game)) {
            return response()->json(["error" => "game not exists", 404]);
        }

        if (isset($request->name)) {
            $game->name = $request->name;
        }
        if (isset($request->category)) {
            $game->surname = $request->category;
        }
        $game->save();
        return response()->json(["data" => $game, 200]);
    }

    public function deleteGame($id)
    {
        $game = Game::where('id', $id)->where('id_user', 1)->first();

        if (empty($game)) {
            return response()->json(["error" => "game not exists", 404]);
        }
        $game->delete();
        return 'Delete by id: ' . $id;
    }
}
