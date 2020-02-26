var asTimer = null,
    asDelay = asDelay ? asDelay : false,
    modSegment = $(location).attr('href').split("/"),
    moduleName = modSegment[3],
    inputFields = 'form input, form textarea',
    selectFields = 'form select, form input[type="radio"], form input[type="checkbox"]',
    token = $("form").find('input[name="_token"]').val();

$(document).on('blur', inputFields,function(){
    convertToSlug($(this));
    uniqueChecker($(this));
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
    if  (asDelay) {
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
}

function characterCount(input){
    if (input.attr('max-count')) {
        var countId = input.attr('id'),
            countNum = input.val().length,
            info = $("form").find('#help-'+countId),
            helpMsg = info.find('[help-original]');
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
        info.find('.help-info').removeClass('hide');
        info.find('.help-validated-check ').addClass('hide');

        if (maxMsg) {
            if (maxCount < countNum) {
                helpMsg.text(maxMsg);                
            } else {
                helpMsg.text(helpMsg.attr('help-original'));
            }
        }
    }
}

function convertToSlug(input){ 
    var autoslug = input.attr('autoslug');
    if (autoslug) {
    
        $.ajax({
            type:"POST",
            url: document.location.origin + '/' + moduleName + '/to-slug',
            data: {"_token": token, "value": input.val()},
            success: function (res) {
                if (res.slug) {
                    var slugAttrName = 'autoslug-'+autoslug,
                        slugField = $('['+slugAttrName+']');
                        
                    $.each(slugField, function (sKey, sVal) {
                        if ($(sVal).attr(slugAttrName) == "off") { return; }
            
                        if ($(sVal).attr(slugAttrName) == "once") {
                            $(sVal).attr(slugAttrName, "off");
                        }
            
                        $(sVal).val(res.slug);
                    });
                }
            },
        });

        $('#autoslug-warning').remove();
    }
}

function uniqueChecker(input){
    if (input.attr('unique-message') && input.attr('autoslug')) {
        var fieldName = input.attr('name');

        $.ajax({
            type:"POST",
            url: document.location.origin + '/' + moduleName + '/check-unique',
            data: {"_token": token, "name": fieldName, "value": input.val()},
            success: function (res) {
                if (res.count) {
                    var info = $("form").find('#help-'+input.attr('id'));
                    info.find('[help-original]').text(input.attr('unique-message'));
                    info.find('.help-info').addClass('hide');
                    info.find('.help-validated-check ').removeClass('hide').css('fill', 'green');
                }
            },
        });
    }
}

$(window).on("load", function(){
    $.each($('form input'), function (v) {
        characterCount($(this));
    });

    $.each($('form textarea'), function (v) {
        characterCount($(this));
    });
});