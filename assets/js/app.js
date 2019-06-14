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

    const miid = $(this).data("id");
    const selbal = $(this).data("balioa");
    let zuzena = 0;

    $(".erantzuna").each(function (  ) {
        const $bal = $(this).data("balioa");
        if ( $bal !== 1 ) {
            $(this).addClass("strike");
            $(this).contents().unwrap();
        } else {
            $(this).addClass('zuzena_azpimarratu')
        }
        if ( selbal === $bal ) {
            zuzena = 1;
        }
    });

    $.ajax({
        url: "/quizz/" + miid,
        type: "GET",
        data: "result=" + zuzena,
        success: function ( data ) {
            console.log(data);
        },
        error: function ( err ) {
            console.log(err);
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

