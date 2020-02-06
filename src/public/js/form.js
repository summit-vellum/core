var asTimer = null,
    // asDelay = 2000, //change to 5 minutes (2 seconds for now)
    asDelay = 5 * 60 * 1000, //5 minutes
    modSegment = $(location).attr('href').split("/"),
    moduleName = modSegment[3];

$(document).on('blur','form input',function(){
    if ($(this).attr('autoslug')) {
        var slug = convertToSlug($(this).val()),
            slugAttrName = 'autoslug-'+$(this).attr('autoslug'),
            slugField = $('['+slugAttrName+']');

        $.each(slugField, function (sKey, sVal) {
            if ($(sVal).attr(slugAttrName) == "off") { return; }

            if ($(sVal).attr(slugAttrName) == "once") {
                $(sVal).attr(slugAttrName, "off");
            }

            $(sVal).val(slug);
        });
    }
});

$(document).on('input','form input',function(){
    characterCount($(this));
});

$(document).on('keyup','form input',function(){
    characterCount($(this));
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

function characterCount(input){
    if (input.attr('max-characters')) {
        var countId = input.attr('id'),
            countNum = input.val().length,
            helpMsg = $("form").find('#help-'+countId+' > .cf-note');
            maxMsg = helpMsg.attr('help-maxed');
        
        $("form").find('#count-'+countId).text(countNum);
        
        if (maxMsg) {
            if (input.attr('max-characters') < countNum) {
                helpMsg.text(maxMsg);
            } else {
                helpMsg.text(helpMsg.attr('help-original'));
            }
        }
    }
}

function convertToSlug(string){
    return string
        .trim()
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');
}

$(window).on("load", function(){
    $.each($('form input'), function (v) {
        characterCount($(this));
    });
});