<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

   protected $appends = ['trial','expired','expires_in'];

   protected $with = ['plan'];

    protected $fillable = [
        'name',
        'company',
        'email',
        'password',
        'phone',
        'timezone',
        'licences',
        'type',
        'status',
        'subscription',
        'subscription_paid',
        'expires_at',
//        'trial',
        'admin_status',
        'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function plan(){
        return $this->hasOne(Plan::class,'id','subscription');
    }

    public function getTrialAttribute() {
        $expires_at = $this->created_at->addDays(14);
        if($expires_at > Carbon::now()){
            return true;
        }else {
            return false;
        }
    }
    public function getExpiredAttribute() {
        if($this->expired_at > Carbon::now()){
            return true;
        }else {
            return false;
        }
    }
    public function getExpiresInAttribute() {
        if($this->expires_at > Carbon::now()){
            return Carbon::now()->diffInDays($this->expires_at, false);
        }else {
            return $this->expires_at;
        }
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
