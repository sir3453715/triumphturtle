<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\OrderBoxItem;
use App\Models\SailingSchedule;
use App\Models\User;
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
    public function individualFormComplete(Request $request,$parameter)
    {
        $array = unserialize(base64_decode($parameter));
        if ($array['flag']){
            $order = Order::find($array['id']);
            return view('order-individual.individual-form-complete',[
                'order'=>$order,
            ]);
        }else{
            return redirect(route('index'));
        }
    }
    public function groupFormInitiator($sailing_id)
    {
        $sailing = SailingSchedule::find($sailing_id);
        return view('order-group.group-form-initiator',[
            'sailing'=>$sailing,
        ]);
    }
    public function groupFormMember($parent_id)
    {
        $parent_order = Order::find($parent_id);
        if ($parent_order->type == 2 && $parent_order->parent_id ==0){
            return view('order-group.group-form-member',[
                'parent_order'=>$parent_order,
            ]);
        }else{
            return redirect(route('index'));
        }
    }
    public function orderUpdateCaptcha(Request $request){
        $order = Order::find($request->get('order_id'));
        if(($order->updateToken == $request->get('updateToken')) && ($order->updateToken)){
            $order->fill(['updateToken'=>'']);
            $order->save();
            return redirect(route('group-form-edit',['seccode'=>$order->seccode]));
        }else{
            return redirect(route('tracking-captcha',['seccode'=>$order->seccode]))->with('errorText','驗證碼輸入錯誤!');
        }
    }
    public function groupFormEdit($seccode)
    {
        $order = Order::where('seccode',$seccode)->first();
        return view('order-group.group-form-edit',[
            'order'=>$order,
        ]);
    }

    public function groupFormCompleteI($parameter)
    {
        $array = unserialize(base64_decode($parameter));
        if ($array['flag']){
            $order = Order::find($array['id']);
            return view('order-group.group-form-complete-i',[
                'order'=>$order,
            ]);
        }else{
            return redirect(route('index'));
        }
    }
    public function groupCaptcha(Request $request){
        $id = $request->get('order_id');
        $captcha = $request->get('captcha');
        $order = Order::where('id',$id)->where('captcha',$captcha)->first();
        if ($order){
            return redirect(route('group-form-member',['parent_id'=>$id]));
        }else{
            return redirect(route('group-member-join',['base64_id'=>base64_encode($id)]))->with('errorText','驗證碼輸入錯誤!');
        }
    }
    public function groupMemberJoin($base64_id)
    {
        $id= base64_decode($base64_id);
        $order = Order::find($id);
        return view('order-group.group-member-join',[
            'order'=>$order
        ]);
    }
    public function groupMemberJoinSuccess($parameter)
    {
        $array = unserialize(base64_decode($parameter));
        if ($array['flag']){
            $order = Order::find($array['id']);
            return view('order-group.group-member-join-success',[
                'order'=>$order
            ]);
        }else{
            return redirect(route('index'));
        }
    }
    public function orderCreate(Request $request)
    {
        /* 判斷當前流水號 */
        $person_number = 1;
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
                $captcha=substr(md5(uniqid(rand())),0,6);  ##產生隨機字串
                $captcha = preg_replace('/\[O|0|I|i|L\]/',rand(2,9),$captcha);  #排除掉特定字元
                $chk_captcha = Order::where('captcha','=',$captcha)->first();//判斷已產生的驗證碼是否存在
            } while ($chk_captcha);
            if ($request->get('parent_id') != 0){
                $captcha = null;
                $parent_order = Order::find($request->get('parent_id'));
                $group_orders = Order::where('parent_id',$request->get('parent_id'))->get();
                if($group_orders){
                    $person_number = count($group_orders)+1;
                    do{
                        $person_number ++;
                        $serial_number2 = $parent_order->serial_number;
                        $chk_seccode = Order::where('seccode','=',$serial_number2.'-'.$person_number)->first();//判斷已產生的訂單編號是否存在
                    } while ($chk_seccode);
                }else{
                    $serial_number2 = $parent_order->serial_number.'-2';
                }
            }
        }else{
            $captcha = null;
        }

        $data = [
            'sailing_id' => $request->get('sailing_id'),
            'type' => $request->get('type'),
            'seccode' => $serial_number2.'-'.$person_number,
            'serial_number' => $serial_number2,
            'person_number' => $person_number,
            'parent_id'=>$request->get('parent_id'),
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
            'captcha' => $captcha,
        ];
        $order = Order::create($data);

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
                $start_item++;
            }
        }
        $parameter = ['id'=>$order->id,'flag'=>true];
        $parameter = base64_encode(serialize($parameter));
        if($request->get('type') == 1){
           $subject = '【海龜集運】個人寄送 - 訂單已成立';
           $msg = '訂單編號: #'.$order->seccode.'<br/>寄件人: '.$order->sender_name.'<br/><br/>請將運單列印後貼至包裹上，並於入倉截止日: '.date('Y/m/d',strtotime($order->sailing->parcel_deadline)).' 前將包裹寄送到倉庫。<br/>請點擊此處: <a href="'.route('pdf-shipment',['id'=>$order->id]).'" target="_blank">下載運單</a><br/><br/>如需查看訂單資訊或修改訂單內容，請前往<a href="'.route('tracking').'">訂單查詢頁面</a>。<br/>';
        }else if($request->get('type') == 2){
            if ($request->get('parent_id') == 0){
                $subject = '【海龜集運】揪團集運 (主揪) - 訂單已成立';
                $msg = '訂單編號: #'.$order->seccode.'<br/>寄件人: '.$order->sender_name.'<br/><br/>請將下列連結及驗證碼分享給您的同團成員，並於訂單截止日: '.date('Y/m/d',strtotime($order->sailing->statement_time)).' 前完成所有寄送資訊與裝箱資料。<br/>分享連結: <a href="'.route('group-member-join',['base64_id'=>base64_encode($order->id)]).'" target="_blank">分享連結</a><br/>驗證碼: '.$order->captcha.'<br/><br/>請將運單列印後貼至包裹上，並於入倉截止日: '.date('Y/m/d',strtotime($order->sailing->parcel_deadline)).' 前將包裹寄送到倉庫。<br/>請點擊此處:  <a href="'.route('pdf-shipment',['id'=>$order->id]).'" target="_blank">下載運單</a><br/><br/>如需查看訂單資訊或修改訂單內容，請前往<a href="'.route('tracking').'">訂單查詢頁面</a>。';
            }else{
                $subject = '【海龜集運】揪團集運 (跟團) - 訂單已成立';
                $msg = '訂單編號: #'.$order->seccode.'<br/>寄件人: '.$order->sender_name.'<br/><br/>請將運單列印後貼至包裹上，並於入倉截止日: '.date('Y/m/d',strtotime($order->sailing->parcel_deadline)).' 前將包裹寄送到倉庫。<br/>請點擊此處: <a href="'.route('pdf-shipment',['id'=>$order->id]).'" target="_blank">下載運單</a><br/>如需查看訂單資訊或修改訂單內容，請前往<a href="'.route('tracking').'">訂單查詢頁面</a>。<br/>';
            }
        }
        /** 用戶收信 - 訂單成立 */
        $mailData = [
            'is_admin'=>false,
            'template'=>'email-order-finish',
            'email'=>$order->sender_email,
            'subject'=>$subject,
            'for_title'=>$order->sender_name,
            'msg'=>$msg,
        ];
        dispatch(new SendMailQueueJob($mailData));
        /** 管理員收信 - 訂單成立 */
        $adminMailData = [
            'is_admin'=>true,
            'template'=>'email-order-finish',
            'subject'=>'【海龜集運】您收到一筆新訂單!',
            'for_title'=>'網站管理員',
            'msg'=>'訂單編號: #'.$order->seccode.'<br/>寄件人: '.$order->sender_name.'<br/>寄件人電話: '.$order->sender_phone.'<br/><br/>您也可以至 <a href="'.route('admin.index').'">網站後台</a> 查看訂單詳細資訊。',
        ];
        $managers = User::role(['manager'])->get();
        $i = 0;$cc = array();
        foreach ($managers as $manager){
            if($manager->email_notification){
                if ($i == 0){
                    $adminMailData['email'] = $manager->email;
                }else{
                    array_push($cc,$manager->email);
                }
                $i ++ ;
            }
        }
        if (sizeof($cc) >0 ){
            $adminMailData['cc']=$cc;
        }
        dispatch(new SendMailQueueJob($adminMailData));


        if($request->get('type') == 1){
            return redirect(route('individual-form-complete',['parameter'=>$parameter]));
        }else if($request->get('type') == 2){
            if ($request->get('parent_id') == 0){
                return redirect(route('group-form-complete-i',['parameter'=>$parameter]));
            }else{
                return redirect(route('group-member-join-success',['parameter'=>$parameter]));
            }
        }

    }
    public function orderUpdate(Request $request)
    {
        $id = $request->get('order_id');
        $order = Order::find($id);
        $data = [
            'for_name' => $request->get('for_name'),
            'for_phone' => $request->get('for_phone'),
            'for_address' => $request->get('for_address'),
            'for_company' => $request->get('for_company'),
            'for_taxid' => $request->get('for_taxid'),
            'invoice' => $request->get('invoice'),
        ];
        $order->fill($data);
        $order->save();

        /* 刪除舊箱子資料 */
        $oldBox = OrderBox::where('order_id',$id);
        $oldBoxItem = OrderBoxItem::where('order_id',$id);
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
            ];
            $box = OrderBox::create($boxData);

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
                $start_item++;
            }
        }
        /** 管理員收信-訂單修改 */
        $adminMailData = [
            'is_admin'=>true,
            'template'=>'email-order-info',
            'subject'=>'【海龜集運】訂單編號 #'.$order->seccode.' 異動通知',
            'for_title'=>'網站管理員',
            'msg'=>'訂單編號: #'.$order->seccode.' 訂單資料有更新，請至 <a href="'.route('admin.index').'">網站後台</a> 查看訂單詳細資訊。',
        ];
        $managers = User::role(['manager'])->get();
        $i = 0;$cc = array();
        foreach ($managers as $manager){
            if($manager->email_notification){
                if ($i == 0){
                    $adminMailData['email'] = $manager->email;
                }else{
                    array_push($cc,$manager->email);
                }
                $i ++ ;
            }
        }
        if (sizeof($cc) >0 ){
            $adminMailData['cc']=$cc;
        }
        dispatch(new SendMailQueueJob($adminMailData));

        return redirect(route('edit-success'));
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
