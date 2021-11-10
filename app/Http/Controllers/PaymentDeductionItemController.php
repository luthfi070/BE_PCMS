<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentDeductionItem;
use DB;

class PaymentDeductionItemController extends Controller
{
    public function ItemNonVat($id)
    {

        return DB::select('SELECT
        b.*
    FROM
        payment_certificate a join 
       payment_deduction_item b ON b.PaymentID = a.id
        where a.docID = "' . $id . '" and b.type = 1');
    }

    public function ItemVat($id)
    {

        return DB::select('SELECT
        b.*
    FROM
        payment_certificate a join
       payment_deduction_item b ON b.PaymentID = a.id
        where a.docID = "' . $id . '" and b.type = 2');
    }

    public function create(Request $request)
    {
        //
        $data=PaymentDeductionItem::Create([
            
            'DeductionItem'      => $request->DeductionItem,
            'Value'      => $request->Value,
            'type'      => $request->type,
            'PaymentID'      => $request->PaymentID
        
        ]);

        return response()->json(['status' => 'success','last_insert_id' => $data->id], 200);
    }

    public function destroy($id){
        
    }
}
