<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Measurement;
class editorsController extends Controller
{
    public function delete_measurements(Request $request)
    {
    	$id = $request->id;
    	$data = Measurement::find($id);
    	$data->delete();
    	return 1;
    }
}
