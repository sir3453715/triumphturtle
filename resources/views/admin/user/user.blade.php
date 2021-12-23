@extends('admin.layouts.app')

@section('admin-page-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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
                                    <label for="users-role">Roles</label>
                                    <select name="type" id="users-role" class="form-control ml-3">
                                        <option value="" >all</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{(isset($queried['type']) && $queried['type']==$role->id )?'selected':''}}>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="">email</label>
                                    <input type="text" name="email" class="form-control ml-3" placeholder="email" value="{{(isset($queried['email'])?$queried['email']:'')}}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control">filter</button>
                                </div>
                            </form>
                            <div class="ml-auto">
                                <a href="{{route('admin.user.create')}}"><button type="button" class="btn btn-primary">create</button></a>
                            </div>
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
                                <th style="width: 10px">#</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{ $user->roles->first()->display_name }}</td>
                                        <td class="action form-inline">
                                            <a href="{{route('admin.user.edit',['user'=>$user->id])}}" class="btn btn-sm btn-secondary mr-1">edit</a>
                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator')||\Illuminate\Support\Facades\Auth::user()->hasRole('manager'))
                                            <form action="{{ route('admin.user.destroy', ['user' => $user->id]) }}" method="post" class="form-btn">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger delete-confirm">delete</button>
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
                        {{ $users->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

