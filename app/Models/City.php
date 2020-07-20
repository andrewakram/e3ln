<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class City extends Model
{
    use Notifiable;


    protected $table = 'cities';

    protected $fillable = ['id','name_ar','name_en','created_at'];

    protected $hidden = ['created_at','updated_at','gov_id'];





}
