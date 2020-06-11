$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    $("#count").change(function () {
        $('#searchButton').click();
    });


    $('.restore').on('click', function () {
        SpinnerBody(true);
        var file_id = $(this).parents('tr').first().attr('id');
        $.get(fullPathCropped + "/base/file/trash-restore", {
            'id': file_id,
        }).done(function (data) {
            SpinnerBody(false);
            if (data == true) {
                bootbox.alert('<p class="text-success">Файл востановлен!</p>', function () {
                    $('#searchButton').click();
                });
            } else {
                bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
            }
        });
    });
});