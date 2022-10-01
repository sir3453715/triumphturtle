@extends('layouts.app')

@section('content')
    <div class="main-wrapper">
        <section class="banner-wrapper">
            <div class="banner container">
                <div><img src="/storage/image/group-initiator-icon.svg" alt="我要揪團">
                    <h1>我要揪團</h1>
                </div>
            </div>
        </section>
        <section class="container">
            <form class="cus-form cus-form-fill validation-form" action="{{route('orderCreate')}}" method="POST">
                @csrf
                <input type="hidden" name="sailing_id" value="{{$sailing->id}}">
                <input type="hidden" name="type" value="2">
                <input type="hidden" name="parent_id" value="0">
                <fieldset class="cus-form-wrap">
                    <div class="cus-form-header">
                        <img src="/storage/image/box-out-icon.svg" alt="寄件資訊圖示">
                        <h2>寄件資訊</h2>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="shipment_use">目的* <span><i class="cus-info-icon fa fa-info-circle" aria-hidden="true" data-toggle="modal" data-target="#info-modal"></i></span></label>
                            <select class="form-control form-required" name="shipment_use" id="shipment_use">
                                <option value="" hidden>請選擇目的</option>
                                <option value="行李後送">行李後送</option>
                                <option value="私人行李">私人行李</option>
                                <option value="商業貨">商業貨</option>
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="sender_name">姓名*</label>
                            <input type="text" class="form-control form-required" name="sender_name" id="sender_name" placeholder="請填寫英文姓名(需同護照名)">
                        </div>
                        <div class="form-group col-6">
                            <label for="sender_phone">聯絡電話*</label>
                            <input type="text" class="form-control form-required" name="sender_phone" id="sender_phone" placeholder="聯絡電話">
                        </div>
                        <div class="form-group col-12">
                            <label for="sender_address">地址*</label>
                            <input type="text" class="form-control form-required" name="sender_address" id="sender_address" placeholder="請填寫英文地址">
                        </div>
                        <div class="form-group col-6 d-hidden">
                            <label for="sender_company">公司名稱*</label>
                            <input type="text" class="form-control hidden-form-required" name="sender_company" id="sender_company" placeholder="公司名稱跟統編是商業貨才顯示">
                        </div>
                        <div class="form-group col-6 d-hidden">
                            <label for="sender_taxid">統編*</label>
                            <input type="text" class="form-control hidden-form-required" name="sender_taxid" id="sender_taxid" placeholder="公司名稱跟統編是商業貨才顯示">
                        </div>
                        <div class="form-group col-6">
                            <label for="sender_email">電子信箱*</label>
                            <input type="text" class="form-control form-required" name="sender_email" id="sender_email" placeholder="輸入電子信箱">
                        </div>
                        <div class="form-group col-6">
                            <label for="sender_emailConfirm">再次輸入電子信箱*</label>
                            <input type="text" class="form-control form-required" name="sender_emailConfirm" id="sender_emailConfirm" placeholder="再次輸入電子信箱">
                        </div>
                        <div class="form-group col-6 d-none reback-required" id="reback-filed">
                            <label for="reback">是否回台灣*</label>
                            <select class="form-control reback-form-required" name="reback" id="reback">
                                <option value="" hidden>請選擇</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>
                        <div class="form-group col-6 d-none reback-required" id="reback-time-field">
                            <label for="reback_time">回台時間*</label>
                            <input type="date" class="form-control reback-form-required" name="reback_time" id="reback_time">
                        </div>
                    </div>
                </fieldset>
                <fieldset class="cus-form-info container-fluid cus-form-wrap">
                    <p>若收件資訊及裝箱資料尚未確認，可先送出訂單產生分享連結讓其他跟團人員填寫,
                        後續主揪在至首頁訂單查詢修改訂單即可，請注意需在結單時間 <span>{{date('Y/m/d',strtotime($sailing->statement_time))}}</span> 前完成訂單填寫動作，以利後續作業。</p>
                </fieldset>
                <fieldset class="cus-form-wrap">
                    <div class="cus-form-header">
                        <img src="/storage/image/box-in-icon.svg" alt="收件資訊圖示">
                        <h2>收件資訊</h2>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="for_name">姓名*</label>
                            <input type="text" class="form-control " name="for_name" id="for_name" placeholder="請填寫中文姓名">
                        </div>
                        <div class="form-group col-6">
                            <label for="for_phone">聯絡電話*</label>
                            <input type="text" class="form-control " name="for_phone" id="for_phone" placeholder="聯絡電話">
                        </div>
                        <div class="form-group col-12">
                            <label for="for_address">地址*</label>
                            <input type="text" class="form-control " name="for_address" id="for_address" placeholder="請填寫中文地址">
                        </div>
                        <div class="form-group col-6 d-hidden">
                            <label for="for_company">公司名稱*</label>
                            <input type="text" class="form-control " name="for_company" id="for_company" placeholder="公司名稱跟統編是商業貨才顯示">
                        </div>
                        <div class="form-group col-6 d-hidden">
                            <label for="for_taxid">統編*</label>
                            <input type="text" class="form-control " name="for_taxid" id="for_taxid" placeholder="公司名稱跟統編是商業貨才顯示">
                        </div>
                    </div>
                </fieldset>
                <hr>
                <fieldset class="cus-form-wrap">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="cus-form-header mb-0">
                            <img src="/storage/image/box-form-icon.svg" alt="裝箱資訊圖示">
                            <h2>裝箱資訊</h2>
                        </div>
                        <div>
                            <button type="button" class="btn btn-md btn-orange add-box-btn">＋新增一箱</button>
                            <input type="hidden" class="form-control box_num" name="box_num[]" value="1">
                        </div>
                    </div>
                    <!-- 裝箱卡 -->
                    <div class="box-wrapper">
                        <div class="add-box box-section">
                            <button type="button" class="btn btn-md btn-red mb-3 remove-box">刪除箱子</button>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="">毛重 <small class="help">(kg)</small></label>
                                    <input type="number" class="form-control" name="box_weight[]" id="box_weight" min="0" step="0.1">
                                </div>
                            </div>
                            <h5 class="mb-2">材積（CM)</h5>
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="">長</label>
                                    <input type="number" class="form-control" name="box_length[]" id="box_length" min="0" step="0.1">
                                </div>
                                <div class="form-group col-4">
                                    <label for="">寬</label>
                                    <input type="number" class="form-control" name="box_width[]" id="box_width" min="0" step="0.1">
                                </div>
                                <div class="form-group col-4">
                                    <label for="">高</label>
                                    <input type="number" class="form-control" name="box_height[]" id="box_height" min="0" step="0.1">
                                </div>
                            </div>
                            <div class="d-block d-md-flex align-items-center mt-4 mb-3 add-item-div">
                                <div class="cus-form-header mb-0">
                                    <img src="/storage/image/box-plus-icon.svg" alt="裝箱商品描述圖示">
                                    <h2 class="mr-4">裝箱商品描述</h2>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-dark-gray mt-2 mt-md-0 add-item-btn">＋新增內容</button>
                                </div>
                            </div>
                            <div class="item-wrapper">
                                <input type="hidden" class="box-item-num" name="box_items_num[]" value="1">
                                <div class="row mb-3 item-section">
                                    <div class="form-group col-12">
                                        <label for="">商品描述</label>
                                        <input type="text" class="form-control" name="item_name[]" id="item_name" placeholder="請填寫英文">
                                    </div>
                                    <div class="form-group col-6 col-md-3">
                                        <label for="">數量</label>
                                        <input type="number" class="form-control change-num" name="item_num[]" id="item_num">
                                    </div>
                                    <div class="form-group col-6 col-md-3">
                                        <label for="">單價<small class="help">(USD)</small></label>
                                        <input type="number" class="form-control change-price" name="unit_price[]" id="unit_price" min="0" step="0.1">
                                    </div>
                                    <div class="form-group col-6 col-md-3">
                                        <label for="">價值<small class="help">(USD)</small></label>
                                        <div> <span class="show-price">XXX</span> <small class="help">USD</small></div>
                                    </div>
                                    <div class="col-6 col-md-3 d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-red remove-item">刪除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <hr>
                <fieldset class="cus-form-wrap">
                    <div class="cus-form-header">
                        <img src="/storage/image/paper-icon.svg" alt="發票圖示">
                        <h2>發票</h2>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="invoice">發票選擇*<small class="help">(需額外加5%)</small></label>
                            <select class="form-control form-required" name="invoice" id="invoice">
                                <option value="" hidden>請選擇發票類型</option>
                                <option value="3">三聯 - 公司戶</option>
                                <option value="2">二聯 - 個人戶</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-solid btn-blue btn-block mt-4 mb-4 order-submit">填寫完畢送出</button>
                </fieldset>
            </form>

        </section>
    </div>
