<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Unit::all();
    }

    public function getOrInsertUnitBySymbol($symbol){
        $unit = Unit::where(DB::raw('lower(unitSymbol)'), '=', strtolower($symbol))
        ->orWhere(DB::raw('lower(unitName)'), '=', strtolower($symbol))->first();
        if(empty($unit)){
            $unit = Unit::create([
                'unitName' => $symbol,
                'unitSymbol' => $symbol
            ]);
        }

        return response()->json($unit);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        Unit::updateOrCreate([
            
            'unitName'      => $request->unitName,
            'unitSymbol'      => $request->unitSymbol]);

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
    public function show(Unit $unit, $id)
    {
        //
        $data = Unit::where('id', $id)->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
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
        Unit::where ('id',$id)->update($request->all());
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
        Unit::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
