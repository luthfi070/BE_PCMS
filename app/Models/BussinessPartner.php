<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BussinessPartner extends Model
{
    //
    protected $table='bussinesspartner';
    protected $primarykey='id';
    protected $fillable = ['BussinessName','BussinessTypeID','Address',
                            'CountryID','CityID','Phone','Fax','MobilePhone','Email','Web'];

}
