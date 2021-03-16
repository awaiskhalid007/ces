<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Sharing;
use DB;
use App\Http\Controllers\emailsController;



class sharingsController extends Controller
{

    public function index($salt)
    {
    	$project_salt = $salt;
    	$project = Project::where('salt', $project_salt)->get();
        $project_id = $project[0]->id;
        $project_name = $project[0]->name;
        $email = session()->get('email');
    	$user = User::where('email', $email)->get();
    	$session_id = $user[0]->id;
    	$shared = Sharing::where('invited_by',$session_id)->get();
    	$count = $shared->count();
    	$invitations = array();
    	if($count > 0)
    	{
    		foreach($shared as $o)
    		{
    			$id = $o->id;
    			$user_id = $o->user_id;
    			$invited_by = $o->invited_by;
    			$project_id = $o->project_id;
    			$status = $o->status;
    			
    			$getUser = User::find($user_id);
    			$user_id = $getUser->id;
    			$user_name = $getUser->name;
    			$user_email = $getUser->email;
    			$user_company = $getUser->company;

    			$getProject = Project::find($project_id);
    			$project_id = $getProject->id;
    			$project_name = $getProject->name;

    			$item = [
    				'user_id'=>$user_id, 'user_name'=>$user_name,'user_email'=>$user_email,'user_company'=>$user_company,'project_id'=>$project_id,'project_name'=>$project_name,'status'=>$status
    			];

    			array_push($invitations, $item);
    		}
    	}
    	return view('dashboard.project-sharing',['project_salt'=>$project_salt,'project_id'=>$project_id,'project_name'=>$project_name, 'user'=>$user,'invitations'=>$invitations]);
    }

    public function search(Request $request)
    {
    	$key = $request->value;

    	$user = DB::select("SELECT * FROM users WHERE email LIKE '%$key%'");

    	return $user;
    }
    public function invite(Request $request)
    {

    	$sessionEmail = $request->session()->get('email');
    	$sUser = User::where('email', $sessionEmail)->get();
    	$session_id = $sUser[0]->id;
    	$status = 0;
    	$id = $request->id;
    	$project_id = $request->project_id;
    	$user = User::find($id);
    	$check = Sharing::where([
    		['user_id','=',$id],
    		['invited_by','=',$session_id]
    	])->get();

    	$checkCount =  $check->count();
    	if($checkCount == 0)
    	{
    		Sharing::create(['user_id'=>$id, 'invited_by'=>$session_id, 'project_id'=>$project_id, 'status'=>$status]);
    	}
    	
    	(new emailsController)->project_invitation($user->name,$user->email,$sUser[0]->name, $sUser[0]->email, $project_id, $id, $session_id);

    	// Send invite email
    	return back()->withErrors('invited');
    }
    public function accept_invite($project_id, $user_id, $invited_by)
    {
    	$check = Sharing::where([
    		['user_id','=',$user_id],
    		['invited_by','=',$invited_by],
    		['project_id','=',$project_id]
    	])->update(['status'=>1]);

    	$project = Project::find($project_id);
    	$salt = $project->salt;
    	return redirect('/projects/'.$salt.'/sharing');
    }
}
