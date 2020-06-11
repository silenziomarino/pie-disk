$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    $('#recovery-btn').on('click',function(){
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/user/recovery-window").done(function (data) {
            SpinnerBody(false);
            bootbox.confirm({
                message: data,
                buttons: {
                    confirm: {
                        label: 'Отправить',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'Отмена',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if(result){
                        SpinnerBody(true);
                        $.post(fullPathCropped + "/base/user/recovery",{
                            'RecoveryForm[email]': $('#recovery_email').val(),
                        }).done(function (data) {
                            bootbox.alert(data);
                            SpinnerBody(false);
                        });
                    }
                }
            });
        });
    });
});