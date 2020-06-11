$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    // Rambler.Likes script start
    (function () {
        var init = function () {
            RamblerShare.init('.rambler-share', {
                "utm": "utm_medium=social",
                "counters": true,
                "buttons": [
                    "copy",
                    "vkontakte",
                    "facebook",
                    "odnoklassniki",
                    "moimir",
                    "telegram",
                    "viber",
                    "whatsapp",
                    "messenger"
                ],
                "url": fullPathCropped+"/base/file/download?id=" +file_id

            });
        };
        var script = document.createElement('script');
        script.onload = init;
        script.async = true;
        script.src = 'https://developers.rambler.ru/likes/v1/widget.js';
        document.head.appendChild(script);
    })();
    // Rambler.Likes script end

    //скрыть показать блок социальных кнопок
    $('#share_btn').on('click', function () {
        if ($(".rambler-share").is(":visible")) {
            $('.rambler-share').hide();
        } else {
            $('.rambler-share').show();
        }
    });

    //закрывает file_bar
    $('#close_file_bar').on('click', function () {
        CloseFileBar();
    });

    $('#history').on('click',function(){
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/file/history", {
            'file_id': file_id,
        }).done(function (data) {
            SpinnerBody(false);
            bootbox.alert(data);
        });
    });

    $('#file_delete').on('click',function () {
        bootbox.confirm({
            message: "Удалить файл?",
            buttons: {
                confirm: {
                    label: 'Удалить',
                    className: 'btn-danger'
                },
                cancel: {
                    label: 'Отмена',
                    className: 'btn-secondary'
                }
            },
            callback: function (result) {
                if (!result) return;
                SpinnerBody(true);
                $.get(fullPathCropped + "/base/file/delete", {
                    'id': file_id,
                }).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<h4 class="text-success">Файл добавлен в корзину!</h4><p> При необходимости его можно вернуть  обратно.</p><span class="span-info">Файл удалится из корзины через 30 дней.</span>',function () {
                            $('#searchButton').click();
                        });
                    } else {
                        bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
                    }
                });
            }
        });
    });
});