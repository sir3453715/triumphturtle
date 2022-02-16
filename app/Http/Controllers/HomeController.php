<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\SailingSchedule;
use App\Models\Warehouse;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    public function tracking()
    {
        return view('tracking');
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

}
