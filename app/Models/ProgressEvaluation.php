<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressEvaluation extends Model
{
    //
    protected $table = 'progress_evaluation';
    protected $primarykey='id';
    protected $fillable = ['periode','progressName','estimatedQty','accumulatedLastMonthQty','thisMonthQty','accumulatedThisMonthQty','amount','weight','contractorID','ProjectID','ItemID','docID'];
}
