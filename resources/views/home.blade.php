@extends('layouts.app')

@section('content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
<div class="main-wrapper" id="home-page">
  <section class="main-slider">
    <div class="slide-item">
        <img class="d-none d-md-block" src="/storage/image/slide-1.jpg" alt="">
        <img class="d-block d-md-none" src="/storage/image/slide-1-mb.jpg" alt="">
        <div class="slide-caption-wrapper">
             <div class="slide-caption">
            <h1>海龜集運</h1>
            <h2 class="deco-line">TRIUMPH TURTLE</h2>
            <p>突破海運的限制!!<br>首創揪團集運平台</p>
            <a class="btn btn-lg btn-solid btn-green" href="{{route('location')}}">查詢倉庫位置</a>
          </div>
        </div>
    </div>
  </section>

  <section class="container p-0 mb-5">
    <div id="search-bar" class="mx-3 mx-md-0">
      <form action="" method="GET">
        <div class="row cus-form justify-content-center">
          <div class="col-md-4">
            <!-- 請選擇出發國家 -->
            <select class="form-control form-control-lg" name="from_country">
              <option value="" hidden>請選擇出發國家</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" {!! $html->selectSelected($country->id,$queried['from_country']) !!}>{{$country->title}}-{{$country->en_title}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-1 center-center my-2 my-md-0">
            <i class="fas fa-long-arrow-alt-right d-none d-md-block"></i>
            <i class="fas fa-long-arrow-alt-down d-block d-md-none"></i>
          </div>
          <div class="col-md-4">
            <!-- 請選擇目的國家 -->
            <select class="form-control form-control-lg" name="to_country">
                <option value="" hidden>請選擇出發國家</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}" {!! $html->selectSelected($country->id,$queried['to_country']) !!}>{{$country->title}}-{{$country->en_title}}</option>
                @endforeach
            </select>
          </div>
          <div class="text-center col-md-2">
            <button type="submit" class="btn btn-lg btn-solid btn-orange w-100 mt-3 mt-md-0">搜尋</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="container" id="shipment">
    <div class="row shipment">
    @foreach($sailings as $sailing)
        <div class="col-12 col-lg-6 col-xl-4 my-4 px-3 px-md-2">
            <div class="card {{($sailing->status == 1)?'':'card-disabled'}}">
                <div class="card-top">
                  <div class="data-header">
                    <div class="data-header-top">
                      <img class="img-circle" src="/storage/image/shipment-icon.svg" alt="">
                      <div>
                        <div class="data-header-title cus-row">
                          <p>{{$sailing->title}}</p>
                            {!! $html->sailingStatus($sailing->status) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="detail-info">
                    <p class="mb-3">
                        <span class="data-label">成團單價:</span>
                        <span class="unit-price">NT$ {{number_format($sailing->price)}}</span> / 箱
                    </p>
                      {!! $html->sailingPrice($sailing) !!}
                  </div>
                </div>
                <hr>
                <div class="card-bottom">
                  <div class="data-content">
                    <div class="data-content-item">
                      <p class="item-label">結單時間</p>
                      <p class="item-date">{{date('m / d',strtotime($sailing->statement_time))}}</p>
                    </div>
                    <div class="center-center my-2 my-md-0">
                      <i class="fas fa-long-arrow-alt-right"></i>
                    </div>
                    <div class="data-content-item">
                      <p class="item-label">包裹進倉<br>截止日</p>
                        <p class="item-date">{{date('m / d',strtotime($sailing->parcel_deadline))}}</p>
                    </div>
                    <div class="center-center my-2 my-md-0">
                      <i class="fas fa-long-arrow-alt-right"></i>
                    </div>
                    <div class="data-content-item">
                      <p class="item-label">抵達目的地<br>倉庫</p>
                        <p class="item-date">{{date('m / d',strtotime($sailing->arrival_date))}}</p>
                    </div>
                  </div>
                    @if($sailing->status == 1)
                        <a href="{{route('option',['id'=>$sailing->id])}}" class="btn btn-lg btn-solid btn-blue btn-block mt-4">來去揪團</a>
                    @else
                        <button type="button" class="btn btn-lg btn-solid btn-blue btn-block mt-4">已結單，下次請早</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <!-- Pagination -->
      {{ $sailings->appends(request()->except('page'))->links() }}
  </section>

  <section class="container d-grid mb-5">
    <div class="display-box display-box-outline display-box-down m-auto"><img src="/storage/image/steps.svg" alt=""><h2>作業流程說明</h2></div>
    <div class="border-box">
      <img class="img-fluid d-none d-md-block" src="/storage/image/process-step.svg" alt="">
      <img class="img-fluid d-block d-md-none" src="/storage/image/process-step-mb.svg" alt="">
    </div>
  </section>

</div>
@endsection

@push('app-scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.page-link', function(event){
                event.preventDefault();
                var parameter = $(this).attr('href').split('?')[1];
                ajaxSailingData(parameter);
            });
            function ajaxSailingData(parameter)
            {
                $.ajax({
                    url:"/ajaxSailingData?"+parameter,
                    success:function(data)
                    {
                        $('#shipment').html('');
                        $('#shipment').html(data);
                        $('html,body').animate({
                            scrollTop:$("#search-bar").offset().top-100
                        },600);
                    }
                });
            }

        });
    </script>
@endpush
