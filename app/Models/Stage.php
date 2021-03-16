<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id', 'plan_id','project_id', 'description','multiplier','all_multiplier','template_id','takeoff_template_id','copy_stage_id','status'];
}
