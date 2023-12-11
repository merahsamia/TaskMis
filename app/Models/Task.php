<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'department_id',
        'performed_by',
        'title',
        'description',
        'priority',
        'start_date',
        'end_date',
        'progress',
        'result',
        'file',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
