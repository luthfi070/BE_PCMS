<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceAnalysis extends Model
{
    protected $table = 'performance_report';
    protected $primarykey='id';
    protected $fillable = ['itemID','AC','PC','EV','CV','SV','CPI','SPI','EAC1','EAC2','EAC3','EAC4','docID'];
}
