<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StationProgress extends Model
{
    //
    protected $table = 'station_progress';
    protected $primarykey='id';
    protected $fillable = ['stationName','description','itemID','ProjectID','ContractorID'];
}