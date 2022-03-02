<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
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
//        return view('admin.payment.createpayment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return redirect(route('admin.payment.index'))->with('message', '資料已建立!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        return view('admin.payment.editpayment',[
//            'payment'=>$payment,
//        ]);
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
//        return redirect(route('admin.payment.index'))->with('message', '資料已更新!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        return redirect(route('admin.payment.index'))->with('message', '資料已刪除!');

    }

    public function checkPay($id){
        $order = Order::find($id);
        if ($order){
            $data = ['pay_status' =>'3'];
            $order->fill($data);
            $order->save();
            ActionLog::create_log($order);

            /** 用戶收信-收款通知 */
            $mailData = [
                'is_admin'=>false,
                'template'=>'email-pay-info',
                'email'=>$order->sender_email,
                'subject'=>'【海龜集運】您的款項已確認',
                'for_title'=>$order->sender_name,
                'msg'=>'訂單編號: #'.$order->seccode.'<br/><br/>您的訂單已確認付款，我們會盡快為您安排出貨，您可隨時至訂單查詢最新的寄送進度，謝謝！',
            ];
            dispatch(new SendMailQueueJob($mailData));

            return redirect(route('admin.payment.index'))->with('message', '訂單'.$order->seccode.'已確認收款!');
        }else{
            return redirect(route('admin.payment.index'))->with('error', '無法確認收款!，請詢問工程人員');
        }

    }
}
