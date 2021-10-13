<?php

namespace App\Http\Controllers;

use App\Models\ContractorEquipment;
use Illuminate\Http\Request;

class ContractorEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        

        return ContractorEquipment::where('contractor_equipment.BusinessPartnerID', $id)->join('bussinesspartner', 'contractor_equipment.BusinessPartnerID', '=', 'bussinesspartner.id')
        ->join('unit', 'contractor_equipment.UnitID', '=', 'unit.id')
        ->join('projects', 'contractor_equipment.ProjectID', '=', 'projects.ProjectID')
        ->select('contractor_equipment.*','projects.ProjectID','bussinesspartner.BussinessName', 'unit.unitName')
        ->get();

        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        ContractorEquipment::create([

            'EquipmentName'         => $request->EquipmentName,
            'ProjectID'             => $request->ProjectID,
            'BusinessPartnerID'     => $request->BusinessPartnerID,
            'UnitID'                => $request->UnitID,
            'MobilizationDate'      => $request->MobilizationDate,
            'DemobilizationDate'    => $request->DemobilizationDate
          
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
     * @param  \App\Models\ContractorEquipment  $contractorEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(ContractorEquipment $contractorEquipment, $id)
    {
        //
        $data = ContractorEquipment::where('contractor_equipment.id', $id)->join('bussinesspartner', 'contractor_equipment.BusinessPartnerID', '=', 'bussinesspartner.id')
        ->join('unit', 'contractor_equipment.UnitID', '=', 'unit.id')
        ->join('projects', 'contractor_equipment.ProjectID', '=', 'projects.ProjectID')
        ->select('contractor_equipment.*','projects.ProjectID','bussinesspartner.BussinessName', 'unit.unitName')
        ->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContractorEquipment  $contractorEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractorEquipment $contractorEquipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContractorEquipment  $contractorEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        ContractorEquipment::where('id', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContractorEquipment  $contractorEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        ContractorEquipment::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
