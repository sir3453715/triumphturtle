@extends('admin.layouts.app')

@section('admin-page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Import & Export</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Import & Export </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <div class="d-flex">
                                            <h3>Import</h3>
                                            <a class="ml-auto" href="{{url('/storage/files/import-demo.xlsx')}}" target="_blank"><button class="btn btn-danger">匯入範本</button></a>
                                        </div>
                                        <span>
                                            <form id="admin-import-form" class="admin-form" action="{{ route('admin.import-export.import') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <input class="form-control bg-success col-9" type="file" name="file" id="file">
                                                    <button type="submit" class="btn btn-primary ml-3">送出</button>
                                                </div>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>Export</h3>
                                        <span>
                                            <form id="admin-export-form" class="admin-form" action="{{ route('admin.import-export.export') }}" method="post" target="_blank">
                                                @csrf
                                                <button type="submit" class="btn btn-primary ml-3">匯出</button>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>Mail Test</h3>
                                        <span>
                                            <form id="admin-send-form" class="admin-form" action="{{ route('admin.import-export.sendmail') }}" method="post" >
                                                @csrf
                                                <div class="form-inline">
                                                    <input name="mail" class="form-control col-8" placeholder="輸入收件信箱">
                                                    <button type="submit" class="btn btn-primary ml-3">發送</button>
                                                </div>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(is_array($import_data))
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="card">
                                    <div class="card-header">{{ '匯入結果' }}</div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>name</th>
                                                <th>phone</th>
                                                <th>email</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($import_data as $data)
                                                <tr>
                                                    <td>{{$data['id']}}</td>
                                                    <td>{{$data['name']}}</td>
                                                    <td>{{$data['phone']}}</td>
                                                    <td>{{$data['email']}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
