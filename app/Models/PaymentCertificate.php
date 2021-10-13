<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCertificate extends Model
{
    protected $table='payment_certificate';
    protected $primarykey='id';
    protected $fillable = ['ReportDate', 'Comment', 'docID'];
}
