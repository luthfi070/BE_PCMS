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
        return  DB::select("SELECT
        COALESCE(a.baseline,0) baseline, COALESCE(a.x,b.x) x, COALESCE(a.month_num,b.month_num) month_num, b.actual
FROM
    (
   SELECT
    a.A + COALESCE ( SUM( a.ay ), 0 ) baseline,
    a.ColumnB x,
    a.idx as month_num
FROM
    (
    SELECT
        x.*,
        y.A AS ay 
    FROM
        (
        SELECT
            SUM( amount ) A,
            MONTHNAME( endDate ) ColumnB,
            MONTH ( endDate ) idx 
        FROM
            baseline_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ProjectID = '" . $projectid . "'  
            AND contractorID = '" . $contractorid . "' 
        GROUP BY
            MONTH ( endDate ) 
        ) x
        LEFT OUTER JOIN (
        SELECT
            SUM( amount ) A,
            MONTHNAME( endDate ) ColumnB,
            MONTH ( endDate ) idx 
        FROM
            baseline_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ProjectID = '" . $projectid . "' 
            AND contractorID = '" . $contractorid . "' 
        GROUP BY
            MONTH ( endDate ) 
        ) y ON y.idx < x.idx 
    ) a 
GROUP BY
    a.ColumnB 
ORDER BY
    a.idx
    ) a right outer join 
    (
        SELECT
    a.A + COALESCE ( SUM( a.ay ), 0 ) actual,
    a.ColumnB x,
    a.idx as month_num
FROM
    (
    SELECT
        x.*,
        y.A AS ay 
    FROM
        (
        SELECT
            SUM( amount ) A,
            MONTHNAME( endDate ) ColumnB,
            MONTH ( endDate ) idx 
        FROM
            actual_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ProjectID = '" . $projectid . "'  
            AND contractorID = '" . $contractorid . "' 
        GROUP BY
            MONTH ( endDate ) 
        ) x
        LEFT OUTER JOIN (
        SELECT
            SUM( amount ) A,
            MONTHNAME( endDate ) ColumnB,
            MONTH ( endDate ) idx 
        FROM
            actual_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ProjectID = '" . $projectid . "' 
            AND contractorID = '" . $contractorid . "' 
        GROUP BY
            MONTH ( endDate ) 
        ) y ON y.idx < x.idx 
    ) a 
GROUP BY
    a.ColumnB 
ORDER BY
    a.idx
        ) b on b.x=a.x
GROUP BY
    x 
ORDER BY
    month_num");
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
