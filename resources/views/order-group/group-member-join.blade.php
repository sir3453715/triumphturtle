@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section class="banner-wrapper">
        <div class="banner container">
            <div><img src="/storage/image/form-icon.svg" alt="加入揪團集運">
                <h1>加入揪團集運</h1>
            </div>
        </div>
    </section>
    <section class="container cus-container">
        <!-- ==== 驗證卡 ==== -->
        <form class="shipment validation-form" method="POST" action="{{route('group-captcha')}}">
            @csrf
            <input type="hidden" name="order_id" id="order_id" value="{{$order->id}}">
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
                    <div class="detail-info">
                        <p class="mb-3"><span class="data-label">主揪人:</span>{{$order->sender_name}}</p>
                    </div>
                </div>
                <div class="card-bottom detail-info">
                    <div>
                        <div class="d-block d-md-flex align-items-center mb-3">
                            <div class="form-control mr-3 border-0 mb-3">
                                <input class="form-control form-control-lg mr-3 form-required {{(\Session::has('errorText'))?'required-error':''}}" type="text" name="captcha" id="captcha" placeholder="請輸入驗證碼">
                                @if (\Session::has('errorText'))
                                    <small class="required-error-message text-danger">{!! \Session::get('errorText') !!}</small>
                                @endif
                            </div>
                            <button type="submit" id="send-confirm" class="btn btn-lg btn-solid btn-orange btn-block mt-4 mt-md-0 open-TAC" data-toggle="modal" href="#tandc-modal" data-link="group-captcha">送出</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="display-box w-100 mt-5 mb-4"><img src="/storage/image/box-white.svg" alt="">
            <h2>揪團集運跟團說明</h2>
        </div>
        <div class="des-box des-box-blue">
            <ol>
                <li>請在 <span>{{date('Y/m/d',strtotime($order->sailing->statement_time))}}</span> 前完成所有資料填寫，若設定完資料後有需要修改, 請點擊首頁訂單查詢查出訂單後再做資料修改</li>
                <li>運單將會發送到您設定個寄件人信箱，請列印出來後貼至箱上，並在入倉截止日前 <span>{{date('Y/m/d',strtotime($order->sailing->parcel_deadline))}}</span> 寄送到<a
                        class="btn-link btn-link-white ml-2" href="/location">倉庫</a></li>
                <li>結單日 <span>{{date('Y/m/d',strtotime($order->sailing->statement_time))}}</span> 過後系統會發送優惠價格通知到電子信箱, 請款單將在貨物發送到台灣倉庫後發送通知</li>
                <li>建議訂單完成後私訊客服人員您的姓名跟訂單編號，以利後續相關作業溝通，謝謝。</li>
            </ol>
        </div>
    </section>
</div>
@endsection
