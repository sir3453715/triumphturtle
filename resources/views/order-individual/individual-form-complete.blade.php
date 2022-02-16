@extends('layouts.app')

@section('content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')
<div class="main-wrapper">
    <section class="banner-wrapper">
        <div class="banner container">
            <div><img src="/storage/image/form-icon.svg" alt="個人資料填寫完成">
                <h1>資料填寫完成</h1>
            </div>
        </div>
    </section>
    <section class="container cus-container">
      <!-- ==== 資料卡 ==== -->
          <div class="shipment">
            <div class="card">
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
              </div>
            </div>
          </div>

          <div class="display-box w-100 mt-5 mb-4"><img src="/storage/image/box-white.svg" alt="">
                <h2>個人寄件說明</h2>
            </div>
            <div class="des-box des-box-blue">
                <ol>
                    <li>若設定完資料後有需要修改, 請在首頁點擊 “訂單查詢” 功能做異動</li>
                   <li>運單將會發送到您設定個寄件人信箱，請列印出來後貼至箱上，並在入倉截止日前 <span>{{date('Y/m/d',strtotime($order->sailing->parcel_deadline))}}</span> 寄送到<a class="btn-link btn-link-white ml-2" href="/location">倉庫</a></li>
                   <li>結單日 <span>{{date('Y/m/d',strtotime($order->sailing->statement_time))}}</span> 過後系統會發送優惠價格通知到電子信箱, 請款單將在貨物發送到台灣倉庫後發送通知</li>
                   <li>建議訂單完成後私訊客服人員您的姓名跟訂單編號，以利後續相關作業溝通，謝謝。</li>
                </ol>
            </div>
    </section>
</div>
@endsection
