<?php

namespace App\Http\Controllers;

use App\Models\HrmReport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * ReportCenterController
 * Laravel equivalent of Oracle Forms: hrm_report_center.fmb
 *
 * Changes in this version:
 *  - LOV block_item types now served as SELECT dropdowns via getLovOptions()
 *  - Dates sent to Oracle Reports in DD-MON-YYYY format (Oracle standard)
 *  - PARAMETER_TYPE = 'lov' triggers an AJAX dropdown load
 */
class ReportCenterController extends BaseController
{
    // ─────────────────────────────────────────────────────────────────
    // LOV SOURCE MAP
    // Maps each block_item name → the DB table/query that populates it.
    // Add entries here whenever a new LOV is needed.
    // Oracle source: LOV_ON_CLICK / POPULATE_LIST_HRM in the .fmb
    // ─────────────────────────────────────────────────────────────────
    private const LOV_SOURCES = [
        'COMPANY_NAME'   => ['table' => 'COMPANY_PROFILE',   'value' => 'COMPANY_ID',    'label' => 'COMPANY_NAME',   'order' => 'COMPANY_NAME'],
        'SETION_TXT'     => ['table' => 'HRM.SECTION',       'value' => 'SECTION_NO',    'label' => 'SECTION_NAME',   'order' => 'SECTION_NAME'],
        'DEPT_NAME'      => ['table' => 'HRM.DEPARTMENT',    'value' => 'DEPT_NO',       'label' => 'DEPT_NAME',      'order' => 'DEPT_NAME'],
        'EMP_TYPE'       => ['table' => 'HRM.EMP_TYPE',      'value' => 'EMP_TYPE',      'label' => 'EMP_TYPE',       'order' => 'PRIORITY'],
        'EMP_GRADE'      => ['table' => 'HRM.GRADE',         'value' => 'GRADE_ID',      'label' => 'GRADE_NAME',     'order' => 'GRADE_NAME'],
        'RELEGION'       => ['table' => 'RELIGION',          'value' => 'RELIGION_ID',   'label' => 'RELIGION_NAME',  'order' => 'RELIGION_NAME'],
        'BLOOD_GROUP'    => ['raw'   => [['v'=>'A+','l'=>'A+'],['v'=>'A-','l'=>'A-'],['v'=>'B+','l'=>'B+'],['v'=>'B-','l'=>'B-'],['v'=>'AB+','l'=>'AB+'],['v'=>'AB-','l'=>'AB-'],['v'=>'O+','l'=>'O+'],['v'=>'O-','l'=>'O-']]],
        'SEX'            => ['raw'   => [['v'=>'Male','l'=>'Male'],['v'=>'Female','l'=>'Female']]],
        'DES_NAME'       => ['table' => 'HRM.DESIGNATION',   'value' => 'DES_NO',        'label' => 'DES_NAME',       'order' => 'DES_NAME'],
        'WORK_ENT'       => ['table' => 'COMPANY_PROFILE',   'value' => 'COMPANY_ID',    'label' => 'COMPANY_NAME',   'order' => 'COMPANY_NAME'],
        'STATUS'         => ['raw'   => [['v'=>'Active','l'=>'Active'],['v'=>'Inactive','l'=>'Inactive'],['v'=>'Terminated','l'=>'Terminated']]],
        'P_MONTH'        => ['raw'   => [
            ['v'=>'01','l'=>'January'],['v'=>'02','l'=>'February'],['v'=>'03','l'=>'March'],
            ['v'=>'04','l'=>'April'],  ['v'=>'05','l'=>'May'],      ['v'=>'06','l'=>'June'],
            ['v'=>'07','l'=>'July'],   ['v'=>'08','l'=>'August'],   ['v'=>'09','l'=>'September'],
            ['v'=>'10','l'=>'October'],['v'=>'11','l'=>'November'], ['v'=>'12','l'=>'December'],
        ]],
        'FLOOR_NAME'     => ['table' => 'HRM.FLOOR',         'value' => 'FLOOR_ID',      'label' => 'FLOOR_NAME',     'order' => 'FLOOR_NAME'],
        'INCREMENT_TYPE' => ['raw'   => [['v'=>'Increment','l'=>'Increment'],['v'=>'Promotion','l'=>'Promotion'],['v'=>'Demotion','l'=>'Demotion']]],
        'LINE_NAME'      => ['table' => 'HRM.LINE',          'value' => 'LINE_ID',       'label' => 'LINE_NAME',      'order' => 'LINE_NAME'],
    ];

    // ─────────────────────────────────────────────────────────────────
    // 1. INDEX — WHEN-NEW-FORM-INSTANCE
    // ─────────────────────────────────────────────────────────────────
    public function index(): \Illuminate\View\View
    {
        $reports = HrmReport::forHrmModule()->get(['report_id', 'report_title']);
        return view('reports.center', compact('reports'));
    }

