<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProgressReportController extends Controller
{
    public function getProject($projectID, $contractorID)
    {
        return DB::select('SELECT a.*,d.PersonilName,c.BussinessName from projects a
        join project_numbers b on b.ProjectID=a.ProjectID
        join bussinesspartner c on c.id= b.BusinessPartnerID
        join personil d on d.BussinessPartnerID=c.id
        where a.ProjectID="' . $projectID . '" and c.id="' . $contractorID . '"');
    }

    public function getTimeElapse($projectID, $contractorID){
        return DB::select('SELECT
        min( StartDate ) as minDate,
        max( endDate ) as maxDate
    FROM
        baseline_wbs 
    WHERE
        (startDate != "0000-00-00" 
        OR endDate != "0000-00-00")
        AND
        (ProjectID = "'.$projectID.'" AND contractorID="'.$contractorID.'")');
    }

    public function getScheduledProgress(Request $request)
    {
        return DB::select('SELECT
        sum( amount ) as ScheduledProgress,
	(
	SELECT
		sum( weight ) 
	FROM
		baseline_wbs 
	WHERE
		parentItem IS NOT NULL 
		AND ProjectID = "' . $request->projectID . '" 
        AND contractorID = "' . $request->contractorID . '" 
        AND ( startDate <= "' . $request->date . '" AND EndDate <= "' . $request->date . '" ) 
	) as ScheduledPercent,
    (
        SELECT
            sum( amount ) 
        FROM
            baseline_wbs 
        WHERE
            parentItem IS NOT NULL 
            AND ProjectID = "' . $request->projectID . '" 
            AND contractorID = "' . $request->contractorID . '" 
        ) as Total_planned_cost
    FROM
        baseline_wbs 
    WHERE
        ProjectID = "' . $request->projectID . '" 
        AND contractorID = "' . $request->contractorID . '" 
        AND ( startDate <= "' . $request->date . '" AND EndDate <= "' . $request->date . '" )');
    }

    public function getActualProgress(Request $request)
    {
        return DB::select('SELECT
        sum( b.weight ) AS All_actual,
        sum(b.amount) AS All_amount,
        (
        SELECT
            sum( b.weight ) 
        FROM
            documents a
            JOIN progress_evaluation b ON b.docID = a.id
            -- JOIN document_detail c ON c.actualWbsID = b.ItemID 
        WHERE
            b.ProjectID = "' . $request->projectID . '" 
            AND b.contractorID = "' . $request->contractorID . '" 
            AND b.docID = "' . $request->docID . '" 
        ) AS ThisMonth 
    FROM
        documents a
        JOIN progress_evaluation b ON b.docID = a.id
        -- JOIN document_detail c ON c.actualWbsID = b.ItemID 
    WHERE
        b.ProjectID = "' . $request->projectID . '" 
        AND b.contractorID ="' . $request->contractorID . '"');
    }

    public function getIssue($projectID)
    {
        return DB::select('SELECT * ,
        round(((select count(id) from issue_management where ProjectID="' . $projectID . '" and priority="high")/(select count(id) from issue_management where ProjectID="' . $projectID . '"))* 100) as high,
        round(((select count(id) from issue_management where ProjectID="' . $projectID . '" and priority="medium")/(select count(id) from issue_management where ProjectID="' . $projectID . '")) * 100) as medium,
        round(((select count(id) from issue_management where ProjectID="' . $projectID . '" and priority="low")/(select count(id) from issue_management where ProjectID="' . $projectID . '"))* 100) as low    
        from issue_management where ProjectID="' . $projectID . '"');
    }

    public function riskReport($projectID, $contractorID)
    {
        // return DB::select('SELECT a.* , 
        
        // round((select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '" AND a.Rank like "High%" )/(select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '") * 100) as high,

        // round((select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '" AND a.Rank like "Medium%" )/(select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '") * 100) as medium,
        
        // round((select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '" AND a.Rank like "Low%" )/(select count(a.id) from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '") * 100) as low
        
        // from risk_management a
        // join personil b on b.id = a.PersonilID
        // join bussinesspartner c on c.id = b.BussinessPartnerID
        // join project_numbers d on d.BusinessPartnerID=c.id
        // where d.ProjectID="' . $projectID . '" 
        // AND d.BusinessPartnerID="' . $contractorID . '"');
        return DB::select('SELECT
        a.*,
        round((
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                AND a.Rank LIKE "High%" 
                )/(
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                ) * 100 
        ) AS high,
        round((
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                AND a.Rank LIKE "Medium%" 
                )/(
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                ) * 100 
        ) AS medium,
        round((
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                AND a.Rank LIKE "Low%" 
                )/(
            SELECT
                count( a.id ) 
            FROM
                risk_management a 
            WHERE
                a.ProjectID = "' . $projectID . '" 
                ) * 100 
        ) AS low 
    FROM
        risk_management a 
    WHERE
        a.ProjectID = "' . $projectID . '"');
    }

    public function getProgressCurve($projectID, $contractorID)
    {
        return  DB::select("SELECT
        a.A + COALESCE ( SUM( a.ay ), 0 ) weight,
        a.ColumnB month,
        a.idx 
    FROM
        (
        SELECT
            x.*,
            y.A AS ay 
        FROM
            (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
                baseline_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "'  
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) x
            LEFT OUTER JOIN (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
                baseline_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "' 
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) y ON y.idx < x.idx 
        ) a 
    GROUP BY
        a.ColumnB 
    ORDER BY
        a.idx");
    }

    public function getActualTable($projectID, $contractorID)
    {
        return  DB::select("SELECT
        a.A + COALESCE ( SUM( a.ay ), 0 ) weight,
        a.ColumnB month,
        a.idx 
    FROM
        (
        SELECT
            x.*,
            y.A AS ay 
        FROM
            (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
                actual_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "'  
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) x
            LEFT OUTER JOIN (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
            actual_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "' 
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) y ON y.idx < x.idx 
        ) a 
    GROUP BY
        a.ColumnB 
    ORDER BY
        a.idx");
    }

    public function getBaseline($projectID, $contractorID)
    {
        return  DB::select("SELECT
        a.A + COALESCE ( SUM( a.ay ), 0 ) weight,
        a.ColumnB month,
        a.idx 
    FROM
        (
        SELECT
            x.*,
            y.A AS ay 
        FROM
            (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
                baseline_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "'  
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) x
            LEFT OUTER JOIN (
            SELECT
                SUM( weight ) A,
                MONTHNAME( endDate ) ColumnB,
                MONTH ( endDate ) idx 
            FROM
                baseline_wbs 
            WHERE
                parentItem IS NOT NULL 
                AND ProjectID = '" . $projectID . "' 
                AND contractorID = '" . $contractorID . "' 
            GROUP BY
                MONTH ( endDate ) 
            ) y ON y.idx < x.idx 
        ) a 
    GROUP BY
        a.ColumnB 
    ORDER BY
        a.idx");
    }

    public function getCurrentTable($projectID, $contractorID)
    {
        return  DB::select("SELECT
        MONTHNAME(b.periode) month,
        MONTH(b.periode) idx,
        sum( b.weight ) AS weight,
        sum(b.amount) AS All_amount,
        (
        SELECT
            sum( b.weight ) 
        FROM
            documents a
            JOIN progress_evaluation b ON b.docID = a.id
            -- JOIN document_detail c ON c.actualWbsID = b.ItemID 
        WHERE
            b.ProjectID = '" . $projectID . "' 
            AND b.contractorID = '" . $contractorID . "' 
        ) AS ThisMonth 
    FROM
        documents a
        JOIN progress_evaluation b ON b.docID = a.id
        -- JOIN document_detail c ON c.actualWbsID = b.ItemID 
    WHERE
        b.ProjectID = '" . $projectID . "' 
        AND b.contractorID = '" . $contractorID . "'
				GROUP BY b.docID");
    }
}
