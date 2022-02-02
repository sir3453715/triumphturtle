@extends('layouts.app')

@section('content')
<div class="main-wrapper" id="home-page">

  <section class="main-slider">
    <div class="slide-item slide-1">
      <div class="container">
        <div class="mx-3 mx-md-0">
          <div class="slide-caption col-xl-5 col-md-6 col-12">
            <h1>海龜集運</h1>
            <h2 class="deco-line">TRIUMPH TURTLE</h2>
            <p>突破海運的限制!!<br>首創揪團集運平台</p>
            <a class="btn btn-lg btn-solid btn-green" href="＃">查詢倉庫位置</a>
          </div>
        </div>

      </div>

    </div>
    <div class="slide-item">slide-2</div>
  </section>

  <section class="container p-0 mb-5">
    <div id="search-bar" class="mx-3 mx-md-0">
      <form action="" method="">
        <div class="row cus-form justify-content-center">
          <div class="col-md-4">
            <!-- 請選擇出發國家 -->
            <select class="form-control form-control-lg">
              <option value="" hidden>請選擇出發國家</option>
              <option value="">國家-1</option>
              <option value="">國家-2</option>
            </select>
          </div>
          <div class="col-md-1 center-center my-2 my-md-0">
            <i class="fas fa-long-arrow-alt-right d-none d-md-block"></i>
            <i class="fas fa-long-arrow-alt-down d-block d-md-none"></i>
          </div>
          <div class="col-md-4">
            <!-- 請選擇目的國家 -->
            <select class="form-control form-control-lg">
              <option value="" hidden>請選擇目的國家</option>
              <option value="">國家-1</option>
              <option value="">國家-2</option>
            </select>
          </div>
          <div class="text-center col-md-2">
            <button class="btn btn-lg btn-solid btn-orange w-100 mt-3 mt-md-0">搜尋</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="container">
    <div class="row shipment">
    @for($i = 1; $i <= 6; $i++) 
    <div class="col-12 col-lg-6 col-xl-4 my-4 px-3 px-md-2">
      <div class="card">
        <div class="card-top">
          <div class="data-header">
            <div class="data-header-top">
              <img class="img-circle" src="/storage/image/shipment-icon.svg" alt="">
              <div>
                <div class="data-header-title cus-row">
                  <p>航班名稱</p>
                  <span class="cus-badge cus-badge-green">集貨中</span>
                  <!-- <span class="cus-badge cus-badge-orange">準備中</span>
                  <span class="cus-badge cus-badge-blue">開航中</span>
                  <span class="cus-badge cus-badge-teal">已抵達</span>
                  <span class="cus-badge cus-badge-gray">已取消</span> -->
                </div>
              </div>
            </div>
          </div>
          <div class="price-info">
            <p class="mb-3"><span class="data-label">成團單價:</span> NT$ 2,600 / 箱</p>
            <!-- <div><img src="/storage/image/pack-icon.svg" alt="">差 <span class="data-number">3</span>箱即可成團</div> -->
            <div><img src="/storage/image/pack-icon.svg" alt="">差 <span class="data-number">3</span>箱即可享有優惠<div
                class="data-extra-info">NT$ 2,600 / 箱</div>
            </div>
          </div>
        </div>
        <hr>
        <div class="card-bottom">
          <div class="data-content">
            <div class="data-content-item">
              <p class="item-label">結單時間</p>
              <p class="item-date">1 / 20</p>
            </div>
            <div class="center-center my-2 my-md-0">
              <i class="fas fa-long-arrow-alt-right"></i>    
            </div>
            <div class="data-content-item">
              <p class="item-label">包裹進倉<br>截止日</p>
              <p class="item-date">2 / 15</p>
            </div>
            <div class="center-center my-2 my-md-0">
              <i class="fas fa-long-arrow-alt-right"></i>    
            </div>
            <div class="data-content-item">
              <p class="item-label">抵達目的地<br>倉庫</p>
              <p class="item-date">2 / 25</p>
            </div>
          </div>
          <button class="btn btn-lg btn-solid btn-blue btn-block mt-4">來去揪團</button>
        </div>
      </div>
      </div>
      @endfor
    </div>
  </section>

  <section class="container mb-5">
    <div class="display-box display-box-outline display-box-down m-auto"><img src="/storage/image/steps.svg" alt=""><h2>作業流程說明</h2></div>
    <div class="border-box">
      <img class="img-fluid d-none d-md-block" src="/storage/image/process-step.svg" alt="">
      <img class="img-fluid d-block d-md-none" src="/storage/image/process-step-mb.svg" alt="">
    </div>
  </section>

</div>
@endsection