<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stage;
use App\Models\Measurement;
use App\Models\User;
use App\Models\Additional_Item;
use App\Models\TakeoffTemplate;
use DB;

class measurementsController extends Controller
{
    public function worksheet_page($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $project_salt = $salt;
        $project = Project::where('salt', $project_salt)->get();
        $project_id = $project[0]->id;
        $project_name = $project[0]->name;
        $data = array();
        $stages = Stage::where('project_id', $project_id)->orderBy('id', 'desc')->Paginate(5);
        
        $current_page =  $stages->currentPage();
        $next_page_url =  $stages->nextPageUrl();
        $prev_page_url =  $stages->previousPageUrl();
        $lastPage =  $stages->lastPage();
        $last_page_url =  $stages->url($lastPage);
        $total_pages =  $stages->total();

        $paginate = ['current_page'=>$current_page,'next_page_url'=>$next_page_url,'prev_page_url'=>$prev_page_url,'total_pages'=>$total_pages,'last_page_url'=>$last_page_url,'last_page'=>$lastPage];

        foreach($stages as $stage)
        {
            $stage_id = $stage->id;
            $measurements = Measurement::where([
                ['project_id', '=' ,$project_id],
                ['stage_id', '=' ,$stage_id],
            ])->orderBy('id','desc')->get();

            $additionals = DB::select("SELECT * FROM additional_items WHERE stage_id='$stage_id' ORDER BY 1 DESC");

            $item = ['stage'=>$stage, 'measurements'=>$measurements,'additionals'=>$additionals];
            array_push($data, $item);
        }

        $takeoffs = TakeoffTemplate::where('user_id', $user_id)->get();
        $stages = Stage::where(['user_id'=> $user_id,'project_id'=>$project_id])->get();

        return view('dashboard.worksheet', ['data'=>$data,'project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name,'paginate'=>$paginate,'takeoffs'=>$takeoffs,'stages'=>$stages]);
    }
    public function add_count(Request $request)
    {
        $data = $request->data;
        $markup = $request->markup;
        $unit_price = $request->unit_price;
        $icon = $request->icon;
        $part_no = $data['part_no'];
        $description = $data['description'];
        $unit = $data['unit'];
        $unit_cost = $data['unit_cost'];
        if(isset($data['fill']))
        {
            $fill = $data['fill'];
        }else{
            $fill = null;
        }
        $stroke = $data['stroke'];
        $size = $data['size'];
        if(isset($data['stage_id']))
        {
            $stage_id = $data['stage_id'];
        }else{
            $stage_id = null;
        }
        if(isset($data['project_id']))
        {
            $project_id = $data['project_id'];
        }else{
            $project_id = null;
        }
        if(isset($data['template_id']))
        {
            $takeoff_id = $data['template_id'];
        }else{
            $takeoff_id = null;
        }
        $type = $data['type'];

    
        $data = new Measurement;

        $data->type = $type;
        $data->stage_id = $stage_id;
        $data->project_id = $project_id;
        $data->takeoff_id = $takeoff_id;
        $data->part_no = $part_no;
        $data->description = $description;
        $data->unit = $unit;
        $data->unit_cost = $unit_cost;
        $data->markup = $markup;
        $data->unit_price = $unit_price;
        $data->symbol = $icon;
        $data->fill = $fill;
        $data->stroke = $stroke;
        $data->size = $size;
        
        $data->save();
        if(isset($request->additional))
        {
            $measurement_id = $data->id;
            if($type == 'count')
            {
                $formula = 'count';
            }elseif($type == 'length')
            {
                $formula = 'len';
            }elseif($type == 'area')
            {
                $formula = 'area';
            }
            $total = 0;
            DB::insert("INSERT INTO additional_items (measurement_id, part_no, description, unit, unit_cost, markup, unit_price, total, formula) VALUES ('$measurement_id','$part_no','$description','$unit','$unit_cost','$markup','$unit_price', '$total','$formula')");
        }
        return 1;
    }
    
    public function adjust_count(Request $request)
    {
        $id = $request->id;
        $total = $request->total;
        if($total == '' || $total == 'undefined' || $total == null)
        {
            $total = 0;
        }

        $query = Measurement::where('id', $id)->update(['total'=>$total]);
        return back();

    }
    public function rename(Request $request)
    {
        $id = $request->id;
        $description = $request->name;
        Measurement::where('id', $id)->update(['description'=>$description]);
        return back();
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Measurement::find($id);
        $data->delete();
        return back();
    }

    public function quantities_page($salt)
    {
        $project_salt = $salt;
        $project = Project::where('salt', $project_salt)->get();
        $project_id = $project[0]->id;
        $project_name = $project[0]->name;
        $data = array();
        $stages = Stage::where('project_id', $project_id)->orderBy('id', 'desc')->Paginate(5);
        
        $current_page =  $stages->currentPage();
        $next_page_url =  $stages->nextPageUrl();
        $prev_page_url =  $stages->previousPageUrl();
        $lastPage =  $stages->lastPage();
        $last_page_url =  $stages->url($lastPage);
        $total_pages =  $stages->total();

        $paginate = ['current_page'=>$current_page,'next_page_url'=>$next_page_url,'prev_page_url'=>$prev_page_url,'total_pages'=>$total_pages,'last_page_url'=>$last_page_url,'last_page'=>$lastPage];

        foreach($stages as $stage)
        {
            $stage_id = $stage->id;
            $measurements = Measurement::where([
                ['project_id', '=' ,$project_id],
                ['stage_id', '=' ,$stage_id],
            ])->orderBy('id','desc')->get();

            $additionals = DB::select("SELECT * FROM additional_items WHERE stage_id='$stage_id' AND part_no != '' ORDER BY 1 DESC");
            $labours = DB::select("SELECT * FROM additional_items WHERE stage_id='$stage_id' AND part_no = '' ORDER BY 1 DESC");

            $item = ['stage'=>$stage, 'measurements'=>$measurements,'additionals'=>$additionals,'labours'=>$labours];
            array_push($data, $item);
        }
        // return $data;
        return view('dashboard.quantities', ['data'=>$data,'project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name,'paginate'=>$paginate]);
    }

    // EDITOR FUNCTIONS
    // ===========================
    public function add_count_editor(Request $request)
    {
        $data = $request->data;
        $part_no = $data['part_no'];
        $description = $data['description'];
        $unit = $data['unit'];
        $unit_cost = $data['unit_cost'];
        $unit_price = $data['unit_price'];
        $stroke = $data['stroke'];
        $size = $data['size'];
        $stage_id = $data['stage_id'];
        $plan_id = $data['plan_id'];
        $project_id = $data['project_id'];
        $icon = $data['icon'];
        $markup = $data['markup'];

        if(isset($data['fill']))
        {
            $fill = $data['fill'];
        }else{
            $fill = null;
        }
        
        $takeoff_id = null;
        $type = $data['type'];

        $data = new Measurement;

        $data->type = $type;
        $data->stage_id = $stage_id;
        $data->project_id = $project_id;
        $data->plan_id = $plan_id;
        $data->takeoff_id = $takeoff_id;
        $data->part_no = $part_no;
        $data->description = $description;
        $data->unit = $unit;
        $data->unit_cost = $unit_cost;
        $data->markup = $markup;
        $data->unit_price = $unit_price;
        $data->symbol = $icon;
        $data->fill = $fill;
        $data->stroke = $stroke;
        $data->size = $size;

        $data->save();
        return $data;
    }
    public function worksheet_measurement_edit_page($project_salt,$measurement_id)
    {
        // $data = TakeoffTemplate::where('salt', $salt)->get();
        $measurements = Measurement::where('id', $measurement_id)->get();
        $m_id = $measurements[0]->id;
        $measurement_name = $measurements[0]->description;

        $parts = DB::select("SELECT * FROM additional_items WHERE measurement_id='$m_id' AND part_no != '' ");
        $labours = DB::select("SELECT * FROM additional_items WHERE measurement_id='$m_id' AND part_no = '' ");
        // $template_salt = $salt;
        $data = Project::where('salt', $project_salt)->get();
        return view('dashboard.worksheet-measurement-edit',[
            'project_salt'      => $project_salt,
            'measurements'      => $measurements, 
            'measurement_name'  => $measurement_name, 
            'data'              => $data,
            'parts'             => $parts,
            'labours'           => $labours
        ]);
    }
    public function update_stage_info(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $description = $request->description;
        $multiply = $request->multiply;

        Stage::where('id', $id)->update(['name'=>$name,'description'=>$description,'multiplier'=>$multiply]);
        return back();

    }
    public function update_stage_measurements(Request $request)
    {
        $stage_id = $request->stage_id;
        $copy_stage = $request->copy_stage;
        $takeoff_id = $request->takeoff_id;

        if($takeoff_id != null)
        {
            Stage::where('id', $stage_id)->update(['takeoff_template_id'=> $takeoff_id]);
            $stage = Stage::where('id', $stage_id)->get();
            $project_id = $stage[0]->project_id;
            $measurements = Measurement::where('takeoff_id', $takeoff_id)->get();
            if($measurements->count() == 0)
            {
                return 0;
            }
            if(!$measurements->isEmpty())
            {
                foreach($measurements as $m)
                {
                    $data = [
                        'part_no' => $m->part_no,
                        'plan_id' => $m->plan_id,
                        'project_id' => $project_id,
                        'size' => $m->size,
                        'stage_id' => $stage_id,
                        'stroke' => $m->stroke,
                        'symbol' => $m->symbol,
                        'takeoff_id' => $m->takeoff_id,
                        'total' => $m->total,
                        'type' => $m->type,
                        'unit' => $m->unit,
                        'markup' => $m->markup,
                        'unit_cost' => $m->unit_cost,
                        'unit_price' => $m->unit_price,
                        'description' => $m->description,
                        'fill' => $m->fill,
                        'line_style' => $m->line_style,
                        'line_width' => $m->line_width,
                    ];

                    Measurement::create($data);
                }
               
                return 1;
            }
        }else{
            $measurements = Measurement::where('stage_id', $copy_stage)->get();
            $addons = Additional_Item::where('stage_id', $copy_stage)->get();
            if($measurements->count() == 0 && $addons->count() == 0)
            {
                return 0;
            }
            foreach($measurements as $m)
            {
                $data = [
                    'part_no' => $m->part_no,
                    'plan_id' => $m->plan_id,
                    'project_id' => $m->project_id,
                    'size' => $m->size,
                    'stage_id' => $stage_id,
                    'stroke' => $m->stroke,
                    'symbol' => $m->symbol,
                    'takeoff_id' => $m->takeoff_id,
                    'total' => $m->total,
                    'type' => $m->type,
                    'unit' => $m->unit,
                    'markup' => $m->markup,
                    'unit_cost' => $m->unit_cost,
                    'unit_price' => $m->unit_price,
                    'description' => $m->description,
                    'fill' => $m->fill,
                    'line_style' => $m->line_style,
                    'line_width' => $m->line_width,
                ];
                Measurement::create($data);
            }
            foreach($addons as $m)
            {
                $data = [
                    'part_no' => $m->part_no,
                    'plan_id' => $m->plan_id,
                    'project_id' => $m->project_id,
                    'stage_id' => $stage_id,
                    'total' => $m->total,
                    'unit' => $m->unit,
                    'markup' => $m->markup,
                    'unit_cost' => $m->unit_cost,
                    'unit_price' => $m->unit_price,
                    'description' => $m->description,
                    'formula' => $m->formula,
                    'measurement_id' => $m->measurement_id
                ];
                Additional_Item::create($data);
            }
            return 1;
        }
    }
    public function apply_to_template(Request $request)
    {
        function generate_salt($len = 12)
        {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789$_';
            $l = strlen($chars) - 1;
            $str = '';
            for ($i = 0; $i < $len; ++$i) {
                $str .= $chars[rand(0, $l)];
            }
            return $str;
        }

        $takeoff_name = $request->name;
        $stage_id = $request->id;

        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;

        $salt_query = TakeoffTemplate::orderBy('created_at','desc')->first();
        if($salt_query != null){
            $salt_id = $salt_query->id;
        }else{
            $salt_id = 1;
        }
        $salt = generate_salt().$salt_id.generate_salt();

        $record = TakeoffTemplate::create([
            'name' => $takeoff_name,
            'user_id' => $user_id,
            'status' => 1,
            'salt' => $salt
        ]);

        $takeoff_id =  $record->id;
        $template_salt= $record->salt;
        $measurements = Measurement::where('stage_id', $stage_id)->get();

        if($measurements->count() != 0)
        {
            foreach($measurements as $m)
            {
                $data = [
                    'part_no' => $m->part_no,
                    'size' => $m->size,
                    'stroke' => $m->stroke,
                    'symbol' => $m->symbol,
                    'takeoff_id' => $takeoff_id,
                    'total' => $m->total,
                    'type' => $m->type,
                    'unit' => $m->unit,
                    'markup' => $m->markup,
                    'unit_cost' => $m->unit_cost,
                    'unit_price' => $m->unit_price,
                    'description' => $m->description,
                    'fill' => $m->fill,
                    'line_style' => $m->line_style,
                    'line_width' => $m->line_width,
                ];
                Measurement::create($data);
            }
            return redirect('/takeoff-templates/'.$template_salt);
        }else{
            return back()->withErrors('noMeasurements');
        }

    }
}
