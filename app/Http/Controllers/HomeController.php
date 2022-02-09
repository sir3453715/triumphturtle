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
        return view('home');
    }
    public function about()
    {
        return view('about');
    }
    public function service()
    {
        return view('service');
    }
    public function option()
    {
        return view('option');
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
        return view('location');
    }
    public function tracking()
    {
        return view('tracking');
    }
}
