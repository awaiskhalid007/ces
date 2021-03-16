<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template_Todo extends Model
{
    use HasFactory;
    protected $table = 'template_todo';
    protected $fillable = ['name', 'user_id', 'template_id', 'status', 'assign_to', 'salt', 'status'];
}

