<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\ActualWbs;

class ActualWbsController extends Controller
{
    public function index($contractorID, $projectID)
    {
        //
        //return  DB::select('SELECT * FROM baselineboq ORDER BY COALESCE(parentItem, id), id');
        return  DB::select("SELECT
        b.*,
c.periode,
c.progressName,
c.estimatedQty,
(select sum(c.amount)FROM
    projects a
    LEFT JOIN actual_wbs b ON b.ProjectID = a.ProjectID
    LEFT JOIN progress_evaluation c ON c.ItemID = b.id 
WHERE
    (a.ProjectID = '" . $projectID . "' 
    AND b.contractorID = '" . $contractorID . "')) as TotalaccumulatedLastMonthQty,
c.thisMonthQty,
c.accumulatedThisMonthQty,
c.amount as actualAmount,
c.weight as actualProgress,
(SELECT sum(qty*price) from actual_wbs) as totalEstimated 
FROM
    projects a
    LEFT JOIN actual_wbs b ON b.ProjectID = a.ProjectID
    LEFT JOIN progress_evaluation c ON c.ItemID = b.id 
WHERE
    (a.ProjectID = '" . $projectID . "' 
    AND b.contractorID = '" . $contractorID . "')
   --  AND
   --  b.hasChild IS NOT NULL 
   --  AND ( b.hasChild != '' OR b.hasChild != 0 ) 
           GROUP BY b.id
   ORDER BY b.parentlevel, COALESCE(b.parentItem, b.id), b.level");
    }

    public function DataActualWbsDetail(Request $request)
    {
        return DB::select("SELECT
        b.*,
        c.periode,
        c.progressName,
        c.estimatedQty,
        c.accumulatedLastMonthQty,
        c.thisMonthQty,
        c.accumulatedThisMonthQty,
        c.amount AS actualAmount,
        c.weight AS actualProgress,
        (
        SELECT
            sum( c.amount ) 
        FROM
        document_detail b
            LEFT JOIN progress_evaluation c ON c.ItemID = b.actualWbsID 
        WHERE
        ( b.ProjectID = '" . $request->projectID . "' AND b.contractorID = '" . $request->contractorID . "' AND c.docID = '" . $request->docID . "' AND b.created_at LIKE '" . $request->date . "%' )) AS totalThisMonth,
        (
        SELECT
            sum( c.accumulatedLastMonthQty * b.price ) 
        FROM
        document_detail b
            LEFT JOIN progress_evaluation c ON c.ItemID = b.actualWbsID 
        WHERE
        ( b.ProjectID = '" . $request->projectID . "' AND b.contractorID = '" . $request->contractorID . "' AND c.docID = '" . $request->docID . "'  AND b.created_at LIKE '" . $request->date . "%' )) AS totalLastMonth,
        ( SELECT sum( qty * price ) FROM baseline_wbs ) AS totalEstimated 
    FROM
        (SELECT * from document_detail where ProjectID = '" . $request->projectID . "' AND contractorID = '" . $request->contractorID . "' AND created_at LIKE '" . $request->date . "%' ) b
        LEFT JOIN progress_evaluation c ON c.ItemID = b.actualWbsID 
    WHERE
        ( c.docID = '" . $request->docID . "' )
	
GROUP BY
	 c.created_at,b.id, b.actualWbsID");
    }

    public function getAllDataActualWbs($contractorID, $projectID)
    {
        $data = ActualWbs::where([
            ['contractorID', '=',  $contractorID], ['ProjectID', '=',  $projectID]
        ])->get();
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
        $data = ActualWbs::updateOrCreate([

            'ProjectID'      => $request->ProjectID,
            'contractorID'      => $request->contractorID,
            'itemName'      => $request->itemName,

        ], [
            
            'parentItem'      => $request->parentItem,
            'hasChild'      => $request->hasChild,
            'unitID'      => $request->unitID,
            'qty'      => $request->qty,
            'price'      => $request->price,
            'startDate'      => $request->startDate,
            'endDate'      => $request->endDate,
            'amount'      => $request->amount,
            'weight'      => $request->weight,
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
    public function show(ActualWbs $ActualWbs, $id)
    {
        //
        return DB::select('SELECT a.*,c.UnitName,d.currencyName
        FROM baselineboq a
        left JOIN unit c on c.id=a.unitID
        left JOIN currency d on d.id = a.CurrencyID
        where a.id=?', [$id]);
    }

    public function DataActualWbschild(ActualWbs $ActualWbs, $id, $contractorID, $projectID)
    {
        return  DB::select('SELECT
        b.*,
        c.periode,
        c.progressName,
        c.estimatedQty,
        c.accumulatedLastMonthQty,
        c.thisMonthQty,
        c.accumulatedThisMonthQty,
        c.amount as actualAmount,
        c.weight as actualProgress 
        FROM
        projects a
        LEFT JOIN actual_wbs b ON b.ProjectID = a.ProjectID
        LEFT JOIN progress_evaluation c ON c.ProjectID = a.ProjectID
         where  (a.ProjectID = "' . $projectID . '"
         AND b.contractorID = "' . $contractorID . '") and b.parentItem = "' . $id . '" and (b.hasChild IS NULL or b.hasChild = 0)
         ORDER BY COALESCE(b.parentItem, b.id), b.id');
    }

    public function DataDetailActualWbsByid(ActualWbs $ActualWbs, $id)
    {
        return  DB::select('SELECT
        b.*,
        c.periode,
        c.progressName,
        c.estimatedQty,
        c.accumulatedLastMonthQty,
        c.thisMonthQty,
        c.accumulatedThisMonthQty,
        c.amount as actualAmount,
        c.weight as actualProgress,
        (SELECT sum(qty*price) from actual_wbs) as totalEstimated
        FROM
        projects a
        LEFT JOIN actual_wbs b ON b.ProjectID = a.ProjectID
        LEFT JOIN progress_evaluation c ON c.ProjectID = a.ProjectID
         where  b.id = "' . $id . '"', [$id]);
    }

    public function GetActualParentItem(ActualWbs $ActualWbs, $projectID, $consultantID)
    {
        return  DB::select("SELECT
        * from actual_wbs
        where (hasChild != '' OR hasChild != 0) AND (ProjectID=? AND contractorID=?)", [$projectID, $consultantID]);
    }

    public function GetActualChildItem(ActualWbs $ActualWbs, $projectID, $consultantID, $itemID)
    {
        return  DB::select("SELECT
        * from actual_wbs
        where (ProjectID=? AND contractorID=? AND parentItem=?)", [$projectID, $consultantID, $itemID]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(ActualWbs $ActualWbs)
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
        ActualWbs::where('id', $id)->update($request->all());
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
        ActualWbs::where('id', $id)->delete();
        DB::delete('DELETE
         FROM baselineboq
         WHERE parentItem IN
         (
             SELECT parentItem
             FROM baselineboq
             WHERE parentItem = ?
         )', [$id]);
        return response()->json(['status' => 'success'], 200);
    }

    public function DeleteDataActualReportWbs($id)
    {
        //

        DB::delete('DELETE
         FROM documents
         WHERE id = "'.$id.'"');
        return response()->json(['status' => 'success'], 200);
    }
}
