<?php

namespace App\Http\Controllers;

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
}
