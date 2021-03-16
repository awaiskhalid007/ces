<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TakeoffTemplate;
use App\Models\Takeofflabel;
use App\Models\User;
use App\Models\Measurement;
use DB;
class takeoffTemplatesController extends Controller
{
     public function index()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $status = 1;
            
            $templates = TakeoffTemplate::where(['user_id' => $user_id, 'status' => $status])->orderBy('id', 'desc')->get();
            


            $data = array();
            $label = '';
            foreach($templates as $template)
            {
                $id = $template->id;
                $name = $template->name;
                $salt = $template->salt;
                $takeoff = array();
                $labelsArray =  $template->takeoff_label_id;
                if($labelsArray != '' || $labelsArray != null)
                {
                    $ex = explode(',',$labelsArray);
                    $l_count = count($ex);
                    
                    if($l_count > 0)
                    {
                        for($i=0;$i<$l_count;$i++)
                        {
                            $takeoffLabelId = $ex[$i];
                            $label_data = Takeofflabel::where('id', $takeoffLabelId)->get();
                            $l_id = $label_data[0]->id;
                            $l_label = $label_data[0]->label;
                            $l_color = $label_data[0]->color;

                            $list = ['id'=>$l_id,'label'=>$l_label,'color'=>$l_color];
                            array_push($takeoff, $list);
                        }
                    }else{
                        $takeoff = [];
                    }
                }
                $item = ['id'=>$id, 'name'=>$name,'salt'=>$salt, 'labels'=>$takeoff];
                array_push($data, $item);
            }

