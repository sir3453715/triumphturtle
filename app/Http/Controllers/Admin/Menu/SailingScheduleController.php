<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\SailingSchedule;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SailingScheduleController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $sailings = SailingSchedule::whereNotNull('id');
        $queried=['status'=>'','on_off'=>'','from_country'=>'','to_country'=>'','statement_time'=>'','sailing_date'=>'',];
        foreach ($queried as $key =>$value){
            if($request->get($key)) {
                $queried[$key] = $request->get($key);
                $sailings = $sailings->where($key,'=',$request->get($key));
            }
        }
        $countries = Country::all();
        $sailings = $sailings->paginate(25);
        return view('admin.sailingSchedule.sailingSchedule', [
            'sailings'=>$sailings,
            'countries'=>$countries,
            'queried'=>$queried,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.sailingSchedule.createSailingSchedule',[
            'countries'=>$countries
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->toArray();
        unset($data['_token']);
        $sailing = SailingSchedule::create($data);
        ActionLog::create_log($sailing,'create');

        return redirect(route('admin.sailing-schedule.index'))->with('message', '航班資料已建立!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sailing = SailingSchedule::find($id);
        $countries = Country::all();
        return view('admin.sailingSchedule.editSailingSchedule',[
            'sailing'=>$sailing,
            'countries'=>$countries
        ]);
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
        $sailing = SailingSchedule::find($id);
        $data=$request->toArray();
        unset($data['_token']);
        if($data['status'] ==2 && $sailing->status !=2){
            $box_interval = $sailing->box_interval;
            $order_ids = Order::where('sailing_id',$id)->pluck('id');
            $box_count = OrderBox::whereIn('order_id',$order_ids)->count();
            $price = $sailing->price;
            $interval = intval(floor($box_count/$box_interval));
            for ($i = 1;$i<=$interval;$i++){
                $price = ($price*$sailing->discount);
            }
            foreach ($order_ids as $order_id){
                $order = Order::find($order_id);
                if($order->invoice != 1){
                    $price = ($price*1.05);
                }
                $order->fill(['total_price'=>$price]);
                ActionLog::create_log($order);
                $order->save();
                $orderBoxes = OrderBox::where('order_id',$order_id)->get();
                $box_price = intval(floor($price/$box_count));
                foreach ($orderBoxes as $orderBox) {
                    $orderBox->fill(['box_price' => $box_price]);
                    $orderBox->save();
                }
            }
        }
        $sailing->fill($data);
        ActionLog::create_log($sailing);
        $sailing->save();

        return redirect(route('admin.sailing-schedule.index'))->with('message', '航班資料已更新!');
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
        $sailing = SailingSchedule::find($id);
        if($sailing){
            $sailing->delete();
            ActionLog::create_log($sailing,'delete');
        }

        return redirect(route('admin.sailing-schedule.index'))->with('message', '航班資料已刪除!');

    }
}
