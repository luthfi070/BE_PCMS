<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\HistoryBoq;

class HistoryBoqController extends Controller
{
    //
    public function index()
    {
        //
         //return  DB::select('SELECT * FROM baselineboq ORDER BY COALESCE(parentItem, id), id');
         return  DB::select('SELECT a.*, count(id)as total_item FROM history_boq a where a.parentItem IS NULL and (a.hasChild IS NOT NULL and a.hasChild != 0)  GROUP by created_at,Created_By');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = HistoryBoq::Create([
            'boqID' => $request->boqID,
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
            'parentLevel' => $request->parentlevel,
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
    public function show(HistoryBoq $HistoryBoq, $id)
    {
        //
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
        FROM baselineboq a
        left JOIN unit c on c.id=a.unitID
        left JOIN currency d on d.id = a.CurrencyID
        where a.id=?',[$id]);
    }

    public function DataBoqByidHistory(HistoryBoq $HistoryBoq, $ProjectID, $contractorID, $created_at, $time_at)
    {
        //
        $created_at=$created_at.' '.$time_at;
        // return DB::select('SELECT a.*,c.UnitName,d.currencyName
        // FROM history_boq a
        // left JOIN unit c on c.id=a.unitID
        // left JOIN currency d on d.id = a.CurrencyID
        // where a.ProjectID=? and a.contractorID = ? and a.created_at like ?',[$ProjectID, $contractorID, $created_at]);

        return DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM history_boq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where (a.hasChild IS NOT NULL and a.hasChild != 0)
       and a.ProjectID IS NULL and a.contractorID IS NULL and a.created_at like ? 
        ORDER BY COALESCE(a.parentItem, a.boqID), a.boqID',[$created_at]);
    }

    public function DataBoqchild(HistoryBoq $HistoryBoq, $id){
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM history_boq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where a.parentItem = ? and (a.hasChild IS NULL or a.hasChild = 0)
         ORDER BY COALESCE(a.parentItem, a.id), a.id', [$id]);
    }

    public function DataBoqchildHistory (HistoryBoq $HistoryBoq, $id){
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM history_boq a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where a.parentItem = ? and (a.hasChild IS NULL or a.hasChild = 0)
         ORDER BY COALESCE(a.parentItem, a.boqID), a.boqID', [$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(HistoryBoq $HistoryBoq)
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
        HistoryBoq::where ('id',$id)->update($request->all());
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
        HistoryBoq::where('id',$id)->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
