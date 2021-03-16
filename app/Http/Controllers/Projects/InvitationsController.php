<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\User;
use App\Http\Controllers\emailsController;
use Carbon\Carbon;
use DB;
class InvitationsController extends Controller
{
    public function invite_user(Request $request)
    {
    	$name = $request->name;
    	$email = $request->email;
    	$check = 0;
    	$status = 0;
    	if(isset($request->type))
    	{
    		$type = $request->type;
    	}else{
    		$type = 0;
    	}

    	//  Getting Session Info
    	$session = session()->get('email');
    	$session_user = User::where('email', $session)->get();
        $session_id = $session_user[0]->id;
    	$session_name = $session_user[0]->name;

    	// Checking if he is already invited or not
    	$qry = Invitation::where([
            ['email','=',$email],
            ['invited_by','=',$session_id]
        ])->get();
    	$check = $qry->count();

    	// Check if the user is already active or not!
    	$query = User::where('email', $email)->get();
		if(!$query->isEmpty())
		{
			return back()->withErrors('active_user');
		}    
    	
    	// Save record 
    	if($check == 0)
    	{
    		Invitation::create(['name'=>$name,'email'=>$email,'invited_by'=>$session_id,'status'=>$status]);
    		User::create(['name'=>$name, 'email'=>$email,'licences'=>'1','type'=>$type, 'status'=>'0','admin_status'=>0,'subscription'=>0,'subscription_paid'=>0,'trial'=>1]);
            
            $message = "Invited ". $name ." <". $email .">";
            $timestamp = Carbon::now()->toDateTimeString();
            $data = DB::table('user_activities')->insert([
                    'message' => $message,
                    'user_id'=>$session_id,
                    'created_at' => $timestamp
                ]);
    	}
        // Sending Email 
        (new emailsController)->user_invitation($name,$email,$session_id,$session_name);
        return back()->withErrors('user_invited');
    }
    public function accept_invite()
    {
        if(!empty($_GET['user']) && !empty($_GET['r']) && !empty($_GET['s']))
        {
            $salt =  $_GET['r'];
            $ex = explode('urlsalter', $salt);
            $str = $ex[1];
            if($_GET['user'] == $str)
            {
                Invitation::where('email', $str)->update(['status'=>1]);
                $invitation = Invitation::where('email', $str)->get();
                User::where('email', $str)->update(['status'=>1]);
                $user = User::where('email', $str)->get();
                $message = "Invite accepted by <". $str .">";
                $timestamp = Carbon::now()->toDateTimeString();
                $data = DB::table('user_activities')->insert([
                        'message' => $message,
                        'user_id'=>$invitation[0]->invited_by,
                        'created_at' => $timestamp
                    ]);

                return view('dashboard.new-user-create-password',['user'=>$user]);
            }else{
                return redirect('/login')->withErrors('user_not_activated');
            }
        }else{
            return redirect('/login')->withErrors('user_not_activated');
        }
    }
    public function deactivate_user(Request $request)
    {
        $id = $request->id;
        Invitation::where('id', $id)->update(['status'=>2]);
        return back();
    }
    public function activate_user(Request $request)
    {
        $id = $request->id;
        Invitation::where('id', $id)->update(['status'=>1]);
        return back();
    }

}
