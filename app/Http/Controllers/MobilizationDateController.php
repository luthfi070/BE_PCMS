<?php

namespace App\Http\Controllers;
use DB;
use App\Models\MobilizationDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MobilizationDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return MobilizationDate::join('projects', 'mobilization_dates.ProjectID', '=', 'projects.ProjectID')
        ->join('bussinesspartner','mobilization_dates.BusinessPartnerID','=','bussinesspartner.id')
        ->join('personil','mobilization_dates.PersonilID','=','personil.id')
        ->join('positioncategory','mobilization_dates.PositionCatID','=','positioncategory.id')
        ->join('position','mobilization_dates.PositionID','=','position.id')
        ->select('mobilization_dates.*','bussinesspartner.BussinessName','positioncategory.CategoryName', 'position.PositionName','personil.PersonilName')
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
        MobilizationDate::create([

            'CurrentManMonth'        => $request->CurrentManMonth,
            'Schedule'               => $request->Schedule,
            'ProjectID'              => $request->ProjectID,
            'BusinessPartnerID'      => $request->BusinessPartnerID,
            'PersonilID'             => $request->PersonilID,
            'PositionCatID'          => $request->PositionCatID,
            
            'PositionID'             => $request->PositionID,
            'StarDateMobilization'   => $request->StarDateMobilization,
            'EndDateMobilization'    => $request->EndDateMobilization
            


          
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
    public function show(MobilizationDate $MobilizationDate, $id)
    {
        //
        return MobilizationDate::where('mobilization_dates.id', $id)
        ->join('projects', 'mobilization_dates.ProjectID', '=', 'projects.ProjectID')
        ->join('bussinesspartner','mobilization_dates.BusinessPartnerID','=','bussinesspartner.id')
        ->join('personil','mobilization_dates.PersonilID','=','personil.id')
        ->join('positioncategory','mobilization_dates.PositionCatID','=','positioncategory.id')
        ->join('position','mobilization_dates.PositionID','=','position.id')
        ->select('mobilization_dates.*','bussinesspartner.BussinessName','personil.PersonilName','positioncategory.CategoryName', 'position.PositionName')
        ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RiskManagement  $riskManagement
     * @return \Illuminate\Http\Response
     */
    public function edit(MobilizationDate $riskManagement)
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
        MobilizationDate::where ('id',$id)->update($request->all());
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
        MobilizationDate::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function byBusinessPartner($BusinessPartner)
    {
       return DB::select('SELECT a.*,d.CategoryName, c.PositionName,b.BussinessName
       from mobilization_dates a 
        left JOIN bussinesspartner b on b.id = a.BusinessPartnerID
    --    left JOIN personil e on e.id = a.PersonilID
       left JOIN position c on c.id = a.PositionID 
       left JOIN positioncategory d on d.id = a.PositionCatID
       where b.id=?',[$BusinessPartner]);

        // $data = MobilizationDate::where('personil.id', $personil)
       
        // // ->join('bussinesspartner','mobilization_dates.BusinessPartnerID','=','bussinesspartner.id')
        // ->join('personil','mobilization_dates.id','=','personil.id')
        // ->join('position','mobilization_dates.PositionID','=','position.id')
        // ->join('positioncategory','position.PositionCatID','=','positioncategory.id')
       
        // ->select('positioncategory.CategoryName')
        // ->get();
        // return response($data);
    }

    public function DataMobilizationPositionCat($id){
        return DB::select("select a.* from positioncategory a
        join position b on b.PositionCatID = a.id
        join personil c on c.PositionID=b.id
        where c.id = '".$id."' ");
    }
    public function DataMobilizationPosition($id){
        return DB::select("select b.* from positioncategory a
        join position b on b.PositionCatID = a.id
        where a.id = '".$id."' ");
    }
}
