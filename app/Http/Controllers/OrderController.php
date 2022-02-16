<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\OrderBoxItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function option(Request $request,$sailing_id)
    {
        return view('option',[
            'sailing_id'=>$sailing_id,
        ]);
    }
    //
    public function individualForm($sailing_id)
    {
        return view('order-individual.individual-form',[
            'sailing_id'=>$sailing_id,
        ]);
    }
    public function individualFormComplete($order_id)
    {
        $order = Order::find($order_id);
        return view('order-individual.individual-form-complete',[
            'order'=>$order,
        ]);
    }
    public function orderCreate(Request $request)
    {
        /* 判斷當前流水號 */
        $tempserial = 'TS'.substr(date('Y', time()), 2, 2) . date('md', time()) ;
        $serial_number_order = Order::where('seccode','LIKE','%'.$tempserial.'%')->where('parent_id',0)->orderBy('created_at','DESC')->get();//只找主單
        if($serial_number_order){
            $num = count($serial_number_order);
            do{
                $num ++;
                $serial_number2 = $tempserial.str_pad($num,3,0,STR_PAD_LEFT);
                $chk_seccode = Order::where('seccode','=',$serial_number2)->first();//判斷已產生的訂單編號是否存在
            } while ($chk_seccode);
        }else{
            $serial_number2 = $tempserial.'001';
        }

        $data = [
            'sailing_id' => $request->get('sailing_id'),
            'type' => 1,
            'seccode' => $serial_number2.'-1',
            'serial_number' => $serial_number2,
            'person_number' => 1,
            'parent_id'=>0,
            'status' => 1,
            'pay_status' => 1,
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


    }



    public function confirmToken(Request $request){
        $return = false;
        $captcha = $request->get('captcha');
        $order = Order::where('captcha',$captcha)->first();
        if ($order){
            $return = '/group-form-member/'.$order->id;
        }
        return json_encode($return); //json
    }

}
