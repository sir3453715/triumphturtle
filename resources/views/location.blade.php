@extends('layouts.app')

@section('content')
<div class="main-wrapper">
  <section id="location-page">
    <div class="container">
      <div class="cus-grid align-items-end">
        <div class="display-box display-box-outline">
          <div class="d-flex align-items-center">
            <img src="/storage/image/location-icon.svg" alt="">
            <h2>倉庫位置</h2>
          </div>
          <p class="mt-4">倉庫陸續增加中!!</p>
          <p>為您提供更多選擇</p>
        </div>
        <div class="edit-box">
          <!-- location card -->
          @for($i = 1; $i <= 6; $i++) <div class="location-card">
            <div class="card-left">
              <img class="img-fluid" src="/storage/image/location-img/location-sample-img.jpg" alt="">
            </div>
            <div class="card-right">
              <div class="data-header">
                <div class="data-header-top">
                  <img class="img-circle" src="/storage/image/box-icon.svg" alt="">
                  <div>
                    <div class="data-header-title cus-row">
                      <p>倉庫名稱</p>
                      <span class="cus-badge cus-badge-dark-gray">美國</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="location-info">
                <p class="mb-3"><span class="data-label">收件人:</span>Michael</p>
                <p class="mb-3"><span class="data-label">地址:</span>Marko Service Street Postepu 19 warehouse 8 Warszawa
                </p>
              </div>
              <div class="location-link">
                <a href="" class="btn-link btn-link-blue">當地宅配資訊</a>
                <a href="" class="btn-link btn-link-orange">紙箱購買連結</a>
              </div>
            </div>
        </div>
        @endfor

        <div class="mt-5">
          <h4>倉庫陸續增加中!!</h4>
        </div>
      </div>

    </div>
</div>


</div>

</section>
</div>
@endsection