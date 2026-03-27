<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Item;
use App\Models\Inventory\Category;
use App\Models\Inventory\Unit;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
class ItemController extends Controller
{
    // PAGE
    public function index()
    {


     if (!session('LoggedUser') == null) {
                 $uri = Route::getFacadeRoot()->current()->uri(); 
            try
            { 
                    //    $categories = Category::latest()->get();
           return view('inventory.items.index');


                        } catch (Exception $e) {
                dd($e->getMessage());
            }} else {
            return redirect('login');
        }
    
    }

    // LIST
 public function list(Request $request)
{
    $search = $request->get('search');

    $query = Item::with(['category','unit']);

    if (!empty($search)) {

        $search = strtoupper($search); // 🔥 Oracle fix

        $query->where(function($q) use ($search) {
            $q->whereRaw("UPPER(ITEM_NAME) LIKE ?", ["%$search%"])
              ->orWhereHas('category', function($c) use ($search) {
                  $c->whereRaw("UPPER(CATEGORY_NAME) LIKE ?", ["%$search%"]);
              })
              ->orWhereHas('unit', function($u) use ($search) {
                  $u->whereRaw("UPPER(UNIT_NAME) LIKE ?", ["%$search%"]);
              });
        });
    }

    $items = $query->orderBy('item_id','desc')->paginate(10);

    return response()->json([
        'data' => $items->map(function ($i) {
            return [
                'item_id' => $i->item_id,
                'item_name' => $i->item_name,
                'category_id' => $i->category_id,
                'category_name' => $i->category->category_name ?? '',
                'unit_id' => $i->unit_id,
                'unit_name' => $i->unit->unit_name ?? '',
                'credit_limit' => $i->credit_limit ?? '',
                'present_balance' => $i->present_balance ?? ''
            ];
        }),
        'current_page' => $items->currentPage(),
        'last_page' => $items->lastPage()
    ]);
}

    // CATEGORY DROPDOWN
    public function categories()
    {
        return response()->json(
            Category::select('category_id','category_name')->get()
        );
    }

    // UNIT DROPDOWN
    public function units()
    {
        return response()->json(
            Unit::select('unit_id','unit_name')->get()
        );
    }

    // STORE
    public function store(Request $r)
    {
        $r->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required'
        ]);

        // AUTO ID
        $last = Item::orderBy('item_id','desc')->first();

        if ($last && preg_match('/IT-(\d+)/', $last->item_id, $m)) {
            $num = $m[1] + 1;
        } else {
            $num = 1;
        }

        $newId = 'IT-' . str_pad($num,3,'0',STR_PAD_LEFT);

        Item::create([
            'item_id'=>$newId,
            'item_name'=>$r->item_name,
            'category_id'=>$r->category_id,
            'unit_id'=>$r->unit_id,
            'credit_limit'=>$r->credit_limit ?? 0,
            'present_balance'=>$r->present_balance ?? 0,
            'item_status'=>1,
            'insert_by'=>session('LoggedUser')
        ]);

        return response()->json(['success'=>true]);
    }

    // UPDATE
    public function update(Request $r,$id)
    {
        $r->validate([
            'item_name' => 'required',
            'category_id' => 'required',
            'unit_id' => 'required'
        ]);

        Item::where('item_id',$id)->update([
            'item_name'=>$r->item_name,
            'category_id'=>$r->category_id,
            'unit_id'=>$r->unit_id,
            'credit_limit'=>$r->credit_limit ?? 0,
            'present_balance'=>$r->present_balance ?? 0,
            'update_by'=>session('LoggedUser')
        ]);

        return response()->json(['success'=>true]);
    }

    // DELETE
    public function destroy($id)
    {
        Item::where('item_id',$id)->delete();
        return response()->json(['success'=>true]);
    }
}