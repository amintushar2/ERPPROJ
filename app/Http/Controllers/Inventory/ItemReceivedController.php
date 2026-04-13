<?php

namespace App\Http\Controllers\Inventory; 


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\ItemReceived\ItemReceivedMaster;
use App\Models\Inventory\ItemReceived\ItemReceivedStyle;
use App\Models\Inventory\ItemReceived\ItemReceivedDetails;
use DB;
use Illuminate\Support\Str; 



class ItemReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ItemReceivedMaster::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('RECEIVED_NO',          'like', "%{$search}%")
                  ->orWhere('PO_NUMBER',           'like', "%{$search}%")
                  ->orWhere('SUPPLIER_CHALLAN_NO', 'like', "%{$search}%")
                  ->orWhere('SUPPLIER_ID',         'like', "%{$search}%");
            });
        }

        $records = $query->orderByDesc('INSERT_DATE')->paginate(15)->withQueryString();

        return view('item-received.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function create()
    {
         $mode = 'create';
        return view('item-received.form', [
              'mode'    => $mode,  
            'master'  => null,
            'styles'  => collect(),
            'details' => collect(),
        ]);
    }


public function supplierLov(Request $request)
{
    $q = $request->get('q');

    $rows = DB::select("
          SELECT SUPPLIER_NO, PP.PARTY_NAME SUPPLIER_NAME
        FROM PUR_ORDER_MASTER POM, F_STORE.PARTY_PROFILE PP
        Where POM.SUPPLIER_NO=PP.PARTY_ID
        WHERE UPPER(PP.PARTY_NAME ) LIKE UPPER(:q)
           OR UPPER(SUPPLIER_NO) LIKE UPPER(:q)
    ", [
        'q' => '%' . $q . '%'
    ]);

    return response()->json($rows);
}







