<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function uploadEditorImage(Request $request)
    {
        $return['result'] = true;
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                $extension = $request->file('file')->getClientOriginalExtension(); //副檔名
                $path1 = md5(Auth::id().time().$request->file('file')->getClientOriginalName()).".".$extension;    //重新命名
                $request->file('file')->move(storage_path('app').'/public/editor/', $path1); //移動至指定目錄
                $return['url'] = url('/storage/editor/'.$path1);
            } else {
                $return['result'] = false;
            }
        }

        return $return; //json
    }
}
