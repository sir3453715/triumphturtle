<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Order;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    /**
     * index
     */
    function index(Request $request){
        $queried=['seccode'=>'','sender'=>''];

        $orders = Order::where('pay_status',2);
        if($request->get('seccode')) {
            $queried['seccode'] = $request->get('seccode');
            $orders = $orders->where('seccode','LIKE','%'.$request->get('seccode').'%');
        }
        if($request->get('sender')) {
            $queried['sender'] = $request->get('sender');
            $orders = $orders->where(function ($query) use ($queried){
                $query->orwhere('sender_name','LIKE','%'.$queried['sender'].'%');
                $query->orwhere('sender_phone','LIKE','%'.$queried['sender'].'%');
            });
        }
        $orders = $orders->paginate(30);
        return view('admin.payment.payment',[
            'queried'=>$queried,
            'orders'=>$orders,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.createCountry');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect(route('admin.country.index'))->with('message', '國家資料已建立!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.country.editCountry',[
            'country'=>$country,
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

        return redirect(route('admin.country.index'))->with('message', '資料已更新!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        return redirect(route('admin.country.index'))->with('message', '資料已刪除!');

    }

    public function checkPay($id){
        $order = Order::find($id);
        if ($order){
            $data = ['pay_status' =>'3'];
            $order->fill($data);
            $order->save();
            ActionLog::create_log($order);

            $mail = [
                'email'=>$order->sender_email,
                'subject'=>'確認收款',
                'for_title'=>$order->sender_name,
                'msg'=>'已收到您的訂單'.$order->seccode.'款項',
                'cc'=>[''],
            ];
            ImportExportController::sendmail($mail);

            return redirect(route('admin.payment.index'))->with('message', '訂單'.$order->seccode.'已確認收款!');
        }else{
            return redirect(route('admin.payment.index'))->with('error', '無法確認收款!，請詢問工程人員');
        }

    }
}
