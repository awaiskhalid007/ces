<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Takeofflabel extends Model
{
    use HasFactory;
    protected $table = 'takeoff_labels';
    protected $fillable = ['label', 'user_id', 'color', 'sort'];

}
