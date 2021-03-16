<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeoffTemplate extends Model
{
    use HasFactory;
    protected $table = 'takeoff_templates';
    protected $fillable = ['name','user_id','takeoff_label_id','salt', 'status'];

}
