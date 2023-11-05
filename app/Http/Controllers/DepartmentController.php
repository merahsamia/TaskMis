<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('management.departments.index');
    }


    public function create()
    {
        return view('management.departments.create');
    }
}
