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
        $action_log = ActionLog::WhereNotNull('id');
        $queried = array();
        if($request->get('id')) {
            $action_log = $action_log->where('action_id',$request->get('id'));
            $queried['id'] = $request->get('id');
        }
        $action_log = $action_log->orderBy('created_at','desc')->simplePaginate(25);
        return view('admin.setting.ActionLog',[
            'action_log'=>$action_log,
            'queried' => $queried,
        ]);
    }
}
