<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class HomeController extends Controller
{
//     public function checkdb(){
      
//             return view('checkdb');
//     }

    public function welcome(){
      
        return view('welcome');
}
}
