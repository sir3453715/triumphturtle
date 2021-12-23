<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    /**
     * index
     */
    function index(){
        if (Auth::check()){
            return redirect(route('admin.dashboard.index'));
        }else{
            return redirect(route('index'));
        }
    }

    public function loginPage()
    {
        if( Auth::check()){
            return redirect(route('admin.index'));
        }else{
            return view('admin.loginPage');

        }
    }

}
