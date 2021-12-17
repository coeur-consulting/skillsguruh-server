<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inbox;
use App\Events\MessageSent;
use App\Http\Resources\ChatHistoryResource;
use App\Models\Facilitator;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use App\Notifications\NewMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\InboxResource;
use App\Http\Resources\SingleInboxResource;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth('admin')->user() && !auth('facilitator')->user() && !auth('api')->user() && !auth('organization')->user()) {
            return ('Unauthorized');
        }

        if (auth('api')->user()) {
            $user = auth('api')->user();
            $data = Inbox::where('receiver_id',  $user->id)->orWhere('user_id', $user->id)->get();
        }


        return ChatHistoryResource::collection($data);
    }

    public function getchathistory($id)
    {

        if (auth('api')->user()) {
            $user = auth('api')->user();
            $data = Inbox::where([['user_id', '=', $id], ['receiver_id', '=', $user->id]])
                ->orWhere([['receiver_id', '=', $id], ['user_id', '=', $user->id]])->get();
        }
        $unread  = $data->filter(function ($a) use ($user) {
            return !$a['is_read'] && $a['receiver_id'] == $user->id;
        })->count();

        $lastmessage = $data->last();
        $messages = ChatHistoryResource::collection($data);

        return response([
            "unreadCount" => $unread,
            "lastMessage" => $lastmessage,
            'message' => $messages,
        ], 200);
    }


    public function store(Request $request)
    {
        if (!auth('admin')->user() && !auth('facilitator')->user() && !auth('api')->user() && !auth('organization')->user()) {
            return ('Unauthorized');
        }
        return $result =  DB::transaction(function () use ($request) {

            if (auth('api')->user()) {
                $user = auth('api')->user();
                $sender_type = null;
                $receiver = User::find($request->receiver_id);
            }



            $message = $user->inbox()->create([
                'message' => $request->message,
                'attachment' => $request->attachment,
                'receiver' => 'user',
                'receiver_id' => $request->receiver_id,
                'voicenote' => $request->voicenote,
                'status' => false,

            ]);
            $title = $user->username . ' sent you a message ';
            $detail = [
                'title' => $title,
                'message' => $request->message,
                'image' => $user->profile
            ];


            $data = $message->load('user');
             broadcast(new MessageSent($receiver, new ChatHistoryResource($data)))->toOthers();


             $receiver->notify(new NewMessage($detail));
            return new ChatHistoryResource($data);
        });
    }

    public function markread(Request $request)
    {

        $message =  Inbox::whereIn('id', $request->ids)->update(['status' => true, 'is_read' => true]);
        return response()->json([
            'success' => true,
            'message' => 'updated',
            'data' => $message
        ]);
    }
    public function markunread(Request $request)
    {

        $id = $request->id;
        $user = auth('api')->user();
        $data = Inbox::where([['user_id', '=', $id], ['receiver_id', '=', $user->id]])
            ->orWhere([['receiver_id', '=', $id], ['user_id', '=', $user->id]])->get();

         $ids  = $data->filter(function ($a) use ($user) {
            return !$a['is_read'] && $a['receiver_id'] == $user->id;
        })->pluck('id',);

        $message =  Inbox::whereIn('id', $ids)->update(['status' => true, 'is_read' => true]);
        return response()->json([
            'success' => true,
            'message' => 'updated',

        ]);
    }
    public function getunreadmessages(){
        $user = auth('api')->user();
        $data = Inbox::where('receiver_id',  $user->id)->orWhere('user_id', $user->id)->latest()->get()->filter(function($a){
            return !$a->is_read;
        });
        return ChatHistoryResource::collection($data);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inbox  $inbox
     * @return \Illuminate\Http\Response
     */
    public function markDelivered($id)
    {
        $inbox = Inbox::find($id);
        $inbox->status = 'delivered';
        $inbox->save();
        return $inbox;
    }


    public function update(Request $request, Inbox $inbox)
    {
        //
    }


    public function destroy(Inbox $inbox)
    {
        $inbox->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
}
