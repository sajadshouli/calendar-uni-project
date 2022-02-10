<?php

namespace App\Models;

use App\Helpers\Jdf;
use App\Helpers\Json;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Use modules, traits, plugins ...


    // Config the model
    protected $guarded = ['id'];


    // Filters
    public function scopeUserId($query, $userId = null)
    {
        if (filled($userId)) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }


    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->task_items();
    }


    // Accessors
    public function getCreatedAtAttribute($value)
    {
        return (string) $value;
    }

    public function getJcreatedAtAttribute()
    {
        return Jdf::gtoj($this->created_at);
    }

    public function getInfoAttribute($info)
    {
        return Json::decode($info) ?? '';
    }


    // Mutators


    // Extra methods

    private function task_items()
    {
        return $this->hasMany(TaskItem::class);
    }
}
