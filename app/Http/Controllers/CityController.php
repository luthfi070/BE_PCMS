<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return City:: join('country', 'city.CountryID', '=', 'country.id')
        ->select('country.CountryName', 'city.CityName', 'city.id')
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
        City::updateOrCreate([
            
            'CityName'      => $request->CityName,
            'CountryID'     => $request->CountryID ]);

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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city,$id)
    {
        //
        $data = City::where('city.id', $id)->join('country', 'city.CountryID', '=', 'country.id')
        ->select('city.CountryID','country.CountryName', 'city.CityName', 'city.id')
        ->get();
        return response($data);
    }

    public function DataCityByCountryId($id)
    {
        //
        $data = City::where('city.CountryID', $id)->join('country', 'city.CountryID', '=', 'country.id')
        ->select('city.CountryID','country.CountryName', 'city.CityName', 'city.id')
        ->get();
        return response($data);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        City::where ('id',$id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        City::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
