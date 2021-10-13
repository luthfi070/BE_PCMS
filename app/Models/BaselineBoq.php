<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaselineBoq extends Model
{
    //
    protected $table = 'baselineboq';
    protected $primarykey='id';
    protected $fillable = ['itemName','parentItem','hasChild','qty','price','amount','weight','ProjectID','unitID','contractorID','CurrencyID','level','parentlevel','Created_By'];
}
