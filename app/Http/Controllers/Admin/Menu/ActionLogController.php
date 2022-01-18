<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    //
    public function index(Request $request)
    {
        $action_log = ActionLog::orderBy('created_at','desc')->simplePaginate(25);

        return view('admin.setting.ActionLog',[
            'action_log'=>$action_log,
        ]);
    }
}
