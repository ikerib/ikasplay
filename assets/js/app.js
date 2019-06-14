global.$ = global.jQuery = $;
// const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    $('.collectionClass').collection();
});



$(".erantzuna").on("click", function () {

    $(".erantzuna").each(function (  ) {
        const $bal = $(this).data("balioa");
        if ( $bal !== 1 ) {
            $(this).addClass("strike");
            $(this).contents().unwrap();
        } else {
            $(this).addClass('zuzena_azpimarratu')
        }
    });

    let $quizz_resp = $(this).data("balioa");
    $("#divPagination").show();
    if ( $quizz_resp === 1 ) {
        $(".emoZuzena").show()
    } else {
        $(".emoOkerra").show()
    }

});

