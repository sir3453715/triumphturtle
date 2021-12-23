$(function(){
    /*User Edit */
    $('.random-password').click(function () {
        let pwd = "";
        var chars = "abcdefghijklmnopqrstuvwxyz@$&*-_ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        for (var x = 0; x < 15; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pwd += chars.charAt(i);
        }
        $('#password').val(pwd);
    });

    $('.view-password').click(function () {
        if($('#password').attr('type') === 'password' ){
            $('#password').attr('type','text');
        }else{
            $('#' +
                'password').attr('type','password');
        }
    });


});