public function lovSuppliers(Request $request)
{
    $q = strtoupper($request->get('q'));

    return DB::select("
        SELECT DISTINCT  
            SUPPLIER_NO AS party_id,
            PP.PARTY_NAME AS party_name
        FROM PUR_ORDER_MASTER POM
        JOIN F_STORE.PARTY_PROFILE PP 
            ON POM.SUPPLIER_NO = PP.PARTY_ID
        WHERE 
            (:q IS NULL 
             OR UPPER(PP.PARTY_NAME) LIKE '%' || :q || '%'
             OR UPPER(SUPPLIER_NO) LIKE '%' || :q || '%')
    ", ['q' => $q]);
}

public function lovItems(Request $request)
{
    $q = strtoupper($request->get('q'));

    return DB::select("
        SELECT 
            ITEM_ID AS item_id,
            ITEM_NAME AS item_name,
            UNIT
        FROM ITEM_MASTER
        WHERE 
            (:q IS NULL 
             OR UPPER(ITEM_ID) LIKE '%' || :q || '%'
             OR UPPER(ITEM_NAME) LIKE '%' || :q || '%')
        FETCH FIRST 20 ROWS ONLY
    ", ['q' => $q]);
}
public function getPoBySupplier(Request $request, $supplierId)
{
    $q = strtoupper($request->get('q'));

    return DB::select("
        SELECT 
            PM.PUR_ORDER_PK,
            PM.PUR_ORDER_NO AS PO_NUMBER,
            GET_PO_BUYER_NAME(PM.PUR_ORDER_NO) AS BUYER_NAME
        FROM PUR_ORDER_MASTER PM
        WHERE PM.SUPPLIER_NO = :supplier
          AND (:q IS NULL 
               OR UPPER(PM.PUR_ORDER_NO) LIKE '%' || :q || '%'
               OR UPPER(PM.PUR_ORDER_PK) LIKE '%' || :q || '%')
        ORDER BY PM.PUR_ORDER_PK DESC
    ", [
        'supplier' => $supplierId,
        'q' => $q
    ]);
}
public function lovPo()
{
    return DB::select("
        SELECT 
            POS.PUR_ORDER_PK,
            POS.PO_NUMBER,
            POS.PO_NUMBER_ID,
            POS.ORDER_NO,
            POS.PO_QTY AS po_quantity,
            GET_PO_BUYER_NAME(POS.PO_NUMBER) AS buyer_name
        FROM PUR_ORDER_STYLE POS
        FETCH FIRST 20 ROWS ONLY
    ");
}



    /* ─── STORE ─────────────────────────────────────────────── */
    public function store(Request $request)
    {


   //dd( $request->all() );
        $request->validate([
            'RECEIVED_DATE'      => 'required|date',
            'SUPPLIER_ID'        => 'required|string|max:50',
            'SUPPLIER_CHALLAN_NO'=> 'nullable|string|max:50',
            'PO_NUMBER'          => 'nullable|string|max:100',
            'SUPP_BILL_NO'       => 'nullable|string|max:100',
            'CLIENT_PI_NUMBER'   => 'nullable|string|max:50',
            'REMARKS'            => 'nullable|string|max:200',
            'styles'             => 'nullable|array',
            'styles.*.PO_NUMBER' => 'nullable|string|max:100',
            'styles.*.STYLE_NO'  => 'nullable|string|max:50',
            'styles.*.ORDER_NO'  => 'nullable|string|max:50',
            'details'            => 'nullable|array',
            'details.*.ITEM_NO'  => 'required|string|max:50',
            'details.*.ITEM_QTY' => 'required|numeric|min:0',
            'details.*.ITEM_UNIT'=> 'nullable|string|max:30',
            'details.*.RATE'     => 'nullable|numeric',
            'details.*.PUR_QTY'  => 'nullable|numeric',
            'details.*.PERCENTAGE'=> 'nullable|numeric',
        ]);

        DB::transaction(function () use ($request) {
            

// 🔢 SERIAL

$receivedNo   = $request->RECEIVED_NO;
$receivedNoId = $request->RECEIVED_NO_ID;


            $master = ItemReceivedMaster::create([
                'RECEIVED_NO'        => $receivedNo,
                'RECEIVED_NO_ID'     => $receivedNoId,
                'SUPPLIER_ID'        => $request->SUPPLIER_ID,
                'RECEIVED_DATE'      => $request->RECEIVED_DATE,
                'SUPPLIER_CHALLAN_NO'=> $request->SUPPLIER_CHALLAN_NO,
                'REMARKS'            => $request->REMARKS,
                'ORDER_NO_ID'        => $request->ORDER_NO_ID,
                'PO_NUMBER'          => $request->PO_NUMBER,
                'FOUR_PO_NO'         => $request->FOUR_PO_NO,
                'FOUR_PO_ID'         => $request->FOUR_PO_ID,
                'SUPP_BILL_NO'       => $request->SUPP_BILL_NO,
                'CLIENT_PI_NUMBER'   => $request->CLIENT_PI_NUMBER,
            ]);

            // Save styles
            foreach (($request->styles ?? []) as $style) {
                if (!empty($style['STYLE_NO']) || !empty($style['ORDER_NO'])) {
                    ItemReceivedStyle::create([
                        'RECEIVED_NO_ID' => $receivedNoId,
                        'PO_NUMBER'      => $style['PO_NUMBER'] ?? $request->PO_NUMBER,
                        'STYLE_NO'       => $style['STYLE_NO'] ?? null,
                        'ORDER_NO'       => $style['ORDER_NO'] ?? null,
                        'ORDER_NO_ID'    => $style['ORDER_NO_ID'] ?? null,
                    ]);
                }
            }

            // Save details
 foreach ($request->details as $d) {

    if (empty($d['ITEM_NO']) || empty($d['ITEM_QTY'])) {
        continue; // 🔥 skip empty row
    }

    DB::table('G_ITEM_RECEIVED_DETAILS')->insert([
        'RECEIVED_NO_ID' => $request->RECEIVED_NO_ID,
        'PO_NUMBER_ID'   => $d['PO_NUMBER_ID'],
        'ITEM_NO'        => $d['ITEM_NO'],
        'ITEM_QTY'       => $d['ITEM_QTY'],
        'ITEM_UNIT'       => $d['ITEM_UNIT'] ?? null,
        'PUR_QTY'        => $d['PUR_QTY'] ?? null,  
        'ITEM_REMARKS'   => $d['ITEM_REMARKS'] ?? null,

    ]);
}
        });

        return redirect()->route('item-received.index')
                         ->with('success', 'Item Received entry created successfully.');
    }



    // GeneratePK 

public function generatePk(Request $request)
{
    try {

        $row = DB::selectOne("
            SELECT 
                -- 🔥 ID FORMAT
                'IR-' || TO_CHAR(TO_DATE(:dt,'RRRR-MM-DD'),'MMRRRR') ||
                LPAD(
                    NVL(MAX(TO_NUMBER(TRIM(SUBSTR(RECEIVED_NO_ID, 10)))), 0) + 1,
                    3,
                    '0'
                ) AS RECEIVED_NO_ID,

                -- 🔥 NUMBER FORMAT
                TO_CHAR(TO_DATE(:dt,'RRRR-MM-DD'),'RRRRMM') ||
                LPAD(
                    NVL(MAX(TO_NUMBER(TRIM(SUBSTR(RECEIVED_NO, 7)))), 0) + 1,
                    4,
                    '0'
                ) AS RECEIVED_NO

            FROM G_ITEM_RECEIVED_MASTER

            WHERE SUBSTR(RECEIVED_NO_ID, 4, 6) =
                  TO_CHAR(TO_DATE(:dt,'RRRR-MM-DD'),'MMRRRR')
        ", [
            'dt' => $request->date
        ]);

        return response()->json([
            'id'  => $row->received_no_id ?? null,
            'no'  => $row->received_no ?? null,
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
}


public function getPoFullData($pk)
{
    $rows = DB::select("
        SELECT 
            POS.PUR_ORDER_PK,
            OPN.PO_NUMBER  ,
            POS.PO_NUMBER_ID,
            POS.ORDER_NO,
            OPN.PO_QUANTITY PO_QTY,
            GET_PO_BUYER_NAME(OPN.PO_NUMBER) AS BUYER_NAME,
            POD.ITEM_ID,
            IM.ITEM_NAME,
            POD.ITM_UNIT,
            POD.QUANTITY,
            POD.ITEM_RATE,
            (POD.QUANTITY * POD.ITEM_RATE) AS VALUE
        FROM PUR_ORDER_STYLE POS
        JOIN PUR_ORDER_DETAILS POD 
            ON POS.PUR_ORDER_PK = POD.PUR_ORDER_PK
           AND POS.PO_NUMBER_ID = POD.PO_NUMBER_ID
        JOIN ITEM_MASTER IM 
            ON POD.ITEM_ID = IM.ITEM_ID
            JOIN ORDER_PO_NUMBER OPN 
            on OPN.PO_NUMBER_ID=POS.PO_NUMBER_ID

        WHERE POS.PUR_ORDER_PK = :pk
    ", ['pk' => $pk]);

    return response()->json($rows);
}
    /* ─── SHOW ──────────────────────────────────────────────── */
    public function show($id)
    {
        $master  = ItemReceivedMaster::with(['styles', 'details'])->findOrFail($id);
        $styles  = $master->styles;
        $details = $master->details;

      return view('item-received.form', [
    'master'  => $master,
    'styles'  => $master->styles,
    'details' => $master->details,
    'viewMode'=> request()->get('view') // ⭐ IMPORTANT
]);
    }

    /* ─── EDIT ──────────────────────────────────────────────── */
 public function edit($id)
{
    $master = ItemReceivedMaster::with(['styles','details'])
        ->where('RECEIVED_NO_ID', $id)
        ->firstOrFail();
   // 🔥 ADD THIS (IMPORTANT)
    $supplier = DB::selectOne("
        SELECT COM.GET_PARTY_NAME(:id) AS NAME FROM DUAL
    ", [
        'id' => $master->supplier_id
    ]);

    $master->supplier_name = $supplier->name ?? '';

  //  dd($master->toArray());
    return view('item-received.form', [
        'master'  => $master,
        'styles'  => $master->styles,
        'details' => $master->details,
        'mode'    => 'view' ,
        'viewMode'=> request()->get('view')
    ]);
}

public function editForm($id)
{
    $master  = ItemReceivedMaster::with(['styles', 'details'])
        ->where('RECEIVED_NO_ID', $id) // or use RECEIVED_NO_ID if fixed
        ->firstOrFail();

     return view('item-received.form', [
        'master'  => $master,
        'styles'  => $master->styles,
        'details' => $master->details,
        'mode'    => 'edit'   // ✅ ALSO ADD THIS
    ]);
}
    /* ─── UPDATE ────────────────────────────────────────────── */
    public function update(Request $request, $id)
    {
        $request->validate([
            'RECEIVED_DATE'       => 'required|date',
            'SUPPLIER_ID'         => 'required|string|max:50',
            'SUPPLIER_CHALLAN_NO' => 'nullable|string|max:50',
            'PO_NUMBER'           => 'nullable|string|max:100',
            'SUPP_BILL_NO'        => 'nullable|string|max:100',
            'CLIENT_PI_NUMBER'    => 'nullable|string|max:50',
            'REMARKS'             => 'nullable|string|max:200',
        ]);

        DB::transaction(function () use ($request, $id) {
              $master = ItemReceivedMaster::where('RECEIVED_NO_ID', $id)->firstOrFail();

            $master->update([
                'SUPPLIER_ID'        => $request->SUPPLIER_ID,
                'RECEIVED_DATE'      => $request->RECEIVED_DATE,
                'SUPPLIER_CHALLAN_NO'=> $request->SUPPLIER_CHALLAN_NO,
                'REMARKS'            => $request->REMARKS,
                'ORDER_NO_ID'        => $request->ORDER_NO_ID,
                'PO_NUMBER'          => $request->PO_NUMBER,
                'FOUR_PO_NO'         => $request->FOUR_PO_NO,
                'FOUR_PO_ID'         => $request->FOUR_PO_ID,
                'SUPP_BILL_NO'       => $request->SUPP_BILL_NO,
                'CLIENT_PI_NUMBER'   => $request->CLIENT_PI_NUMBER,
            ]);

            // Sync styles: delete then re-insert
            ItemReceivedStyle::where('RECEIVED_NO_ID', $id)->delete();
            foreach (($request->styles ?? []) as $style) {
                if (!empty($style['STYLE_NO']) || !empty($style['ORDER_NO'])) {
                    ItemReceivedStyle::create([
                        'RECEIVED_NO_ID' => $id,
                        'PO_NUMBER'      => $style['PO_NUMBER'] ?? $request->PO_NUMBER,
                        'STYLE_NO'       => $style['STYLE_NO'] ?? null,
                        'ORDER_NO'       => $style['ORDER_NO'] ?? null,
                        'ORDER_NO_ID'    => $style['ORDER_NO_ID'] ?? null,
                    ]);
                }
            }

            // Sync details
            ItemReceivedDetails::where('RECEIVED_NO_ID', $id)->delete();
            foreach (($request->details ?? []) as $detail) {
                if (!empty($detail['ITEM_NO'])) {
                    ItemReceivedDetails::create([
                        'RECEIVED_NO_ID'    => $id,
                        'ITEM_NO'           => $detail['ITEM_NO'],
                        'ITEM_QTY'          => $detail['ITEM_QTY'] ?? 0,
                        'ITEM_UNIT'         => $detail['ITEM_UNIT'] ?? null,
                        'ITEM_REMARKS'      => $detail['ITEM_REMARKS'] ?? null,
                        'PO_NUMBER'         => $detail['PO_NUMBER'] ?? $request->PO_NUMBER,
                        'PO_NUMBER_ID'      => $detail['PO_NUMBER_ID'] ?? null,
                        'PUR_QTY'           => $detail['PUR_QTY'] ?? null,
                        'PERCENTAGE'        => $detail['PERCENTAGE'] ?? null,
                        'PREVIOUS_RECEIVED' => $detail['PREVIOUS_RECEIVED'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('item-received.index')
                         ->with('success', 'Item Received entry updated successfully.');
    }

     public function destroy($id)
{
    DB::transaction(function () use ($id) {
        ItemReceivedDetails::where('RECEIVED_NO_ID', $id)->delete();
        ItemReceivedStyle::where('RECEIVED_NO_ID', $id)->delete();
        ItemReceivedMaster::where('RECEIVED_NO_ID', $id)->delete();
    });

    return redirect()->route('item-received.index')
                     ->with('success', 'Item Received entry deleted successfully.');
}
}
