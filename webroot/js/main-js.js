

$(function() {

    var closeWind = 1;
        $('body').mouseleave(function () {
            if (closeWind == 1) {
                if (confirm("Close Window?")) {
                    closeWind = 0;
                }
            }
        });

    $('#mail').delay(15000).fadeIn(1000);
});/**
 * Created by litter on 04.05.16.
 */
