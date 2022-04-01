<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderBox;
use App\Models\SailingSchedule;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        if($data['status'] ==2 && $sailing->status == 1){//集貨轉準備 更動金額
            $box_interval = $sailing->box_interval;
            $order_ids = Order::where('sailing_id',$id)->pluck('id');
            $box_count = OrderBox::whereIn('order_id',$order_ids)->count();
            $minimum = $sailing->minimum;
            $defaultPrice = $sailing->price;
            $interval = intval(floor(($box_count-$minimum)/$box_interval));
            if ($interval > '1'){ // 滿足折扣級距
                for ($i = 1;$i<=$interval;$i++){
                    $defaultPrice = ($defaultPrice*$sailing->discount);
                }
                if($defaultPrice<=$sailing->min_price){ // 達到最低價
                    $defaultPrice = $sailing->min_price;
                }
            }
            $defaultPrice = round($defaultPrice);
            $data['final_price'] = $defaultPrice;
            foreach ($order_ids as $order_id){
                $price = $defaultPrice;//預設為每箱單價
                $order = Order::find($order_id);
                $singleOrderBoxes = OrderBox::where('order_id',$order_id)->get();
                $total_price = $price*count($singleOrderBoxes);
                $tax_price = 0;
                $final_price = $total_price;
                if($order->invoice != 1){
                    $tax_price = round($total_price*0.05);
                    $final_price += $tax_price;
                }
                $order->fill([
                    'total_price'=>$total_price,
                    'tax_price'=>$tax_price,
                    'final_price'=>$final_price,
                ]);
                ActionLog::create_log($order);
                $order->save();
                $box_price = intval(floor($total_price/count($singleOrderBoxes)));
                foreach ($singleOrderBoxes as $orderBox) {
                    $orderBox->fill(['box_price' => $box_price]);
                    $orderBox->save();
                }
                /** 用戶收信-航班準備 */
                $mailData = [
                    'is_admin'=>false,
                    'template'=>'email-order-info',
                    'email'=>$order->sender_email,
                    'subject'=>'【海龜集運】訂單編號 '.$order->seccode.' 航班準備中',
                    'for_title'=>$order->sender_name,
                    'msg'=>'訂單編號: '.$order->seccode.'  狀態更新通知 - 航班準備中！<br/><br/><span style="color: red;">最終優惠價格: '.number_format($defaultPrice).' TWD/箱 (未稅)</span><br/><br/>提醒您請於入倉截止日 '.$sailing->parcel_deadline.' 前將運單列印後貼至包裹上，並寄送至倉庫。<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
                ];
                dispatch(new SendMailQueueJob($mailData));
            }
        }elseif($data['status'] == '3' && $sailing->status != 3) {
            $orders = Order::where('sailing_id',$id)->get();
            foreach ($orders as $order){
                /** 用戶收信-航班航行 */
                $mailData = [
                    'is_admin'=>false,
                    'template'=>'email-order-info',
                    'email'=>$order->sender_email,
                    'subject'=>'【海龜集運】訂單編號 '.$order->seccode.' 航班航行中',
                    'for_title'=>$order->sender_name,
                    'msg'=>'訂單編號: '.$order->seccode.'  狀態更新通知 - 航班航行中！<br/><br/>您也可以至 <a href="'.route('tracking').'">訂單查詢頁面</a> 查看訂單詳細資訊。',
                ];
                dispatch(new SendMailQueueJob($mailData));
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
