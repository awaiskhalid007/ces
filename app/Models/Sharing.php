<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sharing extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','invited_by','project_id', 'template_salt','status'];
}
