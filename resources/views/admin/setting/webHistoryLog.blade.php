@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">History Log</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">History Log </li>
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
                    <!-- ./row -->
                    <div class="card-header p-0 pl-1 pt-2">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link tab-item {{($current_tab=='login-log' || $current_tab=='')?'active':''}} " id="custom-tabs-one-login-log-tab" data-toggle="pill" data-value="login-log" href="#custom-tabs-one-login-log" role="tab" aria-controls="custom-tabs-one-login-log" aria-selected="true">Login Log (僅顯示前25筆)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-item {{($current_tab=='action-log')?'active':''}} " id="custom-tabs-one-action-log-tab" data-toggle="pill" data-value="action-log" href="#custom-tabs-one-action-log" role="tab" aria-controls="custom-tabs-one-action-log" aria-selected="false">Activity History Log</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade {{($current_tab=='login-log' || $current_tab=='')?'active show':''}}" id="custom-tabs-one-login-log" role="tabpanel" aria-labelledby="custom-tabs-one-login-log-tab">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>IP</th>
                                        <th>result</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($login_log as $login)
                                        <tr>
                                            <td>
                                                @if($login->user)
                                                    <a href="{{route('admin.user.edit',['user'=>$login->user->id])}}" target="_blank">
                                                        {{$login->user->name}}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$login->IP}}</td>
                                            <td>{{$login->result}}</td>
                                            <td>{{$login->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade {{($current_tab=='action-log')?'active show':''}} " id="custom-tabs-one-action-log" role="tabpanel" aria-labelledby="custom-tabs-one-action-log-tab">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Action Table</th>
                                        <th>Action</th>
                                        <th>Change Column</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($action_log as $action)
                                        <tr>
                                            <td>
                                                @if($action->user)
                                                    <a href="{{route('admin.user.edit',['user'=>$action->user->id])}}" target="_blank">
                                                        {{$action->user->name}}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$action->action_table}}</td>
                                            <td>{{$action->action}}</td>
                                            <td>
                                                <span class="dropright">
                                                    <a data-toggle="dropdown" href="#">
                                                        <i class="fa fa-info-circle"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xl">
                                                        <div>
                                                            <ul class="list-group">
                                                            @foreach(json_decode($action->change_column) as $key => $change_item )
                                                                <li class="list-group-item">{!! $key  !!} => {!! $change_item  !!}</li>
                                                            @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </span>
                                            </td>
                                            <td>{{$action->created_at}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $action_log->appends(request()->except('page'))->links() }}

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection


@push('admin-app-scripts')
    <script type="text/javascript">
        $(document.body).on('click','.tab-item',function (){
            let $tab = $(this).attr('data-value');
            window.history.pushState('','','?tab='+$tab);
            $('.page-link').each((index, ele)=> {
                let $href = $(ele).attr('href');
                $(ele).attr('href',$href.replace('login-log','action-log'));
            });


        });
    </script>
@endpush
