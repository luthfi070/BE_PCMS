<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisualProgress;
use DB;

class VisualProgressController extends Controller
{
    public function index($projectID, $contractorID)
    {
        //
        return  DB::select("SELECT
        b.*,
        b.id as idVisual,
        c.*,
        a.itemName
    FROM
        actual_wbs a
        LEFT JOIN visual_progress b ON b.itemID = a.id 
        LEFT JOIN visual_progress_image c ON c.visualProgressID = b.id
    WHERE
        b.projectID = '" . $projectID . "'
        AND b.contractorID = '" . $contractorID . "'
        GROUP BY
        idVisual");
    }


    public function showOtherVisual($projectID, $contractorID)
    {
        //
        return  DB::select("SELECT
        b.*,
		b.id as idVisual,
        c.*
    FROM
        visual_progress b 
        LEFT JOIN visual_progress_image c ON c.visualProgressID = b.id
    WHERE
    b.projectID = '" . $projectID . "'
        AND b.contractorID = '" . $contractorID . "'
        AND b.itemID = 0");
    }

    public function DataVisualProgressDetail($id)
    {
        return  DB::select("SELECT
        b.*,
        c.*,
        a.itemName,
        x.BussinessName
    FROM
        bussinesspartner x
        JOIN actual_wbs a on a.contractorID = x.id
        LEFT JOIN visual_progress b ON b.itemID = a.id 
        LEFT JOIN visual_progress_image c ON c.visualProgressID = b.id
    WHERE
        b.id= ?", [$id]);
    }

    public function OtherDataVisualProgressDetail($id)
    {
        return  DB::select("SELECT
        b.*,
        c.*,
        a.BussinessName
    FROM
        bussinesspartner a
        LEFT JOIN visual_progress b ON b.contractorID = a.id 
        LEFT JOIN visual_progress_image c ON c.visualProgressID = b.id
    WHERE
        b.id= ?", [$id]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        VisualProgress::updateOrCreate([

            'itemVisualName'      => $request->itemVisualName,
            'itemID'      => $request->itemID,
            'contractorID'      => $request->contractorID,
            'projectID'      => $request->projectID

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
    public function show(VisualProgress $unit, $id)
    {
        //
        $data = VisualProgress::where('id', $id)->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(VisualProgress $unit)
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
        VisualProgress::where('id', $id)->update($request->all());
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
        VisualProgress::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
