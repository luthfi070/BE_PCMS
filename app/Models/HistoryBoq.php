<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryBoq extends Model
{
    //
    protected $table = 'history_boq';
    protected $primarykey='id';
    protected $fillable = ['boqID','itemName','parentItem','hasChild','qty','price','amount','weight','ProjectID','unitID','contractorID','CurrencyID','level','parentLevel', 'Created_By'];
}
