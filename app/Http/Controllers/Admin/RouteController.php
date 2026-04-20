<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuHierarchy;
use App\Models\RouteDetail;
use App\Models\UserGroupMaster;
use App\Models\UserGroupDetail;
use App\Models\UserSubDetail;
use App\Models\UserInfo;

class RouteController extends Controller
{
    public function index()
    {
        $routes = RouteDetail::orderBy('ROUTE_ID')->get();
        $menus  = MenuHierarchy::orderBy('SORT_BY')->get();
        return view('admin.routes.index', compact('routes', 'menus'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'ROUTE_ID'   => 'required|max:30|unique:ALL_ROUTE_DETAILS,ROUTE_ID',
            'ROUTE_PATH' => 'required|max:200',
            'MENU_CHILD_ID' => 'required',
            'SUB_MENU_NAME' => 'nullable|max:100',
            'IS_ACTIVE' => 'required|in:Y,N',
        ]);

        RouteDetail::create([
            'ROUTE_ID'      => $request->ROUTE_ID,
            'ROUTE_PATH'    => $request->ROUTE_PATH,
            'MENU_CHILD_ID' => $request->MENU_CHILD_ID,
            'COMPONENT'     => $request->SUB_MENU_NAME,
            'IS_ACTIVE'     => $request->IS_ACTIVE,
            'DESCRIPTION'   => $request->DESCRIPTION,
            'INSERT_BY'     => auth()->id() ?? 'USER',
            'INSERT_DATE'   => now(),
        ]);

        return redirect()->route('routes.index')->with('success', 'Route saved.');
    }

    public function destroy($id)
    {
        RouteDetail::findOrFail($id)->delete();
        return redirect()->route('routes.index')->with('success', 'Route deleted.');
    }
}
