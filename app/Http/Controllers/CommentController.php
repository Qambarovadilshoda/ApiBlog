<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request){
        $post = Post::findOrFail($request->post_id);
        $post->comments()->create([
            'user_id'=> Auth::id(),
            'post_id'=> $post->id,
            'message'=> $request->message,
        ]);
        return response()->json(['message'=> 'Comment saved!'],201);
    }
    public function destroy($id){
        $comment = Comment::findOrFail($id);
        if(Auth::id() !== $comment->user_id){
            abort(403);
        }
        $comment->delete();
        return response()->noContent(204);
    }

}
