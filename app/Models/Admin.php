<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\Authenticatable;
//use Illuminate\Auth\Authenticatable as AuthenticableTrait;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasRoles;

    public $guard_name = 'admin';

    /*protected $table ="users";*/

    /*protected $fillable = [
        'active','name','email','phone','password','image','interest_fee'
    ];*/

    /*protected $hidden = [
        'password'
    ];*/


}
