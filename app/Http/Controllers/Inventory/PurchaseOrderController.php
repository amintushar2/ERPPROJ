<?php
namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Models\Inventory\PurOrderMaster;
use App\Models\Inventory\PurOrderDetails;
use App\Models\Inventory\PurOrderStyle;
use App\Models\Inventory\PurOrderTerms;
use App\Services\PurchaseOrderService;

use Session;
use DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route ;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
   protected $service;

    public function __construct(PurchaseOrderService $service)
    {
        $this->service = $service;
    }

    // =====================================================
    // INDEX (QUERY MODE)
    // =====================================================
    public function index()
    {
        return view('inventory.purchaseorder.index'); // your blade
    }

    // =====================================================
    // CREATE
    // =====================================================
    public function create()
    {
        return view('inventory.purchaseorder.index');
    }

    // =====================================================
    // STORE (KEY-COMMIT)
    // =====================================================


 public function store(Request $request)
    {
        
    $data = $request->all();

    $pk = $data['master']['PUR_ORDER_PK'];

    // 🔥 CHECK IF EXISTS

    
    
    try {
$data = $request->all();

    $pk = $data['master']['PUR_ORDER_PK'];

    // 🔥 CHECK IF EXISTS
    $exists = DB::selectOne("
        SELECT COUNT(*) AS CNT 
        FROM PUR_ORDER_MASTER 
        WHERE PUR_ORDER_PK = :pk
    ", ['pk' => $pk]);

    if ($exists->cnt > 0) {
        // 🔁 UPDATE
        $this->service->updateOrder($data);
        return response()->json(['message' => 'Record updated successfully']);
    } else {
        // ➕ INSERT
        $this->service->saveOrder($data);
        return response()->json(['message' => 'Record inserted successfully']);
    }
       

    } catch (\Throwable $e) {

        return response()->json([
            'error' => $e->getMessage(),
            'line'  => $e->getLine(),
            'file'  => $e->getFile()
        ], 500);
    }
    }


    // ===============================
    // SAVE MASTER
    // ===============================
    private function saveMaster($request)
    {
        // if needed later
        return true;
    }


    // ===============================
    // SAVE DETAILS (MAIN)
    // ===============================
    private function saveDetails($details)
    {
         foreach ($details as $d) {

        DB::table('PUR_ORDER_DETAILS')->insert([
            'PUR_ORDER_PK' => $d['PUR_ORDER_PK'],   // 🔗 MASTER
            'PO_NUMBER_ID' => $d['PO_NUMBER_ID'],   // 🔗 STYLE
            'ITEM_ID'      => $d['ITEM_ID'],
            'ITEM_NAME'    => $d['ITEM_NAME'],
            'QTY'          => $d['QTY'],
            'RATE'         => $d['RATE'],
            'UNIT'         => $d['UNIT'],
            'CURRENCY'     => $d['CURRENCY'],   
        ]);
    }
    }











  

    // =====================================================
    // SHOW (LOAD PO)
    // =====================================================
    public function show($id)
{
    $master = DB::selectOne("
    SELECT 
        PUR_ORDER_PK,
        PUR_ORDER_NO,
        TO_CHAR(PUR_ORDER_DATE, 'YYYY-MM-DD') AS PUR_ORDER_DATE,
        SUPPLIER_NO
    FROM PUR_ORDER_MASTER
    WHERE PUR_ORDER_PK = :id
", ['id' => $id]);

return response()->json($master);
}



public function generatePk(Request $request)
{

 
    try {

        $pk = DB::selectOne("
            SELECT 
                'PU-' || TO_CHAR(TO_DATE(:po_date,'RRRR-MM-DD'),'MMRRRR') ||
                LPAD(
                    NVL(MAX(TO_NUMBER(TRIM(SUBSTR(PUR_ORDER_PK, 10)))), 0) + 1,
                    3,
                    '0'
                ) AS PK
            FROM PUR_ORDER_MASTER
            WHERE SUBSTR(PUR_ORDER_PK, 4, 6) = 
                  TO_CHAR(TO_DATE(:po_date,'RRRR-MM-DD'),'MMRRRR')
        ", [
            'po_date' => $request->date
        ]);
//dd($pk);
        return response()->json([
            'pk' => $pk->pk ?? 'NO DATA'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
}
    // =====================================================
    // UPDATE
    // =====================================================
    public function update(Request $request, $id)
    {
        try {

            $this->service->updateOrder($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // =====================================================
    // DELETE
    // =====================================================
  public function destroy($id)
{
    try {

        DB::beginTransaction();

        // 🔥 DELETE CHILD FIRST
        DB::delete("
            DELETE FROM PUR_ORDER_DETAILS 
            WHERE PUR_ORDER_PK = :pk
        ", ['pk' => $id]);

        DB::delete("
            DELETE FROM PUR_ORDER_STYLE 
            WHERE PUR_ORDER_PK = :pk
        ", ['pk' => $id]);

        // 🔥 DELETE MASTER LAST
        DB::delete("
            DELETE FROM PUR_ORDER_MASTER 
            WHERE PUR_ORDER_PK = :pk
        ", ['pk' => $id]);

        DB::commit();

        return response()->json([
            'message' => 'Purchase Order deleted successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

    // =====================================================
    // LOV — PO
    // =====================================================
    public function lovPoNumbers(Request $request)
    {
        return response()->json(
            $this->service->getPoLov($request->q)
        );
    }

    // =====================================================
    // LOV — ITEM
    // =====================================================
    public function lovItems(Request $request)
    {
        return response()->json(
            $this->service->getItemLov($request->q, $request->order_no)
        );
    }

    // =====================================================
    // LOV — SUPPLIER
    // =====================================================
    public function lovSuppliers(Request $request)
    {
        return response()->json(
            $this->service->getSupplierLov($request->q)
        );
    }

    // =====================================================
    // WHEN-VALIDATE-ITEM
    // =====================================================
    public function validateItem(Request $request, $id)
    {
        return response()->json(
            $this->service->validateItem($request->all())
        );
    }

    // =====================================================
    // POST-CHANGE (RECALC)
    // =====================================================
    public function recalcLine(Request $request, $id)
    {
        return response()->json(
            $this->service->recalcLine($request->all())
        );
    }
public function getItemsByPo($poId)
{
    $data = DB::select("
      SELECT 
    POS.PUR_ORDER_PK,
    POD.ITEM_ID,
    IM.ITEM_NAME,
    POD.ITM_UNIT,
    POD.QUANTITY,
    POD.ITEM_RATE,
    POS.PO_NUMBER_ID,
    POD.CURRENCY_CODE,

    -- STYLE DATA
    OPN.PO_NUMBER,
    POS.ORDER_NO,
    GET_PO_BUYER_NAME(OPN.PO_NUMBER) AS BUYER_NAME,
    POS.PO_QTY,

    -- CALCULATIONS
    (POD.QUANTITY * POD.ITEM_RATE) AS VALUE,
    (POD.QUANTITY * POD.ITEM_RATE * 110) AS VALUE_BDT

FROM PUR_ORDER_STYLE POS   -- ✅ MAIN TABLE

LEFT JOIN PUR_ORDER_DETAILS POD
    ON POD.PUR_ORDER_PK = POS.PUR_ORDER_PK
   AND POD.PO_NUMBER_ID = POS.PO_NUMBER_ID

LEFT JOIN ITEM_MASTER IM 
    ON POD.ITEM_ID = IM.ITEM_ID

LEFT JOIN ORDER_PO_NUMBER OPN 
    ON OPN.PO_NUMBER_ID = POS.PO_NUMBER_ID

WHERE POS.PUR_ORDER_PK =   :poId
    ", ['poId' => $poId]);

    return response()->json($data);
}
    // =====================================================
    // IMPORT EXCEL
    // =====================================================
    public function importXl(Request $request, $id)
    {
        return response()->json(
            $this->service->importFromExcel($request->all())
        );
    }

    // =====================================================
    // PO CHECK
    // =====================================================
    public function poCheck()
    {
        return response()->json(
            $this->service->getPoCheckData()
        );
    }
public function search(Request $request)
{
    $q = '%' . $request->q . '%';

    $data = DB::select("
        SELECT 
        PUR_ORDER_NO,
            PUR_ORDER_PK,
            SUPPLIER_NO
        FROM PUR_ORDER_MASTER
        WHERE PUR_ORDER_NO LIKE UPPER(:q)
        FETCH FIRST 100 ROWS ONLY
    ", ['q' => $q]);

    return response()->json($data);
}
public function generatePoNo(Request $request)
{
    try {

        $no = DB::selectOne("
            SELECT 
                TO_CHAR(TO_DATE(:po_date,'rrrr-MM-DD'),'rrrrMM') ||
                LPAD(
                    NVL(MAX(TO_NUMBER(SUBSTR(PUR_ORDER_NO,7))),0) + 1,
                    3,
                    '0'
                ) AS PO_NO
            FROM PUR_ORDER_MASTER
            WHERE SUBSTR(PUR_ORDER_NO,1,6) = 
                  TO_CHAR(TO_DATE(:po_date,'rrrr-MM-DD'),'rrrrMM')
        ", [
            'po_date' => $request->date
        ]);

        return response()->json([
            'po_no' => $no->po_no
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
}

}
