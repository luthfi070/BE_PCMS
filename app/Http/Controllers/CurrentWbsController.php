<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ActualWbs;

class CurrentWbsController extends Controller
{

    public function index($id, $projectid)
    {
        //
        //return  DB::select('SELECT * FROM baseline_wbs ORDER BY COALESCE(parentItem, id), id');
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM actual_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="' . $projectid . '" AND a.contractorID="' . $id . '"
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }

    public function DataActualWbsLevel($id, $itemid, $projectid)
    {
        //
        //return  DB::select('SELECT * FROM baseline_wbs ORDER BY COALESCE(parentItem, id), id');
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM actual_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
        --  where a.hasChild IS NOT NULL AND (a.hasChild != "" OR a.hasChild != 0)
        where a.ProjectID="' . $projectid . '" AND a.contractorID="' . $id . '" AND (a.id="' . $itemid . '" OR a.parentItem="' . $itemid . '")
        ORDER BY a.parentlevel, COALESCE(a.parentItem, a.id), a.level');
    }
    public function getAllCurrentWbs($contractorID,$projectID)
    {
        $data = ActualWbs::where([
            ['contractorID', '=',  $contractorID],['ProjectID', '=',  $projectID]])->get();
        return response($data);
    }

    public function DataWbschild(ActualWbs $BaselineWbs, $id)
    {
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM actual_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where a.parentItem = ? and (a.hasChild IS NULL or a.hasChild = 0)
         ORDER BY COALESCE(a.parentItem, a.id), a.id', [$id]);
    }

    public function getCurrentWbsChart($projectid,$contractorid)
    {
//         return  DB::select("SELECT
//         COALESCE(a.baseline,0) baseline, COALESCE(a.x,b.x) x, COALESCE(a.month_num,b.month_num) month_num, b.actual
// FROM
//     (
//    SELECT
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
//     a.idx
//     ) a right outer join 
//     (
//         SELECT
//     a.A + COALESCE ( SUM( a.ay ), 0 ) actual,
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
//             actual_wbs 
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
//             actual_wbs 
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
//     a.idx
//         ) b on b.x=a.x
// GROUP BY
//     x 
// ORDER BY
//     month_num");

        $baselineWbsController = new BaselineWbsController();
        $baseline = $baselineWbsController->getBaselineChart($projectid,$contractorid);
        $baseline_converted = [];
        $max_date_baseline = $baseline[0]['x'].'-01';
        $min_date_baseline = $baseline[0]['x'].'-01';
        foreach ($baseline as $b){
            $baseline_converted[$b['x']] = $b['baseline'];
            if(strtotime($b['x'].'-01') < strtotime($min_date_baseline.'-01')){
                $min_date_baseline = $b['x'].'-01';
            }
            if(strtotime($b['x'].'-01') > strtotime($max_date_baseline.'-01')){
                $max_date_baseline = $b['x'].'-01';
            }
        }

        $actual = ActualWbs::where('projectID', $projectid)->where('contractorID',$contractorid)
        ->select(DB::raw('sum(amount) as `actual`'),DB::raw('DATE_FORMAT(endDate, "%Y-%m") date'))
        ->where('amount', '>', 0)
        ->groupby('date')
        ->get();

        $actual_converted = [];
        foreach ($actual as $a){
            $actual_converted[$a->date] = $a->actual;
        }

        $data = ActualWbs::where('projectID', $projectid)->where('contractorID',$contractorid)
        ->select(DB::raw('min(endDate) min_date, max(endDate) max_date'))
        ->where('amount', '>', 0)
        ->first();

        $actual_min_date_plus = strtotime("-1 month", strtotime($data->min_date));
        $actual_max_date_plus = strtotime("+1 month", strtotime($data->max_date));

        $min_date = strtotime($min_date_baseline) < $actual_min_date_plus ? $min_date_baseline : date('Y-m-d', $actual_min_date_plus);
        $max_date = strtotime($max_date_baseline) > $actual_max_date_plus ? $max_date_baseline : date('Y-m-d', $actual_max_date_plus);

        $dates = [];
        $month = strtotime($min_date);
        $end = strtotime($max_date);
        $end = strtotime("+1 month", $end);

        while($month < $end)
        {
            array_push($dates, date('Y-m', $month));
            $month = strtotime("+1 month", $month);
        }

        $baseline_amount = 0;
        $actual_amount = 0;
        $actual_baseline_final = [];
        foreach($dates as $date){
            if(isset($actual_converted[$date])){
                $actual_amount += $actual_converted[$date];
            }
            if(isset($baseline_converted[$date])){
                $baseline_amount = $baseline_converted[$date];
            }

            array_push($actual_baseline_final, ['baseline'=>$baseline_amount, 'actual'=>$actual_amount, 'x'=>$date]);
        }
        return $actual_baseline_final;
    }

