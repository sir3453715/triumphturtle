<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exports\DemoExport;
use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class ImportExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $import_data = Session::get('data') ?? null;

        return view('admin.feature.ImportExport', [
            'import_data'=>$import_data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
    }

    /**
     * custome Import And Export
     * @param $id
     */
    public function import(Request $request)
    {
        if($request->hasFile('file')){

            $extension = $request->file('file')->getClientOriginalExtension(); //?????????
            $path1 = time() . "." . $extension;    //????????????
            $request->file('file')->move(storage_path('app').'/temp', $path1); //?????????????????????
            $path=storage_path('app').'/temp/'.$path1;
            $excel = Excel::toCollection('' ,$path);
            $data = array();
            foreach ($excel as $key => $sheets){ // ????????????????????????
                foreach ($sheets as $rows => $column){
                    if($rows>0){ //????????????????????????
                        $data[$key+$rows]['id']=$column[0];
                        $data[$key+$rows]['name']=$column[1];
                        $data[$key+$rows]['phone']=$column[2];
                        $data[$key+$rows]['email']=$column[3];
                    }
                }
            }


            unlink(storage_path('app/temp/'.$path1));
            return redirect(route('admin.import-export.index'))->with('message', '??????????????????!')->with('data',$data);
        }else{
            return redirect(route('admin.import-export.index'))->with('Errormessage','??????????????????!');
        }
    }
    public function export()
    {
        $data=[
            0=>[
                'name'=>'?????????',
                'phone'=>'0912345678',
                'email'=>'a@a.com',
            ],
            1=>[
                'name'=>'?????????',
                'phone'=>'0912876543',
                'email'=>'b@b.com',
            ],
            2=>[
                'name'=>'?????????',
                'phone'=>'0987654321',
                'email'=>'c@c.com',
            ],
        ];
        $title = '????????????';

        $headings = [
            'name'=>"??????",
            'phone'=>"??????",
            'email'=>"??????",
        ];

        return Excel::download(new DemoExport($data,$title,$headings),'????????????'.date('Y-m-d_H_i_s'). '.xls');
    }
    public static function sendmail($mail)
    {
        $data = [
            'email'=>$mail['email'],
            'subject'=>$mail['subject'],
            'for_title'=>$mail['for_title'],
            'msg'=>$mail['msg'],
        ];
        dispatch(new SendMailQueueJob($data));

        return redirect(route('admin.import-export.index'))->with('message', '??????????????????!');
    }
}
