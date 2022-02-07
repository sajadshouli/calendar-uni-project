<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    // Use modules, traits, plugins ...


    // Config the model
    protected $guarded = ['id'];


    // Filters
    public function scopeTaskId($query, $taskId = null)
    {
        if (filled($taskId)) {
            return $query->where('task_id', $taskId);
        }
        return $query;
    }

    // Relations
    public function task()
    {
        return $this->belongsTo(Task::class);
    }


    // Accessors


    // Mutators


    // Extra methods
}
