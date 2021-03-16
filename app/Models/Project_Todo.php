<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Todo extends Model
{
    use HasFactory;
    protected $table = 'project_todo';
    protected $fillable = ['name', 'user_id', 'project_id', 'status', 'start_date', 'end_date', 'salt', 'status'];
}
