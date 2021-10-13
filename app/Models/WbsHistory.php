<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WbsHistory extends Model
{
    protected $table = 'wbs_history';
    protected $primarykey='id';
    protected $fillable = ['actualWbsID','itemName','parentItem','hasChild','qty','price','startDate','endDate','amount','weight','ProjectID','unitID','contractorID','CurrencyID','level','parentLevel', 'Created_By'];
}
