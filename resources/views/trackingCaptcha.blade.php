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
          <!-- ==== 驗證卡 ==== -->
          <form class="shipment validation-form" action="{{route('order-update-captcha')}}" method="POST">
              @csrf
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
                  <p class="mb-3"><span class="data-label">寄件人:</span>{{$order->sender_name}}</p>
                </div>
              </div>
              <hr>
              <div class="card-bottom detail-info">
              <div>
                <div class="py-4">
                  <!-- Button trigger modal -->
                   <button id="sendUpdateToken" type="button" class="btn btn-link btn-link-blue">點擊發送驗證碼</button>
                    <span id="loading-wrapper" class="d-hidden"><img width="45px" src="/storage/image//loading.gif"></span>
                </div>
                  <div class="d-block d-md-flex align-items-center mb-3">
                     <input type="hidden" id="order_id" name="order_id" value="{{$order->id}}">
                      <div class="form-control mr-3 border-0 mb-3">
                         <input id="updateToken" name="updateToken" class="form-control form-control-lg mr-3 form-required {{(\Session::has('errorText'))?'required-error':''}}" type="text" placeholder="請輸入驗證碼">
                          @if (\Session::has('errorText'))
                              <small class="required-error-message text-danger">{!! \Session::get('errorText') !!}</small>
                          @endif
                      </div>
                      <button class="btn btn-lg btn-solid btn-orange btn-block mt-4 mt-md-0 ">送出</button>
                  </div>
              </div>
              </div>
            </div>
          </form>

      </div>
    </div>
</section>
</div>
<!-- Modal -->
<div class="modal modal-dark fade" id="updateToken-modal" tabindex="-1" role="dialog" aria-labelledby="updateToken-modal" aria-hidden="true">
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

@push('app-scripts')
    <script type="text/javascript">
        $(document).on('click', '#sendUpdateToken', function(event){
            event.preventDefault();
            $('#loading-wrapper').show();
            $.ajax({
                type:"POST",
                url:"../updateToken",
                dataType:"json",
                data:{
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'order_id': $('#order_id').val(),
                },success:function(result){
                    if(result){
                        setTimeout(function (){
                            $('#loading-wrapper').hide();
                            $('#updateToken-modal').modal();
                        },2000);
                    }
                }
            });
        });
    </script>
@endpush
