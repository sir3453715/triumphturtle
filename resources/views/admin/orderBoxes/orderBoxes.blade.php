@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">訂單裝箱列表</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">訂單裝箱列表</li>
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
                                        <label for="sailing_id">船期</label>
                                        <select class="form-control ml-3 select2" name="sailing_id" id="sailing_id" >
                                            <option value="">請選擇</option>
                                            @foreach($sailings as $sailing)
                                                <option value="{{$sailing->id}}" {!! $html->selectSelected($sailing->id,$queried['sailing_id']) !!}>{{$sailing->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="from_country">出口國家</label>
                                        <select class="form-control ml-3 select2" name="from_country" id="from_country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {!! $html->selectSelected($country->id,$queried['from_country']) !!}>{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="seccode">訂單編號</label>
                                        <input type="text" name="seccode" class="form-control ml-3" value="{{(isset($queried['seccode'])?$queried['seccode']:'')}}">
                                    </div>
                                    <div class="form-group mr-3">
                                        <label for="sender">主寄件人</label>
                                        <input type="text" name="sender" class="form-control ml-3" placeholder="姓名，電話，信箱" value="{{(isset($queried['sender'])?$queried['sender']:'')}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2 mt-2">
                                    <div class="form-group">
                                        <button type="submit" class="form-control">篩選</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ml-auto">
                            <a href="{{route('admin.user.create')}}"><button type="button" class="btn btn-primary">建立</button></a>
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
                                <th>船期</th>
                                <th>出口國家</th>
                                <th>主寄件人</th>
                                <th>訂單金額</th>
                                <th>總箱數</th>
                                <th>集貨人數</th>
                                <th>裝箱單</th>
                                <th>主揪連結</th>
                                <th>驗證碼</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->serial_number}}</td>
                                        <td>{{$order->sailing->title}}</td>
                                        <td>{{$order->sailing->fromCountry->title}}</td>
                                        <td>{{$order->sender_name}}</td>
                                        <td>{{$order->boxListData()['price']}}</td>
                                        <td>{{$order->boxListData()['box_count']}}</td>
                                        <td>{{$order->boxListData()['person']}}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-info ">
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if($order->type == 2)
                                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-info copy" data-link="https://google.com">
                                                    <i class="fa fa-copy"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->type == 2)
                                                {{$order->captcha}}
                                            @endif
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
    </script>
@endpush

