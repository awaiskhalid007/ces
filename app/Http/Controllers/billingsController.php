<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Billing;
use DB;
use Illuminate\Support\Facades\Crypt;

class billingsController extends Controller
{
    public function show_biling_page(){
    	$session = session()->get('email');
    	$user = User::where('email',$session)->get();
    	$user_id = $user[0]->id;
    	$billing = Billing::where('user_id', $user_id)->get();
        
        if($billing[0]->number != null || $billing[0]->number != ''){
            $billing[0]->number = Crypt::decryptString($billing[0]->number);
        }
        if($billing[0]->expiry != null || $billing[0]->expiry != ''){
            $billing[0]->expiry = Crypt::decryptString($billing[0]->expiry);
        }
        if($billing[0]->cvv != null || $billing[0]->cvv != ''){
            $billing[0]->cvv = Crypt::decryptString($billing[0]->cvv);
        }
    
    	return view('dashboard.setup-billing',['billing'=>$billing,'user'=>$user]);
    }
    public function update(Request $request)
    {
    	$name = $request->name;
    	$email = $request->email;
    	$phone = $request->phone;
    	$company = $request->company;

    	$session = session()->get('email');
    	$user = User::where('email',$session)->get();
    	$user_id = $user[0]->id;

    	Billing::where('user_id', $user_id)->update(['name'=>$name,'email'=>$email,'phone'=>$phone,'company'=>$company]);
    	return back()->withErrors('billing_updated');
    }
    public function add_credit_card(Request $request)
    {

    	$session = session()->get('email');
    	$user = User::where('email',$session)->get();
    	$user_id = $user[0]->id;

    	$name = $request->data['name'];
    	$number = $request->data['number'];
    	$expiry = $request->data['expiry'];
    	$cvv = $request->data['cvv'];

        $encrpt_number = Crypt::encryptString($number);
        $encrpt_expiry = Crypt::encryptString($expiry);
        $encrpt_cvv = Crypt::encryptString($cvv);
        // $decrypted = Crypt::decryptString($crypt);


    	DB::update("UPDATE billings SET name='$name', number='$encrpt_number',expiry='$encrpt_expiry',cvv='$encrpt_cvv' WHERE user_id='$user_id'");

    	return 'ok';
    }
    public function remove_credit_card(Request $request)
    {
    	$session = session()->get('email');
    	$user = User::where('email',$session)->get();
    	$user_id = $user[0]->id;

    	Billing::where('user_id', $user_id)->update(['number'=>null, 'expiry'=>null,'cvv'=>null]);
    	return redirect('/setup/billing');
    }
}
