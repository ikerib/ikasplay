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
    $("#divOkerra").hide();
    $("#divZuzena").hide();
    let balioa = $(this).data('balioa');

    if ( balioa === 1  ) {
        $("#divOkerra").hide();
        $("#divZuzena").show();
    } else {
        $("#divOkerra").show();
        $("#divZuzena").hide();
    }
});

