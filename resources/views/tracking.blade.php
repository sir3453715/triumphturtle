@extends('layouts.app')

@section('content')
<div class="main-wrapper">
  <section id="tracking-page">
    <div class="container">
      <div class="cus-grid">
        <div class="display-box display-box-outline">
          <div class="d-flex align-items-center">
            <img src="/storage/image/location-icon.svg" alt="">
            <h2>訂單查詢</h2>
          </div>
          <form class="mt-5">
            <input class="form-control form-control-lg" type="text" placeholder="輸入訂單編號 或 寄件人門號">
            <button class="btn btn-lg btn-solid btn-orange btn-block mt-4">搜尋</button>
          </form>

        </div>
          <!-- ==== 當無資料時顯示 ==== -->
        <!-- <div class="edit-box">
          <div class="info-text">
          <p>請搜尋訂單查詢或更改資料</p>
          </div>
          </div> -->

           <!-- ==== 資料卡 ==== -->
          <!-- <form class="shipment">
            <div class="card">
              <div class="card-top">
                <div class="data-header">
                  <div class="data-header-top">
                    <img class="img-circle" src="/storage/image/list-icon.svg" alt="">
                    <div>
                      <div class="data-header-title cus-row">
                        <p>訂單編號</p>
                        <span class="cus-badge cus-badge-dark-gray">TS211001002-1</span>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="detail-info detail-info-grid">
                  <p class="mb-3"><span class="data-label">寄件人:</span>Michael</p>
                  <p class="mb-3"><span class="data-label">船期狀態:</span>集貨中</p>
                  <p class="mb-3"><span class="data-label">訂單狀態:</span>未入庫</p>
                  <p class="mb-3"><span class="data-label">付款狀態:</span>未付款</p>
                  <p class="mb-3"><span class="data-label">總箱數:</span>5箱</p>
                </div>
              </div>

              <hr>
              <div class="card-bottom detail-info">
                <p class="mb-3"><span class="data-label">收件人:</span>Michael</p>
                <p class="mb-3"><span class="data-label">收件電話:</span>0912345678</p>
                <p class="mb-3"><span class="data-label">收件地址:</span>Michael</p>
                <button class="btn btn-lg btn-solid btn-blue btn-block mt-4">資料修改</button>
              </div>
            </div>
          </form> -->

          <!-- ==== 驗證卡 ==== -->
          <form class="shipment">
            <div class="card">
              <div class="card-top">
                <div class="data-header">
                  <div class="data-header-top">
                    <img class="img-circle" src="/storage/image/list-icon.svg" alt="">
                    <div>
                      <div class="data-header-title cus-row">
                        <p>訂單編號</p>
                        <span class="cus-badge cus-badge-dark-gray">TS211001002-1</span>

                      </div>
                    </div>
                  </div>
                </div>
                <div class="detail-info">
                  <p class="mb-3"><span class="data-label">寄件人:</span>Michael</p>
                </div>
              </div>

              <hr>
              <div class="card-bottom detail-info">
              <div>
                <div class="py-4">
                  <!-- Button trigger modal -->
                   <button type="button" class="btn btn-link btn-link-blue" data-toggle="modal" data-target="#confirm-modal">點擊發送驗證碼</button> 
                </div>
              <div class="d-block d-md-flex align-items-center mb-3">
                     <input class="form-control form-control-lg mr-3" type="text" placeholder="請輸入驗證碼">
            <button class="btn btn-lg btn-solid btn-orange btn-block mt-3 mt-md-0">送出</button>
              </div>
          </div>
              </div>
            </div>
          </form>

      </div>
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