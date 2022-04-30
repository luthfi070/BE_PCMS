<?php

namespace App\Http\Controllers;

use App\Models\StationProgress;
use Illuminate\Http\Request;
use DB;

class StationProgressController extends Controller
{
    public function index($projectID,$contractorID)
    {
        //
        return  DB::select("SELECT
        a.*,
        b.description,
        c.BussinessName,
        b.id as idStation
    FROM
        actual_wbs a
        JOIN station_progress b ON b.itemID = a.id 
        JOIN bussinesspartner c ON c.id = a.contractorID
    WHERE
        b.ProjectID = '".$projectID."'
        AND b.ContractorID = '".$contractorID."'
    GROUP BY
        a.itemName");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        StationProgress::updateOrCreate([
            'stationName'      => $request->stationName,
            'description'      => $request->description,
            'itemID'      => $request->itemID,
            'ProjectID'      => $request->ProjectID,
            'ContractorID'      => $request->ContractorID,
        ]);

        return response()->json(['status' => 'success'], 200);
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
    public function show(StationProgress $StationProgress, $id)
    {
        //
        $data = StationProgress::where('station_progress.itemID', $id)
        ->join('bussinesspartner', 'station_progress.ContractorID', '=', 'bussinesspartner.id')
        ->join('actual_wbs', 'station_progress.itemID', '=', 'actual_wbs.id')
        ->select('station_progress.*','bussinesspartner.BussinessName','actual_wbs.itemName')
        ->groupBy('actual_wbs.itemName')
        ->get();
        return response($data);
    }

    public function getStationByParent($id){
        $data = StationProgress::where('station_progress.itemID', $id)
        ->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(StationProgress $StationProgress)
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
        StationProgress::where('itemID', $id)->update($request->all());
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
        StationProgress::where('itemID', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
