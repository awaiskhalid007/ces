<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function updatePayment(Request $request){
                $session = session()->get('email');
                $user = User::where('email',$session)->first();
                $user->addPaymentMethod($request->payment_method);

                $p = $user->findPaymentMethod($request->payment_method);
                $exp = $p->card->exp_month . '/'. $p->card->exp_year;
                $card = 'XXXX-XXXX-XXXX-'.$p->card->last4;

                Billing::where('user_id', $user->id)->update(['name'=>$p->billing_details->name,'number'=>$card,'expiry'=>$exp,'payment_id'=>$p->id,'brand' => $p->card->brand]);

                $this->updateSubscription($request->payment_method);

                return $user;

    }

    public function removePayment( Request $request ){
        $session = session()->get('email');
        $user = User::where('email',$session)->first();
        $paymentMethodID = $request->get('id');

        $paymentMethods = $user->paymentMethods();

        Billing::where('user_id', $user->id)->update(['number'=>null, 'expiry'=>null,'cvv'=>null,'brand' =>null,'payment_id' => null]);

        foreach( $paymentMethods as $method ){
            if( $method->id == $paymentMethodID ){
                $method->delete();
                break;
            }
        }
        return redirect()->back()->with('success','Payment method successfully deleted');
    }

    public function updateSubscription( $paymentId){
        $session = session()->get('email');
        $user = User::where('email',$session)->first();
        if( !$user->subscribed($user->plan->stripe_id) ){
            $user->newSubscription('default', $user->plan->stripe_id)
                ->create( $paymentId );
        }
//        else{
//            $user->subscription($user->subscription)->swap( $user->plan->stripe_id );
//        }
        return $user;
    }

    public function createPlan($name,$price,$currency){
        $data['name'] = $name;
        $data['price'] = $price;
        $data['currency'] = $currency;

        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);

        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $data['price'] * 100,
            'currency' => $currency,
            'interval' => $price  > 100 ? 'year' : 'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_id'] = $stripePlanCreation->id;

        $plan = Plan::create($data);

//        return $plan;
    }

}
