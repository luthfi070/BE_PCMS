<?php

namespace App\Http\Controllers;

use App\Models\RiskManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RiskManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return RiskManagement::join('projects', 'risk_management.ProjectID', '=', 'projects.ProjectID')
        ->join('personil','risk_management.PersonilID','=','personil.id')
        ->select('risk_management.*', 'personil.PersonilName')
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        RiskManagement::create([

            'DescriptionRisk'         => $request->DescriptionRisk,
            'ProjectID'               => $request->ProjectID,
            'PersonilID'              => $request->PersonilID,
            'Rank'                    => $request->Rank,
            'DueDateRisk'             => $request->DueDateRisk,
            'Mitigation'              => $request->Mitigation
          
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
     * @param  \App\Models\RiskManagement  $riskManagement
     * @return \Illuminate\Http\Response
     */
    public function show(RiskManagement $riskManagement, $id)
    {
        //
        return RiskManagement::where('risk_management.id', $id)
        ->join('projects', 'risk_management.ProjectID', '=', 'projects.ProjectID')
        ->join('personil','risk_management.PersonilID','=','personil.id')
        ->select('risk_management.*', 'personil.PersonilName', 'projects.ProjectName')
        ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiskManagement  $riskManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(RiskManagement $riskManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiskManagement  $riskManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // RiskManagement::where('id', $id)->update($request->all());
        RiskManagement::where('id', $id)->update([
            'DescriptionRisk' => \request('DescriptionRisk'),
            'ProjectID' => \request('ProjectID'),
            'PersonilID' => \request('PersonilID'),
            'Rank' => \request('Rank'),
            'DueDateRisk' => \request('DueDateRisk'),
            'Mitigation' => \request('Mitigation')
        ]);
       
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiskManagement  $riskManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        RiskManagement::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
