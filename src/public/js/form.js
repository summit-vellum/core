var asTimer = null,
    // asDelay = 2000, //change to 5 minutes (2 seconds for now)
    asDelay = 5 * 60 * 1000, //5 minutes
    modSegment = $(location).attr('href').split("/"),
    moduleName = modSegment[3];

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
        var data = $("form").serialize(),
            formId = $("form").find('input[name="id"]'),
            formType = $("form").find('input[name="_method"]');

        formId = formId.val() ? formId.val() : 0;
        
        $.ajax({
            type: formType.val(),
            url: document.location.origin + '/' + moduleName + '/autosave/' + formId,
            data: data,
            success: function (res) {
                if (res.newMethod) {
                    formId.val(res.id);
                    formType.val(res.newMethod);
                }
            },
        });
    }, asDelay );
}