    // ─────────────────────────────────────────────────────────────────
    // 2. GET PARAMETERS — WHEN-LIST-CHANGED → SHOW_PRM_IN_MOOD
    //
    //    Oracle SQL:
    //      SELECT R.PARAMETER_NAME, P.BLOCK_ITEM PARAMX, R.SERIAL_NO
    //      FROM HRM_REPORT_PARAMETER R, HRM_PARAMETER_MASTER P
    //      WHERE R.PARAMETER_NO = P.PARAMETER_NO
    //      AND R.REPORT_ID = :REPORT_BK.REPORT_NO
    //      ORDER BY R.SERIAL_NO
    // ─────────────────────────────────────────────────────────────────
    public function getParameters(int $reportId): JsonResponse
    {
        $report = HrmReport::where('report_id', $reportId)->firstOrFail();

        $parameters = DB::table('hrm_report_parameter as r')
            ->join('hrm_parameter_master as p', 'r.parameter_no', '=', 'p.parameter_no')
            ->where('r.report_id', $reportId)
            ->orderBy('r.serial_no')
            ->select([
                'r.parameter_name',
                'p.block_item',
                'p.block_value_item',
                'p.parameter_type',
                'r.p_block_name',
                'r.serial_no',
            ])
            ->get()
            ->map(function ($row) {
                $blockItem   = $row->block_item;
                $isLov       = $this->isLovField($blockItem, $row->parameter_type);
                $inputType   = $this->resolveInputType($row->parameter_type, $blockItem);

                return [
                    'parameter_name'   => $row->parameter_name,
                    'block_item'       => $blockItem,
                    'block_value_item' => $row->block_value_item,
                    'parameter_type'   => $row->parameter_type,
                    'p_block_name'     => $row->p_block_name,
                    'serial_no'        => $row->serial_no,
                    'label'            => $this->labelFromBlockItem($blockItem),
                    'input_type'       => $inputType,          // 'lov' | 'date' | 'number' | 'text'
                    'is_lov'           => $isLov,
                    // For LOV: send options inline (avoids a second round-trip)
                    'lov_options'      => $isLov ? $this->fetchLovOptions($blockItem) : [],
                ];
            });

        return response()->json([
            'report_id'        => $report->report_id,
            'report_file_name' => $report->report_file_name,
            'js_report'        => $report->js_report,
            'parameters'       => $parameters,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // 3. LOV OPTIONS (also available standalone via AJAX)
    //    GET /reports/lov/{blockItem}
    // ─────────────────────────────────────────────────────────────────
    public function getLovOptions(string $blockItem): JsonResponse
    {
        $options = $this->fetchLovOptions(strtoupper($blockItem));
        return response()->json(['options' => $options]);
    }

    // ─────────────────────────────────────────────────────────────────
    // 4. RUN REPORT — WHEN-BUTTON-PRESSED
    //
    //    Dates from the UI arrive as DD-MM-YYYY.
    //    Oracle Reports expects DD-MON-YYYY (e.g. 15-JAN-2025).
    //    We convert here before forwarding to rwservlet.
    // ─────────────────────────────────────────────────────────────────
    public function runReport(Request $request): \Illuminate\Http\Response|JsonResponse
    {
        $request->validate([
            'report_id'  => 'required|integer',
            'parameters' => 'nullable|array',
        ]);

        $report = HrmReport::where('report_id', $request->report_id)->firstOrFail();

        // Build Oracle Reports parameter list — mirrors add_parameter() loop
        $reportParams = DB::table('hrm_report_parameter as r')
            ->join('hrm_parameter_master as p', 'r.parameter_no', '=', 'p.parameter_no')
            ->where('r.report_id', $request->report_id)
            ->orderBy('r.serial_no')
            ->select('r.parameter_name', 'p.block_value_item', 'p.block_item', 'p.parameter_type')
            ->get();

        $oracleParams = [];
        foreach ($reportParams as $rp) {
            $blockKey = $rp->block_value_item ?: $rp->block_item;
            $value    = $request->input("parameters.{$blockKey}");

            if (!is_null($value) && $value !== '') {
                // Convert date: DD-MM-YYYY → DD-MON-YYYY (Oracle standard)
                if ($this->isDateType($rp->parameter_type)) {
                    $value = $this->toOracleDate($value);
                }
                $oracleParams[$rp->parameter_name] = $value;
            }
        }

        try {
            return $this->proxyOracleReport($report->report_file_name, $oracleParams);
        } catch (\Exception $e) {
            Log::error('HRM Report failed: ' . $e->getMessage(), [
                'report_id'   => $request->report_id,
                'report_file' => $report->report_file_name,
                'params'      => $oracleParams,
            ]);
            return response()->json(['error' => 'HRM-9999: ERROR !!! ' . $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // 5. PROXY TO ORACLE REPORTS SERVER — RUN_REPORT_ACTUAL
    //    Server: http://192.168.210.205:9002
    //    Format: DD-MON-YYYY for date params
    // ─────────────────────────────────────────────────────────────────
    protected function proxyOracleReport(string $reportFileName, array $params): \Illuminate\Http\Response
    {
        $serverUrl  = config('hrm.report_server_url');   // http://192.168.210.205:9002
        $serverName = config('hrm.report_server_name');  // rep_wls_reports_fdl-server_asinst_1
        $file_path = 'D:/four_design/reports/';
        $queryParams = array_merge([
            'server'    => $serverName,
            'userid'=>'HRM/hrm@orcl' , // Oracle auth (consider more secure options for production)
            'paramform' => 'no',
            'destype'   => 'cache',
            'desformat' => 'pdf',
        ], $params);

        $url = rtrim($serverUrl, '/') . '/reports/rwservlet?'.'report='.$file_path . strtolower($reportFileName)
             . '&' . http_build_query($queryParams);
//dd($url);
        $response = Http::timeout(config('hrm.timeout', 120))
                        ->withOptions(['verify' => false])
                        ->get($url);

        if (!$response->successful()) {
            throw new \RuntimeException(
                "Oracle Reports Server returned HTTP {$response->status()} for: {$reportFileName}"
            );
        }

        return response($response->body(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $reportFileName . '.pdf"',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────────

    /**
     * Fetch LOV options for a given block_item.
     * Returns array of ['value' => ..., 'label' => ...]
     */
    private function fetchLovOptions(string $blockItem): array
    {
        $source = self::LOV_SOURCES[$blockItem] ?? null;
        if (!$source) return [];

        // Static / raw list (no DB query needed)
        if (isset($source['raw'])) {
            return array_map(fn($r) => ['value' => $r['v'], 'label' => $r['l']], $source['raw']);
        }

        // DB-driven LOV
        try {
            $rows = DB::table($source['table'])
                ->select($source['value'] . ' as value', $source['label'] . ' as label')
                ->orderBy($source['order'])
                ->get();
            return $rows->map(fn($r) => ['value' => $r->value, 'label' => $r->label])->toArray();
        } catch (\Exception $e) {
            Log::warning("LOV fetch failed for {$blockItem}: " . $e->getMessage());
            return [];
        }
    }

    /** Determine if this block_item should be rendered as a LOV dropdown */
    private function isLovField(string $blockItem, ?string $paramType): bool
    {
        return isset(self::LOV_SOURCES[$blockItem])
            || strtolower($paramType ?? '') === 'lov';
    }

    /** Resolve final input type for the UI */
    private function resolveInputType(?string $paramType, string $blockItem): string
    {
        if ($this->isLovField($blockItem, $paramType)) return 'lov';
        return $this->isDateType($paramType) ? 'date' : (strtolower($paramType ?? '') === 'number' ? 'number' : 'text');
    }

    private function isDateType(?string $paramType): bool
    {
        return in_array(strtolower($paramType ?? ''), ['date', 'datetime']);
    }

    /**
     * Convert DD-MM-YYYY (UI flatpickr output) → DD-MON-YYYY (Oracle standard)
     * e.g. 15-01-2025 → 15-JAN-2025
     */
    private function toOracleDate(string $date): string
    {
        $months = [
            '01'=>'JAN','02'=>'FEB','03'=>'MAR','04'=>'APR',
            '05'=>'MAY','06'=>'JUN','07'=>'JUL','08'=>'AUG',
            '09'=>'SEP','10'=>'OCT','11'=>'NOV','12'=>'DEC',
        ];

        // Accept DD-MM-YYYY or YYYY-MM-DD
        if (preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $date, $m)) {
            // DD-MM-YYYY
            return $m[1] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[3];
        }
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m)) {
            // YYYY-MM-DD (HTML date input fallback)
            return $m[3] . '-' . ($months[$m[2]] ?? $m[2]) . '-' . $m[1];
        }

        return $date; // Already formatted or unrecognised — pass through
    }

    /** Human-readable label from Oracle block item name */
    private function labelFromBlockItem(?string $blockItem): string
    {
        $map = [
            'COMPANY_NAME'   => 'Company',
            'SETION_TXT'     => 'Section',
            'P_YEAR'         => 'Year',
            'DEPT_NAME'      => 'Department',
            'AS_DATE'        => 'As of Date',
            'EMP_TYPE'       => 'Employee Type',
            'EMP_GRADE'      => 'Employee Grade',
            'RELEGION'       => 'Religion',
            'BLOOD_GROUP'    => 'Blood Group',
            'SEX'            => 'Gender',
            'DES_NAME'       => 'Designation',
            'EMP_NO'         => 'Employee No',
            'WORK_ENT'       => 'Work Entity',
            'P_FROM_DATE'    => 'From Date',
            'P_TO_DATE'      => 'To Date',
            'ATT_DATE'       => 'Attendance Date',
            'STATUS'         => 'Status',
            'P_MONTH'        => 'Month',
            'P_DAYES'        => 'Days',
            'FLOOR_NAME'     => 'Floor',
            'INCREMENT_TYPE' => 'Increment Type',
            'P_BILL'         => 'Bill No',
            'LINE_NAME'      => 'Line',
            'P_LETTER_NO'    => 'Letter No',
        ];
        return $map[$blockItem] ?? ucwords(strtolower(str_replace('_', ' ', $blockItem ?? '')));
    }
}