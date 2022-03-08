@extends('admin.layouts.app')

@section('admin-page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">帳務管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">帳務管理</li>
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
                            <form class="form-inline filter">
                                <div class="form-group row">
                                    <div class="form-group mr-3">
                                        <label for="seccode">訂單編號/運單號</label>
                                        <input type="text" name="seccode" class="form-control ml-3" value="{{(isset($queried['seccode'])?$queried['seccode']:'')}}">
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="sender">寄件人姓名/寄件人電話</label>
                                        <input type="text" name="sender" class="form-control ml-3" placeholder="姓名，電話" value="{{(isset($queried['sender'])?$queried['sender']:'')}}">
                                    </div>
                                <div class="form-group row ml-2 mt-2">
                                    <div class="form-group">
                                        <button type="submit" class="form-control">篩選</button>
                                    </div>
                                </div>
                            </form>
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
                                <th>訂單編號</th>
                                <th>寄件人</th>
                                <th>電話</th>
                                <th>箱數</th>
                                <th>總金額</th>
                                <th>付款狀態</th>
                                <th>確認出帳</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{route('admin.order-detail.edit',['order_detail'=>$order->id])}}">{{$order->seccode}}</a></td>
                                    <td>{{$order->sender_name}}</td>
                                    <td>{{$order->sender_phone}}</td>
                                    <td>{{sizeof($order->box)}}</td>
                                    <td>{{$order->total_price}}</td>
                                    <td>
                                        @switch($order->pay_status)
                                            @case(1)
                                            <span class="badge badge-secondary fa-1x">未付款</span>
                                            @break
                                            @case(2)
                                            <span class="badge badge-warning fa-1x">已出帳</span>
                                            @break
                                            @case(3)
                                            <span class="badge badge-success fa-1x">已付款</span>
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{route('admin.payment.checkPay',['id'=>$order->id])}}" class="btn btn-outline-success">確認收款</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
{{--                        {{ $countries->appends(request()->except('page'))->links() }}--}}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

