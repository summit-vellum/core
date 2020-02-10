var asTimer = null,
    asDelay = 2000, //change to 5 minutes (2 seconds for now)
    // asDelay = 5 * 60 * 1000, //5 minutes
    modSegment = $(location).attr('href').split("/"),
    moduleName = modSegment[3],
    inputFields = 'form input, form textarea',
    selectFields = 'form select, form input[type="radio"], form input[type="checkbox"]';

$(document).on('blur', inputFields,function(){
    if ($(this).attr('autoslug')) {
        var slug = convertToSlug($(this).val()),
            slugAttrName = 'autoslug-'+$(this).attr('autoslug'),
            slugField = $('['+slugAttrName+']');

        $('#autoslug-warning').remove();

        $.each(slugField, function (sKey, sVal) {
            if ($(sVal).attr(slugAttrName) == "off") { return; }

            if ($(sVal).attr(slugAttrName) == "once") {
                $(sVal).attr(slugAttrName, "off");
            }

            $(sVal).val(slug);
        });
    }
});

$(document).on('focus',inputFields ,function(){
    if ($(this).attr('autoslug')) {
        var warningMsg = '<small id="autoslug-warning" class="cf-note" style="color: orange">Editing this might affect other fields.</small>';
        $(warningMsg).appendTo('#help-'+$(this).attr('autoslug'));
    }
});

$(document).on('input',inputFields ,function(){
    characterCount($(this));
});

$(document).on('keyup',inputFields ,function(){
    autosave();
});

$(document).on('change', selectFields,function(){
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

        entryId = formId.val() ? formId.val() : 0;
        
        $.ajax({
            type: formType.val(),
            url: document.location.origin + '/' + moduleName + '/autosave/' + entryId,
            data: data,
            success: function (res) {
                console.log(res);
                if (res.newMethod) {
                    formId.val(res.id);
                    formType.val(res.newMethod);
                }
            },
        });
    }, asDelay );
}

function characterCount(input){
    if (input.attr('max-count')) {
        var countId = input.attr('id'),
            countNum = input.val().length,
            helpMsg = $("form").find('#help-'+countId).find('[help-original]');
            maxMsg = helpMsg.attr('help-maxed'),
            minCount = input.attr('min-count'),
            maxCount = input.attr('max-count');
        
        $("form").find('#count-'+countId).text(countNum);

        var color = 'green';

        if (countNum == 0) {
            color = '#e1e1e1';
        }else if(countNum >= 1 && countNum <= minCount){
            color = 'green';
        }else if(countNum >= parseInt(minCount)+1 && countNum <= maxCount){
            color = 'yellow';
        }else if (countNum >= parseInt(maxCount)+1){
            color = 'red';
        }

        input.css('border-color', color);

        if (maxMsg) {
            if (maxCount < countNum) {
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

    $.each($('form textarea'), function (v) {
        characterCount($(this));
    });
});