<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Models\Projectstatus;
use App\Models\Archeivereason;
use App\Models\Invitation;
use App\Models\Billing;
use DB;
  
class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
      
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {

        try {
    
            $user = Socialite::driver('google')->stateless()->user();
            $email = $user->email;
            $name = $user->name;
            
            $u = User::where('email', $email)->get();
    		$count = $u->count();
    		if($count == 0)
    		{
				$password = bcrypt('123456789');
			    $timezone = 'America/New_York';
			    $licences = '1';
			    $type = '1';  // Administrator
			    $status = '1'; // 0 For Invited Users (Pending)
			    $subscription = '0';
			    $subscription_paid = '0';
			    $trial = '1';
                $admin_status = 0;

	    		$user = User::create(['name'=>$name, 'email'=>$email,'password'=>$password, 'timezone'=>$timezone,'licences'=>$licences, 'type'=>$type, 'status'=>$status,'subscription'=>$subscription,'subscription_paid'=>$subscription_paid,'trial'=>$trial,'admin_status'=>$admin_status]);
                if($user)
                {
                    $user_id = $user->id;
                    SymbolCategory::create(['name'=> 'Generic', 'user_id'=>$user_id,'pack'=>'generic']);
                    Billing::create(['user_id'=>$user_id,'name'=>$name,'email'=>$email]);
                    Projectstatus::create(['status'=>'open', 'user_id'=>$user_id,'color'=>'#5CB85C','sort'=>1]);
                    Projectstatus::create(['status'=>'In-Progress', 'user_id'=>$user_id,'color'=>'#CC98E5','sort'=>2]);
                    Projectstatus::create(['status'=>'Complete', 'user_id'=>$user_id,'color'=>'#4D77CB','sort'=>3]);

                    Archeivereason::create(['reason'=>'Won', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>1]);
                    Archeivereason::create(['reason'=>'Lost', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>2]);
                    Archeivereason::create(['reason'=>'Complete', 'user_id'=>$user_id,'color'=>'#F89C0E','sort'=>3]);
                    DB::insert("INSERT INTO default_packs (name) VALUES ('generic')");
                    DB::insert("INSERT INTO default_packs (name) VALUES ('arrows')");

                    $details = 'details';
                    session()->put('details', $details);
                    session()->put('email', $email);
                    return redirect('/projects/open');
                }else{
                    return redirect('/signup');
                }
    			
    		}else{
                $details = 'details';
                session()->put('details', $details);
    			session()->put('email', $email);
    			return redirect('/projects/open');
    		}


        } catch (Exception $e) {
            return $e;
    		// return redirect('/signup')->withErrors('google_error');
        }
    }
}