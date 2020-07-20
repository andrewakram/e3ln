<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Review extends Model
{
    use Notifiable;


    protected $table = 'reviews';

    protected $fillable = ['id','created_at'];

    protected $hidden = ['updated_at','shop_id'];

    function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->diffForHumans();
    }



}
