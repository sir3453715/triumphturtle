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
            <div class="card card-default color-palette-box">
                <div class="card-body">
                    <div class="row">
                        <div class="col d-flex filter-form">
                            <form class="form-inline filter">
                                <div class="form-group mr-3">
                                    <label for="">更動ID</label>
                                    <input type="text" name="id" class="form-control ml-3" placeholder="id" value="{{(isset($queried['id'])?$queried['id']:'')}}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control">篩選</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
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
                                        <a data-toggle="collapse" class="btn btn-warning" href="#detail-{{$action->id}}" role="button" aria-expanded="false" aria-controls="detail-{{$action->id}}">檢視詳細</a>
                                    </td>
                                    <td>{{$action->created_at}}</td>
                                </tr>
                                <tr class="collapse" id="detail-{{$action->id}}">
                                    <td colspan="6">
                                        <div class="row col-12">
                                            @foreach(json_decode($action->change_column) as $key => $change_item )
                                                @if(is_numeric($key))
                                                    <div class="col-2 border text-lg">{!! $key+1  !!}. {!! $change_item  !!}</div>
                                                @else
                                                    <div class="col-2 border text-lg">{!! $key  !!}: {!! $change_item  !!}</div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix row">
                        <div class="col">
                            {{ $action_log->appends(request()->except('page'))->links() }}
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
