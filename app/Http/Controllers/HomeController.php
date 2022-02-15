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
        $warehouses = Warehouse::all();
        return view('location',['warehouses'=>$warehouses]);
    }
    public function tracking()
    {
        return view('tracking');
    }
    public function groupFormInitiator()
    {
        return view('group-form-initiator');
    }
    public function individualForm()
    {
        return view('individual-form');
    }
    public function groupFormMember()
    {
        return view('group-form-member');
    }
    public function groupFormEdit()
    {
        return view('group-form-edit');
    }

    public function groupFormCompletI()
    {
        return view('group-form-complet-i');
    }
    public function groupMemberJoin()
    {
        return view('group-member-join');
    }
    public function groupMemberJoinSuccess()
    {
        return view('group-member-join-success');
    }

    public function individualFormComplet()
    {
        return view('individual-form-complet');
    }

    public function editSuccess()
    {
        return view('edit-success');
    }

    public function shipmentOrder()
    {
        return view('shipment-order');
    }

    public function deliveryOrder()
    {
        return view('delivery-order');
    }

}