            $templates = $data;
            return view('dashboard.takeoff-templates-main', ['templates'=> $templates]);
            
        }
    }
    public function create(Request $request){
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
        $name = $request->name;
        $email = $request->session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $id = $user[0]->id;
            $salt_query = TakeoffTemplate::orderBy('created_at','desc')->first();
            if($salt_query != null){
                $salt_id = $salt_query->id;
            }else{
                $salt_id = 1;
            }
            $salt = generate_salt().$salt_id.generate_salt();
            TakeoffTemplate::create(['name'=>$name, 'user_id'=>$id,'salt'=>$salt, 'status' => 1]);
            // return redirect('/project-template/'.$salt.'/tasks');
            return redirect('/takeoff-templates/open');
        }
    }
    public function update(Request $request)
    {
        $name = $request->name;
        $id = $request->id;
        
        TakeoffTemplate::where('id', $id)->update(['name'=>$name]);
        return back();
    }
    public function duplicate(Request $request)
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
        $temp_id = $request->id;
        
        $email = $request->session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $id = $user[0]->id;
            
            $old = TakeoffTemplate::find($temp_id);
            // return $old;
            $name = $old->name.' - Copy';
            $label_id = $old->takeoff_label_id;
            $salt_query = TakeoffTemplate::orderBy('created_at','desc')->first();
            if($salt_query != null){
                $salt_id = $salt_query->id;
            }

            $salt = generate_salt().$salt_id.generate_salt();
            TakeoffTemplate::create(['name'=>$name, 'user_id'=>$id,'salt'=>$salt, 'takeoff_label_id'=>$label_id, 'status' => 1]);
            return redirect('/takeoff-templates/open');
        }
    }
    public function delete($id)
    {
        $status = 0;
        TakeoffTemplate::where('id', $id)->update(['status'=>$status]);
        return back();
    }
    public function trash_index()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $status = 0;
            $templates = TakeoffTemplate::where(['user_id' => $user_id, 'status' => $status])->get();
            return view('dashboard.takeoff-templates-trash',['templates'=>$templates]);
        }
    }
    public function restore($id)
    {
        $status = 1;
        TakeoffTemplate::where('id', $id)->update(['status'=>$status]);
        return back();
    }
    public function edit_takeofflabel(Request $request)
    {
        $template = $request->template;
        $label = $request->label;
        
        $data = TakeoffTemplate::find($template);
        
        
        $labels = $data->takeoff_label_id;
        if($labels == '' || $labels == null)
        {
            TakeoffTemplate::where('id', $template)->update(['takeoff_label_id' => $label]);
        }else{
            $ex = explode(',',$labels);
            $count = count($ex);
            $check = 1;
            for($i=0;$i<$count;$i++)
            {
                if($ex[$i] == $label)
                {
                    $check = 0;
                }
            }
            if($check == 1)
            {
                $labels .= ','.$label;
                TakeoffTemplate::where('id', $template)->update(['takeoff_label_id' => $labels]);    
            }        
        }
        return 1;
    }
    public function details_page($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $data = TakeoffTemplate::where('salt', $salt)->get();
        $id = $data[0]->id;
        $measurements = Measurement::where('takeoff_id', $id)->get();
        $labels = Takeofflabel::where('user_id',$user_id)->get();
        $template_salt = $salt;
        return view('dashboard.takeoff-template-details',['data'=>$data,'labels'=>$labels,'measurements'=>$measurements, 'salt' => $template_salt]);
    }
    public function measurements_edit($salt, $id)
    {
        $data = TakeoffTemplate::where('salt', $salt)->get();
        $measurements = Measurement::where('id', $id)->get();
        $m_id = $measurements[0]->id;
        $measurement_name = $measurements[0]->description;

        $parts = DB::select("SELECT * FROM additional_items WHERE measurement_id='$m_id' AND part_no != '' ");
        $labours = DB::select("SELECT * FROM additional_items WHERE measurement_id='$m_id' AND part_no = '' ");
        $template_salt = $salt;
        return view('dashboard.takeoff-template-measurement-edit',[
            'data'              => $data,
            'measurements'      => $measurements, 
            'measurement_name'  => $measurement_name, 
            'salt'              => $template_salt,
            'parts'             => $parts,
            'labours'           => $labours
        ]);
        // return $measurement;
    }
    public function measurements_name_update(Request $request)
    {
        $name = $request->name;
        $id = $request->id;
        Measurement::where('id', $id)->update(['description'=>$name]);
        return redirect()->back();
    }
    public function measurements_style_update(Request $request)
    {
        $data = $request->data;
        $icon = $request->icon;
        $id         = $data['id'];
        $fill       = $data['fill'];
        $stroke     = $data['stroke'];
        $size       = $data['size'];
        Measurement::where('id', $id)->update([
            'fill'=>$fill,
            'stroke'=>$stroke,
            'size'=>$size,
            'symbol'=>$icon
        ]);
        return 1;
    }
    public function measurements_length_style_update(Request $request)
    {
        $data = $request->data;
        $icon = $request->icon;
        $id         = $data['id'];
        $stroke     = $data['stroke'];
        $size       = $data['size'];
        Measurement::where('id', $id)->update([
            'stroke'=>$stroke,
            'size'=>$size,
            'symbol'=>$icon
        ]);
        return 1;
    }
    public function measurements_area_style_update(Request $request)
    {
        $data = $request->data;
        $icon = $request->icon;
        $id         = $data['id'];
        $stroke     = $data['stroke'];
        $fill     = $data['fill'];
        $size       = $data['size'];
        Measurement::where('id', $id)->update([
            'stroke'=>$stroke,
            'fill'=>$fill,
            'size'=>$size,
            'symbol'=>$icon
        ]);
        return 1;
    }
    public function delete_part(Request $request)
    {
        $id = $request->id;
        DB::delete("DELETE FROM additional_items WHERE id='$id'");
        return back();
    }
    public function fetch_labels(Request $request)
    {
        $html = "";
        $template = $request->template;
        $data = TakeoffTemplate::find($template);
        $labels = $data->takeoff_label_id;
        if($labels != '' || $labels != null){
            $ex = explode(',', $labels);
            $count = count($ex);
            for($i=0;$i<$count;$i++)
            {
                $id = $ex[$i];
                $query = Takeofflabel::find($id);
                $html .= "<button type='button' id='rm-$query->id' class='clickable' onclick='cancel($query->id)' style='color:$query->color'><i class='fa fa-tag'></i> <span>$query->label</span></button>";
            }
        }
        return $html;
    }
    public function remove_label(Request $request)
    {
        $label = $request->label;
        $template = $request->template;

        $data = TakeoffTemplate::find($template);
        $labels = $data->takeoff_label_id;
        $ex = explode(',', $labels);
        $count = count($ex);
        $str = "";
        if($count > 1)
        {
            for($i=0;$i<$count;$i++)
            {
                if($ex[$i] != $label)
                {
                    if($i == 0)
                    {
                        $str .= $ex[$i];
                    }else{
                        $str .= ','.$ex[$i];
                    }
                }
            }
            if($str[0] == ',')
            {
                $str = ltrim($str, $str[0]);
            }
        }

        TakeoffTemplate::where('id', $template)->update(['takeoff_label_id'=>$str]);

        return 'done';
    }
    public function measurement_part_update(Request $request)
    {
       $data = $request->data;
       $description = $data['description'];
       $formula = $data['formula'];
       $markup = $data['markup'];
       $measurement_id = $data['measurement_id'];
       $id = $data['id'];
       $part_no = $data['part_no'];
       $unit = $data['unit'];
       $unit_price = $request->unit_price;
       $unit_cost = $data['unit_cost'];

       DB::update("UPDATE additional_items SET description='$description',formula='$formula',markup='$markup',part_no='$part_no',unit='$unit',unit_price='$unit_price',unit_cost='$unit_cost' WHERE id='$id'");
       return 1;
    }
    public function measurement_labours_edit(Request $request)
    {
       $data = $request->data;
       $description = $data['description'];
       $formula = $data['formula'];
       $markup = $data['markup'];
       $id = $data['id'];
       $unit = $data['unit'];
       $unit_price = $request->unit_price;
       $unit_cost = $data['unit_cost'];
       DB::update("UPDATE additional_items SET description='$description',formula='$formula',markup='$markup',unit='$unit',unit_price='$unit_price',unit_cost='$unit_cost' WHERE id='$id'");
       return 1;
    }
    public function measurement_part_add(Request $request)
    {
       $data = $request->data;
       $markup = $request->markup;
       $unit_price = $request->unit_price;
       $description = $data['description'];
       $formula = $data['formula'];
       $measurement_id = $data['id'];
       if(isset($data['part_no'])){
        $part_no = $data['part_no'];
       }else{
        $part_no = null;
       }
       $unit = $data['unit'];
       $unit_cost = $data['unit_cost'];
       $total = 0;

       DB::insert("INSERT INTO additional_items (measurement_id, part_no, description, unit, unit_cost, markup, unit_price, total, formula) VALUES ('$measurement_id','$part_no','$description','$unit','$unit_cost','$markup','$unit_price', '$total','$formula')");
       return 1;
    }
}
