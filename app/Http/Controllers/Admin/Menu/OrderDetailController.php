<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exports\DemoExport;
use App\Exports\OrdersExcelExport;
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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Treerful\Invoice\Pay2goInvoice\Invoice;

class OrderDetailController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $orders = Order::whereNotNull('id');
        $queried=['seccode'=>'','sender'=>'','pay_status'=>'','status'=>'','sailing_id'=>''];
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
        if($request->get('sailing_id')) {
            $queried['sailing_id'] = $request->get('sailing_id');
            $orders = $orders->where('sailing_id','=',$request->get('sailing_id'));
        }

        if($request->get('submit') == 'export'){
            $data = array();
            $orders = $orders->get();
            foreach ($orders as $order){
                foreach ($order->box as $key => $box){
                    if($key == 0){
                        $data[]=[
                            'sender_name'=>$order->sender_name,
                            'sender_phone'=>$order->sender_phone,
                            'sender_address'=>$order->sender_address,
                            'sender_company'=>$order->sender_company,
                            'sender_taxid'=>$order->sender_taxid,
                            'for_name'=>$order->for_name,
                            'for_phone'=>$order->for_phone,
                            'for_address'=>$order->for_address,
                            'for_company'=>$order->for_company,
                            'for_taxid'=>$order->for_taxid,
                            'box_seccode'=>$box->box_seccode,
                            'tracking_number'=>$box->tracking_number,
                            'reback'=>($order->reback==1)?'是':'否',
                            'reback_time'=>($order->reback==1)?$order->reback_time:'',
                        ];
                    }else{
                        $data[]=[
                            'sender_name'=>'',
                            'sender_phone'=>'',
                            'sender_address'=>'',
                            'sender_company'=>'',
                            'sender_taxid'=>'',
                            'for_name'=>'',
                            'for_phone'=>'',
                            'for_address'=>'',
                            'for_company'=>'',
                            'for_taxid'=>'',
                            'box_seccode'=>$box->box_seccode,
                            'tracking_number'=>$box->tracking_number,
                            'reback'=>'',
                            'reback_time'=>'',
                        ];
                    }
                }
            }
            $title = '下載宅配資訊';

            $headings = [
                'sender_name'=>"寄件者姓名",
                'sender_phone'=>"寄件者電話",
                'sender_address'=>"寄件者地址",
                'sender_company'=>"公司名稱",
                'sender_taxid'=>"統編",
                'for_name'=>"收件者姓名",
                'for_phone'=>"收件者電話",
                'for_address'=>"收件者地址",
                'for_company'=>"公司名稱",
                'for_taxid'=>"統編",
                'box_seccode'=>"運單號",
                'tracking_number'=>"宅配單號",
                'reback'=>"是否回台灣",
                'reback_time'=>"回台時間",
            ];

            return Excel::download(new DemoExport($data,$title,$headings),'宅配資訊'.date('Y-m-d_H_i_s'). '.xls');
        }else{
            $orders = $orders->orderBy('created_at','DESC')->paginate(30);
            $sailings = SailingSchedule::whereNotNull('id')->orderBy('created_at','DESC')->get();
            return view('admin.orderBoxes.orderDetail',[
                'orders'=>$orders,
                'sailings'=>$sailings,
                'queried'=>$queried,
            ]);
        }

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
        $total_price = 0; $tax_price = 0;
        if($request->get('box_price')){
            foreach ($request->get('box_price') as $eachPrice){
                $total_price += $eachPrice;
            }
        }
        $final_price = $total_price;
        if($request->get('invoice') != 1){
            $tax_price = $total_price * 0.05;
            $final_price += $tax_price;
        }

        $reback_time = '';
        if($request->get('reback') == 1){
            $reback_time = $request->get('reback_time');
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
            'reback' => $request->get('reback'),
            'reback_time' => $reback_time,
            'captcha'=>$captcha,
            'total_price' => $total_price,
            'tax_price' => $tax_price,
            'final_price' => round($final_price),
        ];
        $order = Order::create($data);
        ActionLog::create_log($order,'create');

        /* 儲存新箱子資料 */
        $start_item = 0;
        $total_items_num = 0;
        $boxSize = ($request->get('box_weight'))?sizeof($request->get('box_weight')):0;
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
        $other_total = 0;
        if($order->other_price){
            $other_price = unserialize($order->other_price);
            foreach ($other_price as $other){
                $other_total += $other['other_qty']*$other['other_unit'];
            }
        }

        return view('admin.orderBoxes.editOrderDetail',[
            'order'=>$order,
            'other_total'=>$other_total,
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
        if($request->get('box_price')){
            foreach ($request->get('box_price') as $eachPrice){
                $total_price += $eachPrice;
            }
        }
        $final_price = $total_price;
        $other_price = unserialize($order->other_price);
        if($other_price){
            foreach ($other_price as $other){
                $final_price += $other['other_qty']*$other['other_unit'];
            }
        }
        if($request->get('invoice') != 1){
            $tax_price = $total_price * 0.05;
            $final_price += $tax_price;
        }
        $reback_time = '';
        if($request->get('reback') == 1){
            $reback_time = $request->get('reback_time');
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
            'reback' => $request->get('reback'),
            'reback_time' => $reback_time,
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
        $boxSize = ($request->get('box_weight'))?sizeof($request->get('box_weight')):0;
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
                'subject'=>'【海龜集運】'.$order->seccode.' 包裹已入倉',
                'for_title'=>$order->sender_name,
                'msg'=>'訂單編號: '.$order->seccode.'  狀態更新通知 - 您的包裹已入倉！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
            ];
            dispatch(new SendMailQueueJob($mailData));
        }
        if($request->get('tracking_number')){
            $trackingNumberDifferent = array_diff($request->get('tracking_number'),$oldBoxTrackingNumber);
            if($trackingNumberDifferent){
                /** 用戶收信-宅配單號 */
                $mailData = [
                    'is_admin'=>false,
                    'template'=>'email-order-info',
                    'email'=>$order->sender_email,
                    'subject'=>'【海龜集運】宅配單號已更新',
                    'for_title'=>$order->sender_name,
                    'msg'=>'訂單編號: '.$order->seccode.'  狀態更新通知 - 宅配單號已更新！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
                ];
                dispatch(new SendMailQueueJob($mailData));
            }
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
        if($orderBoxItems){
            $orderBoxItems->delete();
            ActionLog::create_log($orderBoxItems->get(),'delete');
        }
        if($orderBox){
            $orderBox->delete();
            ActionLog::create_log($orderBox->get(),'delete');
        }
        if($order){
            $order->delete();
            ActionLog::create_log($order,'delete');
        }

        return redirect(route('admin.order-detail.index'))->with('message', '訂單 '.$order->seccode.'已被刪除');

    }

    public function bulk(Request $request){
        $submit = $request->get('submit');
        $order_ids = $request->get('order_id');
        if(!$order_ids){
            return redirect(route('admin.order-detail.index'))->with('error', '沒有選擇任何訂單!');
        }
        if($submit == 'delivery'){
            $data = array();
            $orders = Order::whereIn('id',$order_ids)->orderBy('seccode','ASC')->get();
            foreach ($orders as $order){
                foreach ($order->box as $key => $box){
                    if($key == 0){
                        $data[]=[
                            'sender_name'=>$order->sender_name,
                            'sender_phone'=>$order->sender_phone,
                            'sender_address'=>$order->sender_address,
                            'sender_company'=>$order->sender_company,
                            'sender_taxid'=>$order->sender_taxid,
                            'for_name'=>$order->for_name,
                            'for_phone'=>$order->for_phone,
                            'for_address'=>$order->for_address,
                            'for_company'=>$order->for_company,
                            'for_taxid'=>$order->for_taxid,
                            'box_seccode'=>$box->box_seccode,
                            'tracking_number'=>$box->tracking_number,
                            'reback'=>($order->reback==1)?'是':'否',
                            'reback_time'=>($order->reback==1)?$order->reback_time:'',
                        ];
                    }else{
                        $data[]=[
                            'sender_name'=>'',
                            'sender_phone'=>'',
                            'sender_address'=>'',
                            'sender_company'=>'',
                            'sender_taxid'=>'',
                            'for_name'=>'',
                            'for_phone'=>'',
                            'for_address'=>'',
                            'for_company'=>'',
                            'for_taxid'=>'',
                            'box_seccode'=>$box->box_seccode,
                            'tracking_number'=>$box->tracking_number,
                            'reback'=>'',
                            'reback_time'=>'',
                        ];
                    }
                }
            }
            $title = '下載宅配資訊';

            $headings = [
                'sender_name'=>"寄件者姓名",
                'sender_phone'=>"寄件者電話",
                'sender_address'=>"寄件者地址",
                'sender_company'=>"公司名稱",
                'sender_taxid'=>"統編",
                'for_name'=>"收件者姓名",
                'for_phone'=>"收件者電話",
                'for_address'=>"收件者地址",
                'for_company'=>"公司名稱",
                'for_taxid'=>"統編",
                'box_seccode'=>"運單號",
                'tracking_number'=>"宅配單號",
                'reback'=>'是否回台灣',
                'reback_time'=>'回台時間',
            ];

            return Excel::download(new DemoExport($data,$title,$headings),'宅配資訊'.date('Y-m-d_H_i_s'). '.xls');
        }
        if($submit == 'payment'){
            $orders = Order::whereIn('id',$order_ids)->orderBy('seccode','ASC')->get();
            foreach ($orders as $order){
                $originalname = $order->seccode.'出帳帳單.pdf';
                $final_price = $order->total_price;
                $tax_price = round($final_price*0.05);
                $final_price += $tax_price;
                $data = [
                    'pay_status'=>2,
                    'tax_price' => $tax_price,
                    'final_price'=>$final_price,
                ];
                $order->fill($data);
                $order->save();

                $order = Order::find($order->id);

                $other_total = 0;
                $order_data = $order->toArray();
                $order_data['sailing']=$order->sailing->toArray();
                $order_data['box_count'] = count($order->box);
                if($order_data['other_price']){
                    $other_price = unserialize($order_data['other_price']);
                    $order_data['other_price']=$other_price;
                    foreach ($other_price as $other){
                        $other_total += $other['other_qty']*$other['other_unit'];
                    }
                }
                $order_data['subtotal'] = $order_data['sailing']['final_price'] * count($order->box);
                $order_data['subtotal'] += $other_total;
                $order_data['tax_value'] = ($order_data['invoice'] != 1)? $order_data['subtotal'] * 0.05 :0 ;

                $pdf = App::make('dompdf.wrapper');
                $pdf->loadView('pdf.payment',$order_data)->setPaper('a4')->setOptions(['dpi' => 140, 'defaultFont' => 'msyh' , 'isFontSubsettingEnabled'=>true ,'isRemoteEnabled'=>true]);
                $content = $pdf->download()->getOriginalContent();
                Storage::disk('billing')->put($originalname,$content);

                /** 用戶收信-請款通知 */
                $to = ['email'=>$order->sender_email,'name'=>$order->sender_name];
                $data = [
                    'msg'=>'訂單編號: '.$order->seccode.' <br/><br/>附件為此票寄送的帳單，再請您儘速確認付款，以利加速您出貨的進度。<br/>對於帳單有任何疑問，歡迎與我們客服直接聯絡，謝謝！<br/>',
                    'for_title'=>$order->sender_name,
                ];
                //寄出信件
                Mail::send('email.email-pay-info', $data, function($message) use ($to,$originalname) {
                    $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    $message->to($to['email'], $to['name'])
                        ->subject('【海龜集運】付款通知');
                    $message->attach(storage_path().'/app/public/billing'.'/'.$originalname);
                });
                Storage::disk('billing')->delete($originalname);
            }

            return redirect(route('admin.order-detail.index'))->with('message', '訂單已批次發送請款單!');
        }
        if($submit == 'action'){
            $orders = Order::whereIn('id',$order_ids)->get();
            if($request->get('pay_status')){
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
                            'msg' => '訂單編號: ' . $order->seccode . '<br/><br/>您的訂單已確認付款，我們會盡快為您安排出貨，您可隨時至<a href="' . route('tracking') . '">訂單查詢頁面</a> 查看最新的寄送進度，謝謝！',
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
                            'msg'=>'訂單編號: '.$order->seccode.'  狀態更新通知 - 您的包裹已入倉！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
                        ];
                        dispatch(new SendMailQueueJob($mailData));
                    }
                    $order->fill($data);
                    ActionLog::create_log($order);
                    $order->save();
                }

            }
        }
        return redirect(route('admin.order-detail.index'))->with('message', '訂單批次修改完成');
    }

    public function import(Request $request){
        if($request->hasFile('importFile')){
            $extension = $request->file('importFile')->getClientOriginalExtension(); //副檔名
            $path1 = time() . "." . $extension;    //重新命名
            $request->file('importFile')->move(storage_path('app').'/temp', $path1); //移動至指定目錄
            $path=storage_path('app').'/temp/'.$path1;
            $excel = Excel::toArray('' ,$path);
            foreach ($excel as $key => $sheets){ // 各個表分別撈出來
                unset($sheets[0]);
                foreach ($sheets as $sheetKey => $column){
                    $box_seccode = $column[0];
                    $tracking_number = $column[1];
                    $orderBox = OrderBox::where('box_seccode',$box_seccode)->first();
                    $orderBox->fill(['tracking_number'=>$tracking_number]);
                    ActionLog::create_log($orderBox);
                    $orderBox->save();
                }
            }
            unlink(storage_path('app/temp/'.$path1));
            return redirect(route('admin.order-detail.index'))->with('message', '訂單批次匯入宅配單號完成');
        }else{
            return redirect(route('admin.order-detail.index'))->with('error', '請上傳匯入檔案!');
        }
    }
    public function importList(){
        return view('admin.orderBoxes.orderImport',[
            'orders'=>[''],
        ]);
    }

    public function excelPackage(Request $request,$id){
        $parentOrder = Order::find($id);
        $order_data = $parentOrder->toArray();
        $order_data['fromCountry']=$parentOrder->sailing->fromCountry->title.' '.$parentOrder->sailing->fromCountry->en_title;
        $order_data['toCountry']=$parentOrder->sailing->toCountry->title.' '.$parentOrder->sailing->toCountry->en_title;
        $packageOrderIDs = Order::where('serial_number',$parentOrder['serial_number'])->where('status','!=',5)->orderBy('parent_id','ASC')->pluck('id')->toArray();
        $packageBoxes = OrderBox::whereIn('order_id',$packageOrderIDs)->orderBy('box_seccode','ASC')->get();
        foreach ($packageBoxes as $packageBox){
            $order_data['OrderBoxes'][$packageBox->id]=$packageBox->toArray();
            $order_data['OrderBoxes'][$packageBox->id]['OrderBoxesItems']=OrderBoxItem::where('box_id',$packageBox->id)->orderBy('id','ASC')->get()->toArray();
            $total_value = 0;
            foreach ($order_data['OrderBoxes'][$packageBox->id]['OrderBoxesItems'] as $key => $boxesItem){
                $total_value += ($boxesItem['unit_price']*$boxesItem['item_num']);
            }
            $order_data['OrderBoxes'][$packageBox->id]['total_value'] = $total_value;
        }

        return Excel::download(new OrdersExcelExport($order_data),$parentOrder->serial_number.' 裝箱單'.date('Y-m-d_H_i_s'). '.xls');
    }


    /**
     * 發票開立 & 作廢
    */

    public function issueInvoice($id){
        $order = Order::find($id);
        $data = [
            'BuyerType' => '0', // B2C
            'MerchantOrderNo' => str_replace('-','_',$order->seccode).substr(md5(uniqid(rand())),0,3),  ##產生隨機字串避免重複號碼開立,
            'BuyerName' => $order->sender_name,
            'BuyerEmail' => $order->sender_email,
            'CarrierType' => '', // 0:手機條碼, 1:自然人憑證條碼載具 2:智付寶載具
            'CarrierNum' => '',
            'ItemName' => '物流費用',
            'ItemCount' => '1',
            'ItemPrice' => $order->final_price,
            'ItemUnit' => '個',
        ];

        $invoice = new Invoice();
        $result = $invoice->create($data);


        $data = [
            'invoice_status'=>1,
            'invoice_code'=>$result['InvoiceNumber'],
            'invoice_result'=>json_encode($result),
            'invoice_time'=>$result['CreateTime'],
        ];
        $order->fill($data);
        ActionLog::create_log($order);
        $order->save();

        return redirect(route('admin.order-detail.index'))->with('message', '發票開立成功!');
    }
    public function invalidInvoice(Request $request,$id){
        $order = Order::find($id);

        $data = [
            'InvoiceNumber' => $order->invoice_code,
            'InvalidReason' => $request->get('reason'),
        ];
        $invoice = new Invoice();
        $result = $invoice->void($data);
        if($result['Status'] == 'LIB10005'){
            return redirect(route('admin.order-detail.index'))->with('error', $result['Message']);
        }else{
            $data = [
                'invoice_status'=>2,
                'invoice_code'=>$result['InvoiceNumber'],
                'invoice_result'=>json_encode($result),
                'invoice_cancel_reason'=>$request->get('reason'),
                'invoice_time'=>$result['CreateTime'],
            ];
            $order->fill($data);
            ActionLog::create_log($order);
            $order->save();
            return redirect(route('admin.order-detail.index'))->with('message', '發票作廢成功!');
        }
    }
}
