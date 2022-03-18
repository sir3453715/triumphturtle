@extends('layouts.app')

@section('content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
<div class="main-wrapper">
  <section id="tracking-page">
    <div class="container">
      <div class="cus-grid">
        <div class="display-box display-box-outline">
          <div class="d-flex align-items-center">
            <img src="/storage/image/location-icon.svg" alt="">
            <h2>訂單查詢</h2>
          </div>
          <form class="mt-5" >
            <input class="form-control form-control-lg" type="text" name="keyword" id="keyword" placeholder="輸入訂單編號 或 寄件人門號" value="{{$queried['keyword']}}">
            <button class="btn btn-lg btn-solid btn-orange btn-block mt-4" type="submit">搜尋</button>
          </form>

        </div>
          <!-- ==== 當無資料時顯示 ==== -->
          @if(!$orders)
            <div class="edit-box">
                <div class="info-text">
                    <p>請搜尋訂單查詢或更改資料</p>
                </div>
            </div>
          @else
              @if(sizeof($orders)!=0)
                  <div class="shipment">
                      @foreach($orders as $order)
                          <div class="card mb-2">
                              <div class="card-top">
                                  <div class="data-header">
                                      <div class="data-header-top">
                                          <img class="img-circle" src="/storage/image/list-icon.svg" alt="">
                                          <div>
                                              <div class="data-header-title cus-row">
                                                  <p>訂單編號</p>
                                                  <span class="cus-badge cus-badge-dark-gray">{{$order->seccode}}</span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="detail-info detail-info-grid">
                                      <p class="mb-3"><span class="data-label">寄件人:</span>{{$order->sender_name}}</p>
                                      <p class="mb-3"><span class="data-label">船期狀態:</span>{!! $html->orderStatus($order,'sailing_status') !!}</p>
                                      <p class="mb-3"><span class="data-label">訂單狀態:</span>{!! $html->orderStatus($order,'order_status') !!}</p>
                                      <p class="mb-3"><span class="data-label">付款狀態:</span>{!! $html->orderStatus($order,'pay_status') !!}</p>
                                      <p class="mb-3"><span class="data-label">總箱數:</span>{{count($order->box)}}箱</p>
                                  </div>
                              </div>
                              <hr>
                              <div class="card-bottom detail-info">
                                  <p class="mb-3"><span class="data-label">收件人:</span>{{$order->for_name}}</p>
                                  <p class="mb-3"><span class="data-label">收件電話:</span>{{$order->for_phone}}</p>
                                  <p class="mb-3"><span class="data-label">收件地址:</span>{{$order->for_address}}</p>
                                  <a href="{{route('tracking-captcha',['seccode'=>$order->seccode])}}" class="btn btn-lg btn-solid btn-blue btn-block mt-4" >資料修改</a>
                              </div>
                          </div>
                      @endforeach
                  </div>
              @else
                  <div class="edit-box">
                      <div class="info-text">
                          <p class="text-danger">無此訂單編號，請您再次確認系統通知信或聯絡客服人員，謝謝</p>
                      </div>
                  </div>

              @endif
          @endif
      </div>
    </div>
</section>
</div>
<!-- Modal -->
<div class="modal modal-dark fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirm-modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p>
        驗證碼已送到您的個人電子信箱。<br>請至信箱收取並輸入驗證！
        </p>
      </div>

    </div>
  </div>
</div>

@endsection
