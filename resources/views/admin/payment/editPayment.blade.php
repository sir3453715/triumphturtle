@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">訂單 {{ $order->seccode }} 請款單</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.payment.index')}}">帳務管理</a></li>
                        <li class="breadcrumb-item active">請款單</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.payment.update',['payment'=>$order->id]) }}" method="post" >
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
                                <h3 class="card-title">請款單資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body text-center">
                                <div class="form-group row">
                                    <h5>BILL TO</h5>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">Company : {{$order->sender_name}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="seccode">Order No. : {{$order->seccode}}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_taxid">Tax ID : {{$order->sender_taxid}}</label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">Payment Due : {{ date('Y/m/d',strtotime('+5 days')) }}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">Contact : {{$order->sender_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_phone">Phone : {{$order->sender_phone}}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-3"></div>
                                    <div class="form-group col-md-3">
                                        <label for="sender_email">Email : {{$order->sender_email}}</label>
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <h5>Payment detail</h5>
                                    <button type="button" class="ml-2 btn btn-sm btn-outline-primary" id="add-other">增加額外項目</button>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-2">
                                        <label>Product</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Unit</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Country</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Unit Price</label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Total Price</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-2">
                                        <span> Delivery Fee </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span> {{$billing['box_count']}} </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span> box </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span>{{\App\Models\Country::find($billing['sailing']['to_country'])->title}}</span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span> NT${{ number_format($order->sailing->final_price)}} </span>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span> NT${{ number_format($billing['itemTotal']) }} </span>
                                    </div>
                                </div>
                                <div id="other-section">
                                    @if($order->other_price)
                                        @foreach(unserialize($order->other_price) as $other)
                                            <div class="other-wrapper form-group row">
                                                <div class="form-group col-md-2 row">
                                                    <button type="button" class="btn btn-sm btn-outline-danger col-2 mr-2 remove-other">X</button>
                                                    <input type="text" class="form-control col-9" name="other_title[]" id="other_title" value="{{$other['other_title']}}">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="number" class="form-control other-price other-qty" name="other_qty[]"  value="{{$other['other_qty']}}" min="1">
                                                </div>
                                                <div class="form-group col-md-2"></div>
                                                <div class="form-group col-md-2"></div>
                                                <div class="form-group col-md-2">
                                                    <input type="number" class="form-control other-price other-unit" name="other_unit[]" value="{{$other['other_unit']}}" min="0">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <span class="other_total"> NT${{number_format($other['other_qty']*$other['other_unit'])}} </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="other-wrapper form-group row">
                                            <div class="form-group col-md-2 row">
                                                <button type="button" class="btn btn-sm btn-outline-danger col-2 mr-2 remove-other">X</button>
                                                <input type="text" class="form-control col-9" name="other_title[]" id="other_title">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="number" class="form-control other-price other-qty" name="other_qty[]"  min="1">
                                            </div>
                                            <div class="form-group col-md-2"></div>
                                            <div class="form-group col-md-2"></div>
                                            <div class="form-group col-md-2">
                                                <input type="number" class="form-control other-price other-unit" name="other_unit[]" min="0">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <span class="other_total"> NT$0 </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row border-top">
                                    <div class="form-group col-md-8"></div>
                                    <div class="form-group col-md-2">
                                        <label> Subtotal: </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span id="subtotal" data-value="{{$billing['subtotal']}}"> NT${{number_format($billing['subtotal'])}} </span>
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <div class="form-group col-md-8"></div>
                                    <div class="form-group col-md-2">
                                        <small>(不含額外費用)</small>
                                        <br/>
                                        <label> 營業稅5%: </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span> NT${{number_format($order->tax_price)}} </span>
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <div class="form-group col-md-8"></div>
                                    <div class="form-group col-md-2">
                                        <label> Total: </label>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <span id="total" data-value="{{$order->final_price}}"> NT${{number_format($order->final_price)}} </span>
                                    </div>
                                </div>
                                <div class="form-group row border-top">
                                    <h5>匯款資訊</h5>
                                </div>
                                @if($order->invoice != 1)
                                <div class="form-group row text-left">
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">國泰世華銀行 013</label>
                                    </div>
                                </div>
                                <div class="form-group row text-left">
                                    <div class="form-group col-md-3">
                                        <label for="sender_taxid">帳號 220-03-500712-1</label>
                                    </div>
                                </div>
                                <div class="form-group row text-left">
                                    <div class="form-group col-md-3">
                                        <label for="sender_name">戶名：凱漩國際有限公司</label>
                                    </div>
                                </div>
                                @else
                                    <div class="form-group row text-left">
                                        <div class="form-group col-md-3">
                                            <label for="sender_name">國泰013</label>
                                        </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="form-group col-md-3">
                                            <label for="sender_taxid">帳號: 017589515170</label>
                                        </div>
                                    </div>
                                    <div class="form-group row text-left">
                                        <div class="form-group col-md-3">
                                            <label for="sender_name">蔡宜茵</label>
                                        </div>
                                    </div>
                                @endif
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
    <script type="text/template" id="other-template">
        <div class="other-wrapper form-group row">
            <div class="form-group col-md-2 row">
                <button type="button" class="btn btn-sm btn-outline-danger col-2 mr-2 remove-other">X</button>
                <input type="text" class="form-control col-9" name="other_title[]" >
            </div>
            <div class="form-group col-md-2">
                <input type="number" class="form-control other-price other-qty" name="other_qty[]"  min="1">
            </div>
            <div class="form-group col-md-2"></div>
            <div class="form-group col-md-2"></div>
            <div class="form-group col-md-2">
                <input type="number" class="form-control other-price other-unit" name="other_unit[]" min="0">
            </div>
            <div class="form-group col-md-2">
                <span class="other_total"> NT$0 </span>
            </div>
        </div>
    </script>
    <script type="text/javascript">
        $(document.body).on('change','.other-price',function (){
            priceCount();
        });
        $(document.body).on('click','#add-other',function (){
            let otherTemplate = $('#other-template').text();
            $('#other-section').append(otherTemplate);
        });
        $(document.body).on('click','.remove-other',function (){
            $(this).closest('.other-wrapper').remove();
            priceCount();
        });
        function priceCount(){
            let subTotal = Math.round($('#subtotal').data('value'));
            let total = Math.round($('#total').data('value'));
            let otherCount = 0;
            $('.other-wrapper').each(function (index){
                let thisOtherPrice = Math.round($(this).find('.other-qty').val() ) * Math.round($(this).find('.other-unit').val());
                otherCount += thisOtherPrice;
                $(this).find('.other_total').html('NT$'+thisOtherPrice);
            });
            $('#subtotal').html('NT$'+ parseInt(subTotal+otherCount).toLocaleString());
            $('#total').html('NT$'+parseInt(total+otherCount).toLocaleString());
        }
    </script>
@endpush
