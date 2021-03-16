<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archeivereason extends Model
{
    use HasFactory;
    protected $table = 'archeivereason';
    protected $fillable = ['reason', 'user_id', 'color', 'sort'];
}
