<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailQueueJob;
use App\Models\Calendar;
use App\Models\PunchCard;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function map()
    {
        return view('map');
    }
    public function mailTEST(){

        $mailData = [
            'is_admin'=>false,
            'template'=>'email-order-info',
            'email'=>'han.nomadot@gmail.com',
            'subject'=>'TEST FOR MAIL SEND',
            'for_title'=>'Han',
            'msg'=>'TEST FOR MAIL SEND CONTENT',
        ];
        dispatch(new SendMailQueueJob($mailData));
        print_r('success');
    }
}
