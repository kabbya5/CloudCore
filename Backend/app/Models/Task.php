<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use  HasFactory;

    protected $fillable = [
        'title', 'status', 'due_date',
        'priority', 'description', 'user_id',
        'assigned_to',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
