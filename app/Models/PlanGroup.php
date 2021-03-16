<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanGroup extends Model
{
    use HasFactory;
    protected $table = 'plan_groups';
    protected $fillable = ['name','user_id','project_id'];
}
