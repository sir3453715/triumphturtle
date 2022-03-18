<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\OrderBoxItem;
use App\Models\SailingSchedule;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderDetailController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $orders = Order::whereNotNull('id');
        $queried=['seccode'=>'','sender'=>'','pay_status'=>'','status'=>''];
        if($request->get('seccode')) {
            $queried['seccode'] = $request->get('seccode');
            $orders = $orders->where('seccode','LIKE','%'.$request->get('seccode').'%');
        }
        if($request->get('pay_status')) {
            $queried['pay_status'] = $request->get('pay_status');
            $orders = $orders->where('pay_status','=',$request->get('pay_status'));
        }
        if($request->get('status')) {
            $queried['status'] = $request->get('status');
            $orders = $orders->where('status','=',$request->get('status'));
        }
        if($request->get('sender')) {
            $queried['sender'] = $request->get('sender');
            $orders = $orders->where(function ($query) use ($queried){
                $query->orwhere('sender_name','LIKE','%'.$queried['sender'].'%');
                $query->orwhere('sender_phone','LIKE','%'.$queried['sender'].'%');
            });
        }
        $orders = $orders->paginate(30);
        return view('admin.orderBoxes.orderDetail',[
            'orders'=>$orders,
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
        $time = date('Y-m-d');
        $sailings = SailingSchedule::where('status',1)->where('on_off','2')
            ->where('statement_time', '>=' , $time)->get();
        return view('admin.orderBoxes.createOrderDetail',[
            'sailings'=>$sailings,
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
        /* 判斷當前流水號 */
        $tempserial = 'TS'.substr(date('Y', time()), 2, 2) . date('md', time()) ;
        $serial_number_order = Order::where('seccode','LIKE','%'.$tempserial.'%')->where('parent_id',0)->orderBy('created_at','DESC')->get();//只找主單
        if($serial_number_order){
            $num = count($serial_number_order);
            do{
                $num ++;
                $serial_number2 = $tempserial.str_pad($num,3,0,STR_PAD_LEFT);
                $chk_seccode = Order::where('serial_number','=',$serial_number2)->first();//判斷已產生的訂單編號是否存在
            } while ($chk_seccode);
        }else{
            $serial_number2 = $tempserial.'001';
        }
        if ( $request->get('type') == 2){
            do{

                $captcha=substr(md5(uniqid(rand())),0,8);  ##產生隨機字串
                $captcha = preg_replace('/\[O|0|I|i|L\]/',rand(2,9),$captcha);  #排除掉特定字元
                $chk_captcha = Order::where('captcha','=',$captcha)->first();//判斷已產生的驗證碼是否存在
            } while ($chk_captcha);
        }else{
            $captcha = null;
        }

        $data = [
            'sailing_id' => $request->get('sailing_id'),
            'type' => $request->get('type'),
            'seccode' => $serial_number2.'-1',
            'serial_number' => $serial_number2,
            'person_number' => 1,
            'parent_id'=>0,
            'status' => $request->get('status'),
            'pay_status' => $request->get('pay_status'),
            'total_price' => $request->get('total_price'),
            'shipment_use' => $request->get('shipment_use'),
            'sender_name' => $request->get('sender_name'),
            'sender_phone' => $request->get('sender_phone'),
            'sender_address' => $request->get('sender_address'),
            'sender_company' => $request->get('sender_company'),
            'sender_taxid' => $request->get('sender_taxid'),
            'sender_email' => $request->get('sender_email'),
            'for_name' => $request->get('for_name'),
            'for_phone' => $request->get('for_phone'),
            'for_address' => $request->get('for_address'),
            'for_company' => $request->get('for_company'),
            'for_taxid' => $request->get('for_taxid'),
            'invoice' => $request->get('invoice'),
            'captcha'=>$captcha,
        ];
        $order = Order::create($data);
        ActionLog::create_log($order,'create');

        /* 儲存新箱子資料 */
        $start_item = 0;
        $total_items_num = 0;
        $boxSize = sizeof($request->get('box_weight'));
        for($i = 0; $i<$boxSize; $i++){
            $boxData = [
                'order_id'=>$order->id,
                'box_seccode'=>$order->serial_number.'-'.$order->person_number.'-'.($i+1),
                'box_weight'=>$request->get('box_weight')[$i],
                'box_length'=>$request->get('box_length')[$i],
                'box_width'=>$request->get('box_width')[$i],
                'box_height'=>$request->get('box_height')[$i],
                'box_price'=>$request->get('box_price')[$i],
                'tracking_number'=>$request->get('tracking_number')[$i],
            ];
            $box = OrderBox::create($boxData);
            ActionLog::create_log($box,'create');

            $itemSize = $request->get('box_items_num')[$i];
            $total_items_num = $total_items_num + $itemSize;
            for($j = $start_item;$j<$total_items_num;$j++){
                $itemData = [
                    'order_id'=>$order->id,
                    'box_id'=>$box->id,
                    'item_name'=>$request->get('item_name')[$j],
                    'item_num'=>$request->get('item_num')[$j],
                    'unit_price'=>$request->get('unit_price')[$j],
                ];
                $item = OrderBoxItem::create($itemData);
                ActionLog::create_log($item,'create');
                $start_item++;
            }
        }

        return redirect(route('admin.order-detail.index'))->with('message', '訂單 '.$order->seccode.'已新增成功');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $other_price = unserialize($order->other_price);

        return view('admin.orderBoxes.editOrderDetail',[
            'order'=>$order,
            'other_price'=>$other_price,
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

        /* 修改訂單資料 */
        $order = Order::find($id);
        $old_status = $order->status;
        $new_status = $request->get('status');
        $total_price = 0; $tax_price = 0; $final_price = 0;
        foreach ($request->get('box_price') as $eachPrice){
            $total_price += $eachPrice;
        }
        $final_price = $total_price;
        if($request->get('invoice') != 1){
            $tax_price = $total_price * 0.05;
            $final_price += $tax_price;
        }
        $other_price = unserialize($order->other_price);
        if($other_price){
            $final_price = $final_price + ($other_price['other_qty']*$other_price['other_unit']);
        }
        $data = [
            'status' => $request->get('status'),
            'pay_status' => $request->get('pay_status'),
            'shipment_use' => $request->get('shipment_use'),
            'sender_name' => $request->get('sender_name'),
            'sender_phone' => $request->get('sender_phone'),
            'sender_address' => $request->get('sender_address'),
            'sender_company' => $request->get('sender_company'),
            'sender_taxid' => $request->get('sender_taxid'),
            'sender_email' => $request->get('sender_email'),
            'for_name' => $request->get('for_name'),
            'for_phone' => $request->get('for_phone'),
            'for_address' => $request->get('for_address'),
            'for_company' => $request->get('for_company'),
            'for_taxid' => $request->get('for_taxid'),
            'invoice' => $request->get('invoice'),
            'total_price' => $total_price,
            'tax_price' => $tax_price,
            'final_price' => round($final_price),
        ];
        $order->fill($data);
        ActionLog::create_log($order);
        $order->save();

        /* 刪除舊箱子資料 */
        $oldBox = OrderBox::where('order_id',$id);
        $oldBoxItem = OrderBoxItem::where('order_id',$id);
        $oldBoxTrackingNumber = $oldBox->pluck('tracking_number')->toArray();
        if($oldBoxItem)
            $oldBoxItem->delete();

        if($oldBox)
            $oldBox->delete();

        /* 儲存新箱子資料 */
        $start_item = 0;
        $total_items_num = 0;
        $boxSize = sizeof($request->get('box_weight'));
        for($i = 0; $i<$boxSize; $i++){
            $boxData = [
                'order_id'=>$order->id,
                'box_seccode'=>$order->serial_number.'-'.$order->person_number.'-'.($i+1),
                'box_weight'=>$request->get('box_weight')[$i],
                'box_length'=>$request->get('box_length')[$i],
                'box_width'=>$request->get('box_width')[$i],
                'box_height'=>$request->get('box_height')[$i],
                'box_price'=>$request->get('box_price')[$i],
                'tracking_number'=>$request->get('tracking_number')[$i],
            ];
            $box = OrderBox::create($boxData);
            ActionLog::create_log($box,'create');

            $itemSize = $request->get('box_items_num')[$i];
            $total_items_num = $total_items_num + $itemSize;
            for($j = $start_item;$j<$total_items_num;$j++){
                $itemData = [
                    'order_id'=>$order->id,
                    'box_id'=>$box->id,
                    'item_name'=>$request->get('item_name')[$j],
                    'item_num'=>$request->get('item_num')[$j],
                    'unit_price'=>$request->get('unit_price')[$j],
                ];
                $item = OrderBoxItem::create($itemData);
                ActionLog::create_log($item,'create');
                $start_item++;
            }
        }

        if($new_status == '2' && $old_status == '1'){
            /** 用戶收信-包裹入倉 */
            $mailData = [
                'is_admin'=>false,
                'template'=>'email-order-info',
                'email'=>$order->sender_email,
                'subject'=>'【海龜集運】訂單編號 #'.$order->seccode.' 包裹已入倉',
                'for_title'=>$order->sender_name,
                'msg'=>'訂單編號: #'.$order->seccode.'  狀態更新通知 - 您的包裹已入倉！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
            ];
            dispatch(new SendMailQueueJob($mailData));
        }

        $trackingNumberDifferent = array_diff($request->get('tracking_number'),$oldBoxTrackingNumber);
        if($trackingNumberDifferent){
            /** 用戶收信-宅配單號 */
            $mailData = [
                'is_admin'=>false,
                'template'=>'email-order-info',
                'email'=>$order->sender_email,
                'subject'=>'【海龜集運】宅配單號已更新',
                'for_title'=>$order->sender_name,
                'msg'=>'訂單編號: #'.$order->seccode.'  狀態更新通知 - 宅配單號已更新！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
            ];
            dispatch(new SendMailQueueJob($mailData));
        }

        return redirect(route('admin.order-detail.index'))->with('message', '訂單 '.$order->seccode.'已完成修改');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $orderBox = OrderBox::where('order_id',$id);
        $orderBoxItems = OrderBoxItem::where('order_id',$id);
        if($orderBoxItems)
            $orderBoxItems->delete();
        if($orderBox)
            $orderBox->delete();
        if($order)
            $order->delete();

        return redirect(route('admin.order-detail.index'))->with('message', '訂單 '.$order->seccode.'已被刪除');

    }

    public function bulk(Request $request){
        $order_ids = $request->get('order_id');
        if(!$order_ids){
            return redirect(route('admin.order-detail.index'))->with('error', '沒有選擇任何訂單!');
        }
        if($request->get('pay_status')){
            $orders = Order::whereIn('id',$order_ids)->get();
            foreach ($orders as $order){
                $data = ['pay_status'=>$request->get('pay_status')];

                if($request->get('pay_status') == '3' && $order->pay_status != '3') {
                    /** 用戶收信-收款通知 */
                    $mailData = [
                        'is_admin' => false,
                        'template' => 'email-pay-info',
                        'email' => $order->sender_email,
                        'subject' => '【海龜集運】您的款項已確認',
                        'for_title' => $order->sender_name,
                        'msg' => '訂單編號: #' . $order->seccode . '<br/><br/>您的訂單已確認付款，我們會盡快為您安排出貨，您可隨時至<a href="' . route('tracking') . '">訂單查詢頁面</a> 查看最新的寄送進度，謝謝！',
                    ];
                    dispatch(new SendMailQueueJob($mailData));
                }

                $order->fill($data);
                ActionLog::create_log($order);
                $order->save();

            }
        }
        if($request->get('status')){
            foreach ($orders as $order){
                $data = ['status'=>$request->get('status')];
                if($request->get('status') == '2' && $order->status == '1'){
                    /** 用戶收信-包裹入倉 */
                    $mailData = [
                        'is_admin'=>false,
                        'template'=>'email-order-info',
                        'email'=>$order->sender_email,
                        'subject'=>'【海龜集運】訂單編號 #'.$order->seccode.' 包裹已入倉',
                        'for_title'=>$order->sender_name,
                        'msg'=>'訂單編號: #'.$order->seccode.'  狀態更新通知 - 您的包裹已入倉！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
                    ];
                    dispatch(new SendMailQueueJob($mailData));
                }
                $order->fill($data);
                ActionLog::create_log($order);
                $order->save();
            }

        }

        dd($request->toArray());
    }
}
