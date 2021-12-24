@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">路由列表</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">路由列表</li>
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
                    <table id="example2" class="table table-bordered table-hover table-dark">
                        <thead>
                        <tr>
                            <th class="method desktop tablet-l tablet-p mobile-l mobile-p" data-priority="1">Method</th>
                            <th class="uri desktop tablet-l tablet-p mobile-l mobile-p" data-priority="1">URI</th>
                            <th class="name desktop tablet-l tablet-p" data-priority="3">Name</th>
                            <th class="action desktop tablet-l" data-priority="4">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($routes as $route)
                            <tr>
                                <td class="method">
                                    @foreach($route['methods'] as $method)
                                        @switch(strtolower($method))
                                            @case('get')
                                                <span class="badge badge-success" role="alert">{{$method}}</span>
                                                @break
                                            @case('post')
                                                <span class="badge badge-primary" role="alert">{{$method}}</span>
                                                @break
                                            @case('put')
                                            @case('patch')
                                                <span class="badge badge-warning" role="alert">{{$method}}</span>
                                                @break
                                            @case('delete')
                                                <span class="badge badge-danger" role="alert">{{$method}}</span>
                                                @break
                                        @endswitch
                                        {!! ($method != 'HEAD')?'<br/>':'' !!}
                                    @endforeach
                                </td>
                                <td class="uri">
                                    @if(in_array('GET', $route['methods']))
                                        <a href="/{{ ltrim( $route['uri'], '/') }}" class="font-weight-bold text-break" target="_blank">{{ $route['uri'] }}</a>
                                    @else
                                        <span class="font-weight-bold text-break">{{ $route['uri'] }}</span>
                                    @endif
                                </td>
                                <td class="name">{{ $route['name'] }}</td>
                                <td class="action">
                                    <span class="controller text-break">{{ $route['action']['controller'] }}</span>@<span class="method text-info text-break">{{ $route['action']['method'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>


@endsection
