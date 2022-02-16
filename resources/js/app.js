import './admin/libs';
import slick from 'slick-carousel';

import 'select2/dist/js/i18n/zh-TW.js';


$(() => {
    $( document ).ready(function() {
        if($('.custom-editor').length){
            $('.custom-editor').summernote({
                placeholder: 'Hello Bootstrap 4',
                tabsize: 2,
                height: $('.custom-editor').attr('data-weight'),
            });
        }
        $('.select2').select2({
            placeholder:"enter keyword",
            allowClear: true
        });
        $('.slider').slick({
            prevArrow:'<button type="button" class="slick-prev"></button>',
            nextArrow:'<button type="button" class="slick-next"></button>',
            dots: true,
        });
    });

    //驗證資料是否有必填
    let $form = $('.validation-form');
    function focusField(element) {//鎖定未填欄位
        let tabId = $(element).closest('.tab-pane').attr('aria-labelledby')
        $('#' + tabId).tab('show');
        $(window).scrollTop($(element).offset().top - $(window).height() / 2);
        $(element).focus();
    }
    function showValidationMessage(element, message) {//顯示必填通知
        removeValidationMessage();
        $(element).addClass('required-error');
        $('<small>').addClass('required-error-message text-danger').html(message).insertAfter(element)
    }
    function removeValidationMessage() {//移除必填通知
        $('.required-error-message').remove();
        $('.required-error').removeClass('required-error');
    }
    $(document.body).on('change','.required-error',function (){//必填未填項目修改後移除通知
        removeValidationMessage();
    });



    $form.on('submit', e => {//表單送出後進行驗證
        // 檢查所有的必填欄位
        let invalid = false;
        $('.form-required').each((index, ele) => {
            if(!$(ele).val()) {
                invalid = true;
                focusField(ele);
                showValidationMessage(ele, '此欄位必填');
                return false;
            }
        });
        if ($('.hidden-form-required').length > 0){
            $('.hidden-form-required').each((index, ele) => {
                let style = $(ele).closest('.d-hidden').css('display');
                if (style !== 'none') {
                    if(!$(ele).val()) {
                        invalid = true;
                        focusField(ele);
                        showValidationMessage(ele, '此欄位必填');
                        return false;
                    }
                }
            });
        }
        if ($('#sender_emailConfirm').length >0){
            var mail = $('#sender_email').val();
            if ($('#sender_emailConfirm').val() !== mail){
                focusField('#sender_emailConfirm');
                showValidationMessage('#sender_emailConfirm', '兩次信箱不相同!');
                return false;
            }
        }
        if(invalid) {
            return false;
        }
    });

    //TAC驗證與導向
    $(document).ready(function(){
        $('#tandc-modal').on('shown.bs.modal', function () {
            removeValidationMessage();
        });
        $(document).on('click', '.open-TAC', function(event){
            event.preventDefault();
            var link = $(this).data('link');
            $('#checkTAC').attr('data-link',link);
        });
        $(document).on('click', '#checkTAC', function(event){
            event.preventDefault();
            if($('#TACCheckBox').is(':checked')) {
                let route = $(this).data('link');
                window.location.href=route;
            }else{
                focusField('#TACCheckBoxDiv');
                showValidationMessage('#TACCheckBoxDiv', '請同意條款!');
            }
        });
        $(document).on('click', '#confirm-token', function(event){
            event.preventDefault();
            if(!$('#captcha').val()) {
                focusField('#captcha');
                showValidationMessage('#captcha', '此欄位必填');
            }else{
                $.ajax({
                    type:"POST",
                    url:"../confirmToken",
                    dataType:"json",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'captcha': $('#captcha').val(),
                    },success:function(result){
                        if(result){
                            $('#confirm-modal').modal('hide');
                            $('#tandc-modal').modal();
                            $('#checkTAC').attr('data-link',result);
                        }else{
                            focusField('#captcha');
                            showValidationMessage('#captcha', '驗證碼錯誤!找不到主揪訂單');
                        }
                    }
                });
            }
        });
    });


})



     //========== toggle mobile menu ==========
     $(".navbar-toggler").on('click', function () {
        $("#navBarMobile").toggleClass("active");
        $("body").css({"overflow": "hidden"});
    });

    $("#nav-remove").on('click', function () {
        $("#navBarMobile").removeClass("active");
        $("body").css({"overflow-y": "auto"});
    });


//========== Enable tooltips everywhere ==========
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
