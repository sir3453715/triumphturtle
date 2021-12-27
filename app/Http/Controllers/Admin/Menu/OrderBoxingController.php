<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\SailingSchedule;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderBoxingController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $orders = Order::where('parent_id','0');
        $queried=['seccode'=>'','sailing_id'=>'','from_country'=>'','sender'=>''];
        if($request->get('seccode')) {
            $queried['seccode'] = $request->get('seccode');
            $orders = $orders->where('seccode','LIKE','%'.$request->get('seccode').'%');
        }
        if($request->get('sailing_id')) {
            $queried['sailing_id'] = $request->get('sailing_id');
            $orders = $orders->where('sailing_id','=',$request->get('sailing_id'));
        }
        if($request->get('from_country')) {
            $queried['from_country'] = $request->get('from_country');
            $sailingCountry = SailingSchedule::where('from_country',$request->get('from_country'))->pluck('id');
            $orders = $orders->whereIn('sailing_id',$sailingCountry);
        }
        if($request->get('sender')) {
            $queried['sender'] = $request->get('sender');
            $orders = $orders->where(function ($query) use ($queried){
                $query->orwhere('sender_name','LIKE','%'.$queried['sender'].'%');
                $query->orwhere('sender_phone','LIKE','%'.$queried['sender'].'%');
                $query->orwhere('sender_email','LIKE','%'.$queried['sender'].'%');
            });
        }
        $countries = Country::all();
        $sailings = SailingSchedule::all();

        $orders = $orders->paginate(30);
        return view('admin.orderBoxes.orderBoxes',[
            'orders'=>$orders,
            'queried'=>$queried,
            'sailings'=>$sailings,
            'countries'=>$countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

}
