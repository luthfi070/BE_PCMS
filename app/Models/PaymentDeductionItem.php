<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDeductionItem extends Model
{
    protected $table='payment_deduction_item';
    protected $primarykey='id';
    protected $fillable = ['DeductionItem', 'Value', 'type', 'PaymentID'];
}
