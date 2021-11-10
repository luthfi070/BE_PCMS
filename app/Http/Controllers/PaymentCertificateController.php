<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentCertificate;
use DB;

class PaymentCertificateController extends Controller
{
    public function show($id)
    {
        // $data =  PaymentCertificate::where('payment_certificate.docID',$id)
        // ->join('documents','documents.id', '=', 'payment_certificate.docID')
        // ->join('payment_deduction_item','payment_deduction_item.PaymentID','=','payment_certificate.id')
        // ->join('actual_wbs','actual_wbs.id','=','documents.itemID')
        // ->select();
        //return response($data);

        return DB::select('SELECT
        a.itemName,
        COALESCE(d.price,0) AS price,
        b.amount AS CA,
        COALESCE(b.accumulatedLastMonthQty * d.price,0) AS PAA,
        COALESCE((b.thisMonthQty * d.price),0) AS TA,
        COALESCE(d.amount,0) AS amount
    FROM
        actual_wbs a
        JOIN progress_evaluation b ON b.itemID = a.id
        JOIN documents c ON c.id = b.docID
        LEFT JOIN baseline_wbs d ON d.id = a.id
        where b.docID = "' . $id . '" AND  COALESCE((b.thisMonthQty * d.price),0) != 0');
    }

    public function getList($id)
    {
        return DB::select('select b.* from documents a join payment_certificate b on b.docID=a.id
        where a.ProjectID = "' . $id . '" ');
    }

    public function getCertificateTitle($id)
    {
        return DB::select('SELECT
        b.id as contractorID,
        b.BussinessName,
        c.ReportDate,
        c.COMMENT,
        COALESCE(c.id,1) as id
    FROM
        documents a
        LEFT JOIN bussinesspartner b ON b.id = a.contractorID
        LEFT join payment_certificate c on c.docID=a.id
        where a.id="' . $id . '"');
    }

    public function getPaymentListDetail($id)
    {
        return DB::select('SELECT
        a.itemName,
        f.price,
        b.amount AS CA,
        (b.accumulatedLastMonthQty * f.price) AS PAA,
        (b.thisMonthQty * f.price) AS TA,
        d.*,
        e.DeductionItem,
        e.`Value`,
        f.amount
        FROM
        actual_wbs a
        JOIN progress_evaluation b ON b.itemID = a.id
        JOIN documents c ON c.id = b.docID
        LEFT JOIN payment_certificate d ON d.docID = c.id
        LEFT JOIN payment_deduction_item e ON e.PaymentID = d.id
        LEFT JOIN baseline_wbs f ON f.id = a.id
        where b.docID = "' . $id . '"');
    }

    public function create(Request $request)
    {
        //
        $data = PaymentCertificate::Create([

            'ReportDate'      => $request->ReportDate,
            'Comment'      => $request->Comment,
            'docID'      => $request->docID

        ]);

        return response()->json(['status' => 'success', 'last_insert_id' => $data->id], 200);
    }
}
