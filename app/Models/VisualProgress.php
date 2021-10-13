<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisualProgress extends Model
{
    protected $table = 'visual_progress';
    protected $primarykey='id';
    protected $fillable = ['itemVisualName','itemID','contractorID','projectID'];
}