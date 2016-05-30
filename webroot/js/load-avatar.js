//Центрируем аватарку ------------------------ Старт
function avaCentred($avaSel,$parent){
    $($avaSel).each(function(){
        var parentWidth = $($parent).width(),
            imgWidth = $(this).width(),
            leftMargin = (parentWidth - imgWidth) / 2;
        //alert ('1');
        if (imgWidth > $(this).height()) {
            //    $(this).css("marginLeft", leftMargin);
            $(this).css("maxHeight","75px").css("maxWidth","none");
        }
        else {
            $(this).css("maxWidth","75px").css("maxHeight","none");
        }
    });

}
//Центр. аватарку-----------------------          Конец

//Comments Avatar align
var removeAva = $("#remove-ava");

// removeAva.hide();

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

//Form Avatar Align and Preview
$("#avatar-input").change(function(){
    readURL(this);
    $(".btn-file").fadeOut();
    removeAva.fadeIn();

    $("#avatar").hide().load(function(){
        var parentWidth = $(this).parent().width(),
            imgWidth = $(this).width(),
            imgHeight = $(this).height(),
            leftMargin = (parentWidth - imgWidth) / 2;

        if (imgWidth > imgHeight) {
            $(this).css("marginLeft", leftMargin).width("auto").height("100%");
        }
        else {
            $(this).width("400px").height("auto");
        }
    }).fadeIn(500);
});

//Delete Avatar Button
removeAva.click(function(){
    if($('#avatar').attr('src').indexOf('avatar') < 0) {
        $("#avatar").css("marginLeft","").fadeOut(100).attr("src",REL_URL + "/images/avatars/avatar.png").fadeIn(100);
        removeAva.fadeOut();
        $(".btn-file").fadeIn();
    };
});
//Feedback----------------------------                                  END