@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">建立航班</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.sailing-schedule.index')}}">航班管理</a></li>
                        <li class="breadcrumb-item active">建立航班</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.sailing-schedule.store') }}" method="post">
        @csrf
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
                                    <div class="form-group col-md-6">
                                        <label for="title">航班名稱</label>
                                        <input type="text" class="form-control form-required" name="title" id="title" >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="status">狀態</label>
                                        <select class="form-control form-required" name="status" id="status" >
                                            <option value="">請選擇</option>
                                            <option value="1">集貨中</option>
                                            <option value="2">準備中</option>
                                            <option value="3">開航中</option>
                                            <option value="4">抵達目的地倉庫</option>
                                            <option value="5">取消</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="from_country">Form國家</label>
                                        <select class="form-control form-required" name="from_country" id="from_country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="to_country">To國家</label>
                                        <select class="form-control form-required" name="to_country" id="to_country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="statement_time">結單時間</label>
                                        <input type="date" id="statement_time" name="statement_time" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="parcel_deadline">包裹截止日</label>
                                        <input type="date" id="parcel_deadline" name="parcel_deadline" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sailing_date">開船日</label>
                                        <input type="date" id="sailing_date" name="sailing_date" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="arrival_date">抵達目的地倉庫日</label>
                                        <input type="date" id="arrival_date" name="arrival_date" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="price">原價</label>
                                        <input type="text" id="price" name="price" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="minimum">低消(箱數)</label>
                                        <input type="text" id="minimum" name="minimum" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="box_interval">箱數級距</label>
                                        <input type="text" id="box_interval" name="box_interval" class="form-control form-required">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="discount">折扣</label>
                                        <input type="text" id="discount" name="discount" class="form-control form-required">
                                    </div>
                                </div>
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
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="on_off">上/下架</label>
                                    <select class="form-control form-required" name="on_off" id="on_off" >
                                        <option value="1">下架</option>
                                        <option value="2" selected>上架</option>
                                    </select>
                                </div>
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
