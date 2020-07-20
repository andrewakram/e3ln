<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Gov extends Model
{
    use Notifiable;

    protected $fillable = [
        'country_id','name_ar', 'name_en'
    ];

    protected $table = 'govs';

    public function cities()
    {
        return $this->hasMany(City::class, 'gov_id');
    }




}
