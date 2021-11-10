<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\DocumentDetail;
use DB;
class DocumentsController extends Controller
{
    public function index($projectID, $contractorID, $type)
    {
        //
        return DB::select('SELECT a.*,d.Userfullname
        FROM documents a join projects b on b.ProjectID=a.ProjectID
        join project_numbers c on c.ProjectID = b.ProjectID
        join user d on d.id = a.author
        where c.ProjectID="'.$projectID.'" AND a.contractorID="'.$contractorID.'" 
        AND c.BusinessPartnerID="'.$contractorID.'" 
        AND a.documentType Like "'.$type.'%"');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data=Documents::Create([

            'documentName'      => $request->documentName,
            'documentType'      => $request->documentType,
            'size'      => $request->size,
            'author'      => $request->author,
            'status'      => $request->status,
            'desc'      => $request->desc,
            'ProjectID'      => $request->projectID,
            'contractorID' => $request->contractorID,
            'reportingDate'      => $request->reportingDate

        ]);

        return response()->json(['status' => 'success','doc_insert_id' => $data->id], 200);
    }

    public function createDocumentDetail(Request $request)
    {
        //
        $data = DocumentDetail::Create([
            'actualWbsID' => $request->actualWbsID,
            'itemName'      => $request->itemName,
            'parentItem'      => $request->parentItem,
            'hasChild'      => $request->hasChild,
            'qty'      => $request->qty,
            'price'      => $request->price,
            'startDate'      => $request->startDate,
            'endDate'      => $request->endDate,
            'amount'      => $request->amount,
            'weight'      => $request->weight,
            'ProjectID'      => $request->ProjectID,
            'unitID'      => $request->unitID,
            'contractorID'      => $request->contractorID,
            'CurrencyID'      => $request->CurrencyID,
            'level' => $request->level,
            'parentlevel' => $request->parentlevel,
            'Created_By'    => $request->Created_By

            ]);

            return response()->json(['status' => 'success','last_insert_id' => $data->id], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Documents $Documents, $id)
    {
        //
        $data = Documents::where('id', $id)->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Documents $Documents)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Documents::where('id', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Documents::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
