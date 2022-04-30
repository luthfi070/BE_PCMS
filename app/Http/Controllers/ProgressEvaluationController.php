<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ProgressEvaluation;

class ProgressEvaluationController extends Controller
{
    public function index()
    {
        //
        return ProgressEvaluation::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data=ProgressEvaluation::Create([
            
            'periode'                       => $request->periode,
            'progressName'                  => $request->progressName,
            'estimatedQty'                  => $request->estimatedQty,
            'accumulatedLastMonthQty'       => $request->accumulatedLastMonthQty,
            'thisMonthQty'                  => $request->thisMonthQty,
            'accumulatedThisMonthQty'       => $request->accumulatedThisMonthQty,
            'amount'       => $request->amount,
            'weight'                        => $request->weight,
            'contractorID'                  => $request->contractorID,
            'ProjectID'                     => $request->ProjectID,
            'ItemID'                        => $request->ItemID,
            'docID'                        => $request->docID
            
            ]);

            return response()->json(['status' => 'success','doc_insert_id' => $data->id], 200);
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
    public function show(ProgressEvaluation $ProgressEvaluation, $id)
    {
        //
        $data = ProgressEvaluation::where('id', $id)->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgressEvaluation $ProgressEvaluation)
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
        ProgressEvaluation::where ('id',$id)->update($request->all());
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
        ProgressEvaluation::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
