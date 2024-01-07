<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function tasksIndex()
    {
        return view('tasks.index');
    }
}
