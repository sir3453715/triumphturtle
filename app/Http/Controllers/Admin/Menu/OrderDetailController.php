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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        $orders = $orders->orderBy('created_at','DESC')->paginate(30);

        $sailings = SailingSchedule::all();
        return view('admin.orderBoxes.orderDetail',[
            'orders'=>$orders,
            'sailings'=>$sailings,
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
        /* ????????????????????? */
        $tempserial = 'TS'.substr(date('Y', time()), 2, 2) . date('md', time()) ;
        $serial_number_order = Order::where('seccode','LIKE','%'.$tempserial.'%')->where('parent_id',0)->orderBy('created_at','DESC')->get();//????????????
        if($serial_number_order){
            $num = count($serial_number_order);
            do{
                $num ++;
                $serial_number2 = $tempserial.str_pad($num,3,0,STR_PAD_LEFT);
                $chk_seccode = Order::where('serial_number','=',$serial_number2)->first();//??????????????????????????????????????????
            } while ($chk_seccode);
        }else{
            $serial_number2 = $tempserial.'001';
        }
        if ( $request->get('type') == 2){
            do{

                $captcha=substr(md5(uniqid(rand())),0,8);  ##??????????????????
                $captcha = preg_replace('/\[O|0|I|i|L\]/',rand(2,9),$captcha);  #?????????????????????
                $chk_captcha = Order::where('captcha','=',$captcha)->first();//???????????????????????????????????????
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
            'captcha'=>$captcha,
            'total_price' => $total_price,
            'tax_price' => $tax_price,
            'final_price' => round($final_price),
        ];
        $order = Order::create($data);
        ActionLog::create_log($order,'create');

        /* ????????????????????? */
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

        return redirect(route('admin.order-detail.index'))->with('message', '?????? '.$order->seccode.'???????????????');
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

        /* ?????????????????? */
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

        /* ????????????????????? */
        $oldBox = OrderBox::where('order_id',$id);
        $oldBoxItem = OrderBoxItem::where('order_id',$id);
        $oldBoxTrackingNumber = $oldBox->pluck('tracking_number')->toArray();
        if($oldBoxItem)
            $oldBoxItem->delete();

        if($oldBox)
            $oldBox->delete();

        /* ????????????????????? */
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
            /** ????????????-???????????? */
            $mailData = [
                'is_admin'=>false,
                'template'=>'email-order-info',
                'email'=>$order->sender_email,
                'subject'=>'??????????????????'.$order->seccode.' ???????????????',
                'for_title'=>$order->sender_name,
                'msg'=>'????????????: '.$order->seccode.'  ?????????????????? - ????????????????????????<br/><br/>??????????????? <a href="'.route('tracking').'">??????????????????</a> ???????????????????????????',
            ];
            dispatch(new SendMailQueueJob($mailData));
        }
        if($request->get('tracking_number')){
            $trackingNumberDifferent = array_diff($request->get('tracking_number'),$oldBoxTrackingNumber);
            if($trackingNumberDifferent){
                /** ????????????-???????????? */
                $mailData = [
                    'is_admin'=>false,
                    'template'=>'email-order-info',
                    'email'=>$order->sender_email,
                    'subject'=>'???????????????????????????????????????',
                    'for_title'=>$order->sender_name,
                    'msg'=>'????????????: '.$order->seccode.'  ?????????????????? - ????????????????????????<br/><br/>??????????????? <a href="'.route('tracking').'">??????????????????</a> ???????????????????????????',
                ];
                dispatch(new SendMailQueueJob($mailData));
            }
        }

        return redirect(route('admin.order-detail.index'))->with('message', '?????? '.$order->seccode.'???????????????');
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

        return redirect(route('admin.order-detail.index'))->with('message', '?????? '.$order->seccode.'????????????');

    }

    public function bulk(Request $request){
        $submit = $request->get('submit');
        $order_ids = $request->get('order_id');
        if(!$order_ids){
            return redirect(route('admin.order-detail.index'))->with('error', '????????????????????????!');
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
                        ];
                    }
                }
            }
            $title = '??????????????????';

            $headings = [
                'sender_name'=>"???????????????",
                'sender_phone'=>"???????????????",
                'sender_address'=>"???????????????",
                'sender_company'=>"????????????",
                'sender_taxid'=>"??????",
                'for_name'=>"???????????????",
                'for_phone'=>"???????????????",
                'for_address'=>"???????????????",
                'for_company'=>"????????????",
                'for_taxid'=>"??????",
                'box_seccode'=>"?????????",
                'tracking_number'=>"????????????",
            ];

            return Excel::download(new DemoExport($data,$title,$headings),'????????????'.date('Y-m-d_H_i_s'). '.xls');
        }
        if($submit == 'action'){
            $orders = Order::whereIn('id',$order_ids)->get();
            if($request->get('pay_status')){
                foreach ($orders as $order){
                    $data = ['pay_status'=>$request->get('pay_status')];

                    if($request->get('pay_status') == '3' && $order->pay_status != '3') {
                        /** ????????????-???????????? */
                        $mailData = [
                            'is_admin' => false,
                            'template' => 'email-pay-info',
                            'email' => $order->sender_email,
                            'subject' => '???????????????????????????????????????',
                            'for_title' => $order->sender_name,
                            'msg' => '????????????: ' . $order->seccode . '<br/><br/>?????????????????????????????????????????????????????????????????????????????????<a href="' . route('tracking') . '">??????????????????</a> ???????????????????????????????????????',
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
                        /** ????????????-???????????? */
                        $mailData = [
                            'is_admin'=>false,
                            'template'=>'email-order-info',
                            'email'=>$order->sender_email,
                            'subject'=>'?????????????????????????????? #'.$order->seccode.' ???????????????',
                            'for_title'=>$order->sender_name,
                            'msg'=>'????????????: '.$order->seccode.'  ?????????????????? - ????????????????????????<br/><br/>??????????????? <a href="'.route('tracking').'">??????????????????</a> ???????????????????????????',
                        ];
                        dispatch(new SendMailQueueJob($mailData));
                    }
                    $order->fill($data);
                    ActionLog::create_log($order);
                    $order->save();
                }

            }
        }
        return redirect(route('admin.order-detail.index'))->with('message', '????????????????????????');
    }

    public function import(Request $request){
        if($request->hasFile('importFile')){
            $extension = $request->file('importFile')->getClientOriginalExtension(); //?????????
            $path1 = time() . "." . $extension;    //????????????
            $request->file('importFile')->move(storage_path('app').'/temp', $path1); //?????????????????????
            $path=storage_path('app').'/temp/'.$path1;
            $excel = Excel::toArray('' ,$path);
            foreach ($excel as $key => $sheets){ // ????????????????????????
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
            return redirect(route('admin.order-detail.index'))->with('message', '????????????????????????????????????');
        }else{
            return redirect(route('admin.order-detail.index'))->with('error', '?????????????????????!');
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

        return Excel::download(new OrdersExcelExport($order_data),$parentOrder->serial_number.' ?????????'.date('Y-m-d_H_i_s'). '.xls');
    }
}
