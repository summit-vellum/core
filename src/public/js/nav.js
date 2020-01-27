$(document).ready(function() {
    $('[data-menu="bg"]').on("mouseover", function(e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
    $('[data-menu="bg"]').on("mouseout", function(e) {
        $(this).parent('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});