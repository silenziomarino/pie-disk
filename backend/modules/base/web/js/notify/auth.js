$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    //подтверждение регистрации
    $('.confirm_reg').on('click',function(){
        let el = $(this);
        let id = el.attr('data-id');
        let auth_item = el.parent().find('[name="auth_item"]').val();
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/user/confirm-reg", {
            'id': id,
            'auth_item':auth_item,
            'status': true,
        }).done(function (data) {
            SpinnerBody(false);
            bootbox.alert(data,function () {
                document.location.href = fullPathCropped;
                el.parents('.notify_block:first').remove();
            });
        });
    });

    //отказ в регистрации
    $('.reg_denial').on('click',function(){
        let el = $(this);
        let id = el.attr('data-id');
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/user/confirm-reg", {
            'id': id,
            'status': false,
        }).done(function (data) {
            SpinnerBody(false);
            bootbox.alert(data,function () {
                document.location.href = fullPathCropped;
                el.parents('.notify_block:first').remove();
            });
        });
    });
});