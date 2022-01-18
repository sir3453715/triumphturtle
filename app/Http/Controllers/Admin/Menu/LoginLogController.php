<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{
    //
    public function index(Request $request)
    {
        $login_log = LoginLog::orderBy('created_at','desc')->simplePaginate(25);
        return view('admin.setting.LoginLog',[
            'login_log'=>$login_log,
        ]);
    }
}
