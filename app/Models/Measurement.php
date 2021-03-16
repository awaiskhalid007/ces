<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;
    protected $fillable = [
    	'type', 'stage_id', 'plan_id','takeoff_id', 'project_id', 'part_no', 'description', 'unit', 'unit_cost', 'markup', 'unit_price', 'symbol', 'fill', 'stroke', 'line_style', 'line_width', 'size'
    ];
}
