<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    //
    protected $table = 'weather';
    protected $primarykey='id';
    protected $fillable = ['weatherName','symbol'];
}
