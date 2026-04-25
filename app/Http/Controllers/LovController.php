<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

/**
 * LovController
 * Provides all List-of-Values (LOV) data as JSON for Select2 AJAX.
 * Each method returns { results: [{id, text}] } format.
 */
class LovController extends Controller
{
    private function auth() {
        if (!session('LoggedUser')) abort(401);
    }
  public function company(Request $request) {
        $this->auth();
        $rows = DB::table('COMPANY_PROFILE as cp')
            ->join('COMPANY_PERMISSION as perm', 'cp.COMPANY_ID', '=', 'perm.COMPANY_ID')
            ->select('cp.COMPANY_ID as id', DB::raw("cp.COMPANY_NAME as text"))
            ->when($request->q, fn($q) => $q->where('cp.COMPANY_NAME', 'like', '%'.$request->q.'%'))
            ->orderBy('cp.COMPANY_NAME')
            ->limit(50)
            ->distinct()
            ->get();
        return response()->json(['results' => $rows]);
    }
    // Department  GET /lov/dept
    public function dept(Request $request) {
        $this->auth();
        $rows = DB::table('DEPT')
            ->select('DEPT_NO as id', DB::raw("DEPT_NAME as text"))
            ->when($request->q, fn($q) => $q->where('DEPT_NAME','like','%'.$request->q.'%'))
            ->orderBy('DEPT_NO')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Section  GET /lov/section
    public function section(Request $request) {
        $this->auth();
        $rows = DB::table('SECTION')
            ->select('SECTION_NO as id', DB::raw("SECTION_NAME as text"))
            ->when($request->q, fn($q) => $q->where('SECTION_NAME','like','%'.$request->q.'%'))
            ->orderBy('SECTION_NO')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Floor  GET /lov/floor
    public function floor(Request $request) {
        $this->auth();
        $rows = DB::table('FLOOR')
            ->select('FLOOR_ID as id', DB::raw("FLOOR_DESC as text"))
            ->when($request->q, fn($q) => $q->where('FLOOR_DESC','like','%'.$request->q.'%'))
            ->orderBy('FLOOR_ID')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }



    public function emp_type(Request $request) {
        $this->auth();
        $rows = DB::table('EMP_TYPE')
            ->select('EMP_TYPE as id', DB::raw("EMP_TYPE as text"))
            ->when($request->q, fn($q) => $q->where('EMP_TYPE','like','%'.$request->q.'%'))
            ->orderBy('EMP_TYPE')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }
    // Line  GET /lov/line
    public function line(Request $request) {
        $this->auth();
        $rows = DB::table('LINE_INFO')
            ->select('LINE_NO as id', DB::raw("LINE as text"))
            ->when($request->q, fn($q) => $q->where('LINE','like','%'.$request->q.'%'))
            ->orderBy('LINE')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Designation  GET /lov/designation
    public function designation(Request $request) {
        $this->auth();
        $rows = DB::table('DESIGNATION_DETAILS')
            ->select('DES_ID as id', DB::raw("DESIGNATION_NAME as text"))
            ->when($request->q, fn($q) => $q->where('DESIGNATION_NAME','like','%'.$request->q.'%'))
            ->orderBy('DESIGNATION_NAME')->limit(200)->get();
        return response()->json(['results' => $rows]);
    }

    // Grade  GET /lov/grade
    public function grade(Request $request) {
        $this->auth();
        $rows = DB::table('HRM.GRADE')
            ->select('GRADE_ID as id', DB::raw("GRADE_NAME as text"))
            ->when($request->q, fn($q) => $q->where('GRADE_NAME','like','%'.$request->q.'%'))
            ->orderBy('GRADE_NAME')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Shift  GET /lov/shift
    public function shift(Request $request) {
        $this->auth();
        $rows = DB::table('HRM.SHIFT_INFO')
            ->select('SHIFT_CODE as id', DB::raw("SHIFT_NAME as text"))
            ->when($request->q, fn($q) => $q->where('SHIFT_NAME','like','%'.$request->q.'%'))
            ->orderBy('SHIFT_NAME')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Calendar  GET /lov/calendar
    public function calendar(Request $request) {
        $this->auth();
        $rows = DB::table('HRM.CALENDER_MASTER')
            ->select('CAL_CODE as id', DB::raw("CAL_CODE as text"))
            ->where('IS_CLOSE','N')
            ->when($request->q, fn($q) => $q->where('CAL_CODE','like','%'.$request->q.'%'))
            ->orderBy('CAL_CODE')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Weekly off (static)  GET /lov/weeklyoff
    public function weeklyoff() {
        $this->auth();
        return response()->json(['results' => [
            ['id'=>'Friday',   'text'=>'Friday'],
            ['id'=>'Saturday', 'text'=>'Saturday'],
            ['id'=>'Sunday',   'text'=>'Sunday'],
        ]]);
    }

    // Bank  GET /lov/bank
    public function bank(Request $request) {
        $this->auth();
        $rows = DB::table('BANK')
            ->select('BANK_NAME as id', DB::raw("BANK_NAME as text"))
            ->when($request->q, fn($q) => $q->where('BANK_NAME','like','%'.$request->q.'%'))
            ->orderBy('BANK_NAME')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Leave Category  GET /lov/leavecat
    public function leavecat(Request $request) {
        $this->auth();
        $rows = DB::table('LV_CAT_MASTER')
            ->select('LV_CAT_ID as id', DB::raw("LV_CAT_ID as text"))
            ->when($request->q, fn($q) => $q->where('LV_CAT_ID','like','%'.$request->q.'%'))
            ->orderBy('LV_CAT_ID')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Allowance Category  GET /lov/allwcat
    public function allwcat(Request $request) {
        $this->auth();
        $rows = DB::table('ALLW_CAT_MASTER')
            ->select('ALLW_CAT_ID as id', DB::raw("ALLW_CAT_ID as text"))
            ->when($request->q, fn($q) => $q->where('ALLW_CAT_ID','like','%'.$request->q.'%'))
            ->orderBy('ALLW_CAT_ID')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Thana/Upazila  GET /lov/thana
    public function thana(Request $request) {
        $this->auth();
        $rows = DB::table('HRM.UPAZILAS')
            ->select('NAME as id', DB::raw("NAME as text"))
            ->when($request->q, fn($q) => $q->where('NAME','like','%'.$request->q.'%'))
            ->orderBy('NAME')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // District  GET /lov/district
    public function district(Request $request) {
        $this->auth();
        $rows = DB::table('HRM.DISTRICT')
            ->select('DISTRICT as id', DB::raw("DISTRICT as text"))
            ->when($request->q, fn($q) => $q->where('DISTRICT','like','%'.$request->q.'%'))
            ->orderBy('DISTRICT')->limit(50)->get();
        return response()->json(['results' => $rows]);
    }

    // Y/N options (work_ent, ot_ent, res_ent, tran_ent, pf_ent, tax_ent)
    public function yesno() {
        return response()->json(['results' => [
            ['id'=>'Y','text'=>'Yes'],
            ['id'=>'N','text'=>'No'],
        ]]);
    }
}
