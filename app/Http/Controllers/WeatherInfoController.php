<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeatherInfo;

class WeatherInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WeatherInfo::leftJoin('weather','weather.id','weather_info.condition')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inp = $request->all();

        if($inp) {
            $dbs = new WeatherInfo();

            foreach($inp as $key => $row){
                $dbs->$key = $inp[$key];
            }

            if($dbs->save())
                return json_encode(array('status' => 'ok;', 'text' => ''));
            else
                return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data' ));
        }
        else return json_encode(array('status' => 'error;', 'text' => 'Gagal Menyimpan Data' ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return WeatherInfo::find($id)->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $dbs = WeatherInfo::find($request->id);

            $inp = $request->post('edit');
            if($inp){
                foreach($inp as $key => $row){
                    $dbs->$key = $inp[$key];
                }
            }

            $dbs->save();

            return json_encode(array('status' => 'ok;', 'text' => ''));

        } catch (\Illuminate\Database\QueryException $e) {
            return json_encode(array('status' => 'error;', 'text' => 'Gagal Update Data' ));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = WeatherInfo::destroy($id);

        if($deleted)
            return json_encode(array('status' => 'ok;', 'text' => ''));
        else
            return json_encode(array('status' => 'error;', 'text' => 'Gagal Delete Data' ));
    }
}
