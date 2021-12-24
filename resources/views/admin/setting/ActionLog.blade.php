@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">操作紀錄</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">操作紀錄 </li>
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
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>操作者</th>
                                <th>更動資料表</th>
                                <th>更動ID</th>
                                <th>動作</th>
                                <th>更動項目</th>
                                <th>時間</th>
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
                                    <td>{{$action->action_id}}</td>
                                    <td>{{trans('admin.action.'.$action->action)}}</td>
                                    <td>
                                        <span class="dropright">
                                            <a data-toggle="dropdown" href="#">
                                                <i class="fa fa-info-circle"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl">
                                                <div>
                                                    <ul class="list-group">
                                                        @foreach(json_decode($action->change_column) as $key => $change_item )
                                                            @if(is_numeric($key))
                                                                <li class="list-group-item">{!! $key+1  !!}. {!! $change_item  !!}</li>
                                                            @else
                                                                <li class="list-group-item">{!! $key  !!}: {!! $change_item  !!}</li>
                                                            @endif
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
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        {{ $action_log->appends(request()->except('page'))->links() }}
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
