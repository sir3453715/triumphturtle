@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">建立倉庫</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.warehouse.index')}}">倉庫管理</a></li>
                        <li class="breadcrumb-item active">建立倉庫</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.warehouse.store') }}" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group col-md-4">
                                        <label for="title">倉庫名稱</label>
                                        <input type="text" class="form-control form-required" name="title" id="title" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="country">國家</label>
                                        <select class="form-control form-required select2" name="country" id="country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" >{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="img">圖片</label>
                                        <input type="file" class="form-control-file" name="img" id="img" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="for_name">收件者名稱</label>
                                        <input type="text" class="form-control form-required" name="for_name" id="for_name" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="phone">電話</label>
                                        <input type="text" class="form-control form-required" name="phone" id="phone" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="note">當地宅配資訊</label>
                                        <input type="text" class="form-control" name="local" id="local">
                                    </div>
                                    <div class="form-group col-md-8">
                                        <label for="address">地址</label>
                                        <input type="text" class="form-control form-required" name="address" id="address" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="link">紙箱購買連結</label>
                                        <input type="text" class="form-control" name="link" id="link" >
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
