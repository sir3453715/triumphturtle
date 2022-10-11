@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">訂單列表明細</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">訂單列表明細</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row">
                        <div class="col filter-form">
                            <form class="filter" id="filterForm">
                                <div class="form-group row">
                                    <div class="form-group mr-3">
                                        <label for="seccode">訂單編號</label>
                                        <input type="text" name="seccode" class="form-control" value="{{(isset($queried['seccode'])?$queried['seccode']:'')}}">
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="sender">寄件人姓名/寄件人電話</label>
                                        <input type="text" name="sender" class="form-control" placeholder="姓名，電話" value="{{(isset($queried['sender'])?$queried['sender']:'')}}">
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="pay_status">付款狀態</label>
                                        <select class="form-control" name="pay_status" id="pay_status" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['pay_status']) !!}>未付款</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['pay_status']) !!}>已出帳</option>
                                            <option value="3" {!! $html->selectSelected(3,$queried['pay_status']) !!}>已付款</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="status">訂單狀態</label>
                                        <select class="form-control" name="status" id="status" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['status']) !!}>未入庫</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['status']) !!}>已入庫</option>
                                            <option value="3" {!! $html->selectSelected(3,$queried['status']) !!}>宅配派送中</option>
                                            <option value="4" {!! $html->selectSelected(4,$queried['status']) !!}>完成</option>
                                            <option value="5" {!! $html->selectSelected(5,$queried['status']) !!}>取消</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-2 mr-3">
                                        <label for="sailing_id">航班</label>
                                        <select class="form-control select2" name="sailing_id" id="sailing_id" >
                                            <option value="">請選擇</option>
                                            @foreach($sailings as $sailing)
                                                <option value="{{$sailing->id}}" {!! $html->selectSelected($sailing->id,$queried['sailing_id']) !!}>{{$sailing->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group align-self-center mr-3">
                                        <button type="submit" class="form-control btn btn-outline-dark" name="submit" value="submit">篩選</button>
                                    </div>
                                    <div class="form-group align-self-center">
                                        <button type="submit" class="form-control btn btn-success" name="submit" value="export" form="filterForm">下載全部(所有分頁)</button>
                                    </div>

                                    <div class="ml-auto">
                                        <a href="{{route('admin.order-detail.create')}}"><button type="button" class="btn btn-primary">建立</button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-2" >
                        <div class="col filter-form  border-top">
                            <div class="mt-2">
                                <h5 class="m-0">批次修改訂單</h5>
                            </div>
                            <form class="form-inline filter" id="bulkForm" action="{{route('admin.order-detail.bulk')}}" method="post">
                                @csrf
                                <div class="form-group row mt-2">
                                    <div class="form-group mr-3">
                                        <label for="pay_status">付款狀態</label>
                                        <select class="form-control ml-3" name="pay_status" id="pay_status" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['pay_status']) !!}>未付款</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['pay_status']) !!}>已出帳</option>
                                            <option value="3" {!! $html->selectSelected(3,$queried['pay_status']) !!}>已付款</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="status">訂單狀態</label>
                                        <select class="form-control ml-3" name="status" id="status" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['status']) !!}>未入庫</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['status']) !!}>已入庫</option>
                                            <option value="3" {!! $html->selectSelected(3,$queried['status']) !!}>宅配派送中</option>
                                            <option value="4" {!! $html->selectSelected(4,$queried['status']) !!}>完成</option>
                                            <option value="5" {!! $html->selectSelected(5,$queried['status']) !!}>取消</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row ml-2 mt-2">
                                    <div class="form-group">
                                        <button type="button" class="form-control btn btn-outline-danger update-confirm mr-3" >執行</button>
                                        <button type="submit" class="d-none" id="bulkSubmit" name="submit" value="action"></button>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-outline-success mr-3" name="submit" value="delivery" formtarget="_blank">下載宅配資訊</button>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-danger mr-3" name="submit" value="payment" >批次發送請款單</button>
                                    </div>
                                </div>
                            </form>
                            <div class="ml-auto mt-2 border-top">
                                <a href="{{route('admin.order-detail.importList')}}" class="mt-2 btn btn-outline-primary">批次匯入物流單號</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Main row -->
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>
                                    <button type="button" class="btn btn-sm btn-outline-dark" id="all_check" data-tag="check">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </th>
                                <th>訂單編號</th>
                                <th>寄件人</th>
                                <th>電話</th>
                                <th>箱數</th>
                                <th>總金額</th>
                                <th>付款狀態</th>
                                <th>訂單狀態</th>
                                <th>是否回台灣</th>
                                <th>運單</th>
                                <th>請款單</th>
                                <th>動作</th>
                                <th width="10%">電子發票</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <input class="chk" type="checkbox" name="order_id[]" form="bulkForm" value="{{$order->id}}">
                                        </td>
                                        <td><a href="{{route('admin.order-detail.edit',['order_detail'=>$order->id])}}">{{$order->seccode}}</a></td>
                                        <td>{{$order->sender_name}}</td>
                                        <td>{{$order->sender_phone}}</td>
                                        <td>{{count($order->box)}}</td>
                                        <td>{{$order->final_price}}</td>
                                        <td>
                                            @switch($order->pay_status)
                                                @case(1)
                                                <span class="fa-1x badge badge-secondary">未付款</span>
                                                @break
                                                @case(2)
                                                <span class="fa-1x badge badge-warning">已出帳</span>
                                                @break
                                                @case(3)
                                                <span class="fa-1x badge badge-success">已付款</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case(1)
                                                <span class="fa-1x badge badge-secondary">未入庫</span>
                                                @break
                                                @case(2)
                                                <span class="fa-1x badge badge-info">已入庫</span>
                                                @break
                                                @case(3)
                                                <span class="fa-1x badge badge-primary">宅配派送中</span>
                                                @break
                                                @case(4)
                                                <span class="fa-1x badge badge-success">完成</span>
                                                @break
                                                @case(5)
                                                <span class="fa-1x badge badge-danger">取消</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td style="text-align: center">
                                            @switch($order->reback)
                                                @case(1)
                                                <span class="fa-1x badge badge-success">是</span><br/>
                                                時間 : {{$order->reback_time}}
                                                @break
                                                @case(2)
                                                <span class="fa-1x badge badge-danger">否</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{route('pdf-shipment',['id'=>$order->id])}}" class="btn btn-sm btn-outline-info " target="_blank">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if($order->pay_status != 3)
                                                <a href="{{route('admin.payment.edit',['payment'=>$order->id])}}" class="btn btn-sm btn-outline-info">
                                                    預覽/發送
                                                </a>
                                            @endif
                                        </td>
                                        <td class="action">
                                            <a href="{{route('admin.order-detail.edit',['order_detail'=>$order->id])}}" class="btn btn-sm btn-secondary mb-1">修改</a>
                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator')||\Illuminate\Support\Facades\Auth::user()->hasRole('manager'))
                                                <form action="{{ route('admin.order-detail.destroy', ['order_detail' => $order->id]) }}" method="post" class="form-btn">
                                                    @method('delete')
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger delete-confirm">刪除</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td >
                                            <div style="display: inline-grid;place-items: center;">
                                                @if($order->pay_status == 3)
                                                    @if($order->invoice_status == 1)
                                                        <span> 發票號碼 : {{$order->invoice_code}} </span>
                                                        <span> 開立時間 : {{$order->invoice_time}} </span>

                                                        <form action="{{ route('admin.order-detail.invalidInvoice', ['id' => $order->id]) }}" method="post" class="form-btn">
                                                            @csrf
                                                            <input type="text" name="reason" class="d-none reason">
                                                            <button class="btn btn-sm btn-outline-danger invalid-confirm">發票作廢</button>
                                                        </form>
                                                    @elseif($order->invoice_status ==2)
                                                        <span class="text-danger"> 已作廢發票 : {{$order->invoice_code}} </span>
                                                        <span class="text-danger"> 作廢時間 : {{$order->invoice_time}} </span>
                                                        <a href="{{route('admin.order-detail.issueInvoice',['id'=>$order->id])}}" class="btn btn-sm btn-outline-success">重新開立</a>
                                                    @else
                                                        <a href="{{route('admin.order-detail.issueInvoice',['id'=>$order->id])}}" class="btn btn-sm btn-outline-success">開立發票</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $orders->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection


@push('admin-app-scripts')
    <script type="text/javascript">
        $(document.body).on('click', '.copy', e => {
            let $link = $(e.currentTarget).data('link');
            var sampleTextarea = document.createElement("textarea");
            document.body.appendChild(sampleTextarea);
            sampleTextarea.value = $link; //save main text in it
            sampleTextarea.select(); //select textarea contenrs
            document.execCommand("copy");
            document.body.removeChild(sampleTextarea);
            alert('已複製連結!:'+$link);
        });
        $('#all_check').on('click',function (){
            var tag = $(this).data('tag');
            if(tag === 'check'){
                $(".chk").prop("checked",true);
                $(this).data('tag','uncheck');
                $(this).html('<i class="fa fa-times"></i>');
            }else if(tag === 'uncheck'){
                $(".chk").prop("checked",false);
                $(this).data('tag','check');
                $(this).html('<i class="fa fa-check"></i>');
            }
        });

        $(document.body).on('click','.invalid-confirm',e => {
            e.preventDefault();
            let reason = prompt("請輸入發票作廢原因!");
            if (reason != null) {
                $(e.currentTarget).siblings('.reason').val(reason);
                $(e.currentTarget).closest('form').submit();
            }
        });

    </script>
@endpush

