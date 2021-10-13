<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActualWbs;
use App\Models\PerformanceAnalysis;
use DB;

class PerformanceAnalysisController extends Controller
{
    public function index()
    {
        //
        return PerformanceAnalysis::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        PerformanceAnalysis::updateOrCreate([
            'itemID' => $request->itemID,
            'AC' => $request->AC,
            'PC' => $request->PC,
            'EV' => $request->EV,
            'CV' => $request->CV,
            'SV' => $request->SV,
            'CPI' => $request->CPI,
            'SPI' => $request->SPI,
            'EAC1' => $request->EAC1,
            'EAC2' => $request->EAC2,
            'EAC3' => $request->EAC3,
            'EAC4' => $request->EAC4,
            'docID' => $request->docID
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

    public function getPerformanceList($projectId,$contractorId){
        return DB::select('SELECT * From documents a 
        where a.ProjectID="'.$projectId.'" and a.contractorID="'.$contractorId.'"
        and documentType="performanceReport"');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(PerformanceAnalysis $PerformanceAnalysis, $id)
    {
        //
        $data = PerformanceAnalysis::where('id', $id)->get();
        return response($data);
    }
    public function getPerformanceDetail($docID){
        return  DB::select("SELECT
        a.documentName,
        a.reportingDate,
        b.*,
        c.itemName ,
        d.Userfullname
    FROM
    documents a
        JOIN performance_report b on b.docID = a.id
        JOIN actual_wbs c ON c.id = b.itemID 
        join user d on d.id = a.author
    WHERE
        b.docID ='".$docID."'");
    }

    public function getPerformance($projectId, $contractorId)
    {
        return  DB::select("SELECT
        a.*,
        b.*,
        COALESCE (round(( ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) / b.ACC_TOTAL_PLANNED_COST ), 2 ),0) AS SPI,
        COALESCE (round(( ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) - b.ACC_TOTAL_PLANNED_COST ), 2 ),0) AS SV,
        ( SELECT sum( qty * price ) AS ACC_TOTAL_PLANNED_COST FROM actual_wbs WHERE parentItem IS NOT NULL AND ( ProjectID = " . $projectId . " AND contractorID = " . $contractorId . " ) ) AS BAC,
        COALESCE ((
            a.TOTAL_ACTUAL_COST +(
                b.ACC_TOTAL_PLANNED_COST - ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) 
            )),0) AS EAC1,
        COALESCE (
            round((
                    a.TOTAL_ACTUAL_COST +((
                            b.ACC_TOTAL_PLANNED_COST - ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) 
                        )/ (((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST )/ a.TOTAL_ACTUAL_COST ))),
                2 
            ),
            0 
        ) AS EAC3,
        COALESCE (
            round((
                    a.TOTAL_ACTUAL_COST +((
                            b.ACC_TOTAL_PLANNED_COST - ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) 
                            )/ a.aCPI /(
                            ((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ) / b.ACC_TOTAL_PLANNED_COST 
                        ))),
                2 
            ),
            0 
        ) AS EAC4,
        COALESCE ((((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST )/ a.TOTAL_ACTUAL_COST ),0) AS CPI,
        COALESCE ((((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST )- a.TOTAL_ACTUAL_COST ),0) AS CV,
        COALESCE (((( a.id_per_parent_completed / a.all_station ))* b.ACC_TOTAL_PLANNED_COST ),0) AS EV,
        (((
                    a.id_per_parent_completed / a.all_station 
                ))) AS EARNED 
    FROM
        (
        SELECT
            a.id,
            a.itemName,
            a.startDate,
            a.parentItem,
            a.endDate,
            a.hasChild,
            a.ProjectID,
            a.contractorID,
            b.estimatedQty,
            b.accumulatedLastMonthQty,
            b.accumulatedThisMonthQty,
            b.TOTAL_ACTUAL_COST,
            b.thisMonthQty,
            c.aEV,
            ( c.aEV - b.TOTAL_ACTUAL_COST ) AS aCV,
            ( c.aEV / b.TOTAL_ACTUAL_COST ) AS aCPI,
            c.id_per_parent_completed,
            c.all_station 
        FROM
            actual_wbs a
            JOIN (
            SELECT
                a.parentItem,
                b.estimatedQty,
                b.accumulatedLastMonthQty,
                b.accumulatedThisMonthQty,
                b.thisMonthQty,
                SUM( b.amount ) AS TOTAL_ACTUAL_COST 
            FROM
                actual_wbs a
                JOIN progress_evaluation b ON b.ItemID = a.id
                INNER JOIN ( SELECT docID FROM progress_evaluation WHERE ProjectID = " . $projectId . " AND contractorID = " . $contractorId . " ORDER BY docID DESC LIMIT 1 ) c ON c.docID = b.docID 
            WHERE
                a.parentItem IS NOT NULL 
                AND ( a.ProjectID = " . $projectId . " AND a.contractorID = " . $contractorId . " ) 
            GROUP BY
                a.parentItem 
            ) b ON b.parentItem = a.id
            LEFT JOIN (
            SELECT
                a.parentItem,
                COALESCE ( SUM( b.amount ), 0 ) AS aEV,
                count( b.id ) AS id_per_parent_completed,
                c.itemID,
                e.all_station
    -- 			,sum( e.all_station ) AS all_station 
            FROM
                actual_wbs a
                LEFT JOIN progress_evaluation b ON b.ItemID = a.id
                LEFT JOIN sub_station_progress c ON c.ItemID = b.ItemID -- 		AND a.weight = b.weight
                INNER JOIN ( SELECT docID FROM progress_evaluation WHERE ProjectID = " . $projectId . " AND contractorID = " . $contractorId . " ORDER BY docID DESC LIMIT 1 ) d ON d.docID = b.docID
                LEFT JOIN ( SELECT count( id ) AS all_station, ItemID FROM sub_station_progress GROUP BY parentID ) e ON e.ItemID = b.ItemID 
            WHERE
                a.parentItem IS NOT NULL 
                AND c.completedStatus = 1 
            GROUP BY
                a.parentItem 
            ) c ON c.parentItem = a.id 
        ) a
        LEFT JOIN (
        SELECT
            parentItem,-- 		sum( qty ) AS accTotalQty,
    -- 		sum( price ) AS accTotalPrice,
            sum( qty ) AS ESTIMATED_QTY,
            sum( qty * price ) AS ACC_TOTAL_PLANNED_COST,
            sum( weight ) AS TOTAL_PLANNED_WEIGHT,
            count( id ) AS id_per_parent_total 
        FROM
            baseline_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ( ProjectID = " . $projectId . " AND contractorID = " . $contractorId . " ) 
        GROUP BY
            parentItem 
        ) b ON b.parentItem = a.id 
    WHERE
        ( a.hasChild != '' OR a.hasChild != 0 ) 
        AND (
            a.ProjectID = " . $projectId . " 
        AND a.contractorID = " . $contractorId . " 
        )");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(ActualWbs $ActualWbs)
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
        ActualWbs::where('id', $id)->update($request->all());
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
        ActualWbs::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
