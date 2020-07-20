<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Phone extends Model
{
    use Notifiable;


    protected $table = 'phones';
    protected $primaryKey= 'id';
    protected $visible = ['id','phone'];
    protected $fillable = ['id'];
    protected $hidden = ['updated_at','created_at'];







}
