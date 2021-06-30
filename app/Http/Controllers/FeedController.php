<?php

namespace App\Http\Controllers;

use App\Events\AddFeed;
use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guestfeeds()
    {
        return Feed::with('admin', 'user', 'facilitator', 'comments', 'likes', 'stars')->latest()->get();
    }
    public function index()
    {
        if (auth('admin')->user()) {
            $user = auth('admin')->user();
            $type = 'admin';
        }
        if (auth('facilitator')->user()) {
            $user = auth('facilitator')->user();
            $type = 'facilitator';
        }
        if (auth('api')->user()) {
            $user = auth('api')->user();
            $type = 'user';
        }
        return Feed::with('admin', 'user', 'facilitator', 'comments', 'likes', 'stars')->where('organization_id', $user->organization_id)->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth('admin')->user()) {
            $user = auth('admin')->user();
            $type = 'admin';
        }
        if (auth('facilitator')->user()) {
            $user = auth('facilitator')->user();
            $type = 'facilitator';
        }
        if (auth('api')->user()) {
            $user = auth('api')->user();
            $type = 'user';
        }


        $data = $user->feeds()->create([
            'organization_id' => $user->organization_id,
            'media' => $request->media,
            'url' => $request->url,
            'message' => $request->message
        ]);
        broadcast(new AddFeed($user, $data->load('admin', 'user', 'facilitator', 'comments', 'likes', 'stars')))->toOthers();
        return $data->load('admin', 'user', 'facilitator', 'comments', 'likes', 'stars');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function show(Feed $feed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function edit(Feed $feed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feed $feed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feed $feed)
    {
        $feed->delete();
        return response()->json([
            'message' => 'Delete successful'
        ]);
    }
}
