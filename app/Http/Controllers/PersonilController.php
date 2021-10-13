<?php

namespace App\Http\Controllers;

use App\Models\Personil;
use Illuminate\Http\Request;
use DB;

class PersonilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Personil::  join('bussinesspartner', 'bussinesspartner.id', '=', 'personil.BussinessPartnerID')
        ->join('country','personil.CountryID','=','country.id')
        ->join('city','personil.CityID','=','city.id')
        ->join('position','personil.PositionID','=','position.id')
        ->select('personil.*', 'country.CountryName','city.CityName', 'bussinesspartner.BussinessName','position.PositionName')
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
        Personil::create([
            
            'BussinessPartnerID'       => $request->BussinessPartnerID,
            'PersonilName'             => $request->PersonilName,
            'Address'                  => $request->Address,
            'Postzip'                  => $request->Postzip,
            'CountryID'                => $request->CountryID,
            'CityID'                   => $request->CityID,
            'Phone'                    => $request->Phone,
            'Hp'                       => $request->Hp,
            'Email'                    => $request->Email,
            'PositionID'               => $request->PositionID
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
     * @param  \App\Models\Personil  $personil
     * @return \Illuminate\Http\Response
     */
    public function show(Personil $personil, $id)
    {
        //

        $data = Personil::where('bussinesspartner.id', $id)->join('bussinesspartner', 'bussinesspartner.id', '=', 'personil.BussinessPartnerID')
        ->join('country','personil.CountryID','=','country.id')
        ->join('city','personil.CityID','=','city.id')
        ->join('position','personil.PositionID','=','position.id')
        ->select('personil.*', 'country.CountryName','city.CityName', 'bussinesspartner.BussinessName', 'position.PositionName')
        ->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personil  $personil
     * @return \Illuminate\Http\Response
     */
    public function edit(Personil $personil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personil  $personil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Personil::where ('id',$id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personil  $personil
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Personil::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function PersonilbyPosition($PositionID)
    {
        //
        $data =  Personil::where('PositionID', $PositionID)->get();
        return response($data);
    }

    public function PersonilbyPartner($BussinessPartnerID)
    {
        //
        $data =  Personil::where('BussinessPartnerID', $BussinessPartnerID)->get();
        return response($data);

        
    }

    public function PersonilbyPartnerProject($id)
    {
        //
        return DB::select('SELECT a.* from personil a 
        join bussinesspartner b on b.id = a.BussinessPartnerID
        join project_numbers c on c.BusinessPartnerID=b.id
        where c.ProjectID="'.$id.'" and b.BussinessTypeID=1');

        
    }

    
}
