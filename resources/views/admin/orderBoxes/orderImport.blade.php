@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">匯入物流單號</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.order-detail.index')}}">訂單列表明細</a></li>
                        <li class="breadcrumb-item active">匯入物流單號</li>
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
                            <div class="form-group row">
                                <div class="form-group ml-3">
                                    <a href="{{url('/storage/files/shipmentImportTemplate.xls')}}" class="btn btn-sm btn-outline-info " target="_blank">匯入模板下載
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </div>
                            <form class="form-inline filter" action="{{route('admin.order-detail.import')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="form-group mr-3">
                                        <input type="file" name="importFile" class="form-control-file ml-3" accept=".xlsx,.xls">
                                    </div>
                                </div>
                                <div class="form-group row ml-2">
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn-info">送出</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- Main row -->
{{--            <div class="col-12">--}}
{{--                <div class="card">--}}
{{--                    <!-- /.card-header -->--}}
{{--                    <div class="card-body">--}}
{{--                        <table class="table table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>#</th>--}}
{{--                                <th>訂單編號</th>--}}
{{--                                <th>寄件人</th>--}}
{{--                                <th>電話</th>--}}
{{--                                <th>箱數</th>--}}
{{--                                <th>總金額</th>--}}
{{--                                <th>付款狀態</th>--}}
{{--                                <th>訂單狀態</th>--}}
{{--                                <th>運單</th>--}}
{{--                                <th>請款單</th>--}}
{{--                                <th>動作</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                                @foreach($orders as $order)--}}
{{--                                    <tr>--}}
{{--                                        <td>--}}
{{--                                            <input type="checkbox" name="order_id[]" form="bulkForm" value="{{$order->id}}">--}}
{{--                                        </td>--}}
{{--                                        <td><a href="{{route('admin.order-detail.edit',['order_detail'=>$order->id])}}">{{$order->seccode}}</a></td>--}}
{{--                                        <td>{{$order->sender_name}}</td>--}}
{{--                                        <td>{{$order->sender_phone}}</td>--}}
{{--                                        <td>{{count($order->box)}}</td>--}}
{{--                                        <td>{{$order->final_price}}</td>--}}
{{--                                        <td>--}}
{{--                                            @switch($order->pay_status)--}}
{{--                                                @case(1)--}}
{{--                                                <span class="fa-1x badge badge-secondary">未付款</span>--}}
{{--                                                @break--}}
{{--                                                @case(2)--}}
{{--                                                <span class="fa-1x badge badge-warning">已出帳</span>--}}
{{--                                                @break--}}
{{--                                                @case(3)--}}
{{--                                                <span class="fa-1x badge badge-success">已付款</span>--}}
{{--                                                @break--}}
{{--                                            @endswitch--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @switch($order->status)--}}
{{--                                                @case(1)--}}
{{--                                                <span class="fa-1x badge badge-secondary">未入庫</span>--}}
{{--                                                @break--}}
{{--                                                @case(2)--}}
{{--                                                <span class="fa-1x badge badge-info">已入庫</span>--}}
{{--                                                @break--}}
{{--                                                @case(3)--}}
{{--                                                <span class="fa-1x badge badge-primary">宅配派送中</span>--}}
{{--                                                @break--}}
{{--                                                @case(4)--}}
{{--                                                <span class="fa-1x badge badge-success">完成</span>--}}
{{--                                                @break--}}
{{--                                                @case(5)--}}
{{--                                                <span class="fa-1x badge badge-danger">取消</span>--}}
{{--                                                @break--}}
{{--                                            @endswitch--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            <a href="{{route('pdf-shipment',['id'=>$order->id])}}" class="btn btn-sm btn-outline-info " target="_blank">--}}
{{--                                                <i class="fa fa-download"></i>--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if($order->pay_status != 3)--}}
{{--                                                <a href="{{route('admin.payment.edit',['payment'=>$order->id])}}" class="btn btn-sm btn-outline-info">--}}
{{--                                                    預覽/發送--}}
{{--                                                </a>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                        <td class="action form-inline">--}}
{{--                                            <a href="{{route('admin.order-detail.edit',['order_detail'=>$order->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>--}}
{{--                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator')||\Illuminate\Support\Facades\Auth::user()->hasRole('manager'))--}}
{{--                                                <form action="{{ route('admin.order-detail.destroy', ['order_detail' => $order->id]) }}" method="post" class="form-btn">--}}
{{--                                                    @method('delete')--}}
{{--                                                    @csrf--}}
{{--                                                    <button class="btn btn-sm btn-danger delete-confirm">刪除</button>--}}
{{--                                                </form>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <!-- /.card-body -->--}}
{{--                    <div class="card-footer clearfix">--}}
{{--                        {{ $orders->appends(request()->except('page'))->links() }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- /.card -->--}}
{{--            </div>--}}
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
    </script>
@endpush

