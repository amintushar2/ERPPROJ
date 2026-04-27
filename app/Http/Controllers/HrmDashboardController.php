<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HrmDashboardController extends BaseController
{
    public function index()
    {
        $companyId = session('company_id', '100');

        // ── UI DATE (for display) ──
        $today = Carbon::today();

        // ── EFFECTIVE WORKING DATE (skip Friday + holidays) ──
        $effectiveDate = DB::select("
            SELECT MAX(dt) AS dt
            FROM (
                SELECT TRUNC(SYSDATE) - LEVEL + 1 AS dt
                FROM DUAL
                CONNECT BY LEVEL <= 7
            )
            WHERE TO_CHAR(dt, 'DY', 'NLS_DATE_LANGUAGE=ENGLISH') != 'FRI'
              AND NOT EXISTS (
                    SELECT 1
                    FROM HRM.CALENDER_DETAILS c
                    WHERE dt IN (
                        TRUNC(c.HOLIDAY_1),
                        TRUNC(c.HOLIDAY_2),
                        TRUNC(c.OTHERS)
                    )
              )
        ")[0]->dt;

        // ── 1. TOTAL EMPLOYEES ──
        $totalEmployees = DB::select("
            SELECT COUNT(*) AS cnt
            FROM HRM.EMP_OFFICIAL eo
            JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
            WHERE eo.COMPANY_ID = :cid
              AND eo.TERMINATION_DATE IS NULL
              AND eo.RESIGNED_DATE IS NULL
              AND ep.STATUS = 'Active'
        ", ['cid' => $companyId])[0]->cnt ?? 0;

        // ── 2. ATTENDANCE (WORKING DAY) ──
        $todayAtt = DB::select("
            SELECT
                SUM(CASE WHEN STATUS2 IN ('P','WO') THEN 1 ELSE 0 END) AS present,
                SUM(CASE WHEN STATUS2 = 'A' THEN 1 ELSE 0 END) AS absent,
                SUM(CASE WHEN STATUS2 = 'L' THEN 1 ELSE 0 END) AS on_leave,
                SUM(CASE WHEN LATE > 0 THEN 1 ELSE 0 END) AS late
            FROM HRM.ATTENDANCE_DETAILS
            WHERE TRUNC(ATT_DATE) = :dt
              AND COMPANY_ID = :cid
        ", [
            'dt' => $effectiveDate,
            'cid' => $companyId
        ])[0];

        // ── 3. GENDER SPLIT ──
        $genderSplit = DB::select("
            SELECT ep.SEX, COUNT(*) AS cnt
            FROM HRM.EMP_PERSONAL ep
            JOIN HRM.EMP_OFFICIAL eo ON eo.EMPNO = ep.EMPNO
            WHERE eo.COMPANY_ID = :cid
              AND eo.TERMINATION_DATE IS NULL
              AND eo.RESIGNED_DATE IS NULL
              AND ep.STATUS = 'Active'
            GROUP BY ep.SEX
        ", ['cid' => $companyId]);

        // ── 4. DEPT COUNT ──
        $deptCount = DB::select("
          SELECT *
FROM (
    SELECT eo.DEPT_NAME, COUNT(*) AS cnt
    FROM HRM.EMP_OFFICIAL eo
    JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
    WHERE eo.COMPANY_ID = :cid
      AND eo.TERMINATION_DATE IS NULL
      AND eo.RESIGNED_DATE IS NULL
      AND ep.STATUS = 'Active'
    GROUP BY eo.DEPT_NAME
    ORDER BY cnt DESC
)
        ", ['cid' => $companyId]);

        // ── 5. AVG OT ──
        $avgOT = DB::select("
            SELECT
                TO_CHAR(ATT_DATE,'Mon YYYY') AS att_month,
                ROUND(AVG(OTHOUR + NVL(OTHOUR2,0) + NVL(OTHOUR3,0)),2) AS avg_ot
            FROM HRM.ATTENDANCE_DETAILS
            WHERE COMPANY_ID = :cid
              AND ATT_DATE >= ADD_MONTHS(TRUNC(SYSDATE,'MM'), -5)
              AND OTHOUR > 0
            GROUP BY TRUNC(ATT_DATE,'MM'), TO_CHAR(ATT_DATE,'Mon YYYY')
            ORDER BY TRUNC(ATT_DATE,'MM')
        ", ['cid' => $companyId]);

        // ── 6. LEAVE SUMMARY ──
        $leaveSummary = DB::select("
            SELECT li.LEAVE_NAME,
                   SUM(led.BALANCE) AS total_balance,
                   SUM(led.APPROVE_DAYS) AS total_taken
            FROM HRM.LEAVE_ENTRY_DETAILS led
            JOIN HRM.LEAVE_INFO li ON li.LEAVE_ID = led.LEAVE_ID
            JOIN HRM.EMP_OFFICIAL eo ON eo.EMPNO = led.EMPNO
            WHERE led.YEAR = TO_CHAR(SYSDATE,'YYYY')
              AND eo.COMPANY_ID = :cid
              AND eo.TERMINATION_DATE IS NULL
            GROUP BY li.LEAVE_NAME
            ORDER BY total_taken DESC
        ", ['cid' => $companyId]);

        // ── 7. PROBATION ──
        $probationEnd = DB::select("
    SELECT eo.EMPNO,
           ep.FIRST_NAME || ' ' || ep.LAST_NAME AS EMP_NAME,
           eo.DEPT_NAME,
           eo.DESIGNATION_NAME,
           eo.JOINING_DATE,
           eo.CONFORM_DATE,
           eo.PROVISION_PERIOD,
           ROUND(MONTHS_BETWEEN(SYSDATE, eo.JOINING_DATE)) AS months_served
    FROM HRM.EMP_OFFICIAL eo
    JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
    WHERE eo.COMPANY_ID = :cid
      AND eo.CONFORM_DATE IS NULL
      AND TRUNC(ADD_MONTHS(eo.JOINING_DATE,
            TO_NUMBER(NVL(eo.PROVISION_PERIOD,'3'))),'MM')
          = TRUNC(SYSDATE,'MM')
        ", ['cid' => $companyId]);

        // ── 8. INCREMENT ──
        $incrementThisMonth = DB::select("
           SELECT
  eo.EMPNO,
  ep.FIRST_NAME || ' ' || ep.LAST_NAME AS EMP_NAME,
  eo.DEPT_NAME,
  eo.DESIGNATION_NAME,
  eo.GROSS,
  eo.INCREMENT_DATE,
  NVL(
    (
      SELECT MAX(ii.CUR_GROSS)
      KEEP (DENSE_RANK FIRST ORDER BY ii.INCR_DATE DESC)
      FROM HRM.INCREMENT_INFO ii
      WHERE TRIM(ii.EMPNO) = TRIM(eo.EMPNO)
        AND ii.CUR_GROSS IS NOT NULL
    ),
    eo.GROSS
  ) AS LAST_GROSS
FROM HRM.EMP_OFFICIAL eo
JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
WHERE eo.COMPANY_ID = :cid
  AND ep.STATUS = 'Active'
  AND eo.TERMINATION_DATE IS NULL
  AND eo.RESIGNED_DATE IS NULL
  AND eo.INCREMENT_DATE IS NOT NULL
  AND EXTRACT(MONTH FROM NVL(eo.INCREMENT_DATE, eo.JOINING_DATE)) = EXTRACT(MONTH FROM SYSDATE)
ORDER BY eo.INCREMENT_DATE
        ", ['cid' => $companyId]);

        // ── 9. RECENT JOINERS ──
        $recentJoiners = DB::select("
            SELECT *
            FROM (
                SELECT eo.EMPNO,
                       ep.FIRST_NAME || ' ' || ep.LAST_NAME AS EMP_NAME,
                       eo.DEPT_NAME,
                       eo.DESIGNATION_NAME,
                       eo.JOINING_DATE,
                       ep.SEX
                FROM HRM.EMP_OFFICIAL eo
                JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
                WHERE eo.COMPANY_ID = :cid
                  AND eo.JOINING_DATE >= SYSDATE - 30
                ORDER BY eo.JOINING_DATE DESC
            )
            WHERE ROWNUM <= 8
        ", ['cid' => $companyId]);


        $incrementNextMonth = DB::select("
    SELECT eo.EMPNO,
       ep.FIRST_NAME || ' ' || ep.LAST_NAME AS EMP_NAME,
       eo.DEPT_NAME,
       eo.DESIGNATION_NAME,
       eo.GROSS,
       eo.INCREMENT_DATE
FROM HRM.EMP_OFFICIAL eo
JOIN HRM.EMP_PERSONAL ep ON ep.EMPNO = eo.EMPNO
WHERE eo.COMPANY_ID = :cid
  AND eo.TERMINATION_DATE IS NULL
  AND eo.RESIGNED_DATE IS NULL
    AND ep.STATUS = 'Active'
  AND EXTRACT(MONTH FROM NVL(eo.INCREMENT_DATE, eo.JOINING_DATE))=EXTRACT(MONTH FROM ADD_MONTHS(SYSDATE,1))
ORDER BY eo.INCREMENT_DATE
", ['cid' => $companyId]);





// ── 7. ATTENDANCE HEATMAP — daily present % for current month ────────────
//
//  att_date  : stored as DATE or VARCHAR 'YYYY-MM-DD'
//  status    : your present flag (adjust 'P' to match your column value)
//  Adjust table/column names to match your schema.
//
$attendanceHeatmap = DB::select("
    SELECT
        TO_NUMBER(TO_CHAR(att_date, 'DD'))          AS day,
        ROUND(
            SUM(CASE WHEN status2 = 'P' THEN 1 ELSE 0 END)
            / NULLIF(COUNT(*), 0) * 100
        , 1)                                         AS pct
    FROM ATTENDANCE_DETAILS
    WHERE
        att_date >= TRUNC(SYSDATE, 'MM')
        AND att_date <  LAST_DAY(SYSDATE) + 1
    GROUP BY TO_NUMBER(TO_CHAR(att_date, 'DD'))
    ORDER BY day
");
// Result shape: [ {day:1, pct:92.5}, {day:2, pct:88.0}, ... ]
 
 
// ── 8. DEPT ATTENDANCE RATE TODAY — sorted best → worst ──────────────────
//
//  Joins your dept master to today's attendance.
//  Adjust 'hr_attendance', 'hr_employees', 'hr_departments' as needed.
//
$deptAttToday = DB::select("
    SELECT
        d.dept_name,
        SUM(CASE WHEN a.status2 = 'P' THEN 1 ELSE 0 END)  AS present,
        COUNT(e.empno)                                         AS total,
        ROUND(
            SUM(CASE WHEN a.status2 = 'P' THEN 1 ELSE 0 END)
            / NULLIF(COUNT(e.empno), 0) * 100
        , 1)                                                   AS pct
    FROM HRM.EMP_OFFICIAL e
    JOIN HRM.DEPT d  ON d.DEPT_NO = e.DEPT_NO
        JOIN HRM.EMP_PERSONAL pp  ON pp.EMPNO = e.EMPNO
    LEFT JOIN ATTENDANCE_DETAILS a
        ON  a.EMPNO    = e.EMPNO
        AND a.ATT_DATE = TRUNC(SYSDATE)
    WHERE pp.STATUS = 'Active'
    GROUP BY d.dept_name
    ORDER BY pct DESC NULLS LAST
");
// Result shape: [ {dept_name, present, total, pct}, ... ]
 
 
// ── 9. LATE ARRIVAL TREND — count per day for last 7 days ────────────────
//
//  'L' = Late flag in att_status; adjust to your schema.
//  If you track late separately (e.g. att_late = 'Y'), change the CASE.
//
$lateTrend = DB::select("
    SELECT
        att_date,
        SUM(CASE WHEN LATE > 0 THEN 1 ELSE 0 END) AS late_count
    FROM ATTENDANCE_DETAILS
    WHERE att_date >= TRUNC(SYSDATE) - 6
      AND att_date <= TRUNC(SYSDATE)
    GROUP BY att_date
    ORDER BY att_date
");
// Result shape: [ {att_date:'2025-04-21', late_count:3}, ... ]
 
 
// ── 10. OT COST ESTIMATE BY DEPT — current month ─────────────────────────
//
//  Assumes:
//    hr_overtime  : empno, ot_date, ot_hours
//    hr_employees : empno, dept_code, gross  (monthly gross salary)
//    hr_departments: dept_code, dept_name
//
//  Hourly rate  = gross / 208  (26 working days × 8 hrs — adjust divisor)
//  Estimated OT = total_ot_hrs × avg_hourly_rate
//
$otCostByDept = DB::select("
    SELECT
        d.dept_name,
        ROUND(SUM(o.othour), 2)                               AS total_ot_hrs,
        ROUND(AVG(e.gross / 208), 2)                            AS avg_hourly_rate,
        ROUND(SUM(o.othour) * AVG(e.gross / 208), 2)         AS estimated_cost
    FROM ATTENDANCE_DETAILS o
    JOIN HRM.EMP_OFFICIAL   e ON e.EMPNO     = o.EMPNO
    JOIN HRM.EMP_personal   PP ON e.EMPNO     = PP.EMPNO
    JOIN HRM.DEPT d ON d.DEPT_no = e.DEPT_NO
    WHERE
        o.ATT_DATE >= TRUNC(SYSDATE, 'MM')
        AND o.ATT_DATE < LAST_DAY(SYSDATE) + 1
        AND PP.STATUS = 'Active'
    GROUP BY d.DEPT_NAME
    ORDER BY estimated_cost DESC
");
// Result shape: [ {dept_name, total_ot_hrs, avg_hourly_rate, estimated_cost}, ... ]
 
 
        return view('dashboard', compact(
            'totalEmployees',
            'todayAtt',
            'genderSplit',
            'deptCount',
            'avgOT',
            'leaveSummary',
            'probationEnd',
            'incrementThisMonth',
            'incrementNextMonth',
            'recentJoiners',
            'today',
            'effectiveDate',
                'attendanceHeatmap',
     'deptAttToday',
      'lateTrend',
     'otCostByDept'
        ));
    }
}