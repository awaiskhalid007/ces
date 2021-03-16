<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Additional_Item extends Model
{
    use HasFactory;
    protected $table = "additional_items";
    protected $fillable = ['stage_id','project_id','plan_id','measurement_id','part_no','description','unit','unit_cost','markup','unit_price','total','formula'];
}
