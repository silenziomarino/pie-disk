$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    $("#count").change(function () {
        document.forms.dic_teg.submit();
    });

    $(".teg_delete").on('click',function () {
        var el = $(this);
        var id = el.parents('tr').first().attr('id');
        SpinnerBody(true);
        $.get(fullPathCropped + "/base/teg/teg-delete", {
            'id': id,
        }).done(function (data) {
            SpinnerBody(false);
            $('#'+id).remove();
        });
    });

    $('#deleteAll').on('click',function () {
        bootbox.confirm({
            message: "Удалить все ключевые слова?",
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
                $.post(fullPathCropped + "/base/teg/delete-all", {}).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<p class="text-success">Все ключевые слова удалены!</p>',function () {
                            location.reload();
                        });
                    } else {
                        bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
                    }
                });
            }
        });
    });
});