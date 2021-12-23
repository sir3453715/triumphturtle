<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class WebLogController extends Controller
{
    //
    public function index(Request $request)
    {
        $login_log = LoginLog::orderBy('created_at','desc')->limit(25)->get();
        $action_log = ActionLog::orderBy('created_at','desc')->paginate(10);
        $current_tab = $request->get('tab');

        return view('admin.setting.webHistoryLog',[
            'login_log'=>$login_log,
            'action_log'=>$action_log,
            'current_tab'=> $current_tab?? null,

        ]);
    }
}
