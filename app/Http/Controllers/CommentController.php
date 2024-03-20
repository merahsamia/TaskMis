<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;

use App\Notifications\TaskNotification;

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

        $task = Task::findOrFail($request->task_id);

        $users_array = [];

        array_push($users_array, auth('api')->user()->id);  
        array_push($users_array, $task->user_id);
        
        foreach($task->users as $user) {
            array_push($users_array, $user->id);
        }


        $message = 'New Comment';

        foreach($users_array as $user_id) {

            if(auth('api')->user()->id != $user_id) {

                $userToNotify = User::findOrFail($user_id);
                $userToNotify->notify(new TaskNotification(auth('api')->user(), $task, $message));
            }
        };

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

        $task = Task::findOrFail($request->task_id);

        $users_array = [];

        array_push($users_array, auth('api')->user()->id);  
        array_push($users_array, $task->user_id);
        
        foreach($task->users as $user) {
            array_push($users_array, $user->id);
        }


        $message = 'Comment updated';

        foreach($users_array as $user_id) {

            if(auth('api')->user()->id != $user_id) {

                $userToNotify = User::findOrFail($user_id);
                $userToNotify->notify(new TaskNotification(auth('api')->user(), $task, $message));
            }
        };


        return response()->json('success');
    }

    public function deleteComment($id)
    {
        return response()->json(Comment::where('id', $id)->delete());
    }

}
