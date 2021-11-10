<?php

namespace App\Http\Controllers;

use App\Models\ProjectNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ProjectNumber:: all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        Log::info('PN insert', \request()->all());
        ProjectNumber::create(request()->all());
        // try{
        //     ProjectNumber::create(request()->all());
        //     // ProjectNumber::create([

        //     //     'ContractNumber'        => $request->ContracNumber,
        //     //     'ProjectID'             => $request->ProjectID,
        //     //     'BusinessPartnerID'     => $request->BusinessPartnerID,
        //     //     'PositionID'            => $request->PositionID,
        //     //     'StartDate'             => $request->StartDate,
        //     //     'EndDate'               => $request->EndDate,
        //     //     'Length'                => $request->Length,
        //     //     'TotalAmount'           => $request->TotalAmount,
        //     //     'ScopeOfWork'           => $request->ScopeOfWork,
        //     // ]);

        // } catch(Exception $e){
        //     Log::error("error save", $e);
        // }
        
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
     * @param  \App\Models\ProjectNumber  $projectNumber
     * @return \Illuminate\Http\Response
     */
    public function showContractor(ProjectNumber $ProjectNumber, $id)
    {
        //
        $data = ProjectNumber::where('ProjectID' , $id)
        ->where('BussinessTypeID', 1)
        // ->join('projects','project_numbers.ProjectID','=','projects.ProjectID')
        ->join('bussinesspartner','project_numbers.BusinessPartnerID','=','bussinesspartner.id')
        ->join('personil','bussinesspartner.id','=','personil.BussinessPartnerID')
        ->select('project_numbers.*','bussinesspartner.BussinessName','personil.PersonilName')
        ->get();
        return response($data);
    }

    public function showConsultant(ProjectNumber $ProjectNumber, $id)
    {
        //
        $data = ProjectNumber::where('ProjectID' , $id)
        ->where('BussinessTypeID', 2)
        // ->join('projects','project_numbers.ProjectID','=','projects.ProjectID')
        ->join('bussinesspartner','project_numbers.BusinessPartnerID','=','bussinesspartner.id')
        ->join('personil','bussinesspartner.id','=','personil.BussinessPartnerID')
        ->select('project_numbers.*','bussinesspartner.BussinessName','personil.PersonilName')
        ->get();
        return response($data);
    }

    public function getProjectIDConsultant(ProjectNumber $ProjectNumber, $id)
    {
        //
        $data = ProjectNumber::where('ProjectID' , $id)
        ->where('BussinessTypeID', 2)
        // ->join('projects','project_numbers.ProjectID','=','projects.ProjectID')
        ->join('bussinesspartner','project_numbers.BusinessPartnerID','=','bussinesspartner.id')
        
        ->select('project_numbers.ProjectID')
        ->get();
        return response($data);
    }
    
    public function getProjectIDConContractor(ProjectNumber $ProjectNumber, $id)
    {
        //
        $data = ProjectNumber::where('ProjectID' , $id)
        ->where('BussinessTypeID', 1)
        // ->join('projects','project_numbers.ProjectID','=','projects.ProjectID')
        ->join('bussinesspartner','project_numbers.BusinessPartnerID','=','bussinesspartner.id')
        
        ->select('project_numbers.ProjectID')
        ->get();
        return response($data);
    }
    
    public function getLastProjectNumber()
    {
        //
        $data = ProjectNumber::max('ContractNumber');
        // Log::info("last_id", $data);
        // ->select('project_numbers.ContractNumber')
        // ->get();
        return response($data);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectNumber  $projectNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectNumber $projectNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectNumber  $projectNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectNumber $projectNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectNumber  $projectNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectNumber $projectNumber)
    {
        //
    }
}
