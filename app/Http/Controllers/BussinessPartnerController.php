<?php

namespace App\Http\Controllers;

use App\Models\BussinessPartner;
use App\Models\ProjectNumber;
use Illuminate\Http\Request;
use DB;

class BussinessPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return BussinessPartner::  join('bussiness_types', 'bussinesspartner.BussinessTypeID', '=', 'bussiness_types.id')
        ->join('country','bussinesspartner.CountryID','=','country.id')
        ->join('city','bussinesspartner.CityID','=','city.id')
        ->select('bussinesspartner.*', 'country.CountryName','city.CityName', 'bussiness_types.BussinessTypeName')
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
        BussinessPartner::create([

            'BussinessName'     => $request->BussinessName,
            'BussinessTypeID'   => $request->BussinessTypeID,
            'Address'           => $request->Address,
            'CountryID'         => $request->CountryID,
            'CityID'            => $request->CityID,
            'Phone'             => $request->Phone,
            'Fax'               => $request->Fax,
            'MobilePhone'       => $request->MobilePhone,
            'Email'             => $request->Email,
            'Web'               => $request->Web
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
     * @param  \App\Models\BussinessPartner  $bussinessPartner
     * @return \Illuminate\Http\Response
     */
    public function show(BussinessPartner $bussinessPartner, $id)
    {
        //
        $data = BussinessPartner::where('bussinesspartner.id', $id)->join('bussiness_types', 'bussinesspartner.BussinessTypeID', '=', 'bussiness_types.id')
        ->join('country','bussinesspartner.CountryID','=','country.id')
        ->join('city','bussinesspartner.CityID','=','city.id')
        ->select('bussinesspartner.*', 'country.CountryName','city.CityName', 'bussiness_types.BussinessTypeName')
        ->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BussinessPartner  $bussinessPartner
     * @return \Illuminate\Http\Response
     */
    public function DataContractor($id)
    {
        return ProjectNumber::where('project_numbers.ProjectID','=', $id)->where('bussiness_types.BussinessTypeName','like','%Contractor%')
        ->join('projects', 'projects.ProjectID', '=', 'project_numbers.ProjectID')
        ->join('bussinesspartner', 'bussinesspartner.id', '=', 'project_numbers.BusinessPartnerID')
        ->join('bussiness_types', 'bussiness_types.id', '=', 'bussinesspartner.BussinessTypeID')
        ->select('bussinesspartner.*')
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BussinessPartner  $bussinessPartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        BussinessPartner::where('id', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BussinessPartner  $bussinessPartner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        BussinessPartner::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
