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
use App\Models\Activity;
use App\Models\Sharing;
use App\Models\PlanGroup;
use Carbon\Carbon;
use DB;

class projectsController extends Controller
{
  
    public function profileSetupPage()
    {   
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $email)->get();
            return view('dashboard.setup-profile',['user'=>$user]);
        }
    }
    public function index()
    {
        $session = session()->get('email');
        $project_view = session()->get('details');

        if($session == "")
        {
            return redirect('/login');
        }else{

            $param = 'id';
            $flag = 'desc';
            if(isset($_GET['sort']))
            {
                
                if($_GET['sort'] == 'modifiedDate')
                {
                    $param = 'updated_at';
                    $flag = $_GET['dir'];
                }
                if($_GET['sort'] == 'creationDate')
                {
                    $param = 'created_at';
                    $flag = $_GET['dir'];
                }
                if($_GET['sort'] == 'name')
                {
                    $param = 'name';
                    $flag = $_GET['dir'];
                }
            }
            $user = User::where('email', $session)->get();
            $user_id = $user[0]->id;
            $username = $user[0]->name;
            $templates = Template::where('user_id', $user_id)->orderBy('id', 'desc')->get();

            $reasons = Archeivereason::where('user_id', $user_id)->get();
            $project_status = Projectstatus::where('user_id', $user_id)->get();
            $projectsData = Project::where(['user_id' => $user_id, 'status' => 1])->orderBy($param, $flag)->get();
            $data = array();
            foreach($projectsData as $projectsRaw){
                $template_id = $projectsRaw->template_id;
                $status_id = $projectsRaw->status_id;
                $label_id = $projectsRaw->label_id;
                $user_id_2 = $projectsRaw->user_id;
                $project_id = $projectsRaw->id;
                $reason_id = $projectsRaw->archive_reasons_id;
                $shared_with = $projectsRaw->shared_with;


                $plans = Project_Plan::where('project_id',$project_id)->count();
                $activities = array();
                $activitiess = Activity::where([
                    ['project_id','=', $project_id]
                ])->orderBy('id','desc')->limit(3)->get();
                foreach($activitiess as $activity)
                {
                    $user_id = $activity->user_id;
                    $user = User::find($user_id);
                    $username = $user->name;
                    $message = $activity->message;
                    $created_at = $activity->created_at;
                    $item = ['name'=>$username,'message'=>$message,'created_at'=>$created_at];
                    array_push($activities, $item);
                }
                if($status_id != null){
                    $status = DB::table('projectstatus')->find($status_id);
                }else{ 
                    $status = ""; 
                }

                if($label_id != null){
                    $labelRaw = DB::table('projectlabels')->find($label_id);
                    $label = $labelRaw->label;
                }else{ $label = ""; }
                $userRaw = DB::table('users')->find($user_id_2);
                $username = $userRaw->name;
                
                $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'plans'=>$plans,'activities'=>$activities,'icon'=>0];
                array_push($data, $arr);
            }

            // Getting Shared Projects
            // ==============================================
            // ==============================================
            if(!$templates->isEmpty())
            {
                foreach($templates as $template)
                {
                    $template_id = $template->id;
                    
                    $projectsData = Project::where(['status' => 1,'template_id'=>$template_id])->orderBy($param, $flag)->get();
                    foreach($projectsData as $projectsRaw){
                        $template_id = $projectsRaw->template_id;
                        $status_id = $projectsRaw->status_id;
                        $label_id = $projectsRaw->label_id;
                        $user_id_2 = $projectsRaw->user_id;
                        $project_id = $projectsRaw->id;
                        $reason_id = $projectsRaw->archive_reasons_id;

                        $dont_add = 0;
                        
                        foreach($data as $d){
                            $data_id = $d['project']->id;
                            
                            if($project_id == $data_id)
                            {   
                                $dont_add = 1;
                            }
                        }
                        if($dont_add == 0)
                        {
                            $plans = Project_Plan::where('project_id',$project_id)->count();
                            $activities = array();
                            $activitiess = Activity::where([
                                ['project_id','=', $project_id]
                            ])->orderBy('id','desc')->limit(3)->get();
                            foreach($activitiess as $activity)
                            {
                                $user_id = $activity->user_id;
                                $user = User::find($user_id);
                                $username = $user->name;
                                $message = $activity->message;
                                $created_at = $activity->created_at;
                                $item = ['name'=>$username,'message'=>$message,'created_at'=>$created_at];
                                array_push($activities, $item);
                            }
                            if($status_id != null){
                                $status = DB::table('projectstatus')->find($status_id);
                            }else{ 
                                $status = ""; 
                            }
                            if($label_id != null){
                                $labelRaw = DB::table('projectlabels')->find($label_id);
                                $label = $labelRaw->label;
                            }else{ $label = ""; }
                            $userRaw = DB::table('users')->find($user_id_2);
                            $username = $userRaw->name;
                            
                            $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'plans'=>$plans,'activities'=>$activities,'icon'=>1];
                            array_push($data, $arr);
                        }
                    }
                }
            }

            // ==============================================
            // ==============================================

            return view('dashboard.projects',[
                'data'            =>  $data,
                'templates'       =>  $templates,
                'reasons'         =>  $reasons,
                'project_status'  =>  $project_status,
                'project_view'    =>  $project_view
            ]);
            
        }
    }
    public function change_to_detail_list(Request $request)
    {
        $request->session()->forget('details');
        $details = "details";
        $request->session()->put('details', $details);
        return redirect('/projects/open');
    }
    public function change_to_compact_list(Request $request)
    {
        $request->session()->forget('details');
        $details = "compact_list";
        $request->session()->put('details', $details);
        return redirect('/projects/open');
    }
    public function change_to_table_view(Request $request)
    {
        $request->session()->forget('details');
        $details = "table_view";
        $request->session()->put('details', $details);
        return redirect('/projects/open');
    }
    public function filter_by($id)
    {
        $session = session()->get('email');
        $project_view = session()->get('details');
        if($session == "")
        {
            return redirect('/login');
        }else{
            $s_id  = $id;
            $status = Projectstatus::find($id);
            $user = User::where('email', $session)->get();
            $user_id = $user[0]->id;
            $username = $user[0]->name;
            $templates = Template::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $reasons = Archeivereason::where('user_id', $user_id)->get();
            $project_status = Projectstatus::where('user_id', $user_id)->get();
            $projectsData = Project::where(['user_id' => $user_id, 'status' => 1, 'status_id' => $s_id ])->orderBy('updated_at', 'asc')->get();
            $data = array();
            foreach($projectsData as $projectsRaw){
                $template_id = $projectsRaw->template_id;
                $status_id = $projectsRaw->status_id;
                $label_id = $projectsRaw->label_id;
                $user_id_2 = $projectsRaw->user_id;
                  
                if($status_id != null){
                    $status = DB::table('projectstatus')->find($status_id);
                }else{ 
                    $status = ""; 
                }
                if($label_id != null){
                    $labelRaw = DB::table('projectlabels')->find($label_id);
                    $label = $labelRaw->label;
                }else{ $label = ""; }
                $userRaw = DB::table('users')->find($user_id_2);
                $username = $userRaw->name;
                
                $plans = Project_Plan::where('project_id',$projectsRaw->id)->get()->count();
                $activities = Activity::where([
                    ['user_id','=', $user_id_2],
                    ['project_id','=', $projectsRaw]
                ])->orderBy('id','desc')->limit(3)->get();

                $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'plans'=>$plans,'activities'=>$activities,'icon'=>0];
                array_push($data, $arr);
            }
           
            return view('dashboard.projects',[
                'data'      =>  $data,
                'templates' =>  $templates,
                'reasons'   =>  $reasons,
                'project_status'    =>  $project_status,
                'project_view' => $project_view
            ]);
        }
    }
    public function search(Request $request)
    {
        $session = session()->get('email');
        $project_view = session()->get('details');
        if($session == "")
        {
            return redirect('/login');
        }else{
            $key  = $request->search;
            $user = User::where('email', $session)->get();
            $user_id = $user[0]->id;
            $username = $user[0]->name;
            $templates = Template::where('user_id', $user_id)->orderBy('id', 'desc')->get();
            $reasons = Archeivereason::where('user_id', $user_id)->get();
            $project_status = Projectstatus::where('user_id', $user_id)->get();
            $projectsData = Project::where([
                ['user_id','=',$user_id],
                ['name', 'like', '%' . $key . '%']
            ])->orderBy('updated_at', 'asc')->get();
            $data = array();
            foreach($projectsData as $projectsRaw){
                $template_id = $projectsRaw->template_id;
                $status_id = $projectsRaw->status_id;
                $label_id = $projectsRaw->label_id;
                $user_id_2 = $projectsRaw->user_id;
                $project_id = $projectsRaw->id;
                
                $activities = Activity::where([
                    ['user_id','=', $user_id_2],
                    ['project_id','=', $project_id]
                ])->orderBy('id','desc')->limit(3)->get();
                
                if($status_id != null){
                    $status = DB::table('projectstatus')->find($status_id);
                }else{ 
                    $status = ""; 
                }
                if($label_id != null){
                    $labelRaw = DB::table('projectlabels')->find($label_id);
                    $label = $labelRaw->label;
                }else{ $label = ""; }
                $userRaw = DB::table('users')->find($user_id_2);
                $username = $userRaw->name;
                $plans = Project_Plan::where('project_id',$project_id)->count();
                $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'plans'=>$plans,'activities'=>$activities, 'icon'=>0];
                array_push($data, $arr);
            }
            
            // Getting Shared Projects
            // ==============================================
            // ==============================================
            if(!$templates->isEmpty())
            {
                foreach($templates as $template)
                {
                    $template_id = $template->id;
                    
                    $projectsData = Project::where([
                        ['name', 'like', '%' . $key . '%'],
                        ['template_id','=', $template_id]
                    ])->orderBy('updated_at', 'asc')->get();
                    
                    foreach($projectsData as $projectsRaw){
                        $template_id = $projectsRaw->template_id;
                        $status_id = $projectsRaw->status_id;
                        $label_id = $projectsRaw->label_id;
                        $user_id_2 = $projectsRaw->user_id;
                        $project_id = $projectsRaw->id;
                        $reason_id = $projectsRaw->archive_reasons_id;

                        $dont_add = 0;
                        
                        foreach($data as $d){
                            $data_id = $d['project']->id;
                            
                            if($project_id == $data_id)
                            {   
                                $dont_add = 1;
                            }
                        }
                        if($dont_add == 0)
                        {
                            $plans = Project_Plan::where('project_id',$project_id)->count();
                            $activities = array();
                            $activitiess = Activity::where([
                                ['project_id','=', $project_id]
                            ])->orderBy('id','desc')->limit(3)->get();
                            foreach($activitiess as $activity)
                            {
                                $user_id = $activity->user_id;
                                $user = User::find($user_id);
                                $username = $user->name;
                                $message = $activity->message;
                                $created_at = $activity->created_at;
                                $item = ['name'=>$username,'message'=>$message,'created_at'=>$created_at];
                                array_push($activities, $item);
                            }
                            if($status_id != null){
                                $status = DB::table('projectstatus')->find($status_id);
                            }else{ 
                                $status = ""; 
                            }
                            if($label_id != null){
                                $labelRaw = DB::table('projectlabels')->find($label_id);
                                $label = $labelRaw->label;
                            }else{ $label = ""; }
                            $userRaw = DB::table('users')->find($user_id_2);
                            $username = $userRaw->name;
                            
                            $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'plans'=>$plans,'activities'=>$activities,'icon'=>1];
                            array_push($data, $arr);
                        }
                    }
                }
            }

            // ==============================================
            // ==============================================
            return view('dashboard.projects',[
                'data'      =>  $data,
                'templates' =>  $templates,
                'reasons'   =>  $reasons,
                'project_status'    =>  $project_status,
                'project_view' => $project_view
            ]);
        }
    }
    public function create_index()
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $templates = Template::where('user_id', $user_id)->get();
            $statuses = Projectstatus::where('user_id', $user_id)->get();
            $sharing = Sharing::where([
                ['user_id','=',$user_id],
                ['template_salt','!=',null]
            ])->get();

            if($sharing->count() > 0){
                $template_salt = $sharing[0]->template_salt;
                $shared_templates = Template::where('salt', $template_salt)->get();
            }else{
                $shared_templates = '';
            }
            $labels = Projectlabel::where('user_id', $user_id)->get();
            
            return view('dashboard.project-create',[
                'statuses'   =>  $statuses,
                'labels'     =>  $labels,
                'templates'  =>  $templates,
                'shared_templates' => $shared_templates
            ]);
        }
    }
    
    public function create_project(Request $request)
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

        $name = $request->name;
        $template = $request->template;
        if(isset($request->description)){
            $description = $request->description;
        }else{ $description = null; }
        if(isset($request->client)){
            $client = $request->client;
        }else{ $client = null; }
        if(isset($request->status)){
            $status = $request->status;
        }else{ $status = null; }
        if(isset($request->labels)){
            $labels = $request->labels;
        }else{ $labels = null; }

        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;

        $salt_query = Project::orderBy('created_at','desc')->first();
        if($salt_query != null){
            $salt_id = $salt_query->id;
        }else{
            $salt_id = 1;
        }
        
        $salt = generate_salt().$salt_id.generate_salt();

        $project = Project::create(['name'=>$name,'user_id'=>$user_id, 'template_id'=>$template,'description'=>$description,'client'=>$client,'status_id'=>$status,'label_id'=>$labels,'salt'=>$salt, 'status' => 1]);
        $project_id = $project->id;

        PlanGroup::create(['name'=>'Plans','user_id'=>$user_id,'project_id'=>$project_id]);
        
        $message = "created project (". $name. ")";
        Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
        return redirect('project/'.$salt.'/overview/details');
    }
    public function overview($id)
    {
        $session = session()->get('email');
        if($session == "")
        {
            return redirect('/login');
        }else{
            $projectsRaw = Project::where('salt', $id)->get();
            $template_id = $projectsRaw[0]->template_id;
            $status_id = $projectsRaw[0]->status_id;
            $status = $projectsRaw[0]->status;
            $archive_reasons_id = $projectsRaw[0]->archive_reasons_id;
            $label_id = $projectsRaw[0]->label_id;
            $user_id_2 = $projectsRaw[0]->user_id;
            $project_salt = $projectsRaw[0]->salt;
            
            // Saving data in recently viewed projects
            $user = User::where('email', $session)->get();
            $u_id = $user[0]->id;
            $project_name = $projectsRaw[0]->name;
            $project_id = $projectsRaw[0]->id;
            $timestamp = Carbon::now()->toDateTimeString();
            $todayDate = Carbon::today();

            $viewCheck = DB::select("SELECT * FROM recently_viewed WHERE project_id='$project_id' AND user_id='$u_id' AND created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)");
            $viewCount = count($viewCheck);
            if($viewCount == 0)
            {
                DB::insert("INSERT INTO recently_viewed (project_id, user_id, created_at, updated_at) VALUES ('$project_id','$u_id','$timestamp','$timestamp')");
            }else{
                $p_id = $viewCheck[0]->id;
                DB::update("UPDATE recently_viewed SET updated_at='$timestamp' WHERE id='$p_id'");
            }

            if($status == 2)
            {
                $reason = Archeivereason::find($archive_reasons_id);
            }else{
                $reason = 'undefined';
            }

            if($status_id != null){
                $status = DB::table('projectstatus')->find($status_id);
            }else{ $status = ""; }
            if($label_id != null){
                $label = DB::table('projectlabels')->where('id',$label_id)->get();
                // $label = $labelRaw->label;
            }else{ $label = ""; }
            $userRaw = DB::table('users')->find($user_id_2);
            $username = $userRaw->name;

            $data = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'reason'=>$reason];
            return view('dashboard.project-overview-details',['data'=>$data, 'project_salt' => $project_salt,'project_id'=>$project_id,'project_name'=>$project_name]);
        }
    }
    public function edit_view($id)
    {
        $session = session()->get('email');
        if($session == "")
        {
            return redirect('/login');
        }else{
            $projectsRaw = Project::where('salt', $id)->get();
            $template_id = $projectsRaw[0]->template_id;
            $status_id = $projectsRaw[0]->status_id;
            $label_id = $projectsRaw[0]->label_id;
            $user_id_2 = $projectsRaw[0]->user_id;
            $project_name = $projectsRaw[0]->name;
            $project_id = $projectsRaw[0]->id;
            
            $project_template = Template::find($template_id);
            $templates = Template::where('user_id', $user_id_2)->get();

            $sharing = Sharing::where([
                ['user_id','=',$user_id_2],
                ['template_salt','!=',null]
            ])->get();

            if($sharing->count() > 0){
                $template_salt = $sharing[0]->template_salt;
                $shared_templates = Template::where('salt', $template_salt)->get();
            }else{
                $shared_templates = '';
            }

            $labels = DB::table('projectlabels')->where('user_id', $user_id_2)->get();
            $statuses = DB::table('projectstatus')->where('user_id', $user_id_2)->get();

            if($status_id != null){
                $statusRaw = DB::table('projectstatus')->find($status_id);
                $status = $statusRaw->status;
            }else{ $status = ""; }
            if($label_id != null){
                $labelRaw = DB::table('projectlabels')->find($label_id);
                $label = $labelRaw->label;
            }else{ $label = ""; }
            $userRaw = DB::table('users')->find($user_id_2);
            $username = $userRaw->name;
            $data = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'labels'=>$labels,'statuses'=>$statuses];
            return view('dashboard.project-details-edit',['data'=>$data,'project_id'=>$project_id,'project_name'=>$project_name,'project_salt'=>$id,'shared_templates'=>$shared_templates,'templates'=>$templates,'project_template'=>$project_template]);
        }
    }
    public function update(Request $request)
    {
        $name = $request->name;
        $template = $request->template;
        $id = $request->id;
        $salt = $request->salt;
        if(isset($request->description)){
            $description = $request->description;
        }else{ $description = null; }
        if(isset($request->client)){
            $client = $request->client;
        }else{ $client = null; }
        if(isset($request->status)){
            $status = $request->status;
        }else{ $status = null; }
        if(isset($request->label)){
            $label = $request->label;
        }else{ $label = null; }

        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;

        $res = Project::where(['id'=>$id])->update(['name'=>$name,'template_id'=>$template,'description'=>$description,'client'=>$client,'status_id'=>$status,'label_id'=>$label]);

        // return $res;
        return redirect('/project/'.$salt.'/overview/details');
    }
    public function delete_project($id)
    {
        $status = 0;
        DB::update("UPDATE projects SET  status = ? WHERE id = ?", [$status, $id]);
        return redirect()->back();
    }
    public function archive_project($id)
    {
        $status = 2;
        DB::update("UPDATE projects SET  status = ? WHERE id = ?", [$status, $id]);
        return redirect('projects/open');   
    }
    public function view_trash_page()
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        
        $project_status = Projectstatus::where('user_id', $user_id)->get();
        if($session == "")
        {
            return redirect('/login');
        }else{
            $projectsData = Project::where(['user_id' => $user_id, 'status' => 0])->orderBy('updated_at', 'desc')->get();
            $data = array();
            $reasons = Archeivereason::where('user_id', $user_id)->get();
            foreach($projectsData as $projectsRaw){
                $status_id = $projectsRaw->status_id;
                $label_id = $projectsRaw->label_id;
                $user_id_2 = $projectsRaw->user_id;
                $project_id = $projectsRaw->id;
                
                $activities = array();
                $activitiess = Activity::where([
                    ['project_id','=', $project_id]
                ])->orderBy('id','desc')->limit(3)->get();
                foreach($activitiess as $activity)
                {
                    $user_id = $activity->user_id;
                    $user = User::find($user_id);
                    $username = $user->name;
                    $message = $activity->message;
                    $created_at = $activity->created_at;
                    $item = ['name'=>$username,'message'=>$message,'created_at'=>$created_at];
                    array_push($activities, $item);
                }

                if($status_id != null){
                    $status = DB::table('projectstatus')->find($status_id);
                    // $status = $statusRaw->status;
                }else{ $status = ""; }
                if($label_id != null){
                    $labelRaw = DB::table('projectlabels')->find($label_id);
                    $label = $labelRaw->label;
                }else{ $label = ""; }
                $userRaw = DB::table('users')->find($user_id_2);
                $username = $userRaw->name;
                
                $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'activities'=>$activities];
                array_push($data, $arr);
            }
            return view('dashboard.trashed-projects',['data'=>$data,'reasons'=>$reasons,'project_status'=>$project_status]);
        }
    }
    public function restore_deleted_project($id)
    {
        $status = 1;
        DB::update("UPDATE projects SET  status = ? WHERE id = ?", [$status, $id]);
        return redirect('projects/open');
    }
    public function view_archive_page()
    {
        $session = session()->get('email');
        if($session == "")
        {
            return redirect('/login');
        }else{
            $user = User::where('email', $session)->get();
            $user_id = $user[0]->id;
            $username = $user[0]->name;
            $projectsData = Project::where(['user_id' => $user_id, 'status' => 2])->orderBy('updated_at', 'desc')->get();
            $reasons = Archeivereason::where('user_id', $user_id)->get();
            $statuses = Projectstatus::where('user_id', $user_id)->get();
            $data = array();
            foreach($projectsData as $projectsRaw){
                $status_id = $projectsRaw->status_id;
                $label_id = $projectsRaw->label_id;
                $user_id_2 = $projectsRaw->user_id;
                $reason_id = $projectsRaw->archive_reasons_id;
                $project_id = $projectsRaw->id;
                
                $activities = array();
                $activitiess = Activity::where([
                    ['project_id','=', $project_id]
                ])->orderBy('id','desc')->limit(3)->get();
                foreach($activitiess as $activity)
                {
                    $user_id = $activity->user_id;
                    $user = User::find($user_id);
                    $username = $user->name;
                    $message = $activity->message;
                    $created_at = $activity->created_at;
                    $item = ['name'=>$username,'message'=>$message,'created_at'=>$created_at];
                    array_push($activities, $item);
                }
                
                if($status_id != null){
                    $statusRaw = DB::table('projectstatus')->find($status_id);
                    $status = $statusRaw->status;
                }else{ $status = ""; }
                if($label_id != null){
                    $labelRaw = DB::table('projectlabels')->find($label_id);
                    $label = $labelRaw->label;
                }else{ $label = ""; }
                if($reason_id != null){
                    $reason = DB::table('archeivereason')->find($reason_id);
                    // $reason = $reasonsRaw->reason;
                }else{ $reason = ""; }
                $userRaw = DB::table('users')->find($user_id_2);
                $username = $userRaw->name;
                
                $arr = ['status'=>$status,'label'=>$label,'username'=>$username,'project'=>$projectsRaw,'reason'=>$reason,'activities'=>$activities];
                array_push($data, $arr);
            }
            return view('dashboard.archived-projects',['data'=>$data,'reasons'=>$reasons, 'statuses'=>$statuses]);
        }
    }
    public function add_to_archive(Request $request)
    {
        $id = $request->id;
        $reason_id = $request->reason;
        $res = Project::where('id', $id)->update(['status'=>2,'archive_reasons_id'=>$reason_id]);
        return redirect()->back();
    }
    public function changestatus (Request $request)
    {
        $project_id = $request->project_id;
        $status_id = $request->status;
        $status_update = Project::where('id', $project_id)->update(['status_id'=> $status_id]);
        return redirect()->back();
    }
    public function duplicateproject(Request $request)
    {
        $project_id = $request->project_id;
        $project_details = Project::where('id', $project_id)->get();

        $name           = $project_details[0]->name;
        $new_name       = $name."-Copy";
        $user_id        = $project_details[0]->user_id;
        $template_id    = $project_details[0]->template_id;
        $description    = $project_details[0]->description;
        $client         = $project_details[0]->client;
        $status_id      = $project_details[0]->status_id;
        $label_id       = $project_details[0]->label_id;
        $status         = $project_details[0]->status;
        $archive__r_id  = $project_details[0]->archive_reasons_id;
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
        $salt_query = Project::orderBy('created_at','desc')->first();
        if($salt_query != null){
            $salt_id = $salt_query->id;
        }else{
            $salt_id = 1;
        }
        $salt = generate_salt().$salt_id.generate_salt(); 

        $array = [
            'name'                  =>  $new_name,
            'user_id'               =>  $user_id,
            'description'           =>  $description,
            'client'                =>  $client,
            'template_id'           =>  $template_id,
            'status_id'             =>  $status_id,
            'label_id'              =>  $label_id,
            'salt'                  =>  $salt,
            'status'                =>  $status,
            'archive_reasons_id'    =>  $archive__r_id,
        ];
        Project::create($array);
        return redirect()->back();
    }
    public function unarchive_project(Request $request)
    {
        $id = $request->id;
        $status_id = $request->status;
        $res = Project::where('id', $id)->update(['status'=>1,'status_id'=>$status_id]);
        return redirect('/projects/archive');
    }
    public function todo_view($salt)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            // $status = 0;
            $project_salt = $salt;
            $project_details = Project::where(['salt' => $project_salt, 'user_id' => $user_id])->get();
            $project_id = $project_details[0]->id;
            $project_name = $project_details[0]->name;
            $todo_list = Project_Todo::where(['project_id' => $project_id, 'user_id' => $user_id])->orderBy('status' , 'asc')->get();
            $projectid = $project_id;
            return view('dashboard.project-todo', ['todo_list' => $todo_list, 'project_id' => $projectid, 'project_name' => $project_name,'project_salt'=>$project_salt]);
        }
    }
    public function store_todo(Request $request)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $project_id     =    $request->id;
            $name           =    $request->name;
            $status         =    0;
            $userid         =    $user_id;
            $salt           =    "Salt";

            $request->validate([
                'name'     =>      'required | min:1 | max:30',
            ]);
            $array = [
                'name'          =>      $name,
                'project_id'    =>      $project_id,
                'status'        =>      $status,
                'user_id'       =>      $userid,
                'salt'          =>      $salt,
            ];
            Project_Todo::create($array);
            $message = "created todo (". $name. ")";
            Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
            return redirect()->back();

        }
    }
    public function update_todo(Request $request)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $name = $request->name;
            $project_id = $request->project_id;
            $id = $request->id;

            $request->validate([
                'name'     =>      'required | min:1 | max:30',
            ]);
            Project_Todo::where('id', $id)->update(['name' => $name]);
            $message = "updated todo (". $name. ")";
            Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
            return redirect()->back();
        }
    }
    public function mark_complete_todo($id, $project_id)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            Project_Todo::where('id', $id)->update(['status'=>1]);
            $todo = Project_Todo::where('id', $id)->get();
            $todo_name = $todo[0]->name;
            $message = "Marked completed todo (". $todo_name. ")";
            Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
            return redirect()->back();
        }
    }
    public function mark_uncomplete_todo($id, $project_id)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            Project_Todo::where('id', $id)->update(['status'=>0]);
            $todo = Project_Todo::where('id', $id)->get();
            $todo_name = $todo[0]->name;
            $message = "Marked uncompleted todo (". $todo_name. ")";
            Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
            return redirect()->back();
        }
    }
    public function delete_todo($id,$project_id)
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            
            $todo = Project_Todo::where('id', $id)->get();
            $todo_name = $todo[0]->name;
            $message = "deleted todo (". $todo_name. ")";
            Activity::create(['user_id'=>$user_id,'project_id'=>$project_id,'message'=>$message]);
            Project_Todo::where('id', $id)->delete();
            return redirect()->back();
        }
    }
    public function update_todo_start_date(Request $request)
    {
        $date = $request->date;
        $id = $request->id;
        Project_Todo::where('id', $id)->update(['start_date'=>$date]);
        return back();
    }
    public function update_todo_end_date(Request $request)
    {
        $date = $request->date;
        $id = $request->id;
        Project_Todo::where('id', $id)->update(['end_date'=>$date]);
        return back();
    }
    public function fetch_recent_viewed_projects($id)
    {
        $html = "";
        $query = DB::table('recently_viewed')->where([
            ['user_id','=',$id],
            ['updated_at','>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 DAY)')],
        ])->orderBy('updated_at','desc')->get();
        $html .= "<a class='dropdown-item'><b>Viewed Projects</b></a>";
        foreach($query as $q)
        {
            $project_id = $q->project_id;
            $project = Project::find($project_id);
            $time = $q->updated_at;
            $time = date('h:i A', strtotime($time));
            $html .= 
            "<a class='dropdown-item' href='/project/$project->salt/plans'>$project->name <small>- Today at $time</small>
            </a>";
        }

        return $html;
    }
    public function export_view($salt)
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
            return view('dashboard.project-export',['project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name]);
        }       
    }
}

