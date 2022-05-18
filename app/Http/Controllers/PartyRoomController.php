<?php

namespace App\Http\Controllers;


use App\Models\PartyRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    public function getAllPartiesRoom()
    {
        try {
            Log::info('Init get all parties');
            $party = PartyRoom::all();

            if (empty($party)) {
                return response()->json(["success" => "There are not parties"],202);
            };
            Log::info('Get all parties');

            return response()->json($party, 200);
        } catch (\Throwable $th) {
            Log::error('Failed ⛔ to get all parties->' . $th->getMessage());

            return response()->json(['error' => 'Error, try again!'], 500);
        }
    }

    public function createPartyRoom(Request $request)
    {
        try {
            Log::info('Init create room');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            };

            $newParty = new PartyRoom();
            $newParty->name = $request->name;
            $newParty->id_game = $request->id_game;

            $newParty->save();

            return response()->json(["data" => $newParty, "success" => 'PartyRoom created, everything ok👌'], 200);
        } catch (\Throwable $th) {
            Log::error('Failed⛔to create the room->' . $th->getMessage());

            return response()->json(['error' => 'Error, try again!'], 500);
        }
    }

    public function getPartyRoomById($id) 
    {
        try {
            Log::info('Init get room by id');
            $party = DB::table('parties')->where('id_game', $id)->get();

            if (empty($party)) {
                return response()->json(["error" => "The party does not exists"],400);
            };

            return response()->json($party, 200);
        } catch (\Throwable $th) {
            Log::error('Failed to get Room by id->' . $th->getMessage());

            return response()->json(['error' => 'Error ⛔, try again!'], 500);
        }
    }

    public function updatePartyRoom(Request $request, $id)
    {
        try {
            Log::info('Update room by id');

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:140',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 404);
            };

            $party = PartyRoom::where('id', $id)->first();

            if (empty($party)) {
                return response()->json(["error" => "The party not exists"], 404);
            };

            if (isset($request->name)) {
                $party->name = $request->name;
            }

            $party->save();

            return response()->json(["data" => $party, "success" => 'party updated'], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to update the room->' . $th->getMessage());
            return response()->json(['error' => 'Error ⛔, try again!'], 500);
        }
    }

    public function deletePartyRoom($id)
    {
        try {
            Log::info('delete Room');
            $party = PartyRoom::where('id', $id)->first();

            if (empty($party)) {
                return response()->json(["error ⛔" => "The party does not exists"], 404);
            };
            $party->delete();

            return response()->json(["data" => "Party deleted"], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to deleted the room->' . $th->getMessage());
            return response()->json(['error' => 'Error⛔, try again!'], 500);
        }
    }
}
