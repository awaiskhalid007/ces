<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additional_Item;
use DB;

class additionalItemsController extends Controller
{
    public function create(Request $request)
    {
    	$data = $request->data;
    	$markup = $request->markup;
    	$unit_price = $request->unit_price;
    	if(isset($data['part_no'])){
            $part_no = $data['part_no'];
        }else{
            $part_no = null;
        }
        if(isset($data['measurement_id'])){
            $measurement_id = $data['measurement_id'];
        }else{
            $measurement_id = null;
        }
        if(isset($data['plan_id'])){
            $plan_id = $data['plan_id'];
        }else{
            $plan_id = null;
        }
    	$description = $data['description'];
    	$unit = $data['unit'];
    	$unit_cost = $data['unit_cost'];
    	$stage_id = $data['stage_id'];
    	$project_id = $data['project_id'];
    	$total = $data['total'];
        $formula = 'count';
        $items = [
            'stage_id' => $stage_id,
            'project_id' => $project_id,
            'plan_id' => $plan_id,
            'measurement_id' => $measurement_id,
            'part_no' => $part_no,
            'description' => $description,
            'unit' => $unit,
            'unit_cost' => $unit_cost,
            'markup' => $markup,
            'unit_price' => $unit_price,
            'total' => $total,
            'formula' => $formula
        ];

        // return $items;
    	// $query = DB::insert("INSERT INTO additional_items (stage_id, project_id, part_no, description, unit, unit_cost, markup, unit_price, total) VALUES('$stage_id','$project_id','$part_no','$description','$unit','$unit_cost','$markup','$unit_price','$total')");
        $query = Additional_Item::create([
            'stage_id' => $stage_id,
            'project_id' => $project_id,
            'plan_id' => $plan_id,
            'measurement_id' => $measurement_id,
            'part_no' => $part_no,
            'description' => $description,
            'unit' => $unit,
            'unit_cost' => $unit_cost,
            'markup' => $markup,
            'unit_price' => $unit_price,
            'total' => $total,
            'formula' => $formula
        ]);
    	if($query)
    	{
    		return 1;
    	}else
    	{
    		return 0;
    	}
    }
    public function delete(Request $request)
    {
    	$id = $request->id;
    	DB::delete("DELETE FROM additional_items WHERE id='$id'");
    	return back();
    }
    public function update(Request $request)
    {
    	$data = $request->data;

    	$markup = $request->markup;
    	$unit_price = $request->unit_price;
    	$part_no = $data['part_no'];
    	$description = $data['description'];
    	$unit = $data['unit'];
    	$unit_cost = $data['unit_cost'];
    	$total = $data['total'];
    	$id = $data['id'];

    	$query = DB::update("UPDATE additional_items SET part_no='$part_no',description='$description',unit='$unit',unit_cost='$unit_cost',markup='$markup',unit_price='$unit_price',total='$total' WHERE id='$id'");
    	if($query)
    	{
    		return 1;
    	}else
    	{
    		return 0;
    	}
    }
}
