<?php

namespace App\Models;

use App\Policies\TaskPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use  HasFactory;

    protected $fillable = [
        'title', 'status', 'due_date',
        'priority', 'description', 'user_id',
        'assigned_to',
    ];

    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function setTitleAttribute($title){
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title,'-');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
