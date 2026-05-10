<?php

namespace App\Http\Controllers\Reports;
use App\Http\Controllers\Controller;

use App\Models\EmpPersonal;
use App\Models\Section;
use App\Models\IdCardPrintLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    //  LOV – AJAX employee search
    //  GET /id-card/api/employees?q=...&section_no=...
    // ─────────────────────────────────────────────────────────
    public function searchEmployees(Request $request)
    {
        $q     = $request->get('q', '');
        $secNo = $request->get('section_no', '');

        $query = EmpPersonal::query()
            ->select(
                'HRM.EMP_PERSONAL.empno',
                'HRM.EMP_PERSONAL.first_name',
                'HRM.EMP_PERSONAL.last_name',
                'HRM.EMP_PERSONAL.b_name',
                'HRM.EMP_PERSONAL.blood_group',
                'HRM.EMP_PERSONAL.status'
            )
            ->with(['getempofficial' => fn($q) => $q->select('empno','designation','section_id','card_type','join_date')])
            ->join('HRM.EMP_OFFICIAL', 'HRM.EMP_PERSONAL.empno', '=', 'HRM.EMP_OFFICIAL.empno')
            ->orderByDesc('HRM.EMP_OFFICIAL.join_date');  // most recent join first

        if ($q) {
            $query->where(function ($qb) use ($q) {
                $qb->where('HRM.EMP_PERSONAL.empno',       'like', "%{$q}%")
                   ->orWhere('HRM.EMP_PERSONAL.first_name', 'like', "%{$q}%")
                   ->orWhere('HRM.EMP_PERSONAL.b_name',     'like', "%{$q}%");
            });
        }

        if ($secNo) {
            $query->whereHas('getempofficial', function ($qb) use ($secNo) {
                $qb->whereHas('section', fn($s) => $s->where('section_no', $secNo));
            });
        }

        $rows = $query->limit(100)->get()->map(fn($e) => [
            'emp_no'      => $e->empno,
            'emp_name'    => trim($e->first_name . ' ' . $e->last_name),
            'emp_name_bn' => $e->b_name,
            'designation' => $e->getempofficial?->designation,
            'section'     => $e->getempofficial?->section?->section_name,
            'section_no'  => $e->getempofficial?->section?->section_no,
            'blood_group' => $e->blood_group,
            'card_type'   => $e->getempofficial?->card_type,
            'status'      => $e->status,
            'join_date'   => $e->getempofficial?->join_date
                                ? \Carbon\Carbon::parse($e->getempofficial->join_date)->format('d-M-Y')
                                : '',
        ]);

        return response()->json($rows);
    }

    // ─────────────────────────────────────────────────────────
    //  SECTIONS LOV
    // ─────────────────────────────────────────────────────────
    public function getSections()
    {
        return response()->json(
            Section::select('id', 'section_no', 'section_name')->orderBy('section_no')->get()
        );
    }

    // ─────────────────────────────────────────────────────────
    //  RUN REPORT  –  GET /id-card/print
    //
    //  GET so the browser can open the PDF directly in a new tab.
    //  JS builds a query string and does: window.open(url, '_blank')
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
            'emp_nos'    => 'required|string|min:1',
            'card_type'  => 'required|string|in:bangla_knit,bangla_front,bangla_single,bangla_back,process_label,emp_label,card_label,temp_card,process_rony,bangla_level',
            'section_no' => 'nullable|string',
            'from_date'  => 'nullable|string',
            'end_date'   => 'nullable|string',
        ]);

        // Extra guard: emp_nos must not be blank after trim
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
    //
    //  Original .fmb trigger pattern (extracted from binary):
    //    add_parameter(pl_id,'P_emp',  text_parameter,:REPORT_BK.EMP_NO);
    //    add_parameter(pl_id,'P_emp1', text_parameter,:REPORT_BK.EMP_NO1);
    //    add_parameter(pl_id,'P_emp2', text_parameter,:REPORT_BK.EMP_NO2);
    //    ...up to P_emp12
    //
    //  Each employee gets its OWN numbered parameter.
    //  NOT a comma-separated list — that is why only 1st emp showed.
    //
    //  Supports up to 12 employees per run (matches original form limit).
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

        // ─────────────────────────────────────────────────────
        //  Per-report emp parameter name mapping
        //  (extracted directly from .fmb button triggers)
        //
        //  RUN_REPORTS      → ID_CARD_bangla_level_knit  → P_emp
        //  PB_BANGLA_FRONT  → ID_CARD_bangla_back        → P_emp
        //  PB_BANGLA_SINGLE → ID_CARD_bangla_level       → P_emp
        //  BACK_PART        → ID_CARD_bangla_level        → P_emp
        //  ITEM140          → ID_CARD_bangla_front        → P_emp
        //                  → ID_CARD_bangla               → P_emp
        //                  → ID_CARD_Process_Rony_I       → P_emp
        //  PUSH_BUTTON136   → emp_lebel                   → P_empno
        //                  → ID_CARD_Process_lebel        → P_empno
        //                  → ID_CARD_Process_Temp         → P_empno
        //                  → ID_CARD_Process_back         → P_empno
        //  CAED_LEBEL       → ID_CARD_bangla_level        → P_emp
        //  EMP_LEBEL        → ID_CARD_bangla_level        → P_emp
        // ─────────────────────────────────────────────────────

        switch ($cardType) {

            // ── Uses P_emp ───────────────────────────────────
            case 'bangla_knit':    // ID_CARD_bangla_level_knit  ← RUN_REPORTS
            case 'bangla_front':   // ID_CARD_bangla_front       ← ITEM140
            case 'bangla_single':  // ID_CARD_bangla             ← ITEM140
            case 'bangla_back':    // ID_CARD_bangla_back        ← PB_BANGLA_FRONT
            case 'bangla_level':   // ID_CARD_bangla_level       ← PB_BANGLA_SINGLE / BACK_PART
                 case 'card_label':     // ID_CARD_Process_lebel      ← PUSH_BUTTON136 / CAED_LEBEL
            case 'process_label':  // ID_CARD_Process_lebel      ← PUSH_BUTTON136
            case 'process_rony':   // ID_CARD_Process_Rony_I     ← ITEM140
                case 'temp_card':      // ID_CARD_Process_Temp       ← PUSH_BUTTON136
                $params['P_emp'] = $empStr;
                if ($sectionNo) $params['P_SACTION'] = $sectionNo;
                break;

            // ── Uses P_empno ─────────────────────────────────
            case 'emp_label':      // emp_lebel                  ← PUSH_BUTTON136
           
            
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
    //  Identical to your ReportCentreController pattern
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

        // Log URL for debugging — comment out in production
        Log::info('ID Card Report URL: ' . $url);

        $response = Http::timeout(config('hrm.timeout', 120))
                        ->withOptions(['verify' => false])
                        ->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException(
                "Oracle Reports Server returned HTTP {$response->status()} for: {$reportFileName}"
            );
        }

        // Check if Oracle returned an error HTML page instead of PDF
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

        // YYYY-MM-DD  →  DD-MON-YYYY
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m)) {
            return $m[3] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[1];
        }
        // DD-MM-YYYY  →  DD-MON-YYYY
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $m)) {
            return $m[1] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[3];
        }

        return strtoupper($date); // already DD-MON-YYYY
    }
}
