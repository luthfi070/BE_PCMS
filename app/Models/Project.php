<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $table = 'projects';
    protected $primarykey='id';
    protected $fillable = ['ProjectName', 'ProjectOwner', 'ProjectDesc', 'ProjectManager', 
    'ContractAmount', 'Length', 'CommencementDate','CompletionDate', 'ProjectDuration', 'CurrencyType', 'setDefault'];
    
     

}
