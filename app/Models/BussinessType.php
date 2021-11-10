<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BussinessType extends Model
{
    //
    protected $table='bussiness_types';
    protected $primarykey='id';
    protected $fillable = ['BussinessTypeName'];
}
