<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;
    protected $fillable = [
        'name_ar', 'name_en', 'image'
    ];


    protected $table = 'categories';

    public function offers()
    {
        return $this->hasMany(Offer::class, 'worker_id');
    }

    public function setImageAttribute($value)
    {
        $img_name = time().uniqid().'.'.$value->getClientOriginalExtension();
        $value->move(public_path('categories/'),$img_name);
        $this->attributes['image'] = $img_name ;
    }

    public function getImageAttribute($value)
    {
        if($value)
        {
            return asset('/categories/'.$value);
        }else{
            return asset('/default.png');
        }
    }



}
