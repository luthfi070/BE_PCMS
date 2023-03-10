<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\BaselineWbs;
use DateTime;

class BaselineWbsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $projectid)
    {
        //
        //return  DB::select('SELECT * FROM baseline_wbs ORDER BY COALESCE(parentItem, id), id');
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName,e.Userfullname
         FROM baseline_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         left JOIN user e on e.id = a.Created_By
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="' . $projectid . '" AND a.contractorID="' . $id . '"
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }
    public function DataWbsLevel($id, $itemid, $projectid)
    {
        //
        //return  DB::select('SELECT * FROM baseline_wbs ORDER BY COALESCE(parentItem, id), id');
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM baseline_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="' . $projectid . '" AND a.contractorID="' . $id . '" AND (a.id="' . $itemid . '" OR a.parentItem="' . $itemid . '")
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }
    public function getAllWbs($contractorID,$projectID)
    {
        $data = BaselineWbs::where([
            ['contractorID', '=',  $contractorID],['ProjectID', '=',  $projectID]])->get();
        return response($data);
    }

    public function getBaselineChart($projectid,$contractorid)
    {
    //     return  DB::select("SELECT
    //     a.A + COALESCE ( SUM( a.ay ), 0 ) baseline,
    //     a.ColumnB x,
    //     a.idx as month_num
    // FROM
    //     (
    //     SELECT
    //         x.*,
    //         y.A AS ay 
    //     FROM
    //         (
    //         SELECT
    //             SUM( amount ) A,
    //             MONTHNAME( endDate ) ColumnB,
    //             MONTH ( endDate ) idx 
    //         FROM
    //             baseline_wbs 
    //         WHERE
    //             parentItem IS NOT NULL 
    //             AND ProjectID = '" . $projectid . "'  
    //             AND contractorID = '" . $contractorid . "' 
    //         GROUP BY
    //             MONTH ( endDate ) 
    //         ) x
    //         LEFT OUTER JOIN (
    //         SELECT
    //             SUM( amount ) A,
    //             MONTHNAME( endDate ) ColumnB,
    //             MONTH ( endDate ) idx 
    //         FROM
    //             baseline_wbs 
    //         WHERE
    //             parentItem IS NOT NULL 
    //             AND ProjectID = '" . $projectid . "' 
    //             AND contractorID = '" . $contractorid . "' 
    //         GROUP BY
    //             MONTH ( endDate ) 
    //         ) y ON y.idx < x.idx 
    //     ) a 
    // GROUP BY
    //     a.ColumnB 
    // ORDER BY
    //     a.idx");

        $baseline = BaselineWbs::where('projectID', $projectid)->where('contractorID',$contractorid)
        ->select(DB::raw('sum(amount) as `baseline`'),DB::raw('DATE_FORMAT(endDate, "%Y-%m") date'))
        ->where('amount', '>', 0)
        ->groupby('date')
        ->get();

        $baseline_converted = [];
        foreach ($baseline as $b){
            $baseline_converted[$b->date] = $b->baseline;
        }

        $data = BaselineWbs::where('projectID', $projectid)->where('contractorID',$contractorid)
        ->select(DB::raw('min(startDate) min_date, max(endDate) max_date'))
        ->where('amount', '>', 0)
        ->first();

        $dates = [];
        $month = strtotime($data->min_date);

        $end = strtotime($data->max_date);
        $end = strtotime("+1 month", $end);

        while($month < $end)
        {
            array_push($dates, date('Y-m', $month));
            $month = strtotime("+1 month", $month);
        }

        $baseline_amount = 0;
        $baseline_final = [];
        foreach($dates as $date){
            if(isset($baseline_converted[$date])){
                $baseline_amount += $baseline_converted[$date];
            }

            array_push($baseline_final, ['baseline'=>$baseline_amount, 'x'=>$date]);
        }
        return $baseline_final;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = BaselineWbs::updateOrCreate([

            'ProjectID'      => $request->ProjectID,
            'contractorID'      => $request->contractorID,
            'itemName'      => $request->itemName,
        ],[

            
            'parentItem'      => $request->parentItem,
            'hasChild'      => $request->hasChild,
            'qty'      => $request->qty,
            'price'      => $request->price,
            'startDate'      => $request->startDate,
            'endDate'      => $request->endDate,
            'amount'      => $request->amount,
            'weight'      => $request->weight,
            'unitID'      => $request->unitID,
            'CurrencyID'      => $request->CurrencyID,
            'level' => $request->level,
            'parentlevel' => $request->parentlevel,
            'Created_By'    => $request->Created_By

        ]);

        return response()->json(['status' => 'success', 'last_insert_id' => $data->id], 200);
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
    public function show(BaselineWbs $BaselineWbs, $id)
    {
        //
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
        FROM baseline_wbs a
        left JOIN unit c on c.id=a.unitID
        left JOIN currency d on d.id = a.CurrencyID
        where a.id=?', [$id]);
    }

    public function DataWbschild(BaselineWbs $BaselineWbs, $id)
    {
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM baseline_wbs a
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
    public function getWeightWbs($projectid, $contractorid)
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
        ( SELECT id, parentItem, contractorID, ProjectID, sum( amount ) AS TotalAmount FROM baseline_wbs WHERE parentItem IS NOT NULL GROUP BY parentItem ) AS a
        JOIN ( SELECT id, parentItem, sum( amount ) AS All_TOTAL FROM baseline_wbs) AS b
        JOIN ( SELECT id AS parentID FROM baseline_wbs WHERE parentItem IS NULL ) AS c on a.parentItem =c.parentID
    WHERE
       a.contractorID = "' . $contractorid . '" 
        AND a.ProjectID = "' . $projectid . '" 
    GROUP BY
        a.id');
    }

    public function getWeightBaselineWbsByItem($id)
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
        ( SELECT id, parentItem, contractorID, ProjectID, sum( amount ) AS TotalAmount FROM baseline_wbs WHERE parentItem IS NOT NULL GROUP BY parentItem ) AS a
        JOIN ( SELECT id, parentItem, sum( amount ) AS All_TOTAL FROM baseline_wbs) AS b
        JOIN ( SELECT id AS parentID FROM baseline_wbs WHERE parentItem IS NULL ) AS c on a.parentItem =c.parentID
    WHERE
       a.contractorID IN (select contractorID from baseline_wbs where id="'.$id.'" group by id) 
        AND a.ProjectID IN (select ProjectID from baseline_wbs where id="'.$id.'" group by id) 
    GROUP BY
        a.id');
    }

    public function getWbsParentDuration($id){
        $datas = BaselineWbs::where('parentItem', $id)->get();
        $totalDuration = 0;

        // countDay
        foreach($datas as $data){
            $duration = (new DateTime($data->startDate))->diff(new DateTime($data->endDate))->format("%a");
            $totalDuration += $duration;
        }
        return response()->json(['status' => 'success', 'duration' => $totalDuration], 200);
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
        BaselineWbs::where('id', $id)->update($request->all());
        $parentItem = BaselineWbs::find($id)->parentItem;
        return response()->json(['status' => 'success', 'parentItem' => $parentItem], 200);
    }

    public function UpdateWbsChildParentLevel(Request $request, $id)
    {
        //
        BaselineWbs::where('parentItem', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function recalculateWeightWbs($projectid, $contractorid){
        $datas = BaselineWbs::where('projectID', $projectid)
        ->where('contractorID', $contractorid)
        ->get();
        $totalAmountAll = BaselineWbs::where('projectID', $projectid)
        ->where('contractorID', $contractorid)
        ->sum('amount');

        foreach ($datas as $data){
            if($data->hasChild == 'Y'){
                $totalAmountParent = BaselineWbs::where('parentItem', $data->id)->sum('amount');
                $amount = $totalAmountParent;
            }else{
                $amount = $data->amount ?? 0;
            }
            $weight = ($amount/$totalAmountAll)*100;
            $updateWeight = BaselineWbs::find($data->id)->update([
                'weight' => $weight,
            ]);
        }
        
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
        BaselineWbs::where('id', $id)->delete();
        DB::delete('DELETE
         FROM baseline_wbs
         WHERE parentItem IN
         (
             SELECT parentItem
             FROM baseline_wbs
             WHERE parentItem = ?
         )', [$id]);
        return response()->json(['status' => 'success'], 200);
    }
}
