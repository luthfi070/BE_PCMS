<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskManagement extends Model
{
    //
    protected $table = 'risk_management';
    protected $primarykey='id';
    protected $fillable = ['DescriptionRisk', 'ProjectID', 'PersonilID', 'Rank', 
    'DueDateRisk', 'Mitigation'];
}
