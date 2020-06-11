(function ($) {

    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    $(".skip").click(function(){
        $(this).parents('.panel')[0].remove();
    });

    $(".update_file").click(function(e){
        e.preventDefault();
        var el = $(this);
        var fd = new FormData($(this).parents('form')[0]);
        $.ajax({
            url: fullPathCropped + "/base/file/update",
            type: "POST",
            data: fd,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                console.log(data == true);
                console.log(data == 'true');
                if(data == true){
                    el.parents('.panel')[0].remove();
                }
                if($('.panel').length == 0){
                    document.location.href = fullPathCropped + '/base/file/my-file';
                }
            }
        });
    });

    $('.option-str').on('keyup',function(){
        let value = $(this).val();
        value = value.replace(/[^0-9, \.a-zа-яё-]/ig,"")
                     .replace(/\s\s+/g," ")
                     .replace(/-{2,}/g,"-")
                     .replace(/\.{2,}/g,".")
                     .replace(/^[^a-zа-я0-9]/gi,"");
        $(this).val(value);
    });
})(jQuery);




