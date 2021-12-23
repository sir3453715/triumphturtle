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

            $extension = $request->file('file')->getClientOriginalExtension(); //副檔名
            $path1 = time() . "." . $extension;    //重新命名
            $request->file('file')->move(storage_path('app').'/temp', $path1); //移動至指定目錄
            $path=storage_path('app').'/temp/'.$path1;
            $excel = Excel::toCollection('' ,$path);
            $data = array();
            foreach ($excel as $key => $sheets){ // 各個表分別撈出來
                foreach ($sheets as $rows => $column){
                    if($rows>0){ //排除檔案標題欄位
                        $data[$key+$rows]['id']=$column[0];
                        $data[$key+$rows]['name']=$column[1];
                        $data[$key+$rows]['phone']=$column[2];
                        $data[$key+$rows]['email']=$column[3];
                    }
                }
            }


            unlink(storage_path('app/temp/'.$path1));
            return redirect(route('admin.import-export.index'))->with('message', '檔案成功匯入!')->with('data',$data);
        }else{
            return redirect(route('admin.import-export.index'))->with('Errormessage','檔案匯出失敗!');
        }
    }
    public function export()
    {
        $data=[
            0=>[
                'name'=>'王小明',
                'phone'=>'0912345678',
                'email'=>'a@a.com',
            ],
            1=>[
                'name'=>'王中明',
                'phone'=>'0912876543',
                'email'=>'b@b.com',
            ],
            2=>[
                'name'=>'王大明',
                'phone'=>'0987654321',
                'email'=>'c@c.com',
            ],
        ];
        $title = '模擬匯出';

        $headings = [
            'name'=>"姓名",
            'phone'=>"電話",
            'email'=>"信箱",
        ];

        return Excel::download(new DemoExport($data,$title,$headings),'模擬匯出'.date('Y-m-d_H_i_s'). '.xls');
    }
    public function sendmail(Request $request)
    {
        $data = [
            'email'=>$request->get('mail'),
            'subject'=>'測試發送信件主旨',
            'for_title'=>'測試對象',
            'msg'=>'測試發送信件內文!收到信表示功能目前正常，一切都好',
            'cc'=>['sir3453715@gmail.com','hanhsu@beautifullife.global'],
        ];
        dispatch(new SendMailQueueJob($data));

        return redirect(route('admin.import-export.index'))->with('message', '信件成功寄出!');
    }
}
