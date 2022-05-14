<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
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
            //$contacts = Contact::find(7)->user;

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

    public function getGameById($id)
    {
        try {
            Log::info('init get all contacts');
            $games = Game::where('id', $id)->where('user_id', 1)->first();
            if (empty($games)) {
                return response()->json(["sucess" => "game no exits"], 404);
            }
            return response()->json($games, 200);
        } catch (\Throwable $th) {
            Log::error('ha ocurrido un error->' . $th->getMessage());
            return response()->json(["error" => "upps"], 500);
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

