<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\Category;
use App\Models\Inventory\InventoryGroup;
use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if (!session('LoggedUser') == null) {
                 $uri = Route::getFacadeRoot()->current()->uri(); 
            try
            { 
                    //    $categories = Category::latest()->get();
        return view('inventory.categories.index');


                        } catch (Exception $e) {
                dd($e->getMessage());
            }} else {
            return redirect('login');
        }
    


   
    }


// LOAD CATEGORY LIST (WITH GROUP NAME)
public function list()
{
      $data = Category::with('group')->get();

    return response()->json(
        $data->map(function ($c) {
            return [
                'category_id'   => $c->category_id,
                'category_name' => $c->category_name, // ✅ FIX
                'inv_group_id'  => $c->inv_group_id,
                'group_name'    => optional($c->group)->inv_group_name ?? 'N/A' // ✅ SAFE
            ];
        })
       
    );
   //  dd($data);
}

// LOAD GROUP DROPDOWN
public function groups()
{
    return response()->json(
        InventoryGroup::select('inv_group_id','inv_group_name')->get()
    );
}

// STORE (AUTO ID)
public function store(Request $r)
{
    $r->validate([
        'category_name' => 'required'
    ]);

    $last = Category::orderBy('category_id','desc')->first();

    if ($last && preg_match('/IC-(\d+)/', $last->category_id, $m)) {
        $num = $m[1] + 1;
    } else {
        $num = 1;
    }

    $newId = 'IC-' . str_pad($num,3,'0',STR_PAD_LEFT);

    Category::create([
        'category_id'=>$newId,
        'category_name'=>$r->category_name,
        'inv_group_id'=>$r->inv_group_id,
        'insert_by'=>session('LoggedUser')
    ]);

    return response()->json(['success'=>true]);
}

// UPDATE
public function update(Request $r,$id)
{
    Category::where('category_id',$id)->update([
        'category_name'=>$r->category_name,
        'inv_group_id'=>$r->inv_group_id,
        'update_by'=>session('LoggedUser')
    ]);

    return response()->json(['success'=>true]);
}

// DELETE
public function destroy($id)
{
    Category::where('category_id',$id)->delete();
    return response()->json(['success'=>true]);
}







    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
