//
// window.onbeforeunload = function() {
//         return "Вы действительно хотите покинуть сайт?";
// };

var canGoOut = 0;
$(document).mouseleave(function(e) {
        if (canGoOut != 1) {
                var msg = 'Вы действительно хотите покинуть сайт?';
                var res = confirm(msg);
                if (res) {
                        canGoOut = '1';
                }
        }
});



