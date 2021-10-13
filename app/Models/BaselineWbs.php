<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaselineWbs extends Model
{
    protected $table = 'baseline_wbs';
    protected $primarykey='id';
    protected $fillable = ['itemName','parentItem','hasChild','qty','price','startDate','endDate','amount','weight','ProjectID','unitID','contractorID','CurrencyID','level','parentlevel','Created_By'];
}
