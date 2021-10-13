<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPrivileged;

class UserPrivilegedController extends Controller
{
    //
    public function index()
    {
        //
        return UserPrivileged:: join('privilegedname', 'userprivileged.PrivilegedNameID', '=', 'privilegedname.id')
        ->select('privilegedname.PrivilegedName', 'userprivileged.*')
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
        UserPrivileged::updateOrCreate([
            
            'UserPrivileged'      => $request->UserPrivileged,
            'PrivilegedNameID'      => $request->PrivilegedNameID],
            ['status'      => $request->status]);

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
    public function show(UserPrivileged $UserPrivileged, $id)
    {
        //
        $data = UserPrivileged::where('PrivilegedNameID', $id)->get();
        return response($data);
    }

    public function SpecPrivilegedByid(UserPrivileged $UserPrivileged, $id)
    {
        //
        $data = UserPrivileged::where('id', $id)->get();
        return response($data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPrivileged $UserPrivileged)
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
        UserPrivileged::where ('id',$id)->update($request->all());
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
        UserPrivileged::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
