<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

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
            'assign_to' => ['required', 'array'],
        ]);

        Task::create([
            'user_id' => auth('api')->user()->id,
            'department_id' => auth('api')->user()->department_id,
            'title' => $request->title,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            
        ]);
    }
}
