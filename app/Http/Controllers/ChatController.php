<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function newChat(Request $request, $partyId)
    {
        try {
            Log::info('Init create message');
            $userId = auth()->user()->id;
            $userIn = DB::table('partyroom_user')->where('id_user', $userId)->where('partyroom_id', $partyId)->get()->toArray();

            if ($userIn) {
                $validator = Validator::make($request->all(), [
                    'message' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 404);
                };
                $newMessage = new Chat();
                $newMessage->message = $request->message;
                $newMessage->id_party = $partyId;
                $newMessage->id_user = $userId;
                $newMessage->save();

                return response()->json(["data" => $newMessage, "success" => 'You Post a new Message'], 200);
            };
        } catch (\Throwable $th) {
            Log::error('Failed to post the message' . $th->getMessage());
            return response()->json(['error' => 'Error, try again!'], 500);
        }
    }
}
