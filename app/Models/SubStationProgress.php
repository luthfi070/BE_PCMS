<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubStationProgress extends Model
{
    protected $table = 'sub_station_progress';
    protected $primarykey='id';
    protected $fillable = ['itemID','parentID','stationID','completedStatus','completionDate'];
}
