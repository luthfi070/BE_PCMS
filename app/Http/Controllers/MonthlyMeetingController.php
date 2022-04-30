<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyMeeting;
use Illuminate\Support\Str;

class MonthlyMeetingController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MonthlyMeeting::get();
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

        $b64 = $inp['file'];  // your base64 encoded
        $name = Str::random(10) . '.pdf';
        $file = file_put_contents($name, base64_decode($b64));

        if($inp) {
            $dbs = new MonthlyMeeting();

            foreach($inp as $key => $row){
                $dbs->$key = $inp[$key];
            }
            $dbs->file = $name;

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
        return MonthlyMeeting::find($id)->toJson();
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
            $dbs = MonthlyMeeting::find($request->id);

            $inp = $request->all();

            if (!empty($inp['file'])) {
                $b64 = $inp['file'];  // your base64 encoded
                $name = Str::random(10) . '.pdf';
                $file = file_put_contents($name, base64_decode($b64));
                $inp['file'] = $name;
            }else{
                array_filter($inp);
            }

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
        $deleted = MonthlyMeeting::destroy($id);

        if($deleted)
            return json_encode(array('status' => 'ok;', 'text' => ''));
        else
            return json_encode(array('status' => 'error;', 'text' => 'Gagal Delete Data' ));
    }
}
