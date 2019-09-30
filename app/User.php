<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyApiEmail;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname','profile_img', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email','email_verified_at','updated_at','created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }

    public function masseurpost()
    {
        return $this->hasOne('App\MasseurPost');
    }

    public function opinions()
		{
			return $this->hasMany('App\Opinion');
		}

    public function educoexps()
    {
      return $this->hasMany('App\Educoexp');
    }

    public function lastSeen()
    {
       $redis = Redis::connection();
       return $redis->get('last_seen_' . $this->id);
    }
}
