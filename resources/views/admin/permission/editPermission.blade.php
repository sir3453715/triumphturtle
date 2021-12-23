@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Role : {{$role->display_name}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.permission.index')}}">Permissions</a></li>
                        <li class="breadcrumb-item active">Edit Role </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="admin-edit-form" class="admin-form" method="post" action="{{route('admin.permission.update', [$role->id])}}">
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
                            <h3 class="card-title">Form Fields Data</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input custom-control-input-danger" type="checkbox" name="permissions[]" id="role-{{$permission->id}}" value="{{$permission->name}}" {{($role->hasPermissionTo($permission->name))?'checked':''}}>
                                                <label for="role-{{$permission->id}}" class="custom-control-label">{{$permission->display_name}}</label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
@endsection
