<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Shop_categorie extends Authenticatable
{
    use Notifiable;


    protected $table = 'shop_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

}
