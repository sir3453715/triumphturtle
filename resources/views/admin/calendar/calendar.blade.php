@extends('admin.layouts.app')


@push('admin-app-styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.css" rel="stylesheet">
@endpush

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Calendar</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row slider">
                <div class="col-lg-10 col-12 bg-white">
                    <div id="calendar">
                        @foreach($calendars as $calendar)
                            <div class="calendar-event" data-id="{{$calendar->id}}" data-title="{{$calendar->get_title_with_member()}}" data-show="{{$calendar->title}}" data-member="{{$calendar->member}}" data-start="{{$calendar->start_time}}" data-end="{{$calendar->end_time}}" data-description="{{$calendar->description}}" data-color="{{$calendar->color}}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-2 col-4">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddEvent">
                        新增活動
                    </button>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <div class="col-lg-3">
        <div class="model-menu mt-4">
            <div class="modal fade" id="AddEvent">
                <form id="admin-form" class="admin-form" action="{{ route('admin.calendar.store') }}" method="post">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">新增活動</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="form-group col-md-6">
                                        <label for="start_time">起始時間</label>
                                        <input type="date" class="form-control" name="start_time" id="start_time" >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_time">結束時間</label>
                                        <input type="date" class="form-control" name="end_time" id="end_time">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="member">人員</label>
                                        <select id="member" name="member" class="form-control">
                                            <option value="no">無</option>
                                            <option value="all">所有人</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="title">標題</label>
                                        <input type="text" class="form-control" name="title" id="title">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="color">顏色</label>
                                        <input type="color" class="form-control" name="color" id="color">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description">概述</label>
                                        <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="reset"  class="btn btn-secondary reset">重製</button>
                                <button type="submit" class="btn btn-primary">送出</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="model-menu mt-4">
            <div class="modal fade" id="UpdateEvent">
                <form id="admin-form" class="admin-form" action="{{ route('admin.calendar.update',['calendar'=>'1']) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">修改活動</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group row">
                                    <input type="hidden" class="form-control" name="id" id="edit_id" >
                                    <div class="form-group col-md-6">
                                        <label for="start_time">起始時間</label>
                                        <input type="date" class="form-control" name="start_time" id="edit_start_time" >
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_time">結束時間</label>
                                        <input type="date" class="form-control" name="end_time" id="edit_end_time">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="member">人員</label>
                                        <select id="edit_member" name="member" class="form-control">
                                            <option value="no">無</option>
                                            <option value="all">所有人</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="title">標題</label>
                                        <input type="text" class="form-control" name="title" id="edit_title">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="color">顏色</label>
                                        <input type="color" class="form-control" name="color" id="edit_color">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description">概述</label>
                                        <textarea class="form-control" rows="3" id="edit_description" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger remove-event">刪除</button>
                                <button type="reset" class="btn btn-secondary reset">重製</button>
                                <button type="submit" class="btn btn-primary">送出</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('admin-app-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.3/dist/locale-all.js"></script>
    <script type="text/javascript">
        let events = [];
        $('.calendar-event').each(function (index) {
            var single = {
                id:$(this).data('id'),
                start:$(this).data('start')+'T00:00:00',
                end:$(this).data('end')+'T23:59:59',
                title:$(this).data('title'),
                show:$(this).data('show'),
                description:$(this).data('description'),
                member:$(this).data('member'),
                color:$(this).data('color'),
            };
            events.push(single);
        });
        $('#calendar').fullCalendar({
            locale: 'zh-tw',
            editable: true,
            displayEventTime: false,
            events: events,
            eventRender: function(info, element) {
                $(element).tooltip({title: info.description});
            },
            dayClick: function(date, event, view) {
                $('#start_time').val(date.format('YYYY-MM-DD'));
                $('#end_time').val(date.format('YYYY-MM-DD'));
                $('#AddEvent').modal();
            },
            eventClick: function(info) {
                $('.reset').click();
                $('#edit_id').val(info.id);
                $('#edit_start_time').val(info.start.format('YYYY-MM-DD'));
                $('#edit_end_time').val(info.end.format('YYYY-MM-DD'));
                $('#edit_member').val(info.member);
                $('#edit_title').val(info.show);
                $('#edit_color').val(info.color);
                $('#edit_description').val(info.description);
                $('#UpdateEvent').modal();
            },
            eventDrop: function(event, delta, revertFunc) {
                let start = event.start.format('YYYY-MM-DD');
                let end = (event.end)?event.end.format('YYYY-MM-DD'):event.start.format('YYYY-MM-DD');
                $.ajax({
                    type:"POST",
                    url:"./calendar/changeEventDate",
                    dataType:"json",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': event.id,
                        'start': start,
                        'end': end,
                    },success:function(object){
                        if (object == '1'){
                            alert(event.title+'已成功修改');
                        }
                    }
                });
            }
        });

        $(document.body).on('click','.remove-event',e => {
            e.preventDefault();
            let code = '';
            var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            for (var x = 0; x < 10; x++) {
                var i = Math.floor(Math.random() * chars.length);
                code += chars.charAt(i);
            }
            if(prompt('注意！目前將刪除所選擇項目，此操作無法回覆。 如果仍要繼續動作，請輸入以下代碼： ' + code ) === code) {
                $.ajax({
                    type:"POST",
                    url:"./calendar/EventDelete",
                    dataType:"json",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $('#edit_id').val(),
                    },success:function(object){
                        if (object == '1'){
                            alert('活動已成功刪除!');
                            $('#calendar').fullCalendar('removeEvents', $('#edit_id').val());
                            $('#UpdateEvent').modal('hide');
                        }else{
                            alert('活動無法刪除!請洽工程人員!');
                            $('#UpdateEvent').modal('hide');
                        }
                    }
                });
            }
        });
    </script>
@endpush


