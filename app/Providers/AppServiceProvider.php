<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

use Session;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
   
public function boot()
{
    View::composer('*', function ($view) {

        $uri = request()->path();

      

$data = DB::table('ALL_USER_INFO')
->select(
                'USER_ID',
                'EMPLOYEE_ID',
                'USER_GROUP_ID',
                'INITIAL_PASSWORD',
                'COMPANY_ID',
                'USER_MOBILE',
           DB::raw('"GET_EMP_NAME"(EMPLOYEE_ID) as EMPLOYEE_NAME')
    )
    ->where('EMPLOYEE_ID', session('LoggedUser'))
    ->first();
//dd($data);
//dd(gettype($data), $data);



        $leftmenu = DB::table('ALL_USER_GROUP_DETAILS')
            ->crossJoin('ALL_MENU_HIERARCHY')
            ->select('MENU_ITEM_ID', 'USER_GROUP_ID', 'TITLE', 'DESCRIPTION')
            ->where('ALL_USER_GROUP_DETAILS.ENABLED', 'Y')
            ->where('ALL_MENU_HIERARCHY.CHILD_ID', DB::raw('ALL_USER_GROUP_DETAILS.MENU_ITEM_ID'))
            ->get();

        $submenu = DB::table('ALL_USER_SUB_DETAILS')
            ->whereNull('SUB_MENU_2')
            ->get();

        $submenu2 = DB::table('ALL_USER_SUB_DETAILS')
            ->whereNotNull('SUB_MENU_2')
            ->get();

        $headeer = DB::table('ALL_USER_SUB_DETAILS')
            ->where('ROUTE', $uri)
            ->get();

        // share to all views
        $view->with([
            'data' => $data,
            'menu' => $leftmenu,
            'submenu' => $submenu,
            'submenu2' => $submenu2,
            'headeer' => $headeer
        ]);
    });
}
}
