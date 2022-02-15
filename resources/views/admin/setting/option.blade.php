@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">一般設定</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">一般設定</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-edit-form" class="admin-form" action="{{ route('admin.option.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-md-10">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">設定資料</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @inject('html', 'App\Presenters\Admin\OptionFormFieldsPresenter')
                            {!! $html->render() !!}
                            <div class="form-group row">
                                <div class="col-12 col-md-2">
                                    <label for="option-banner">首頁Banner(電腦版)</label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="file" class="form-control-file" name="banner" id="option-banner" >
                                    @if(app('Option')->banner)
                                        <img src="{{app('Option')->banner}}" width="300px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-md-2">
                                    <label for="option-banner">首頁Banner(手機板)</label>
                                </div>
                                <div class="col-12 col-md-10">
                                    <input type="file" class="form-control-file" name="banner_mb" id="option-banner" >
                                    @if(app('Option')->banner_mb)
                                        <img src="{{app('Option')->banner_mb}}" width="100px">
                                    @endif
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
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">儲存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
@endsection
