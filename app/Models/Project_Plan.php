<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Plan extends Model
{
    use HasFactory;
    protected $table = 'project_plan';
    protected $fillable = ['name','project_id', 'user_id','group_id', 'plan_image','salt', 'status'];
}
