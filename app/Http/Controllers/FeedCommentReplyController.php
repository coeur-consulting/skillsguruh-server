<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\NotificationSent;
use App\Models\FeedCommentReply;
use App\Notifications\LikeComment;
use App\Notifications\TaggedNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\FeedCommentRepliesResource;

class FeedCommentReplyController extends Controller
{
    public function store(Request $request)
    {

        if (!auth('admin')->user() && !auth('facilitator')->user() && !auth('api')->user() && !auth('organization')->user()) {
            return ('Unauthorized');
        }


        if (auth('api')->user()) {
            $user = auth('api')->user();
        }

        $data = $user->feedcommentreplies()->create([

            'message' => $request->message,
            'feed_id' => $request->feed_id,
            'feed_comment_id' => $request->feed_comment_id,

        ]);

        $feed = Feed::find($request->feed_id)->value('message');
        $body = $user->username . ' replied your comment - ' . $feed;
        $owner = User::find(FeedCommentReply::where('feed_comment_id', $request->feed_comment_id)->value('user_id'));
        $details = [
            'from_email' => 'info@nzukoor.com',
            'from_name' => 'Nzukoor',
            'greeting' => 'Hello ' . $owner->username,
            'body' => $body,
            'actionText' => 'Click to view',
            //  'url' => "https://nzukoor.com/explore/discussion/" . $request->discussion_id,

        ];

        // if (!$owner->username !== $user->username) {
        //     $owner->notify(new CommentReply($details));
        // }

        $regex = '(@\w+)';
        $tagged = [];
        if (preg_match_all($regex, $request->message, $matches, PREG_PATTERN_ORDER)) {

            foreach ($matches[0] as $word) {
                $username = User::where('username', strtolower(str_replace('@', '', $word)))->first();
                if (!is_null($username)) {
                    array_push($tagged, $username);
                }
            }
            $detail = [
                'body' => $user->username . ' mentioned you in a comment',
                'url' => 'https://nzukoor.com/member/feed/view/' . $request->feed_id
            ];

            Notification::send($tagged, new TaggedNotification($detail));
        }
        return response(new  FeedCommentRepliesResource($data->load('user')), 201);
    }
    public function replylike(Request $request)
    {

        if (auth('api')->user()) {
            $user = auth('api')->user();
        }
        $feed = FeedCommentReply::find($request->feed_comment_reply_id);
        $creator = User::find($feed->user_id);
          $mainfeed = Feed::find($feed->feed_id);
        if ($mainfeed->user_id !== $user->id) {
            return response([
                'success'=>false,
                'message'=> 'only creator allowed'
            ], 401);
        }

        $check = $user->feedcommentreplylikes()->where('feed_comment_reply_id', $request->feed_comment_reply_id)->first();
        if (is_null($check)) {
            $value =   $user->feedcommentreplylikes()->create([
                'feed_comment_reply_id' => $request->feed_comment_reply_id
            ]);

            return response()->json('success');
        } else {
            $check->delete();
            return response()->json('deleted');
        }
    }
}
