<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisualProgressImage extends Model
{
    protected $table = 'visual_progress_image';
    protected $primarykey='id';
    protected $fillable = ['visualDesc','imgUrl','visualDate','imgName','imgExt','visualProgressID'];
}
