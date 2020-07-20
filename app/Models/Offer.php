<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Offer extends Model
{
    use Notifiable;


    protected $table = 'offers';

    protected $fillable = ['image','name_en','name_ar','old_price','new_price','description_en','description_ar'];

    protected $hidden = ['created_at','updated_at','shop_id'];

    public function setImageAttribute($value)
    {
        $img_name = time().uniqid().'.'.$value->getClientOriginalExtension();
        $value->move(public_path('/offers/'),$img_name);
        $this->attributes['image'] = $img_name ;
    }

    public function getImageAttribute($value)
    {
        if($value)
        {
            return asset('offers/'.$value);
        }else{
            return asset('/default.png');
        }
    }

}
