<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'user_id',
        'task_id',
        'comment',

    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

}
   
