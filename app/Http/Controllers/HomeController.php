<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailQueueJob;
use App\Models\Country;
use App\Models\Order;
use App\Models\SailingSchedule;
use App\Models\Warehouse;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $countries = Country::all();
        $sailings = SailingSchedule::where('on_off','2');
        $queried=['from_country'=>'','to_country'=>''];
        if($request->get('from_country')) {
            $queried['from_country'] = $request->get('from_country');
            $sailings = $sailings->where('from_country',$request->get('from_country'));
        }
        if($request->get('to_country')) {
            $queried['to_country'] = $request->get('to_country');
            $sailings = $sailings->where('to_country',$request->get('to_country'));
        }

        $sailings = $sailings->paginate(6);
        return view('home',[
            'queried'=>$queried,
            'countries'=>$countries,
            'sailings'=>$sailings,
        ]);
    }
    public function about()
    {
        return view('about');
    }
    public function service()
    {
        return view('service');
    }
    public function embargo()
    {
        return view('embargo');
    }
    public function question()
    {
        return view('question');
    }
    public function location()
    {
        $warehouses = Warehouse::all();
        return view('location',['warehouses'=>$warehouses]);
    }
    public function tracking(Request $request)
    {
        $queried=['keyword'=>''];
        if($request->get('keyword')) {
            $queried['keyword'] = $request->get('keyword');
            $sailing_ids = SailingSchedule::where('status','1')->pluck('id');
            $orders = Order::whereIn('sailing_id',$sailing_ids)->where(function ($query) use ($queried){
                $query->orwhere('seccode',$queried['keyword']);
                $query->orwhere('sender_phone',$queried['keyword']);
            })->get();
        }
        return view('tracking', [
            'orders'=>$orders??null,
            'queried'=>$queried
        ]);
    }
    public function trackingCaptcha($seccode)
    {
        $order = Order::where('seccode',$seccode)->first();
        return view('trackingCaptcha',[
            'order'=>$order
        ]);
    }
    public function editSuccess()
    {
        return view('edit-success');
    }

    public function ajaxSailingData(Request $request)
    {
        if ($request->ajax()) {
            $sailings = SailingSchedule::where('on_off','2');
            if($request->get('from_country')) {
                $sailings = $sailings->where('from_country',$request->get('from_country'));
            }
            if($request->get('to_country')) {
                $sailings = $sailings->where('to_country',$request->get('to_country'));
            }
            $sailings = $sailings->paginate(6);
            return view('component.ajaxSailingData', ['sailings' => $sailings])->render();
        }
    }
    public function updateToken(Request $request){
        $return = false;
        $order = Order::find($request->get('order_id'));
        if ($order){

            $updateToken=substr(md5(uniqid(rand())),0,8);  ##產生隨機字串
            $updateToken = preg_replace('/\[O|0|I|i|L\]/',rand(2,9),$updateToken);  #排除掉特定字元
            $order->fill(['updateToken'=>$updateToken]);
            $order->save();
            $data = [
                'email'=>$order->sender_email,
                'subject'=>'修改訂單驗證碼通知信',
                'for_title'=>$order->sender_name,
                'msg'=>'您的訂單修改驗證碼為:'.$updateToken.'請再透過網站進行驗證後修改訂單，<br/>'.
                    '或透過下方連結進行驗證手續<a target="_blank" href="'.route('tracking-captcha',['seccode'=>$order->seccode]).'"></a>',
            ];
            dispatch(new SendMailQueueJob($data));

            $return = true;
        }
        return json_encode($return); //json
    }

}
