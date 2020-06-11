$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#avatar').css({'background': 'url('+ e.target.result +')','background-size': 'cover'});
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#add_photo').on('click', function () {
        $('#input_add_photo').click();
    });
    $('#input_add_photo').on('change',function () {
        readURL(this);
    });

    $('#get_pas').on('click',function(){
        $.post(fullPathCropped + "/base/user/recovery", {
        "":"",   
        }).done(function (data) {
            bootbox.alert(data,function () {
                document.location.href = fullPathCropped + '/base/user/logout';
            });
        });

    });

});