    public function create(Request $request)
    {
        //
        $data = ActualWbs::updateOrCreate([

            'itemName'      => $request->itemName,
            'parentItem'      => $request->parentItem,
            'hasChild'      => $request->hasChild,
            'qty'      => $request->qty,
            'price'      => $request->price,
            'amount'      => $request->amount,
            'weight'      => $request->weight,
            'startDate' => $request->startDate ?? '0000-00-00',
            'endDate' => $request->endDate ?? '0000-00-00',
            'ProjectID'      => $request->ProjectID,
            'unitID'      => $request->unitID,
            'contractorID'      => $request->contractorID,
            'CurrencyID'      => $request->CurrencyID,
            'level' => $request->level,
            'parentlevel' => $request->parentlevel,
            'Created_By'    => $request->Created_By

        ]);

        return response()->json(['status' => 'success', 'last_insert_id' => $data->id], 200);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(ActualWbs $ActualWbs, $id)
    {
        //
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
        FROM actual_wbs a
        left JOIN unit c on c.id=a.unitID
        left JOIN currency d on d.id = a.CurrencyID
        where a.id=?', [$id]);
    }

    public function DataActualWbschild(ActualWbs $ActualWbs, $id)
    {
        return  DB::select('SELECT a.*,c.UnitName,d.currencyName
         FROM actual_wbs a
         left JOIN unit c on c.id=a.unitID
         left JOIN currency d on d.id = a.CurrencyID
         where a.parentItem = ? and (a.hasChild IS NULL or a.hasChild = 0)
         ORDER BY COALESCE(a.parentItem, a.id), a.id', [$id]);
    }


    public function getWeightActualWbs($projectid, $contractorid)
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
        ( SELECT id, parentItem, contractorID, ProjectID, sum( amount ) AS TotalAmount FROM actual_wbs WHERE parentItem IS NOT NULL GROUP BY parentItem ) AS a
        JOIN ( SELECT id, parentItem, sum( amount ) AS All_TOTAL FROM actual_wbs) AS b
        JOIN ( SELECT id AS parentID FROM actual_wbs WHERE parentItem IS NULL ) AS c on a.parentItem =c.parentID
    WHERE
       a.contractorID = "' . $contractorid . '" 
        AND a.ProjectID = "' . $projectid . '" 
    GROUP BY
        a.id');
    }

    
    public function getWeightCurrentWbsByItem($id)
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
        ( SELECT id, parentItem, contractorID, ProjectID, sum( amount ) AS TotalAmount FROM actual_wbs WHERE parentItem IS NOT NULL GROUP BY parentItem ) AS a
        JOIN ( SELECT id, parentItem, sum( amount ) AS All_TOTAL FROM actual_wbs) AS b
        JOIN ( SELECT id AS parentID FROM actual_wbs WHERE parentItem IS NULL ) AS c on a.parentItem =c.parentID
    WHERE
       a.contractorID IN (select contractorID from actual_wbs where id="'.$id.'" group by id) 
        AND a.ProjectID IN (select ProjectID from actual_wbs where id="'.$id.'" group by id) 
    GROUP BY
        a.id');
    }


    public function update(Request $request, $id)
    {
        //
        ActualWbs::where('id', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function UpdateActualWbsChildParentLevel(Request $request, $id)
    {
        //
        ActualWbs::where('parentItem', $id)->update($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function recalculateWeightCurrentWbs($projectid, $contractorid)
    {
        $datas = ActualWbs::where('projectID', $projectid)
        ->where('contractorID', $contractorid)
        ->get();
        $totalAmountAll = ActualWbs::where('projectID', $projectid)
        ->where('contractorID', $contractorid)
        ->sum('amount');

        foreach ($datas as $data){
            if($data->hasChild == 'Y'){
                $totalAmountParent = ActualWbs::where('parentItem', $data->id)->sum('amount');
                $amount = $totalAmountParent;
            }else{
                $amount = $data->amount ?? 0;
            }
            $weight = ($amount/$totalAmountAll)*100;
            $updateWeight = ActualWbs::find($data->id)->update([
                'weight' => $weight,
            ]);
        }
        
        return response()->json(['status' => 'success'], 200);
    }

   
    public function destroy($id)
    {
        //
        ActualWbs::where('id', $id)->delete();
        DB::delete('DELETE
         FROM actual_wbs
         WHERE parentItem IN
         (
             SELECT parentItem
             FROM actual_wbs
             WHERE parentItem = ?
         )', [$id]);
        return response()->json(['status' => 'success'], 200);
    }
}
