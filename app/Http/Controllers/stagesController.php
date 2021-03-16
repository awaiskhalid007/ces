<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stage;
use App\Models\User;
use App\Models\Measurement;
use App\Models\Activity;
use DB;

class stagesController extends Controller
{
    public function index($salt)
    {
    	$project_salt = $salt;
    	$project = Project::where('salt', $project_salt)->get();
        $project_id = $project[0]->id;
        $project_name = $project[0]->name;

        $stages = Stage::where('project_id', $project_id)->orderBy('id', 'desc')->get();
    	return view('dashboard.project-stages', ['stages'=>$stages,'project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name]);
    }
    public function create(Request $request)
    {
    	$name = $request->name;
    	if(isset($request->id))
        {
            $project_id = $request->id;
        }else{
            $project_id = null;
        }
        if(isset($request->template_id))
        {
            $template_id = $request->template_id;
        }else{
            $template_id = null;
        }

        $email = session()->get('email');
    	$user = User::where('email',$email)->get();
        $user_id = $user[0]->id;
        $status = 1;
        Stage::create(['name'=>$name,'project_id'=>$project_id,'user_id'=>$user_id,'template_id'=>$template_id, 'status'=>$status]);
        $message = "created stage (". $name. ")";
        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
    	return back();
    }
    public function delete(Request $request)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $id = $request->id;
    	$project_id = $request->project_id;
    	$data = Stage::find($id);
        $stages = Stage::where('id', $id)->get();
        $stages_name = $stages[0]->name;
    	$data->delete();
        $message = "deleted stage (". $stages_name. ")";
        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
        if(isset($request->ajax))
        {
         return 1;   
        }else{
    	   return back();
        }
    }
    public function update(Request $request)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $project_id = $request->project_id;
    	$name = $request->name;
    	$id = $request->id;
    	$description = $request->description;
        if(isset($request->takeOffTemplate)){
            $takeoff_template_id = $request->takeOffTemplate;
        }else{
            $takeoff_template_id = null;
        }
        if(isset($request->template_id)){
            $template_id = $request->template_id;
        }else{
            $template_id = null;
        }
    	$multiplier = 1;
    	$all_multiplier = 1;
    	Stage::where('id',$id)->update(['name'=>$name, 'description'=>$description, 'multiplier'=>$multiplier,'all_multiplier'=>$all_multiplier,'template_id'=>$template_id,'takeoff_template_id'=> $takeoff_template_id]);
        $message = "Update stage (". $name. ")";
        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
    	return back();
    }
    public function create_plan_stage(Request $request)
    {
        $session = session()->get('email');
        $user = DB::select("SELECT * FROM users WHERE email='$session'");
        $user_id        = $user[0]->id;
        $name           = $request->data['name'];
        $description    = $request->data['desc'];
        $multiplier     = $request->data['quantity'];
        // $template_id    = $request->data['template'];
        $plan_id        = $request->data['plan_id'];
        $project_id     = $request->data['project_id'];
        $copy_take_off  = $request->data['takeoff'];
        $copy_stage     = $request->data['copy_stage_id'];
        $user_id        = $user_id;
        $status         = 1;
        $template_id = null;
        $all_multiplier  = 1;

        $stage = Stage::create([
            'name'                  =>   $name, 
            'user_id'               =>   $user_id, 
            'plan_id'               =>   $plan_id,
            'project_id'            =>   $project_id,
            'project_id'            =>   $project_id,
            'description'           =>   $description,
            'multiplier'            =>   $multiplier,
            'all_multiplier'        =>   $all_multiplier,
            'template_id'           =>   $template_id,
            'takeoff_template_id'   =>   $copy_take_off,
            'copy_stage_id'         =>   $copy_stage,
            'status'                =>   $status
        ]);
        $stage_id = $stage->id;
        $plan_id = $plan_id;
        if($copy_take_off != null)
        {
            $measurements = Measurement::where('takeoff_id', $copy_take_off)->get();
            if($measurements->count() > 0)
            {
                foreach($measurements as $m)
                {
                    $data = [
                        'type' => $m->type,
                        'stage_id' => $stage_id,
                        'plan_id' => $plan_id,
                        'project_id' => $project_id,
                        'takeoff_id' => null,
                        'part_no' => $m->part_no,
                        'description' => $m->description,
                        'unit' => $m->unit,
                        'unit_cost' => $m->unit_cost,
                        'markup' => $m->markup,
                        'unit_price' => $m->unit_price,
                        'symbol' => $m->symbol,
                        'fill' => $m->fill,
                        'stroke' => $m->stroke,
                        'line_style' => $m->line_style,
                        'line_width' => $m->line_width,
                        'size' => $m->size,
                        'total' => $m->total
                    ];
                    Measurement::create($data);
                }
            }
        }
        if($copy_stage != null)
        {
            $measurements = Measurement::where('stage_id', $copy_stage)->get();
            if($measurements->count() > 0)
            {
                foreach($measurements as $m)
                {
                    $data = [
                        'type' => $m->type,
                        'stage_id' => $stage_id,
                        'plan_id' => $plan_id,
                        'project_id' => $project_id,
                        'takeoff_id' => null,
                        'part_no' => $m->part_no,
                        'description' => $m->description,
                        'unit' => $m->unit,
                        'unit_cost' => $m->unit_cost,
                        'markup' => $m->markup,
                        'unit_price' => $m->unit_price,
                        'symbol' => $m->symbol,
                        'fill' => $m->fill,
                        'stroke' => $m->stroke,
                        'line_style' => $m->line_style,
                        'line_width' => $m->line_width,
                        'size' => $m->size,
                        'total' => $m->total
                    ];
                    Measurement::create($data);
                }
            }
        }
        return 1;
    
    }

    public function fetch_stages(Request $request)
    {
        $plan_id = $request->plan_id;
        $stages = DB::select("SELECT * FROM stages WHERE plan_id='$plan_id' ORDER BY 1 DESC");
        $data = array();
        $i = 0;
        foreach ($stages as $k) {
           $id = $k->id;
           $name = $k->name;
           $description = $k->description;
           $multiplier = $k->multiplier;
           $plan_id = $k->plan_id;
           $measurements = Measurement::where('stage_id', $id)->orderBy('id','desc')->get();
           
           $item = ['id'=>$id, 'stageName'=>$name, 'stageDesc'=>$description,'stageQuantity'=>$multiplier,'plan_id'=>$plan_id, 'measurements' => $measurements];

           array_push($data, $item);
           $i++;
        }
        return $data;
    }
    public function delete_plan_stage(Request $request)
    {
        $id = $request->id;
        $stages = DB::select("DELETE FROM stages WHERE id='$id'");
        return 1;
    }
    public function delete_stage_worksheet(Request $request)
    {
        $id = $request->id;

        Measurement::where('stage_id', $id)->delete();
        $data = Stage::find($id);
        $data->delete();
        return back();
    }
}
