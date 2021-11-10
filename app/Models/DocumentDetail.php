<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentDetail extends Model
{
    protected $table = 'document_detail';
    protected $primarykey='id';
    protected $fillable = ['actualWbsID','itemName','parentItem','hasChild','qty','price','startDate','endDate','amount','weight','ProjectID','unitID','contractorID','CurrencyID','level','parentLevel', 'Created_By'];
}
