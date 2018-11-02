<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $table = 'users'; // we dont have sellers table, sellers is extended from users

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verified', 'verification_token', 'admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];
/**  Mutator and Accessors
Mutator : Values can me modified before saving to db.
 *         signature set____Attribute($value) { return $this->attributes['name] = value ; }
Accessors : Values can be modified before sending data
 *         signature get____Attribute($value) { return doSomeStuff(value) ; }
 **/

    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name){
        return ucwords($name);
    }

    public function setEmailAttribute($email){
        return $this->attributes['email'] = strtolower($email);
    }

    public function isAdmin(){
        return $this->admin == User::ADMIN_USER;
    }
    public function isVerified(){
        return $this->verified == User::VERIFIED_USER;
    }
    public static function genegateVerificationCode(){
        return str_random(40);
    }
}
