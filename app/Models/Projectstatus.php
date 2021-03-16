<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectstatus extends Model
{
    use HasFactory;
    protected $table = 'projectstatus';
    protected $fillable = ['status', 'user_id', 'color','sort'];
}
