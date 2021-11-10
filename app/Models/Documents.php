<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    //
    protected $table = 'documents';
    protected $primarykey='id';
    protected $fillable = ['documentName','documentType','size','author','status','desc','ProjectID','contractorID','reportingDate'];
}
