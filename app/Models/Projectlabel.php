<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectlabel extends Model
{
    use HasFactory;
    protected $table = 'projectlabels';
    protected $fillable = ['label', 'user_id', 'color', 'sort'];
}
