$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');
    //открываем окно выбора файлов-----------------------------------------------
    $('#add_file').on('click', function () {
        SpinnerBody(true);
        $.post(fullPathCropped + "/base/file/info-load", {}).done(function (data) {
            SpinnerBody(false);
            bootbox.confirm({
                message: data,
                buttons: {
                    confirm: {
                        label: 'Выбрать файл',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'Отмена',
                        className: 'btn-secondary'
                    }
                },
                callback: function (result) {
                    if (!result) return;
                    $('#input_add_file').click();
                }
            });
        });
    });
    //отправляем форму после выбора файлов
    $('#input_add_file').change(function () {
        $('#add_file').submit();
    });

    //-----------chosen-start--------------------
    $("#Teg").chosen({
        width: "100%",
        no_results_text: "Поиск по запросу: ",
        max_selected_options: 5,
    });
    //очищаем select от невыбранных значений
    $("#Teg").chosen().change(function (){
        var sel_value = $("#Teg").val();

        $('#Teg').find('option').each(function () {
            let opt_value = $(this).attr('value');
            if(sel_value.indexOf( opt_value ) == -1){
                $(this).remove(); //отчищаем поля от невыбранных значений
            }
        });
        $("#Teg").trigger("chosen:updated");
    });

    //поиск тегов через ajax
    $('#Teg_chosen .search-field').find('input').autocomplete({
        delay: 900,
        minLength: 2,
        source: function (request, response) {
            var el = $('#Teg_chosen .search-field').find('input');
            var search_param = el.val();//искомое слово
            $.get(fullPathCropped + '/base/file/get-tegs', {
                name: search_param
            }, function(data) {
                var data = JSON.parse(data);

                for (var id in data) {
                    //если такого тега нет в списке тогда добавляем его!
                    if($('#Teg option[value="'+id+'"]').html() == null){
                        $("#Teg").append('<option value="' + id + '">' + data[id] +'</option>');
                    }
                }
                $("#Teg").trigger("chosen:updated");

                var e = jQuery.Event( "keyup");
                el.val(search_param).trigger(e);
                //anSelected = $(".chosen-select").val();
                $('.tag-spinner').hide();
            });
        },
        search: function(event, ui) {
            $('.tag-spinner').show();
        },
    });
    //-----------chosen-end-------------------
    //маска для поля ввода даты
    $.mask.definitions['~'] = '[+-]';
    var filtr_date = $('#date-range');
    filtr_date.mask('99.99.9999 - 99.99.9999');

    //перевод DatePicker на русский
    var loc = {
        applyLabel: applyLabelDate,
        cancelLabel: cancelLabel,
        fromLabel: fromLabelDate,
        toLabel: toLabelDate,
        customRangeLabel: 'Custom',
        daysOfWeek: [suDate, moDate, tuDate, weDate, thDate, frDate, saDate],
        monthNames: [janDate, febDate, marchDate, aprDate, mayDate, juneDate, julDate, augDate, sepDate, octDate, novDate, decDate]
    };
    filtr_date.daterangepicker({
        'applyClass': ' btn-success',
        'cancelClass': ' btn-default',
        locale: loc,
        format: 'DD.MM.YYYY'
    });
    filtr_date.on("apply.daterangepicker", function (ev, picker) {
        $('#StartDate').val(picker.startDate.format('DD.MM.YYYY'));
        $('#EndDate').val(picker.endDate.format('DD.MM.YYYY'));
    });

    //очищаем фильтры от старых данных
    $('#clearFilter').on('click', function () {
        $('#date-range').val('');
        $('#StartDate').val('');
        $('#EndDate').val('');
        $('#UserCreate').val('');
        $('#FileName').val('');
        $('#Teg').val('');
        $("#Teg").trigger("chosen:updated");
    });

    //обработка события по кнопке "поиск"
    $('#searchButton').click(function (e) {
        var el = $(this);
        var fd = new FormData($(this).parents('form')[0]);
        $('#iconSearch').attr('class', 'ace-icon fa fa-refresh fa-spin');

        $.ajax({
            url: fullPathCropped + "/base/home/search-index",
            type: "POST",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
        }).done(function (data) {
            $('#iconSearch').attr('class', 'ace-icon fa fa-search');
            var tbody = $('#searchInfo');
            tbody.empty();
            tbody.html(data);
        });
    });
    $('#searchButton').click();//атвозапуск отчета
});