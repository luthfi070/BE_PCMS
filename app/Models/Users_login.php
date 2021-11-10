<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users_login extends Model
{
    //
    protected $table='user';
    protected $primarykey='id';
    protected $fillable = ['Userfullname','UserLogin','UserMail','UserProfile','PrivilegedStatus','password'];
}
