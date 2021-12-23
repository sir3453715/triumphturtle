<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.option');
    }
    public function store(Request $request)
    {

        $fields = $request->toArray();
        unset($fields['_token']);
        unset($fields['banner']);
        foreach ($fields as $key => $value) {
            app('Option')->$key = $value;
        }
        if($request->hasFile('banner')){
            $extension = $request->file('banner')->getClientOriginalExtension(); //副檔名
            $path1 = time() . "." . $extension;    //重新命名
            $request->file('banner')->move(storage_path('app').'/public/image/', $path1); //移動至指定目錄
            app('Option')->banner = '/storage/image/'.$path1;;
        }



        return redirect(route('admin.option.index'))->with('message','設定修改成功!');



    }

}
