<?php

namespace App\Http\Controllers;

use App\Models\SubStationProgress;
use Illuminate\Http\Request;
use DB;

class SubStationProgressController extends Controller
{
    public function index($projectID,$contractorID)
    {
        //
        return  DB::select("SELECT
        a.*,
        b.description,
        c.BussinessName 
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
        SubStationProgress::updateOrCreate([
            'itemID'      => $request->itemID,
            'parentID'      => $request->parentID,
            'stationID'      => $request->stationID,
            'completedStatus'      => $request->completedStatus,
            'completionDate' => $request->completionDate
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
    public function show(SubStationProgress $SubStationProgress, $id)
    {
        //
        return  DB::select("SELECT
        *
        FROM
            actual_wbs a
            JOIN sub_station_progress b ON b.ItemID = a.id 
        WHERE
             b.parentID  = ?
             group by b.ItemID", [$id]);
    }

    public function getSubItemTable(SubStationProgress $SubStationProgress, $id){
        return  DB::select("SELECT
        b.*,c.completedStatus,c.stationID,c.id as idSubItem
    FROM
        actual_wbs a
        JOIN station_progress b ON b.ItemID = a.id
        JOIN sub_station_progress c ON c.parentID = b.itemID 
    WHERE
        c.parentID = ? 
    GROUP BY
        b.id ", [$id]);
    }

    public function getCompSubItemTable(SubStationProgress $SubStationProgress, $id){
        return  DB::select("SELECT
        b.*,c.completedStatus,c.stationID,c.id as idSubItem,
        c.itemID as itemID2
    FROM
        actual_wbs a
        JOIN station_progress b ON b.ItemID = a.id
        JOIN sub_station_progress c ON c.stationID = b.id 
    WHERE
        c.parentID = ? and completedStatus=1", [$id]);
    }

    public function getSubItemRowTable(SubStationProgress $SubStationProgress, $id){
        return  DB::select("SELECT
        c.*,
        a.itemName,
        b.id as idSubItem,
        b.itemID as itemID2
    FROM
        actual_wbs a
        JOIN sub_station_progress b ON b.ItemID = a.id
        JOIN station_progress c ON c.ItemID = b.parentID 
    WHERE
        b.parentID = ? 
    GROUP BY
        a.itemName", [$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(SubStationProgress $SubStationProgress)
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
    public function update(Request $request, $id, $stationID)
    {
        //
        SubStationProgress::where(['itemID'=>$id,'stationID'=>$stationID])->update($request->all());
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
        SubStationProgress::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
