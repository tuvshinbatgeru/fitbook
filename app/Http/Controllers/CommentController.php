<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests;
use App\Mentionable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function reaction(Comment $comment, Request $request)
    {
        $action = \App\Reaction::makeModel($request->action_type);
        $response = Auth::user()->toggleReaction($action, $comment);        

        return Response::json([
            'code' => 0,
            'type' => $response,
            'message' => 'Thumbs upped :D', 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $decode = json_decode($request->data);

        $comment = new Comment;
        $comment->message = stripslashes($decode->message);
        $comment->commentable_id = $decode->commentable_id;
        $comment->commentable_type = $decode->commentable_type;
        $comment->user_id = Auth::user()->id;

        $comment->save();

        foreach ($decode->tags as $key => $tag) {
            Mentionable::mentionedBy($comment, User::where('username', $tag)->first());
        }

        return Response::json([
            'code' => 0,
            'result' => $comment,
            'message' => 'Successfully added comment',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
