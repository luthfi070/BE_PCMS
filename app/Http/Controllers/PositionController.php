<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Position::  join('positioncategory', 'position.PositionCatID', '=', 'positioncategory.id')
        ->select('positioncategory.CategoryName', 'position.PositionName','position.PositionCatID', 'position.id')
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
        Position::create([
            
            'PositionName'      => $request->PositionName,
            'Jobdesk'           => $request->Jobdesk,
            'PositionCatID'      => $request->PositionCatID
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
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position, $id)
    {
        //
        $data = Position::where('position.id', $id)->join('positioncategory', 'position.PositionCatID', '=', 'positioncategory.id')
        ->select('positioncategory.CategoryName', 'position.PositionName','position.PositionCatID', 'position.id')
        ->get();
        return response($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Position::where ('id',$id)->update($request->all());
        return response()->json(['status' => 'success'], 200); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Position::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }

    public function PositionbyPersonil($PersonilID)
    {
        //
        $data =  Position::where('personil.id', $PersonilID)->join('personil', 'personil.PositionID', '=', 'position.id')->get('position.*');
        return response($data);

        
    }
}
