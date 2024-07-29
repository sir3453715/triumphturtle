<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\Order;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{

    /**
     * index
     */
    function index(Request $request){
        $queried=['seccode'=>'','sender'=>''];

        $orders = Order::where('pay_status',2)->where('status','!=','5');
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
        $order = Order::find($id);

        $billing['sailing']=$order->sailing->toArray();
        $billing['box_count'] = count($order->box);
        $billing['itemTotal']= round($order->sailing->final_price * $billing['box_count']);
        $other_total = 0;
        if($order->other_price){
            foreach (unserialize($order->other_price) as $other){
                $other_total += $other['other_qty']*$other['other_unit'];
            }
        }
        $billing['subtotal'] = $order->sailing->final_price * count($order->box) +$other_total;


        return view('admin.payment.editPayment',[
            'order'=>$order,
            'billing'=>$billing,
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
        $order = Order::find($id);
        $originalname = $order->seccode.'出帳帳單.pdf';
        $other_title = $request->get('other_title');
        $other_qty = $request->get('other_qty');
        $other_unit = $request->get('other_unit');
        $final_price = $order->total_price;
        foreach ($other_title as $key => $title){
            $other_price[] = [
                'other_title'=>$title,
                'other_qty'=>$other_qty[$key],
                'other_unit'=>$other_unit[$key],
            ];
            $final_price += ($other_qty[$key]*$other_unit[$key]);
        }
        $tax_price = round($final_price*0.05);
        $final_price += $tax_price;
        $data = [
            'pay_status'=>2,
            'other_price'=>serialize($other_price),
            'tax_price' => $tax_price,
            'final_price'=>$final_price,
        ];
        $order->fill($data);
        $order->save();

        $order = Order::find($id);
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
                ->subject('【揪揪運】付款通知');
            $message->attach(storage_path().'/app/public/billing'.'/'.$originalname);
        });
        Storage::disk('billing')->delete($originalname);

        return redirect(route('admin.payment.index'))->with('message', '訂單'.$order->seccode.'已發送請款單!');
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
                'subject'=>'【揪揪運】您的款項已確認',
                'for_title'=>$order->sender_name,
                'msg'=>'訂單編號: '.$order->seccode.'<br/><br/>您的訂單已確認付款，我們會盡快為您安排出貨，您可隨時至<a href="'.route('tracking').'">訂單查詢頁面</a> 查看最新的寄送進度，謝謝！',
            ];
            dispatch(new SendMailQueueJob($mailData));

            return redirect(route('admin.payment.index'))->with('message', '訂單'.$order->seccode.'已確認收款!');
        }else{
            return redirect(route('admin.payment.index'))->with('error', '無法確認收款!，請詢問工程人員');
        }

    }
}
