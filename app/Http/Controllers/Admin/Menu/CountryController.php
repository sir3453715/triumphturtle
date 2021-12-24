<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Country;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{

    /**
     * index
     */
    public function index(Request $request)
    {
        $countries = Country::paginate(25);
        return view('admin.country.country', [
            'countries'=>$countries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.createCountry');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $data=[
            'title'=>$request->get('title'),
            'en_title'=>$request->get('en_title'),
        ];
        $country = Country::create($data);
        ActionLog::create_log($country,'create');

        return redirect(route('admin.country.index'))->with('message', '國家資料已建立!');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::find($id);

        return view('admin.country.editCountry',[
            'country'=>$country,
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
        $country = Country::find($id);
        $data=[
            'title'=>$request->get('title'),
            'en_title'=>$request->get('en_title'),
        ];
        $country->fill($data);
        ActionLog::create_log($country);
        $country->save();

        return redirect(route('admin.country.index'))->with('message', '資料已更新!');
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
        $country = Country::find($id);
        if($country){
            $country->delete();
            ActionLog::create_log($country,'delete');
        }

        return redirect(route('admin.country.index'))->with('message', '資料已刪除!');

    }

}
