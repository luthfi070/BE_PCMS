<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\BaselineBoq;

class BaselineBoqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id,$projectid)
    {
        //
         //return  DB::select('SELECT * FROM baselineboq ORDER BY COALESCE(parentItem, id), id');
         return  DB::select('SELECT a.*,c.UnitName,d.currencyName,e.Userfullname
         FROM baselineboq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         left JOIN user e on e.id = a.Created_By
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="'.$projectid.'" AND a.contractorID="'.$id.'"
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }
    public function DataBoqLevel($id,$itemid,$projectid)
    {
        //
         //return  DB::select('SELECT * FROM baselineboq ORDER BY COALESCE(parentItem, id), id');
         return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM baselineboq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="'.$projectid.'" AND a.contractorID="'.$id.'" AND (a.id="'.$itemid.'" OR a.parentItem="'.$itemid.'")
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }
    public function getAllBoq($contractorID,$projectID)
    {
        $data = BaselineBoq::where([
            ['contractorID', '=',  $contractorID],['ProjectID', '=',  $projectID]])->get();
        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = BaselineBoq::updateOrCreate([
            
            'itemName'      => $request->itemName,
            'parentItem'      => $request->parentItem,
            'hasChild'      => $request->hasChild,
            'qty'      => $request->qty,
            'price'      => $request->price,
            'amount'      => $request->amount,
            'weight'      => $request->weight,
            'ProjectID'      => $request->ProjectID,
            'unitID'      => $request->unitID,
            'contractorID'      => $request->contractorID,
            'CurrencyID'      => $request->CurrencyID,
            'level' => $request->level,
            'parentlevel' => $request->parentlevel,
            'Created_By'    => $request->Created_By

            ]);

            return response()->json(['status' => 'success','last_insert_id' => $data->id], 200);
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
    public function show(BaselineBoq $BaselineBoq, $id)
    {
        //
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
        FROM baselineboq a
        left JOIN unit c on c.id=a.unitID
        left JOIN currency d on d.id = a.CurrencyID
        where a.id=?',[$id]);
    }

    public function DataBoqchild(BaselineBoq $BaselineBoq, $id){
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM baselineboq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where a.parentItem = ? and (a.hasChild IS NULL or a.hasChild = 0)
         ORDER BY COALESCE(a.parentItem, a.id), a.id', [$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function getWeightBoq($projectid,$contractorid)
    {
        return DB::select('SELECT
        a.id,
        c.parentID,
        a.parentItem,
        a.TotalAmount,
        a.contractorID,
        a.ProjectID,
        b.All_TOTAL,
        ( a.TotalAmount / b.All_TOTAL )* 100 AS ParentWeight
    FROM
        ( SELECT id, parentItem, contractorID, ProjectID, sum( amount ) AS TotalAmount FROM baselineboq WHERE parentItem IS NOT NULL GROUP BY parentItem ) AS a
        JOIN ( SELECT id, parentItem, sum( amount ) AS All_TOTAL FROM baselineboq) AS b
        JOIN ( SELECT id AS parentID FROM baselineboq WHERE parentItem IS NULL ) AS c on a.parentItem =c.parentID
    WHERE
       a.contractorID = "'.$contractorid.'" 
        AND a.ProjectID = "'.$projectid.'" 
    GROUP BY
        a.id');
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
        BaselineBoq::where ('id',$id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function UpdateBoqChildParentLevel(Request $request, $id)
    {
        //
        BaselineBoq::where ('parentItem',$id)->update($request->all());
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
        BaselineBoq::where('id',$id)->delete();
        DB::delete('DELETE
         FROM baselineboq
         WHERE parentItem IN
         (
             SELECT parentItem
             FROM baselineboq
             WHERE parentItem = ?
         )',[$id]);
        return response()->json(['status' => 'success'], 200);
    }
}
