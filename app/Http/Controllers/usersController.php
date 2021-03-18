<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projectstatus;
use App\Models\Archeivereason;
use App\Models\Invitation;
use App\Models\Billing;
use App\Models\SymbolCategory;
use App\Http\Controllers\emailsController;
use Carbon\Carbon;
use DB;

class usersController extends Controller
{
    public function view_signup_page(){
    	return view('signup');
    }
    public function view_signin_page(){
    	return view('signin');
    }
    public function view_forgot_password_page()
    {
    	return view('forgot-password');
    }
    public function signup(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required| min:3| max:20',
            'email' => 'required| min:3| unique:users| max:45',
            'password' => ['required', 'min:9','max:25', 'regex:((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20})'],
        ]);
    	$name = $request->name;
    	$company = $request->company;
    	$email = $request->email;
    	$password = $request->password;
    	$phone = $request->phone;
        $timezone = 'America/New_York';
        $licences = '1';
        $type = '1';  // Administrator
        $status = '0'; // 0 For Invited Users (Pending)
        $subscription = $request->subscription;
        $subscription_paid = '0';
        $trial = '1';
        $expires_at = Carbon::now()->addDays(14);
        $admin_status = 0;
    	// Checking if the email already exists or not!
    	$checkEmail = User::where('email', $email)->get();

    	if($checkEmail->isEmpty()){

    	// Encryting Password
	    	$password = bcrypt($request->password);
	    	// Inserting data
	    	$user = User::create(['name'=>$name,'expires_at' => $expires_at,'trial_ends_at'=>$expires_at, 'company'=>$company,'email'=>$email,'password'=>$password,'phone'=>$phone, 'timezone'=>$timezone,'licences'=>$licences, 'type'=>$type, 'status'=>$status,'subscription'=>$subscription,'subscription_paid'=>$subscription_paid,'trial'=>$trial,'admin_status'=>$admin_status]);
	    	if($user)
	    	{
                $user_id = $user->id;
                $user_email = $user->email;
                $timestamp = Carbon::now()->toDateTimeString();
                $message = "Registered (".$user_email.")";
                SymbolCategory::create(['name'=> 'Generic', 'user_id'=>$user_id,'pack'=>'generic']);
                Billing::create(['user_id'=>$user_id,'name'=>$name,'email'=>$email,'company'=>$company,'phone'=>$phone]);
                Projectstatus::create(['status'=>'open', 'user_id'=>$user_id,'color'=>'#5CB85C','sort'=>1]);
                Projectstatus::create(['status'=>'In-Progress', 'user_id'=>$user_id,'color'=>'#CC98E5','sort'=>2]);
                Projectstatus::create(['status'=>'Complete', 'user_id'=>$user_id,'color'=>'#4D77CB','sort'=>3]);

                Archeivereason::create(['reason'=>'Won', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>1]);
                Archeivereason::create(['reason'=>'Lost', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>2]);
                Archeivereason::create(['reason'=>'Complete', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>3]);

                $data = DB::table('user_activities')->insert([
                    'message' => $message,
                    'user_id'=>$user_id,
                    'created_at' => $timestamp
                ]);
                $user->createOrGetStripeCustomer();
                // Sending confirmation email.
                (new emailsController)->signup_verification_email($name,$email);
	    		// $request->session()->put('email', $email);
	    		return redirect('/login')->withErrors('confirmation_email_sent');
	    	}else{
	    		// return back()->withErrors('unknownError');
	    	}
    	}else{
	    	// return back()->withErrors('emailError');
    	}
    }
    public function signin(Request $request)
    {
    	$email = $request->email;
    	$password = $request->password;

    	$user = User::where('email', $email)->get();

        if(!$user->isEmpty())
        {
            $newUser = User::where('email',$email)->first();
            $newUser->createOrGetStripeCustomer();
        	$dbPass = $user[0]->password;
            if(password_verify($password, $dbPass))
            {
                $status = $user[0]->status;
                if($status == 1)
                {
                    $details = "details";
                    $request->session()->put('details', $details);
                    $request->session()->put('email', $email);

                    return redirect('/projects/open');
                }else{
                    return back()->withErrors('not_verified');
                }
            }else{
            	return back()->withErrors('passError');
            }
        }else{
        	return back()->withErrors('emailError');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
    public function recover_password(Request $request)
    {
        $email = $request->email;
        $emailCheck = User::where('email', $email)->get();
        if(!$emailCheck->isEmpty())
        {
            $name = $emailCheck[0]->name;
            $id = $emailCheck[0]->id;

            $a = (new emailsController)->recover_user_password($name,$email,$id);
            return back()->withErrors('success');

        }else{
            return back()->withErrors('emailError');
        }
    }
    public function show_change_pass_page()
    {
        if(!empty($_GET['r']) && !empty($_GET['s']))
        {
            $salt =  $_GET['r'];
            $ex = explode('.', $salt);
            $str = $ex[1];
            $id = $str[0];
            $user = User::where('id', $id)->get();
            $count = $user->count();
            if($count == 1)
            {
                return view('change-password',['user'=>$user]);
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }
    }
    public function update_user_password(Request $request)
    {
        $validate = $request->validate([
            'password' => 'required| min:5| max:25',
            'confirm_password' => 'required| min:5| max:25',
        ]);
        $pass1 = $request->password;
        $pass2 = $request->confirm_password;
        $user_id = $request->user_id;
        if($pass1 == $pass2)
        {
            $password = bcrypt($pass1);
            User::where('id', $user_id)->update(['password'=>$password]);
            return redirect('/login')->withErrors('pass_reset');
        }else{
            return back()->withErrors('matchError');
        }
    }
    public function change_name(Request $request)
    {
        $email = session()->get('email');
        $name = $request->name;

        User::where('email', $email)->update(['name'=>$name]);
        return redirect('/setup/profile')->withErrors('namechanged');
    }
    public function change_timezone(Request $request)
    {
        $timezone = $request->timezone;
        $email = session()->get('email');

        $user = User::where('email', $email)->update(['timezone'=>$timezone]);
        return redirect('/setup/profile')->withErrors('timezonechanged');
    }
    public function change_password(Request $request)
    {
        $email = session()->get('email');
        $old = $request->old;
        $new = $request->new;

        $user = User::where('email', $email)->get();
        $dbPass = $user[0]->password;
        if(password_verify($old, $dbPass))
        {
            $password = bcrypt($new);
            User::where('email', $email)->update(['password'=>$password]);
            return redirect('/setup/profile')->withErrors('passupdated');
        }else{
            return redirect('/setup/profile')->withErrors('oldpasserror');
        }
    }
    public function show_licences_page()
    {
        $email = session()->get('email');
        if($email == "")
        {
            return redirect('/login');
        }else{

            $user = User::where('email', $email)->get();
            $user_id = $user[0]->id;
            $invitations = Invitation::where('invited_by', $user_id)->get();

            return view('dashboard.setup-licences',[
                'user'              =>      $user,
                'invitations'       =>      $invitations
            ]);
        }
    }
    public function update_licences(Request $request)
    {
        $quantity = $request->value;
        $email = session()->get('email');
        DB::update("UPDATE users SET licences='$quantity' WHERE email='$email'");
        return 1;
    }

    public function activate_account()
    {
        if(!empty($_GET['user']) && !empty($_GET['r']) && !empty($_GET['s']))
        {
            $salt =  $_GET['r'];
            $ex = explode('urlsalter', $salt);
            $str = $ex[1];
            if($_GET['user'] == $str)
            {
                User::where('email', $str)->update(['status'=>1]);
                return redirect('/login')->withErrors('email_verified');
            }else{
                return redirect('/login')->withErrors('email_not_verified');
            }
        }else{
            return redirect('/login')->withErrors('email_not_verified');;
        }
    }
    public function resend_confirmation_email(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->get();
        $count = $user->count();
        if($count > 0)
        {
            $name = $user[0]->name;
            (new emailsController)->signup_verification_email($name,$email);
            return back()->withErrors('confirmation_email_sent');
        }else{
            return back()->withErrors('invalid_confirmation_email');
        }
    }
    public function new_user_password_update(Request $request)
    {
        $validate = $request->validate([
            'password' => 'required| min:5| max:25',
            'confirm_password' => 'required| min:5| max:25',
        ]);
        $pass1 = $request->password;
        $pass2 = $request->confirm_password;
        $user_id = $request->user_id;
        if($pass1 == $pass2)
        {
            $password = bcrypt($pass1);
            User::where('id', $user_id)->update(['password'=>$password]);
            return redirect('/login')->withErrors('pass_reset');
        }else{
            return back()->withErrors('matchError');
        }
    }
}
