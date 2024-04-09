<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

use App\Notifications\TaskNotification;
use App\Notifications\TaskEmailNotification;
use Notification;

use App\Events\NotificationEvent;

class TaskController extends Controller
{
    public function tasksIndex()
    {
        return view('tasks.index');
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'priority' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'description' => ['required'],
            'assign_to' => ['required', 'array']
        ]);

        if(isset($request->parent_id)) {
            $parent_id = $request->parent_id;
        }else {
            $parent_id = 0;
        }

        $task = Task::create([
            'user_id' => auth('api')->user()->id,
            'department_id' => auth('api')->user()->department_id,
            'parent_id' => $parent_id,
            'title' => $request->title,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            
        ]);

        $task->users()->sync($request->assign_to);

        $message = 'New Task';

        foreach($request->assign_to as $user_id) {
            $userToNotify = User::findOrFail($user_id);
            $userToNotify->notify(new TaskNotification(auth('api')->user(), $task, $message));
            Notification::send($userToNotify, new TaskEmailNotification(auth('api')->user(), $task, $message));
        };

        broadcast(new NotificationEvent())->toOthers();


        return response()->json('success');
    }

    public function getTasks()
    {
        $user_role = auth('api')->user()->hasRole('admin');

        $user_id = auth('api')->user()->id;

        $tasks = !$user_role 
                ? Task::where('user_id', $user_id)->where('parent_id', '0')->with('users')->with('department')->with('performed_by_user')->latest()->paginate(2)
                : Task::where('parent_id', '0')->with('users')->with('department')->with('performed_by_user')->latest()->paginate(2);

        return response()->json($tasks);

    }

    public function updateTask(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'priority' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'description' => ['required'],
            'assign_to' => ['required', 'array']
        ]);

        $task = Task::findOrFail($id);

        Task::where('id', $id)->update([
           
            'title' => $request->title,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            
        ]);

        $task->users()->sync($request->assign_to);

        $message = 'Task Updated';

        foreach($request->assign_to as $user_id) {
            $userToNotify = User::findOrFail($user_id);
            $userToNotify->notify(new TaskNotification(auth('api')->user(), $task, $message));
            Notification::send($userToNotify, new TaskEmailNotification(auth('api')->user(), $task, $message));

        };

        broadcast(new NotificationEvent())->toOthers();

        return response()->json('success');
    }

    public function deleteTask($id)
    {
        $task = Task::findOrFail($id);
        $task->users()->detach();
        $task->delete();
        return response()->json('success');
    }

    public function tasksInbox()
    {
        return view('tasks.inbox');
    }

    public function getInboxTasks()
    {
        $tasks = auth('api')->user()->tasks()->where('status', '0')->latest()->paginate(10);
        return response()->json($tasks);

    }

    public function storePerformTask(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        if($request->progress == 100) {
            $performed_by = auth('api')->user()->id;
            $status= 1;

            $message = 'Task Completed';


        }else {
            $performed_by = 0;
            $status= 0;

            $message = 'Task Performance';

        }

        if($request->file){
            if($task->file) {
                unlink(public_path('tasks/' . $task->file));
            }

            $upload_path = public_path('tasks');
            $extension = $request->file->getClientOriginalExtension();
            $file_name = time() . '.' . $extension;
            $request->file->move($upload_path, $file_name);

            $file = $file_name;

        } else {
            $file = $task->file;
        }


        Task::where('id', $request->task_id)->update([
            'performed_by'   => $performed_by,
            'result'         => $request->result,
            'progress'       => $request->progress,
            'file'           => $file,
            'status'         => $status,
        ]);


        $userToNotify = User::findOrFail($task->user_id);
        $userToNotify->notify(new TaskNotification(auth('api')->user(), $task, $message));
        Notification::send($userToNotify, new TaskEmailNotification(auth('api')->user(), $task, $message));

        broadcast(new NotificationEvent())->toOthers();


        return response()->json('success');

    }


    public function tasksCompleted()
    {
        return view('tasks.completed');
    }


    public function getCompletedTasks()
    {
        $tasks = auth('api')->user()->tasks()->where('status', '1')->latest()->paginate(1);
        return response()->json($tasks);

    }

    public function searchTask()
    {
        $user_role = auth('api')->user()->hasRole('admin');

        $user_id = auth('api')->user()->id;

        if($search = \Request::get('users')){

            $tasks = !$user_role 
                     ? Task::where('user_id', $user_id)->where('parent_id', '0')->with('users')->with('department')
                    ->with('performed_by_user')->whereHas( 'users',function($query) use ($search){

                    $query->where('name', 'LIKE', "%$search%");

                    })->latest()->paginate(2)

                     : Task::where('parent_id', '0')->with('users')->with('department')
                    ->with('performed_by_user')->whereHas( 'users',function($query) use ($search){

                    $query->where('name', 'LIKE', "%$search%");

                    })->latest()->paginate(2);

        }else if($search = \Request::get('title')) {

            $tasks = !$user_role 
                    ? Task::where('user_id', $user_id)->where('parent_id', '0')->with('users')->with('department')
                    ->with('performed_by_user')->where
                    (function($query) use ($search){
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('priority', 'LIKE', "%$search%")
                        ->orWhere('start_date', 'LIKE', "%$search%")
                        ->orWhere('end_date', 'LIKE', "%$search%");

                    })->latest()->paginate(2)

                    : Task::where('parent_id', '0')->with('users')->with('department')
                    ->with('performed_by_user')->where
                    (function($query) use ($search){
                    $query->where('title', 'LIKE', "%$search%")
                        ->orWhere('priority', 'LIKE', "%$search%")
                        ->orWhere('start_date', 'LIKE', "%$search%")
                        ->orWhere('end_date', 'LIKE', "%$search%");

                    })->latest()->paginate(2);


        }else{
           $tasks = !$user_role 
                    ? Task::where('user_id', $user_id)->where('parent_id', '0')->with('users')->with('department')->with('performed_by_user')->latest()->paginate(2)
                    : Task::where('parent_id', '0')->with('users')->with('performed_by_user')->latest()->paginate(2);
        }

        return response()->json($tasks);
    }

    public function searchInbox()
    {

       if($search = \Request::get('title')) {

            $tasks = auth('api')->user()->tasks()->where('status', '0')->where
            (function($query) use ($search){
            $query->where('title', 'LIKE', "%$search%")
                  ->orWhere('priority', 'LIKE', "%$search%")
                  ->orWhere('start_date', 'LIKE', "%$search%")
                  ->orWhere('end_date', 'LIKE', "%$search%");

            })->latest()->paginate(2);


        }else{
           $tasks = auth('api')->user()->tasks()->where('status', '0')->latest()->paginate(10);
        }

        return response()->json($tasks);
    }

    public function searchCompleted()
    {

       if($search = \Request::get('title')) {

            $tasks = auth('api')->user()->tasks()->where('status', '1')->where
            (function($query) use ($search){
            $query->where('title', 'LIKE', "%$search%")
                  ->orWhere('priority', 'LIKE', "%$search%")
                  ->orWhere('start_date', 'LIKE', "%$search%")
                  ->orWhere('end_date', 'LIKE', "%$search%");

            })->latest()->paginate(2);


        }else{
           $tasks = auth('api')->user()->tasks()->where('status', '1')->latest()->paginate(10);
        }

        return response()->json($tasks);
    }

    public function tasksReport()
    {
        return view('tasks.reports');

    }


  
}
