@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">登入紀錄</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">登入紀錄 </li>
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
                                <th>姓名</th>
                                <th>信箱</th>
                                <th>IP</th>
                                <th>結果</th>
                                <th>時間</th>
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
                                    <td>
                                        @if($login->user)
                                            {{$login->user->email}}
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
                    <!-- /.card-body -->
                    <div class="card-footer clearfix row">
                        <div class="col">
                            {{ $login_log->appends(request()->except('page'))->links() }}
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
