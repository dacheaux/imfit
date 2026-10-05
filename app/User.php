<?php

namespace App;


use App\Notifications\WellcomeNotify;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\MyResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable, HasRoles;


    protected $dates = ['birth'];

    protected $attributes = ['birth'  => null];

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type','name', 'lastname', 'birth', 'phone', 'note','email', 'password', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function setPasswordAttribute($value)
//    {
//        $this->attributes['password'] = bcrypt($value);
//    }

    public function ownerTerms()
    {
        return $this->hasMany(UserTerm::class);
    }

    public function userPlans()
    {
        return $this->hasMany(UserPlan::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function accountUserplans()
    {
        return $this->hasMany(AccountUserplan::class);
    }
    public function account()
    {
        return $this->hasOne(Account::class);
    }
    public function coach()
    {
        return $this->hasMany(Term::class,  'id', 'trener_id');
    }

    public function entrances()
    {
        return $this->hasMany(Entry::class);
    }

     public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');
    }

    public function getBirthAttribute()
    {
        return  Carbon::parse($this->attributes['birth'])->format('d.M.Y.');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public static function sendWelcomeEmail($user, $gpasswod)
    {
        // Generate a new reset password token
        $token = app('auth.password.broker')->createToken($user);

        $user->notify( new WellcomeNotify($token, $gpasswod) );

        return true;

    }

    // Belogns to qrcode
    public function qrcode()
    {
        return $this->hasOne('App\Qrcode');
    }

    // Belogns to order
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
