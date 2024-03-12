<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function storeComment(Request $request)
    {
        $request->validate([
            'comment'   => ['required'],
        ]);

        Comment::create([
            'user_id'   => auth('api')->user()->id,
            'task_id'   => $request->task_id,
            'comment'   => $request->comment,
        ]);


        return response()->json('success');
    }

    public function getComments($id)
    {
        return response()->json(Comment::where('task_id', $id)->with('user')->latest()->get());
    }

    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'comment'   => ['required'],
        ]);

        Comment::where('id', $id)->update([
            
            'comment'   => $request->comment,
        ]);


        return response()->json('success');
    }

    public function deleteComment($id)
    {
        return response()->json(Comment::where('id', $id)->delete());
    }

}
