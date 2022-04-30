<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorEquipment extends Model
{
    //
    protected $table='contractor_equipment';
    protected $primarykey='id';
    protected $fillable = ['EquipmentName','ProjectID','BusinessPartnerID',
                            'UnitID','MobilizationDate','DemobilizationDate','Fax','MobilePhone','Email','Web'];
}
