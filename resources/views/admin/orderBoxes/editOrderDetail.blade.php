@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">修改訂單 {{ $order->seccode }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.order-detail.index')}}">訂單明細列表</a></li>
                        <li class="breadcrumb-item active">修改訂單</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.order-detail.update',['order_detail'=>$order->id]) }}" method="post">
        @csrf
        @method('PUT')
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-10">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">基本資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <h5>訂單資訊</h5>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3">
                                        <label for="sailing_id">船班</label>
                                        <select id="sailing_id" name="sailing_id" class="form-control form-required" disabled>
                                            <option value="{{$order->sailing_id}}">{{$order->sailing->title}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="type">訂單類型</label>
                                        <select id="type" name="type" class="form-control form-required" disabled>
                                            <option value="1" {!! $html->selectSelected(1,$order->type) !!}>個人訂單</option>
                                            <option value="2" {!! $html->selectSelected(2,$order->type) !!}>團購訂單</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="status">訂單狀態</label>
                                        <select id="status" name="status" class="form-control form-required">
                                            <option value="1" {!! $html->selectSelected(1,$order->status) !!}>未入庫</option>
                                            <option value="2" {!! $html->selectSelected(2,$order->status) !!}>已入庫</option>
                                            <option value="3" {!! $html->selectSelected(3,$order->status) !!}>宅配派送中</option>
                                            <option value="4" {!! $html->selectSelected(4,$order->status) !!}>完成</option>
                                            <option value="5" {!! $html->selectSelected(5,$order->status) !!}>取消</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="pay_status">付款狀態</label>
                                        <select id="pay_status" name="pay_status" class="form-control form-required">
                                            <option value="1" {!! $html->selectSelected(1,$order->pay_status) !!}>未付款</option>
                                            <option value="2" {!! $html->selectSelected(2,$order->pay_status) !!}>已出帳</option>
                                            <option value="3" {!! $html->selectSelected(3,$order->pay_status) !!}>已付款</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="shipment_use">目的</label>
                                        <select name="shipment_use" id="shipment_use" class="form-control form-required" >
                                            <option value="" hidden>請選擇目的</option>
                                            <option value="行李後送"{!! $html->selectSelected('行李後送',$order->shipment_use) !!}>行李後送</option>
                                            <option value="私人行李"{!! $html->selectSelected('私人行李',$order->shipment_use) !!}>私人行李</option>
                                            <option value="商業貨"{!! $html->selectSelected('商業貨',$order->shipment_use) !!}>商業貨</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="invoice">發票</label>
                                        <select id="invoice" name="invoice" class="form-control form-required">
                                            <option value="2" {!! $html->selectSelected(2,$order->invoice) !!}>二聯 - 個人戶</option>
                                            <option value="3" {!! $html->selectSelected(3,$order->invoice) !!}>三聯 - 公司戶</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3">
                                        <label for="total_price">訂單總金額(不含稅)</label>
                                        <input type="text" class="form-control" name="total_price" id="total_price" value="{{$order->total_price}}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="total_price">營業稅金額</label>
                                        <input type="text" class="form-control" name="tax_price" id="tax_price" value="{{$order->tax_price}}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="total_price">額外費用-總價</label>
                                        <input type="text" class="form-control" name="final_price" id="final_price" value="{{$other_total}}" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="total_price">最後總金額</label>
                                        <input type="text" class="form-control " name="final_price" id="final_price" value="{{$order->final_price}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <h5>寄件資訊</h5>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">寄件者姓名</label>
                                        <input type="text" class="form-control form-required" name="sender_name" id="sender_name" value="{{$order->sender_name}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_phone">寄件者電話</label>
                                        <input type="text" class="form-control form-required" name="sender_phone" id="sender_phone" value="{{$order->sender_phone}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sender_address">寄件者地址</label>
                                        <input type="text" class="form-control form-required" name="sender_address" id="sender_address" value="{{$order->sender_address}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_company">寄件者公司名稱</label>
                                        <input type="text" class="form-control" name="sender_company" id="sender_company" value="{{$order->sender_company}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_taxid">寄件者統編</label>
                                        <input type="text" class="form-control" name="sender_taxid" id="sender_taxid" value="{{$order->sender_taxid}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="sender_email">寄件者信箱</label>
                                        <input type="text" class="form-control form-required" name="sender_email" id="sender_email" value="{{$order->sender_email}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="reback">是否回台灣*</label>
                                        <select class="form-control form-required" name="reback" id="reback">
                                            <option value="1" {!! $html->selectSelected($order->reback,'1') !!}>是</option>
                                            <option value="2" {!! $html->selectSelected($order->reback,'2') !!}>否</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="reback_time">回台時間*</label>
                                        <input type="date" class="form-control" name="reback_time" id="reback_time" value="{{$order->reback_time}}">
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <h5>收件資訊</h5>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3">
                                        <label for="for_name">收件者姓名</label>
                                        <input type="text" class="form-control" name="for_name" id="for_name" value="{{$order->for_name}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="for_phone">收件者電話</label>
                                        <input type="text" class="form-control" name="for_phone" id="for_phone" value="{{$order->for_phone}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="for_address">收件者地址</label>
                                        <input type="text" class="form-control" name="for_address" id="for_address" value="{{$order->for_address}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="for_company">收件者公司名稱</label>
                                        <input type="text" class="form-control" name="for_company" id="for_company" value="{{$order->for_company}}">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="for_taxid">收件者統編</label>
                                        <input type="text" class="form-control" name="for_taxid" id="for_taxid" value="{{$order->for_taxid}}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-header bg-white border-top">
                                <h3 class="card-title">裝箱資訊</h3>
                                <a href="javascript:void(0);" class="add-box btn btn-outline-primary float-right">
                                    <i class="fa fa-plus"> 新增一箱</i>
                                </a>
                                <input type="hidden" class="form-control box_num" name="box_num[]" value="{{ sizeof($order->box) }}">
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body bg-light box-wrapper">
                                @foreach($order->box as $key => $box)
                                    <div class="form-group box-section border-bottom">
                                        <div class="row">
                                            <h3  class="card-title">運單號{{$box->box_seccode}}</h3>
                                            <a href="javascript:void(0);" class="delete-box btn btn-sm btn-outline-danger ml-3">
                                                <i class="fa fa-times"> 刪除箱子</i>
                                            </a>
                                        </div>
                                        <div class="form-group row">
                                            <div class="form-group col-md-2">
                                                <label for="box_weight">GW 毛重(KG)</label>
                                                <input type="number" class="form-control " name="box_weight[]" id="box_weight" min="0" step="0.1" value="{{$box->box_weight}}">
                                            </div>
                                            <div class="form-group col-md-1 align-self-center">
                                                <label>材積(CM) :</label>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label for="box_length">長</label>
                                                <input type="number" class="form-control" name="box_length[]" id="box_length" min="0" step="0.1" value="{{$box->box_length}}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label for="box_width">寬</label>
                                                <input type="number" class="form-control " name="box_width[]" id="box_width" min="0" step="0.1" value="{{$box->box_width}}">
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label for="box_height">高</label>
                                                <input type="number" class="form-control " name="box_height[]" id="box_height" min="0" step="0.1" value="{{$box->box_height}}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="box_price">箱子費用(未稅)</label>
                                                <input type="number" class="form-control" name="box_price[]" id="box_price" value="{{$box->box_price}}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="tracking_number">宅配單號</label>
                                                <input type="text" class="form-control" name="tracking_number[]" id="tracking_number" value="{{$box->tracking_number}}">
                                            </div>
                                        </div>
                                        <div class="row mb-2 add-item-div">
                                            <h3 class="card-title">裝箱內容</h3>
                                            <a href="javascript:void(0);" class="add-item btn btn-sm btn-outline-secondary ml-3">
                                                <i class="fa fa-plus"> 新增內容</i>
                                            </a>
                                        </div>
                                        <div class="item-wrapper bg-gray-light ">
                                            <input type="hidden" class="box-item-num" name="box_items_num[]" value="{{sizeof($box->boxitems)}}" >
                                            @foreach($box->boxitems as $item )
                                                <div class="form-group row item-section">
                                                    <div class="form-group col-md-3">
                                                        <label for="item_name">商品描述</label>
                                                        <input type="text" class="form-control" name="item_name[]" id="item_name" value="{{$item->item_name}}" placeholder="請填寫英文">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="item_num">數量</label>
                                                        <input type="number" class="form-control" name="item_num[]" id="item_num" value="{{$item->item_num}}">
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="unit_price">單價(USD)</label>
                                                        <input type="number" class="form-control" name="unit_price[]" id="unit_price" min="0" step="0.1" value="{{$item->unit_price}}">
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <a href="javascript:void(0);" class="delete-item btn btn-sm btn-danger ml-3">
                                                            <i class="fa fa-minus"> 刪除</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-2">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">動作</h3>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">送出</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('admin-app-scripts')
    <script type="text/javascript">
        $(document.body).on('click','.add-box',function (){
            let OrderBoxHtml = $('#templateOrderBox').html();
            $('.box-wrapper').append(OrderBoxHtml);
            $(".box-wrapper .box-section").each(function(index, el) {
                var no = index + 1;
                $('.box_num').val(no);
            });
        });
        $(document.body).on('click','.add-item',function (){
            let OrderBoxItemHtml = $('#templateOrderBoxItem').html(),
                $this = $(this), addItem = $this.closest('.add-item-div').siblings('.item-wrapper');
            addItem.append(OrderBoxItemHtml);
            var item_num = 0;
            addItem.children('.item-section').each(function(index, el) {
                item_num ++;
            });
            addItem.children('.box-item-num').val(item_num);
        });
        $(document.body).on('click','.delete-box',function (){
            let $this = $(this), deleteBox = $this.closest('.box-section');
            deleteBox.remove();
            $(".box-wrapper .box-section").each(function(index, el) {
                var no = index + 1;
                $('.box_num').val(no);
            });
        });
        $(document.body).on('click','.delete-item',function (){
            let $this = $(this), deleteItem = $this.closest('.item-section'), itemWrapper = $this.closest('.item-wrapper');
            deleteItem.remove();
            var item_num = 0;
            itemWrapper.children('.item-section').each(function(index, el) {
                item_num ++;
            });
            itemWrapper.children('.box-item-num').val(item_num);
        });
    </script>
    <script type="text/template" id="templateOrderBox">
        @include('admin.orderBoxes.orderBoxTemplate')
    </script>
    <script type="text/template" id="templateOrderBoxItem">
        @include('admin.orderBoxes.orderBoxItemTemplate')
    </script>
@endpush
