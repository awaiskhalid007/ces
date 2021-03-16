<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Activity;
use Carbon\Carbon;
use DB;

class Activity_LogController extends Controller
{
    public function activity_index($salt)
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

            $activities = Activity::where([
                ['project_id', '=',$project_id],
                ['user_id', '=',$user_id]
            ])->orderBy('id','desc')->get();

            // return $sortedArr = collect($activities)->sortBy('created_at')->all();

            return view('dashboard.project-activity',['project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name,'activities'=>$activities,'username'=>$username]);
        }
    }
    public function user_activity_index()
    {
        $session = session()->get('email');
        $user = User::where('email', $session)->get();
        $user_id = $user[0]->id;
        $username = $user[0]->name;
        if($session == "")
        {
            return redirect('/login');
        }else{
            $activities = DB::table('user_activities')->where(['user_id' => $user_id])->orderBy('id','desc')->get();
            return view('dashboard.setup-user-activity', 
                ['activities' => $activities]
            );
        }

    }
}
