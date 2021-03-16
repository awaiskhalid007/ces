<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Template;
use App\Models\Projectstatus;
use App\Models\Projectlabel;
use App\Models\Archeivereason;
use App\Models\Project_Todo;
use App\Models\Project_Plan;
use App\Models\TakeoffTemplate;
use App\Models\Stage;
use App\Models\Activity;
use App\Models\PlanGroup;
use App\Models\Upload;
use Carbon\Carbon;
// use Spatie\PdfToImage\Pdf;
use DB;

class ProjectPlansController extends Controller
{
    public function plans_view($salt)
    {
    	$session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $project_salt = $salt;
            $project = Project::where('salt', $project_salt)->get();
            $project_id = $project[0]->id;
            $project_name = $project[0]->name;
            $project_salt = $project[0]->salt;
            $data = array();
            $groups = PlanGroup::where(['user_id'=>$user_id,'project_id'=>$project_id])->orderBy('id','desc')->get();
            foreach($groups as $group)
            {
                $id = $group->id;
                $name = $group->name;

                $plan = Project_Plan::where('group_id', $id)->get();

                if($plan->count() > 0){
                    $plan_id = $plan[0]->id;
                    
                    $count = $plan->count();
                    foreach($plan as $p)
                    {
                        $p_id = $p->id;
                        $stages = Stage::where('plan_id',$p_id)->get();
                        $total_stages = $stages->count();   
                        $p['stages'] = $stages;
                        $p['total_stages'] = $total_stages;
                    }

                    $item = ['id'=>$id,'name'=>$name,'plan'=>$plan,'count'=>$count,'stages'=>$stages,'total_stages'=>$total_stages];
                    array_push($data, $item);
                    
                }else{
                    $item = ['id'=>$id,'name'=>$name,'plan'=>$plan,'count'=>0];
                    array_push($data, $item);
                }

                
            }
        	return view('dashboard.project-plan',[
                'user_id' => $user_id, 
                'project_id'=>$project_id, 
                'project_salt'=>$project_salt, 
                'project_name'=>$project_name, 
                'data'=>$data,
                'groups'=>$groups
            ]);
        }
    }
    public function upload_plan(Request $request)
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

        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
    
        if($session == "")
        {
            return redirect('/login');
        }else{
            $type = $request->type;
            $project_id = $request->project_id;
            $group_id = $request->group_id;
            // $file = $request->file;
            $files = $request->file('file');
            
            if($type == 'plan')
            {
                if($request->hasFile('file'))
                {
                    foreach ($files as $file) {

                        $name = $file->getClientOriginalName();
                        $timestamp = Carbon::now()->toDateTimeString();
                        $ext = $file->getClientOriginalExtension();

                        $size = $file->getSize(); //bytes
                        $size = number_format($size / 1048576,2);
                        $status = 0;
                        if($size > 25)
                        {
                            return back()->withErrors('sizeError');
                        }
                        $new_name = uniqid(rand(99, 99999)).date('m-y-d').rand(1,100).'.'.$ext;
               
                        $path = 'img/plans/';
                        move_uploaded_file($file, $path.$new_name);
                
                        $salt_query = Project_Plan::orderBy('created_at','desc')->first();
                        if($salt_query != null){
                            $salt_id = $salt_query->id;
                        }else{
                            $salt_id = 1;
                        }

                        $salt = generate_salt().$salt_id.generate_salt();
                        $plan = Project_Plan::create(['name'=>$name,'project_id'=>$project_id,'user_id'=>$user_id,'group_id'=>$group_id, 'plan_image'=>$new_name,'salt'=>$salt, 'status'=>$status]);
                        $plan_id = $plan->id;
                        Upload::create(['name'=>$name,'project_id'=>$project_id,'plan_id'=>$plan_id,'user_id'=>$user_id]);
                        $message = "created plan (". $name. ")";
                        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
                    }
                }
                
                return back();
            }
            else{

                if($request->hasFile('file'))
                {
                    foreach ($files as $file) {

                        $name = $file->getClientOriginalName();
                        $timestamp = Carbon::now()->toDateTimeString();
                        $ext = $file->getClientOriginalExtension();
                        $size = $file->getSize(); //bytes
                        $size = number_format($size / 1048576,2); //MB'S
                        if($size > 25)
                        {
                            return back()->withErrors('sizeError');
                        }
                        
                        $new_name = uniqid(rand(99, 99999)).date('m-y-d').rand(1,100).'.'.$ext;

                        $path = 'img/attachments/';
                        move_uploaded_file($file, $path.$new_name);

                        DB::insert("INSERT INTO attachments (name, file, user_id, project_id, created_at, updated_at) VALUES ('$name','$new_name','$user_id','$project_id','$timestamp','$timestamp')");

                        Upload::create(['name'=>$name,'project_id'=>$project_id,'user_id'=>$user_id]);
                    }
                }

                return back();
            }

        }
        return back();
    }
    public function fetch(Request $request)
    {
        $project_id = $request->project_id;
        $project = Project::find($project_id);
        $project_salt = $project->salt;
        $plans = Project_Plan::where('project_id', $project_id)->orderBy('updated_at','desc')->get();
        $html = "";
        $domain = env("APP_URL", "http://127.0.0.1:8000/");
        $data = array();
        
        foreach($plans as $plan)
        {
            $image = $plan->plan_image;
            $name = $plan->name;
            $plan_salt = $plan->salt;
            $date = date('d M, Y h:i A', strtotime($plan->updated_at));
            
            
            $item = ['name'=>$name,'image'=>$image,'date'=>$date,'project_salt'=>$project_salt,'plan_salt'=>$plan_salt];
            array_push($data, $item);    
            // $html .= 
            // '<tr>
            //     <td></td>
            //     <td></td>
            //     <td><img scr="'.$url.'" class="img-fluid" /></td>
            //     <td><a href="/project/'.$project_salt.'/plans/'.$plan->salt.'/editor">'.$plan->name.'</a></td>
            //     <td>'.date('d M, Y', strtotime($plan->updated_at)).'</td>
            //     <td></td>
            // </tr>';
        }

        return $data;
    }
    public function plans_edit_view($salt, $plan_salt)
    {
        $host_url = env("APP_URL", "default");
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $project_salt = $salt;
            $project = Project::where('salt', $project_salt)->get();
            $project_id = $project[0]->id;
            $project_salt = $project[0]->salt;
            $project_plans = Project_Plan::where(['project_id'=> $project_id, 'salt'=>$plan_salt])->get();
            $takeoff = TakeoffTemplate::where('user_id', $user_id)->get();
            $stages = Stage::where('user_id', $user_id)->get();

            $plan_name = $project_plans[0]->name;

            $storage = ['name'=>$plan_name,'plan_salt'=>$plan_salt,'project_salt'=>$project_salt];
            session()->put('active_plan', $storage);

            return view('dashboard.project-plan-edit',[
                'user_id' => $user_id, 
                'project_id'=>$project_id, 
                'project_salt'=>$project_salt, 
                'plan'=>$project_plans,
                'plan_salt'=>$plan_salt,
                'takeoff'=>$takeoff,
                'stages'=>$stages,
                'host_url'=>$host_url
            ]);
        }
    }
    public function delete_plan(Request $request){
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $project_id = $request->project_id;
        $plan_id = $request->plan_id;
        $salt = $request->project_salt;
        $plan = Project_Plan::where('id', $plan_id)->get();
        $plan_name = $plan[0]->name;
        $message = "Deleted plan (". $plan_name. ")";
        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
        Project_Plan::where('id', $plan_id)->delete();
        return redirect('/project/'.$salt.'/plans');
    }
    public function create_group(Request $request)
    {
        $name = $request->name;
        $project_id = $request->project_id;
        $email = session()->get('email');
        $user = User::where('email', $email)->get();
        $user_id = $user[0]->id;
        PlanGroup::create(['name'=>$name,'project_id'=>$project_id,'user_id'=>$user_id]);
        return back();
    }
    public function rename_group(Request $request)
    {
      $name = $request->name;
      $id = $request->id;
      PlanGroup::where('id', $id)->update(['name'=>$name]);
      return back();
    }
    public function delete_group_plans(Request $request)
    {
        $id = $request->id;
        $plans = Project_Plan::where('group_id', $id)->delete();
        return back();
    }
    public function delete_group(Request $request)
    {
        $id = $request->id;
        $plans = Project_Plan::where('group_id', $id)->delete();
        $group = PlanGroup::find($id);
        $group->delete();
        return back();
    }
    public function fetch_uploads($id)
    {
        $uploads = Upload::where('user_id', $id)->limit(14)->get();
        $data = array();
        foreach($uploads as $u)
        {
            $project_id = $u->project_id;
            $plan_id = $u->plan_id;
            $name = $u->name;

            $project = Project::find($project_id);
            $project_salt = $project->salt;


            if($plan_id != null)
            {
                $plan = Project_Plan::find($plan_id);
                $plan_salt = $plan->salt;
                $type = 'plan';
            }else{
                $plan_salt = '';
                $type = 'attachment';
            }

            $item = ['name'=>$name,'project_id'=>$project_id,'plan_id'=>$plan_id,'project_salt'=>$project_salt,'plan_salt'=>$plan_salt,'type'=>$type];
            array_push($data, $item);
        }
        return $data;
    }
    public function remove_uploads(Request $request)
    {
        $email = session()->get('email');
        $user = User::where('email', $email)->get();
        $user_id = $user[0]->id;

        Upload::where('user_id', $user_id)->delete();
        return back();
    }
    public function fetch_active_plan()
    {
        $plan = session()->get('active_plan');
        return $plan;
    }

}
