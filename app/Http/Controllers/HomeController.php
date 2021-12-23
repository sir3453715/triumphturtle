<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\PunchCard;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        return view('welcome');
    }
    public function punch(Request $request){
        if($request->get('status') == 0){
            $status = 1;
        }else{
            $status = $request->get('status');
        }
        $punch_card = '';
        $data = [
            'user_id'=>Auth::id(),
            'status'=>$status,
        ];

        if($request->get('date')){
            $date = $request->get('date');
        }else{
            $date = date('Y-m-d');
        }
        if($status != 1){
            switch($request->get('time')){
                case '1':
                    $statr_time = $date.' 09:00:00';
                    $end_time = $date.' 12:00:00';
                    break;
                case '2':
                    $statr_time = $date.' 13:00:00';
                    $end_time = $date.' 18:00:00';
                    break;
                case '3':
                    $statr_time = $date.' 09:00:00';
                    $end_time = $date.' 18:00:00';
                    break;
                default:
                    break;
            }
        }else{

            $punch_card = PunchCard::where('user_id',Auth::id())->where('start_time','LIKE','%'.$date.'%')
                ->where('status','1')->first();

            if($request->get('status') == 0){
                if($punch_card){
                    return redirect(route('index'))->with('error', '今天已打過上班卡!');
                }
                $statr_time = date('Y-m-d H:i:s');
                $end_time = '';
            }else{
                if($punch_card){
                    $statr_time = $punch_card->start_time;
                    $end_time = date('Y-m-d H:i:s');
                }else{
                    return redirect(route('index'))->with('error', '今天還沒打上班卡!');
                }
            }

        }
        $data['start_time']=$statr_time;
        $data['end_time']=$end_time;

        if($punch_card){
            $punch_card->fill($data);
            $punch_card->save();
        }else{
            PunchCard::create($data);
        }
        if ($request->get('status') == 4){
            $user = User::find(Auth::id());
            $special = $user->special_vacation;
            $data=[
                'special_vacation'=>$special-1,
            ];
            $user->fill($data);
            $user->save();
        }

        return redirect(route('index'))->with('message', '打卡成功!');


    }
}
