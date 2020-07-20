<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Block extends Model
{
    use Notifiable;


    protected $table = 'blocks';
    protected $primaryKey= 'id';








}
