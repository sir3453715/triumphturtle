@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.user.index')}}">User</a></li>
                        <li class="breadcrumb-item active">Create User </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-form" class="admin-form" action="{{ route('admin.user.store') }}" method="post">
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
                                        <label for="name">姓名</label>
                                        <input type="text" class="form-control form-required" name="name" id="name" value="{{ old('name') }}" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="email">帳號</label>
                                        <input type="email" class="form-control form-required" name="email" id="email" value="{{ old('email') }}" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="form-group col-md-4">
                                        <label class="field-name" for="password">密碼</label>
                                        <input type="password" id="password form-required" class="form-control" name="password" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="field-name" for="re-password">請再次輸入密碼</label>
                                        <input type="password" id="re-password form-required" class="form-control" name="re_password" value="">
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
                                <h3 class="card-title">Action</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">角色</label>
                                    <select name="users_role" id="users-role" class="form-control select2">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" >{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
