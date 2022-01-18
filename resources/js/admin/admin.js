import './libs';
import slick from 'slick-carousel';
import 'select2/dist/js/i18n/zh-TW.js';

require('./template/adminlte');

$(() => {
    /**
     * 全後台基礎JS 宣告
     */
    $( document ).ready(function() {
        if($('.custom-editor').length){
            $('.custom-editor').summernote({
                placeholder: 'Please Edit Here.',
                tabsize: 2,
                height: $('.custom-editor').attr('data-weight'),
                callbacks:{
                    onImageUpload: function(files, editor, welEditable) {
                        for(let i=0; i < files.length; i++) {
                            var data = new FormData();
                            var $this = $(this);
                            data.append("file", files[i]);
                            data.append('_token', $('meta[name="csrf-token"]').attr('content'));
                            $.ajax({
                                data: data,
                                type: "POST",
                                url:"./uploadEditorImage",
                                cache: false,
                                contentType: false,
                                processData: false,
                                success:function(object){
                                    if (object['result'] === true){
                                        $this.summernote('insertImage', object['url']);
                                        $('input[name="files"]').val('');
                                    }else{
                                        alert('圖片無法正常上傳!請洽工程人員');
                                    }
                                }
                            });
                        }

                    }
                }
            });
        }
        $('.select2').select2({
            width: '100%',
            placeholder:"請選擇...",
            language:'zh-TW',
            allowClear: true
        });
        $('.table').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            info: false,
            "ordering" : false,
            "language": {
                "emptyTable": "目前沒有資料"
            }
        });
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            $('.table').DataTable({
                responsive: true,
                paging: false,
                searching: false,
                info: false,
                destroy:true,
                "ordering" : false,
            });
        });
    });

    //驗證資料是否有必填
    let $form = $('#admin-form');
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
    });
    $(document.body).on('click','.delete-confirm',e => {
       e.preventDefault();
        let code = '';
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        for (var x = 0; x < 10; x++) {
            var i = Math.floor(Math.random() * chars.length);
            code += chars.charAt(i);
        }
        if(prompt('注意！目前將刪除所選擇項目，此操作無法回覆。 如果仍要繼續動作，請輸入以下代碼： ' + code ) === code) {
            $(e.currentTarget).closest('form').submit();
        }
    });


    /**
     * 上傳圖片預覽與刪除
     */
    $(document.body).on('change', 'input[type=file]', e => {
        let reader = new FileReader(),
            $this = $(e.currentTarget),
            $preview = $this.siblings('.cus-upload-img');

        if(!$this.val()) return;
        if($preview.length) {
            let file = e.currentTarget.files[0];
            let isImage = $.inArray(file.type, ['image/jpeg','image/png']) !== -1;
            if(isImage) {
                reader.onload = function(_e) {
                    $preview.attr('src', _e.target.result);
                }
                reader.readAsDataURL(e.currentTarget.files[0]);
            }
        }
    });
    $(document.body).on('click', '.reback', e => {
        let $reID = $(e.currentTarget).data('id'),
            $reSrc = $(e.currentTarget).data('default'),
            $change = $($reID),
            $input = $(e.currentTarget).siblings('input[type=file]');

        $change.attr('src', $reSrc);
        $input.val('');
    });


})
