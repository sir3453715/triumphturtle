@extends('admin.layouts.app')

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">航班管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">首頁</a></li>
                        <li class="breadcrumb-item active">航班管理</li>
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
                        <div class="col filter-form">
                            <form class="form-inline filter">
                                <div class="form-group row col-12">
                                    <div class="form-group col-2">
                                        <label for="from_country">From國家</label>
                                        <select class="form-control ml-3 col-12 select2" name="from_country" id="from_country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {!! $html->selectSelected($country->id,$queried['from_country']) !!}>{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="to_country">To國家</label>
                                        <select class="form-control ml-3 col-12 select2" name="to_country" id="to_country" >
                                            <option value="">請選擇</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" {!! $html->selectSelected($country->id,$queried['to_country']) !!}>{{$country->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="status">狀態</label>
                                        <select class="form-control ml-3 col-12" name="status" id="status" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['status']) !!}>集貨中</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['status']) !!}>準備中</option>
                                            <option value="3" {!! $html->selectSelected(3,$queried['status']) !!}>開航中</option>
                                            <option value="4" {!! $html->selectSelected(4,$queried['status']) !!}>抵達目的地倉庫</option>
                                            <option value="5" {!! $html->selectSelected(5,$queried['status']) !!}>取消</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="on_off">上/下架</label>
                                        <select class="form-control ml-3 col-12" name="on_off" id="on_off" >
                                            <option value="">請選擇</option>
                                            <option value="1" {!! $html->selectSelected(1,$queried['on_off']) !!}>下架</option>
                                            <option value="2" {!! $html->selectSelected(2,$queried['on_off']) !!}>上架</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="statement_time">結單時間</label>
                                        <input type="date" name="statement_time" class="form-control ml-3 col-12" value="{{(isset($queried['statement_time'])?$queried['statement_time']:'')}}">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="sailing_date">開船日</label>
                                        <input type="date" name="sailing_date" class="form-control ml-3 col-12" value="{{(isset($queried['sailing_date'])?$queried['sailing_date']:'')}}">
                                    </div>
                                </div>
                                <div class="form-group row ml-2 mt-2">
                                    <div class="form-group">
                                        <button type="submit" class="form-control">篩選</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ml-auto">
                            <a href="{{route('admin.sailing-schedule.create')}}"><button type="button" class="btn btn-primary">建立</button></a>
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
                                <th>船班名稱</th>
                                <th>狀態</th>
                                <th>上/下架</th>
                                <th>From 國家</th>
                                <th>To 國家</th>
                                <th>結單時間</th>
                                <th>包裹截止日</th>
                                <th>開船日</th>
                                <th>原價</th>
                                <th>低消(箱數)</th>
                                <th>箱數級距</th>
                                <th>折扣</th>
                                <th style="width: 15%">動作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sailings as $sailing)
                                    <tr>
                                        <td>{{$sailing->id}}</td>
                                        <td>{{$sailing->title}}</td>
                                        <td>
                                            @switch($sailing->status)
                                                @case(1)
                                                <span class="fa-1x badge badge-secondary">集貨中</span>
                                                @break
                                                @case(2)
                                                <span class="fa-1x badge badge-info">準備中</span>
                                                @break
                                                @case(3)
                                                <span class="fa-1x badge badge-warning">開航中</span>
                                                @break
                                                @case(4)
                                                <span class="fa-1x badge badge-success">抵達目的地倉庫</span>
                                                @break
                                                @case(5)
                                                <span class="fa-1x badge badge-danger">取消</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($sailing->on_off == '2')
                                                <span class="fa-1x badge badge-success">上架</span>
                                            @else
                                                <span class="fa-1x badge badge-danger">下架</span>
                                            @endif
                                        </td>
                                        <td>{{($sailing->fromCountry)?$sailing->fromCountry->title:'國家已移除'}}</td>
                                        <td>{{($sailing->toCountry)?$sailing->toCountry->title:'國家已移除'}}</td>
                                        <td>{{$sailing->statement_time}}</td>
                                        <td>{{$sailing->parcel_deadline}}</td>
                                        <td>{{$sailing->sailing_date}}</td>
                                        <td>{{$sailing->price}}</td>
                                        <td>{{$sailing->minimum}}</td>
                                        <td>{{$sailing->box_interval}}</td>
                                        <td>{{$sailing->discount}}</td>
                                        <td class="action form-inline">
                                            <a href="{{route('admin.sailing-schedule.edit',['sailing_schedule'=>$sailing->id])}}" class="btn btn-sm btn-secondary mr-1">修改</a>
                                            @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator')||\Illuminate\Support\Facades\Auth::user()->hasRole('manager'))
                                            <form action="{{ route('admin.sailing-schedule.destroy', ['sailing_schedule' => $sailing->id]) }}" method="post" class="form-btn">
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
                        {{ $sailings->appends(request()->except('page'))->links() }}
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection

