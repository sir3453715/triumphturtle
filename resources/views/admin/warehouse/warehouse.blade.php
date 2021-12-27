@extends('admin.layouts.app')

@section('admin-page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">倉庫管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">倉庫管理</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col d-flex p-lg-1">
                    <div class="ml-auto">
                        <a href="{{route('admin.warehouse.create')}}"><button type="button" class="btn btn-primary">建立</button></a>
                    </div>
                </div>
            </div>
            <!-- Main row -->
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>倉庫名稱</th>
                                <th>國家</th>
                                <th>電話</th>
                                <th>地址</th>
                                <th style="width: 15%">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($warehouses as $warehouse)
                                    <tr>
                                        <td>{{$warehouse->title}}</td>
                                        <td>{{$warehouse->countryTitle->title}}</td>
                                        <td>{{$warehouse->phone}}</td>
                                        <td>{{$warehouse->address}}</td>
                                        <td class="action form-inline">
                                            <a href="{{route('admin.warehouse.edit',['warehouse'=>$warehouse->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator')||\Illuminate\Support\Facades\Auth::user()->hasRole('manager'))
                                            <form action="{{ route('admin.warehouse.destroy', ['warehouse' => $warehouse->id]) }}" method="post" class="form-btn">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger delete-confirm">刪除</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $warehouses->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

