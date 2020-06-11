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

    //установка новой роли
    $('#user_set_role').on('click', function () {
        var user_id = $(this).parents('tr').first().attr('id');
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/user/get-role", {
            'user_id': user_id,
        }).done(function (data) {
            SpinnerBody(false);
            bootbox.alert(data, function () {
                SpinnerBody(true);
                $.post(fullPathCropped + "/base/user/set-role", {
                    'user_id': user_id,
                    'role': $('#role').val(),
                }).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<p class="text-success">Роль установлена!</p>');
                    } else {
                        bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
                    }
                });
            });
        });
    });

    //блокировка пользователя
    $('#user_lock').on('click', function () {
        var user_id = $(this).parents('tr').first().attr('id');
        bootbox.confirm({
            message: "Добавить пользователя в <b>черный список</b>?",
            buttons: {
                confirm: {
                    label: 'Заблокировать',
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
                $.post(fullPathCropped + "/base/user/user-lock", {
                    'user_id': user_id,
                    'status': 1,
                }).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<p class="text-success">Пользователь заблокирован!</p>',function () {
                            $('#searchButton').click();
                        });
                    } else {
                        bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
                    }
                });
            }
        });
    });

    //разблокировка пользователя
    $('#user_unlock').on('click', function () {
        var user_id = $(this).parents('tr').first().attr('id');
        bootbox.confirm({
            message: "Убрать пользователя из <b>черного списка</b>?",
            buttons: {
                confirm: {
                    label: 'Разблокировать',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Отмена',
                    className: 'btn-secondary'
                }
            },
            callback: function (result) {
                if (!result) return;
                SpinnerBody(true);
                $.post(fullPathCropped + "/base/user/user-lock", {
                    'user_id': user_id,
                    'status': 0,
                }).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<p class="text-success">Пользователь разблокирован!</p>',function () {
                            $('#searchButton').click();
                        });
                    } else {
                        bootbox.alert('<p class="text-danger">Произошла ошибка!</p>');
                    }
                });
            }
        });
    });

    //удаление пользователя
    $('#user_delete').on('click', function () {
        var user_id = $(this).parents('tr').first().attr('id');
        bootbox.confirm({
            message: "Удалить пользователя и все его файлы?",
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
                $.post(fullPathCropped + "/base/user/user-delete", {
                    'user_id': user_id,
                }).done(function (data) {
                    SpinnerBody(false);
                    if (data == true) {
                        bootbox.alert('<p class="text-success">Пользователь удален!</p>',function () {
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