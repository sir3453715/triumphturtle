@extends('layouts.app')

@section('content')
<div class="main-wrapper">
    <section class="banner-wrapper">
        <div class="banner container">
            <div><img src="/storage/image/form-icon.svg" alt="主揪資料填寫完成">
                <h1>資料填寫完成</h1>
            </div>
        </div>
    </section>
    <section class="container cus-container">
    <div class="shipment mb-4">
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
                  <p class="mb-2"><span class="data-label">主揪人:</span>{{$order->sender_name}}</p>
                </div>
              </div>
              <div class="card-bottom detail-info">
                  <div class="mb-3">
                     <p class="mb-3"><span class="data-label">分享連結:</span><span>{{route('group-member-join',['base64_id'=>base64_encode($order->id)])}}</span></p>
                    <button type="button" class="btn btn-sm btn-orange mt-2 mt-md-0 copy" data-link="{{route('group-member-join',['base64_id'=>base64_encode($order->id)])}}">點我複製</button>
                  </div>
                  <div>
                     <p class="mb-3"><span class="data-label">驗證碼:</span><span>{{$order->captcha}}</span></p>
              <button type="button" class="btn btn-sm btn-orange mt-2 mt-md-0 copy" data-link="{{$order->captcha}}">點我複製</button>
                  </div>
              </div>
            </div>
          </div>

          <div class="display-box w-100 mt-5 mb-4"><img src="/storage/image/box-white.svg" alt="">
                <h2>揪團集運主揪說明</h2>
            </div>
            <div class="des-box des-box-blue">
                <ol>
                    <li>請將此連結分享給同團成員新增寄送地址及裝箱資訊</li>
                   <li>需讓所有團員在 <span>{{date('Y/m/d',strtotime($order->sailing->statement_time))}}</span> 前完成所有資料填寫, 超過時間做異動須通知客服人員</li>
                   <li>若設定完資料後有需要修改, 請在首頁點擊“訂單查詢” 功能做異動</li>
                   <li>運單將會發送到您設定個寄件人信箱，請列印出來後貼至箱上，並在入倉截止日前 <span>{{date('Y/m/d',strtotime($order->sailing->parcel_deadline))}}</span> 寄送到<a class="btn-link btn-link-white ml-2" href="/location">倉庫</a></li>
                   <li>結單日 <span>{{date('Y/m/d',strtotime($order->sailing->statement_time))}}</span> 過後系統會發送優惠價格通知到電子信箱, 請款單將在貨物發送到台灣倉庫後發送通知</li>
                   <li>建議訂單完成後私訊客服人員您的姓名跟訂單編號，以利後續相關作業溝通，謝謝。</li>
                </ol>
            </div>
    </section>
</div>
@endsection

@push('app-scripts')
    <script type="text/javascript">
        $(document.body).on('click', '.copy', e => {
            let $link = $(e.currentTarget).data('link');
            var sampleTextarea = document.createElement("textarea");
            document.body.appendChild(sampleTextarea);
            sampleTextarea.value = $link; //save main text in it
            sampleTextarea.select(); //select textarea contenrs
            document.execCommand("copy");
            document.body.removeChild(sampleTextarea);
            alert('已複製連結/文字 :'+$link);
        });
    </script>
@endpush
