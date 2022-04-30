<?php

namespace App\Http\Controllers;

use App\Models\BussinessType;
use Illuminate\Http\Request;

class BussinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return BussinessType:: all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        BussinessType::create([
            'BussinessTypeName' => $request->BussinessTypeName
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
     * @param  \App\Models\BussinessType  $bussinessType
     * @return \Illuminate\Http\Response
     */
    public function show(BussinessType $bussinessType, $id)
    {
        //
        $data = BussinessType::where('id', $id)->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BussinessType  $bussinessType
     * @return \Illuminate\Http\Response
     */
    public function edit(BussinessType $bussinessType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BussinessType  $bussinessType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        BussinessType::where ('id',$id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BussinessType  $bussinessType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        BussinessType::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function bytype($type)
    {
        //
        $data = BussinessType::where('BussinessTypeName', $type)
        ->join('bussinesspartner', 'bussiness_types.id', '=','bussinesspartner.BussinessTypeID')
        ->get();
        return response($data);
    }
}
