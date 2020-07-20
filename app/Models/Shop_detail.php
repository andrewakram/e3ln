<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Shop_detail extends Model
{
    use Notifiable;

    protected $table = 'shop_details';
    protected $fillable = [
        'name', 'description_en','description_ar','lat','lng','website','email',
        'tax_num','open_hours','open_from','open_to','category_id','shop_id','bisiness_id','image'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function setImageAttribute($value)
    {
        $img_name = time().uniqid().'.'.$value->getClientOriginalExtension();
        $value->move(public_path('/shops/'),$img_name);
        $this->attributes['image'] = $img_name ;
    }



    public function getImageAttribute($value)
    {
        if($value)
        {
            return asset('/shops/'.$value);
        }else{
            return asset('/default.png');
        }
    }

    public function setBusinessIdAttribute($value)
    {
        $img_name = time().uniqid().'.'.$value->getClientOriginalExtension();
        $value->move(public_path('/business_ids/'),$img_name);
        $this->attributes['image'] = $img_name ;
    }

    public function getBusinessIdAttribute($value)
    {
        if($value)
        {
            return asset('/business_ids/'.$value);
        }else{
            return asset('/default.png');
        }
    }

    /*public function email()
    {
        return $this->hasOne(User::class, 'id');
    }*/

    public function phones()
    {
        return $this->hasMany(Phone::class, 'shop_id','shop_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'shop_id','shop_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'shop_id','shop_id');
    }
}
