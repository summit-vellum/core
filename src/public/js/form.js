var asTimer = null,
    // asDelay = 2000, //change to 5 minutes (2 seconds for now)
    asDelay = 5 * 60 * 1000, //5 minutes
    modSegment = $(location).attr('href').split("/"),
    moduleName = modSegment[3],
    moduleId = modSegment[4];

$(document).on('keyup','form input',function(){
    autosave();
});

$(document).on('change','form select, form input[type="radio"], form input[type="checkbox"]',function(){
    autosave();
});

function autosave(){
    if (asTimer) {
        clearTimeout(asTimer);
    }

    asTimer = setTimeout(function () {
        var data = $("form").serialize();
        $.ajax({
            type: $("form").find('input[name="_method"]').val(),
            url: document.location.origin + '/' + moduleName + '/autosave/' + moduleId,
            data: data,
            success: function (res) {
                if (res.redirect) {
                    window.location.href = res.redirect;
                }
            },
        });
    }, asDelay );
}