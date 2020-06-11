$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    //показать 5 последних уведомлений
    $('#notify').on('click',function(){
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/notify/index", {}).done(function (data) {
            SpinnerBody(false);
            bootbox.dialog({
                message: data,
            });
        });
    });
});


//-------генератор цветов--------------------------------------
function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

//---------склонения слов----------------------------------------
function num2str(n, text_forms) {
    n = Math.abs(n) % 100; var n1 = n % 10;
    if (n > 10 && n < 20) { return text_forms[2]; }
    if (n1 > 1 && n1 < 5) { return text_forms[1]; }
    if (n1 == 1) { return text_forms[0]; }
    return text_forms[2];
}

//добавление/удаление спинера на всю страницу
function SpinnerBody(status) {
    if (status) {
        var div = document.createElement('div');
        div.id = 'body-spinner';
        div.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        document.body.appendChild(div);
    } else {
        $('#body-spinner').remove();
    }
}
