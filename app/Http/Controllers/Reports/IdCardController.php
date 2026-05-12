<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\IdCardPrintLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class IdCardController extends Controller
{
    // ─────────────────────────────────────────────────────────
    //  REPORT FORM  (main page)
    // ─────────────────────────────────────────────────────────
    public function index()
    {
        $sections = Section::orderBy('section_no')->get();
        return view('hrm.report.id_card.index', compact('sections'));
    }

    // ─────────────────────────────────────────────────────────
    //  LOV – AJAX employee search  (server-side paginated)
    //  GET /id-card/api/employees?q=&section_no=&page=1&per_page=50
    // ─────────────────────────────────────────────────────────
 public function searchEmployees(Request $request): JsonResponse
{
    $q       = trim($request->get('q', ''));
    $secNo   = trim($request->get('section_no', ''));
    $perPage = min((int) $request->get('per_page', 50), 200);
    $page    = max((int) $request->get('page', 1), 1);
    $offset  = ($page - 1) * $perPage;
    $end     = $offset + $perPage;

    // ── WHERE conditions ──────────────────────────────────
    $where    = [];
    $bindings = [];

    if ($q !== '') {
        $where[]        = "(UPPER(EP.EMPNO) LIKE UPPER(:q1)
                         OR UPPER(EP.FIRST_NAME) LIKE UPPER(:q2)
                         OR UPPER(EP.LAST_NAME)  LIKE UPPER(:q3)
                         OR UPPER(EP.B_NAME)     LIKE UPPER(:q4))";
        $bindings[':q1'] = "%{$q}%";
        $bindings[':q2'] = "%{$q}%";
        $bindings[':q3'] = "%{$q}%";
        $bindings[':q4'] = "%{$q}%";
    }

    if ($secNo !== '') {
        $where[]           = "UPPER(EO.SECTION_NO) = UPPER(:sec)";
        $bindings[':sec']  = $secNo;
    }

    $whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // ── Total count ───────────────────────────────────────
    $total = DB::selectOne("
        SELECT COUNT(*) AS cnt
        FROM HRM.EMP_PERSONAL EP
        LEFT JOIN HRM.EMP_OFFICIAL EO ON EP.EMPNO = EO.EMPNO
        {$whereSQL}
    ", $bindings)->cnt;

    // ── Paginated query ───────────────────────────────────
    $paginationBindings = array_merge($bindings, [
        ':rn_end'    => $end,
        ':rn_offset' => $offset,
    ]);

    $rows = DB::select("
        SELECT * FROM (
            SELECT inner_.*, ROWNUM AS rn FROM (
                SELECT
                    EP.EMPNO                                               AS emp_no,
                    EP.FIRST_NAME                                          AS first_name,
                    EP.LAST_NAME                                           AS last_name,
                    EP.B_NAME                                              AS emp_name_bn,
                    EP.BLOOD_GROUP                                         AS blood_group,
                    EP.STATUS                                              AS status,
                    EO.DES_NAME                                            AS designation,
                    EO.SECTION_NO                                          AS section_no,
                    EO.SECTION_NAME                                        AS section,
                    TO_CHAR(CAST(EO.JOINING_DATE AS DATE), 'DD-MON-YYYY') AS join_date
                FROM HRM.EMP_PERSONAL EP
                LEFT JOIN HRM.EMP_OFFICIAL EO ON EP.EMPNO = EO.EMPNO
                {$whereSQL}
                ORDER BY EO.INSERT_DATE DESC NULLS LAST
            ) inner_
            WHERE ROWNUM <= :rn_end
        )
        WHERE rn > :rn_offset
    ", $paginationBindings);

    // ── Map results ───────────────────────────────────────
    $mapped = collect($rows)->map(fn($e) => [
        'emp_no'      => $e->emp_no,
        'emp_name'    => trim(($e->first_name ?? '') . ' ' . ($e->last_name ?? '')),
        'emp_name_bn' => $e->emp_name_bn ?? '',
        'designation' => $e->designation ?? '',
        'section'     => $e->section     ?? '',
        'section_no'  => $e->section_no  ?? '',
        'blood_group' => $e->blood_group ?? '',
        'card_type'   => '',
        'status'      => $e->status      ?? '',
        'join_date'   => $e->join_date   ?? '',
    ]);

    return response()->json([
        'data'         => $mapped,
        'total'        => $total,
        'per_page'     => $perPage,
        'current_page' => $page,
        'last_page'    => (int) ceil($total / $perPage),
    ]);
}

    // ─────────────────────────────────────────────────────────
    //  RUN REPORT  –  GET /id-card/print
    //
    //  Params:
    //    emp_nos    comma-separated string  e.g. "1001,1002,1003"
    //    card_type  e.g. "bangla_front"
    //    section_no (optional)
    //    from_date  (optional)  YYYY-MM-DD
    //    end_date   (optional)  YYYY-MM-DD
    // ─────────────────────────────────────────────────────────
    public function printCard(Request $request): \Illuminate\Http\Response|JsonResponse
    {
        $request->validate([
            'emp_nos'   => 'required|string|min:1',
            'card_type' => 'required|string|in:bangla_knit,bangla_front,bangla_single,bangla_back,process_label,emp_label,card_label,temp_card,process_rony,bangla_level',
            'section_no'=> 'nullable|string',
            'from_date' => 'nullable|string',
            'end_date'  => 'nullable|string',
        ]);

        if (trim($request->emp_nos) === '') {
            abort(422, 'emp_nos is empty.');
        }

        // ── 1. Normalise emp_nos ────────────────────────────
        $empNos = array_values(array_unique(
            array_filter(array_map('trim', explode(',', $request->emp_nos)))
        ));

        if (empty($empNos)) {
            return response()->json(['success' => false, 'message' => 'No employee numbers provided.'], 422);
        }

        // ── 2. Report file map ──────────────────────────────
        $reportMap = [
            'bangla_knit'   => 'ID_CARD_bangla_level_knit',
            'bangla_front'  => 'ID_CARD_bangla_front',
            'bangla_single' => 'ID_CARD_bangla',
            'bangla_back'   => 'ID_CARD_bangla_back',
            'process_label' => 'ID_CARD_Process_lebel',
            'emp_label'     => 'emp_lebel',
            'card_label'    => 'ID_CARD_Process_lebel',
            'temp_card'     => 'ID_CARD_Process_Temp',
            'process_rony'  => 'ID_CARD_Process_Rony_I',
            'bangla_level'  => 'ID_CARD_bangla_level',
        ];

        $reportFileName = $reportMap[$request->card_type];

        // ── 3. Build Oracle params ──────────────────────────
        $oracleParams = $this->buildOracleParams(
            $request->card_type,
            $empNos,
            $request->section_no,
            $request->from_date,
            $request->end_date
        );

        // ── 4. Log print action ─────────────────────────────
        try {
            IdCardPrintLog::insert(
                array_map(fn($empNo) => [
                    'emp_no'      => $empNo,
                    'card_type'   => $request->card_type,
                    'report_file' => $reportFileName,
                    'section_no'  => $request->section_no,
                    'from_date'   => $request->from_date,
                    'end_date'    => $request->end_date,
                    'printed_by'  => auth()->user()->name ?? 'system',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ], $empNos)
            );
        } catch (\Exception $e) {
            Log::warning('ID Card print log failed: ' . $e->getMessage());
        }

        // ── 5. Proxy → Oracle Reports Server → stream PDF ──
        try {
            return $this->proxyOracleReport($reportFileName, $oracleParams);
        } catch (\Exception $e) {
            Log::error('ID Card Report failed: ' . $e->getMessage(), [
                'card_type'   => $request->card_type,
                'report_file' => $reportFileName,
                'emp_nos'     => $empNos,
                'params'      => $oracleParams,
            ]);
            return response()->json([
                'success' => false,
                'error'   => 'HRM-9999: ERROR !!! ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────
    //  BUILD ORACLE PARAMS
    // ─────────────────────────────────────────────────────────
    private function buildOracleParams(
        string  $cardType,
        array   $empNos,
        ?string $sectionNo,
        ?string $fromDate,
        ?string $endDate
    ): array {
        $params = [];
        $empStr = implode(',', $empNos);

        switch ($cardType) {
            case 'bangla_knit':
            case 'bangla_front':
            case 'bangla_single':
            case 'bangla_back':
            case 'bangla_level':
            case 'card_label':
            case 'process_label':
            case 'process_rony':
            case 'temp_card':
                $params['P_emp'] = $empStr;
                if ($sectionNo) $params['P_SACTION'] = $sectionNo;
                break;

            case 'emp_label':
                $params['P_empno'] = $empStr;
                if ($sectionNo) $params['P_SACTION']   = $sectionNo;
                if ($fromDate)  $params['P_FROM_DATE'] = $this->toOracleDate($fromDate);
                if ($endDate)   $params['P_END_DATE']  = $this->toOracleDate($endDate);
                break;

            default:
                $params['P_emp'] = $empStr;
                break;
        }

        return $params;
    }

    // ─────────────────────────────────────────────────────────
    //  PROXY TO ORACLE REPORTS SERVER
    // ─────────────────────────────────────────────────────────
    protected function proxyOracleReport(string $reportFileName, array $params): \Illuminate\Http\Response
    {
        $serverUrl  = config('hrm.report_server_url');
        $serverName = config('hrm.report_server_name');
        $filePath   = 'D:/four_design/reports/';

        $queryParams = array_merge([
            'server'    => $serverName,
            'userid'    => 'HRM/hrm@orcl',
            'paramform' => 'no',
            'destype'   => 'cache',
            'desformat' => 'pdf',
        ], $params);

        $url = rtrim($serverUrl, '/')
             . '/reports/rwservlet?'
             . 'report=' . $filePath . strtolower($reportFileName)
             . '&' . http_build_query($queryParams);

        Log::info('ID Card Report URL: ' . $url);

        $response = Http::timeout(config('hrm.timeout', 120))
                        ->withOptions(['verify' => false])
                        ->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException(
                "Oracle Reports Server returned HTTP {$response->status()} for: {$reportFileName}"
            );
        }

        $contentType = $response->header('Content-Type');
        if (str_contains($contentType, 'text/html')) {
            $body = substr($response->body(), 0, 500);
            throw new \RuntimeException("Oracle returned HTML instead of PDF. Response: {$body}");
        }

        return response($response->body(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $reportFileName . '.pdf"',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    //  DATE HELPERS
    // ─────────────────────────────────────────────────────────
    private function toOracleDate(string $date): string
    {
        $months = [
            '01'=>'JAN','02'=>'FEB','03'=>'MAR','04'=>'APR',
            '05'=>'MAY','06'=>'JUN','07'=>'JUL','08'=>'AUG',
            '09'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC',
        ];

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m)) {
            return $m[3] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[1];
        }
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $m)) {
            return $m[1] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[3];
        }

        return strtoupper($date);
    }
}