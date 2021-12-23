<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::role(['member'])->where('status',1)->get();//排除未啟用帳號
        $calendars = Calendar::all();
        return view('admin.calendar.calendar',[
            'calendars'=>$calendars,
            'users'=>$users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //建立行事曆
        $data = [
            "title" => $request->get('title'),
            "member" => $request->get('member'),
            "start_time" => $request->get('start_time'),
            "end_time" => $request->get('end_time'),
            "description" => $request->get('description'),
            "color" => $request->get('color'),
        ];
        $calendar = Calendar::create($data);
        ActionLog::create_log($calendar,'create');

        return redirect(route('admin.calendar.index'))->with('message', '事件已建立!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [
            "title" => $request->get('title'),
            "member" => $request->get('member'),
            "start_time" => $request->get('start_time'),
            "end_time" => $request->get('end_time'),
            "description" => $request->get('description'),
            "color" => $request->get('color'),
        ];
        $calendar = Calendar::find($request->get('id'));
        $calendar->fill($data);
        $calendar->save();
        ActionLog::create_log($calendar);

        return redirect(route('admin.calendar.index'))->with('message', '事件已修改!');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function changeEventDate(Request $request)
    {

        $data = [
            "start_time" => $request->get('start'),
            "end_time" => $request->get('end'),
        ];
        $calendar = Calendar::find($request->get('id'));
        $calendar->fill($data);
        $calendar->save();

        ActionLog::create_log($calendar);

        return 1; //json
    }
    public function EventDelete(Request $request)
    {
        $calendar = Calendar::find($request->get('id'));
        if($calendar){
            $calendar->delete();
            ActionLog::create_log($calendar,'delete');
            return 1; //json
        }else{
            return 0; //json
        }

    }
}
