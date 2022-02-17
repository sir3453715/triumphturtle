<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Country;
use App\Models\Warehouse;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $warehouses = Warehouse::paginate(25);
        return view('admin.warehouse.warehouse', [
            'warehouses'=>$warehouses,
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
        return view('admin.warehouse.createWarehouse',[
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
        $img = '';
        if($request->hasFile('img')){//有圖檔上傳
            $img = date('ymdhis').rand(0,9).rand(0,9).'.'.$request->file('img')->getClientOriginalExtension();
            $request->file('img')->storeAs('public/customer',$img);
        }

        $data=[
            'title'=>$request->get('title'),
            'for_name'=>$request->get('for_name'),
            'country'=>$request->get('country'),
            'phone'=>$request->get('phone'),
            'address'=>$request->get('address'),
            'link'=>$request->get('link'),
            'local'=>$request->get('local'),
            'img'=>$img,
        ];
        $warehouse = Warehouse::create($data);
        ActionLog::create_log($warehouse,'create');

        return redirect(route('admin.warehouse.index'))->with('message', '倉庫資料已建立!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = Warehouse::find($id);
        $countries = Country::all();
        return view('admin.warehouse.editWarehouse',[
            'warehouse'=>$warehouse,
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
        $warehouse = Warehouse::find($id);
        $img = $warehouse->img;
        if($request->hasFile('img')){//有圖檔上傳
            if($img){
                unlink(storage_path('app/public/customer/'.$img));
            }
            $img = date('ymdhis').rand(0,9).rand(0,9).'.'.$request->file('img')->getClientOriginalExtension();
            $request->file('img')->storeAs('public/customer',$img);
        }

        $data=[
            'title'=>$request->get('title'),
            'for_name'=>$request->get('for_name'),
            'country'=>$request->get('country'),
            'phone'=>$request->get('phone'),
            'address'=>$request->get('address'),
            'link'=>$request->get('link'),
            'local'=>$request->get('local'),
            'img'=>$img,
        ];

        $warehouse->fill($data);
        ActionLog::create_log($warehouse);
        $warehouse->save();

        return redirect(route('admin.warehouse.index'))->with('message', '資料已更新!');
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
        $warehouse = Warehouse::find($id);
        if($warehouse){
            $warehouse->delete();
            ActionLog::create_log($warehouse,'delete');
        }

        return redirect(route('admin.warehouse.index'))->with('message', '資料已刪除!');

    }

}
