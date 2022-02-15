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
        unset($fields['banner_mb']);
        foreach ($fields as $key => $value) {
            app('Option')->$key = $value;
        }
        //電腦版Banner
        $banner = app('Option')->banner;
        $banner_img = explode('/',$banner);
        if($request->hasFile('banner')){
            if($banner){
                unlink(storage_path('app/public/image/'.$banner_img[3]));
            }
            $extension = $request->file('banner')->getClientOriginalExtension(); //副檔名
//            $path1 = time() . "." . $extension;    //重新命名
            $path1 = "slide-1." . $extension;    //重新命名
            $request->file('banner')->move(storage_path('app').'/public/image/', $path1); //移動至指定目錄
            app('Option')->banner = '/storage/image/'.$path1;
        }
        //手機板Banner
        $banner_mb = app('Option')->banner_mb;
        $banner_mb_img = explode('/',$banner_mb);
        if($request->hasFile('banner_mb')){
            if($banner_mb){
                unlink(storage_path('app/public/image/'.$banner_mb_img[3]));
            }
            $extension = $request->file('banner_mb')->getClientOriginalExtension(); //副檔名
//            $path1 = time() . "." . $extension;    //重新命名
            $path1 = "slide-1-mb." . $extension;    //重新命名
            $request->file('banner_mb')->move(storage_path('app').'/public/image/', $path1); //移動至指定目錄
            app('Option')->banner_mb = '/storage/image/'.$path1;
        }

        return redirect(route('admin.option.index'))->with('message','設定修改成功!');



    }

}
