$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    $('.file-row').on('click',function () {
        SpinnerBody(true);
        var el = $(this);
        CloseFileBar();

        $.post(fullPathCropped + "/base/file/file-bar", {
            'file_id': el.attr('id'),
        }).done(function (data) {
            var file_bar = document.createElement("div");
            file_bar.id = 'file_bar';
            file_bar.innerHTML = data;
            $('.wrapper').append(file_bar);
            el.css({'background':'#59686f','color':'#fff'});
            old_el = el;
            SpinnerBody(false);
        });
    });

    $(document).click(function (e){ // событие клика по веб-документу
        var div = $("#file_bar"); // тут указываем ID элемента
        var share = $("#share-block"); // тут указываем ID элемента
        if (!div.is(e.target ) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            CloseFileBar(); // скрываем его
        }
        if (!share.is(e.target ) // если клик был не по нашему блоку
            && share.has(e.target).length === 0) { // и не по его дочерним элементам
            $('.rambler-share').hide(); // скрываем его
        }
    });
});

var old_el;
function CloseFileBar(el = old_el){
    $('#file_bar').remove();
    if(el){
        el.css({'background':'','color':''});
    }
}