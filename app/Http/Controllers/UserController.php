<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use DB;

class UserController extends Controller
{

    public function index()
    {
        //
        return Users::all();
    }

    public function create(Request $request)
    {
        //
        Users::updateOrCreate([

            'Userfullname'      => $request->Userfullname,
            'UserLogin'      => $request->UserLogin,
            'UserMail'      => $request->UserMail,
            'UserProfile'      => $request->UserProfile,
            'PrivilegedStatus'      => $request->PrivilegedStatus,
            'password'      => $request->password,
            'guest'      => $request->guest,
            'project'      => $request->project,

        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function getUser(Request $request)
    {

        $data = DB::select("SELECT *,a.id as UserID
    FROM
        user a 
        LEFT JOIN personil b ON b.Email = a.UserMail
        LEFT JOIN bussinesspartner c ON c.id = b.BussinessPartnerID
        -- LEFT JOIN project_numbers d ON d.BusinessPartnerID = c.id
        -- LEFT JOIN (SELECT * from projects Where setDefault='1') e ON e.ProjectID = d.ProjectID
    WHERE
        a.UserLogin = '".$request->UserLogin."'
        AND a.password = BINARY '".$request->password."'");

        if ($data) {
            return $data;
        } else {
            return response()->json(['status' => 'empty'], 202);
        }
    }

    public function getGuest(Request $request)
    {

        $data = DB::select("SELECT *,a.id as UserID
    FROM
        user a 
    WHERE
        a.UserLogin = '".$request->UserLogin."'
        AND a.password = BINARY '".$request->password."' AND guest != 0 ");

        if ($data) {
            return $data;
        } else {
            return response()->json(['status' => 'empty'], 202);
        }
    }

    public function getUserProject(Request $request){
        
        $data = DB::select("SELECT b.*
    FROM
        project_numbers a
        LEFT JOIN (SELECT * from projects Where setDefault='1') b ON b.ProjectID = a.ProjectID
    WHERE
        a.BusinessPartnerID = '".$request->BusinessPartnerID."'
        ");

        if ($data) {
            return $data;
        } else {
            return response()->json(array(), 202);
        }
    }

    public function getUserPrivileged($id)
    {
        $data = DB::select("SELECT *
        FROM
            user a 
            LEFT JOIN privilegedname b ON b.id = a.UserProfile
            LEFT JOIN userprivileged c ON c.PrivilegedNameID = b.id
        WHERE
            a.id = '".$id."'");
    
            if ($data) {
                return $data;
            } else {
                return response()->json(['status' => 'empty'], 202);
            }
    }

    public function UserPrivilegedByid(Users $Users, $id)
    {
        $data = Users::where('user.id', $id)->join('privilegedname', 'privilegedname.id', '=', 'user.UserProfile')
            ->join('userprivileged', 'userprivileged.PrivilegedNameID', '=', 'privilegedname.id')
            ->select('userprivileged.UserPrivileged', 'privilegedname.PrivilegedName', 'privilegedname.id')
            ->get();
        return response($data);
    }

    public function show(Users $Users, $id)
    {
        //
        return  DB::select("SELECT
        a.*,
        b.PrivilegedName 
        from user a join privilegedname b on b.id = a.UserProfile
        join userprivileged c on c.PrivilegedNameID = b.id
        where a.id = '".$id."'");

        // $data = Users::where('user.id', $id)->join('privilegedname', 'privilegedname.id', '=', 'user.UserProfile')
        //     ->join('userprivileged', 'userprivileged.PrivilegedNameID', '=', 'privilegedname.id')
        //     ->select('privilegedname.PrivilegedName', 'user.*')->groupBy('user.UserProfile')
        //     ->get();
        // return response($data);
    }
    public function edit(Users $Users)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
        Users::where('id', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }
    public function destroy($id)
    {
        //
        Users::where('id', $id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