@endsection

@push('app-scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document.body).on('click','.add-box-btn',function (){
                let OrderBoxHtml = $('#addBoxTemplate').html();
                $('.box-wrapper').append(OrderBoxHtml);
                $(".box-wrapper .box-section").each(function(index, el) {
                    var no = index + 1;
                    $('.box_num').val(no);
                });
            });
            $(document.body).on('click','.add-item-btn',function (){
                let OrderBoxItemHtml = $('#addItemTemplate').html(),
                    $this = $(this), addItem = $this.closest('.add-item-div').siblings('.item-wrapper');
                addItem.append(OrderBoxItemHtml);
                var item_num = 0;
                addItem.children('.item-section').each(function(index, el) {
                    item_num ++;
                });
                addItem.children('.box-item-num').val(item_num);
            });
            $(document.body).on('click','.remove-box',function (){
                let $this = $(this), deleteBox = $this.closest('.box-section');
                deleteBox.remove();
                $(".box-wrapper .box-section").each(function(index, el) {
                    var no = index + 1;
                    $('.box_num').val(no);
                });
            });
            $(document.body).on('click','.remove-item',function (){
                let $this = $(this), deleteItem = $this.closest('.item-section'), itemWrapper = $this.closest('.item-wrapper');
                deleteItem.remove();
                var item_num = 0;
                itemWrapper.children('.item-section').each(function(index, el) {
                    item_num ++;
                });
                itemWrapper.children('.box-item-num').val(item_num);
            });

            $('#shipment_use').on('change',function (){
                if ($(this).val() === '商業貨'){
                    $('.d-hidden').show();
                    if(!$('.reback-field').hasClass('d-none')){
                        $('#reback-filed').addClass('d-none');
                    }
                    if(!$('#reback-time-field').hasClass('d-none')){
                        $('#reback-time-field').addClass('d-none');
                    }
                }else{
                    $('.d-hidden').hide();
                    $('#reback-filed').removeClass('d-none');
                    if($('#reback').val() == 1){
                        $('#reback-time-field').removeClass('d-none');
                    }
                }
            });
            /** 220929 回台灣判斷*/
            $('#reback').on('change',function (){
                if ($(this).val() === '1'){
                    $('#reback-time-field').removeClass('d-none');
                }else{
                    if(!$('#reback-time-field').hasClass('d-none')){
                        $('#reback-time-field').addClass('d-none');
                    }
                }
            });
            $(document.body).on('change','.change-num',function (){
                let num = $(this).val(), price = $(this).closest('.item-section').find('.change-price').val(),
                    totalHtml = $(this).closest('.item-section').find('.show-price');
                totalHtml.html((Math.round(num)*Math.round(price)));
            });
            $(document.body).on('change','.change-price',function (){
                let num = $(this).val(), price = $(this).closest('.item-section').find('.change-num').val(),
                    totalHtml = $(this).closest('.item-section').find('.show-price');
                totalHtml.html((Math.round(num)*Math.round(price)));
            });
        });
    </script>
    <script type="text/html" id="addBoxTemplate">
        @include('component.addBoxTemplate')
    </script>
    <script type="text/html" id="addItemTemplate">
        @include('component.addItemTemplate')
    </script>
@endpush
