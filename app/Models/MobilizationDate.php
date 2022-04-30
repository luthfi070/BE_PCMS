<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilizationDate extends Model
{
    //
    protected $table = 'mobilization_dates';
    protected $primarykey='id';
    protected $fillable = ['CurrentManMonth','Schedule','ProjectID', 'BusinessPartnerID', 'PersonilID','PositionCatID', 'PositionID', 
    'StarDateMobilization', 'EndDateMobilization'];
}
