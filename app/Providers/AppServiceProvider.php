<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Archeivereason;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        view()->composer('*', function ($view) 
        {
            $session = \Session::get('email');
            if($session != "")
            {
                $sessionData = User::where('email', $session)->get();
                $view->with('sessionData', $sessionData);
                if(!$sessionData->isEmpty())
                {
                    $user_id = $sessionData[0]->id;
                    $reasons = Archeivereason::where('user_id', $user_id)->get();
                    $view->with('reasons', $reasons);

                }
                
            }
        });  
    }
}
