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
        $('<div>').addClass('required-error-message text-danger').html(message).insertAfter(element)
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
        if(invalid) {
            return false;
        }
        $('#notification-message').show();
        return false;
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

//========== active main slider ==========
$('.main-slider').slick({
    dots: true,
    infinite: true,
    speed: 500
});

//========== Enable tooltips everywhere ==========
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
