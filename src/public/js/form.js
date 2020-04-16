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

var slug = function(str) {
    var $slug = '';

    var trimmed = $.trim(str);

    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
    replace(/-+/g, '-').
    replace(/^-|-$/g, '');

    return $slug.toLowerCase();
}

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
        info.find('.help-validated-check').addClass('hide');
        info.find('.help-validated-error').addClass('hide');

        if (maxMsg) {
            if (maxCount < countNum) {
                helpMsg.text(maxMsg);
            } else {
                helpMsg.text(helpMsg.attr('help-original'));
            }
        }

        helpMsg.removeAttr('style');
    }
}

function convertToSlug(input){
    var autoslug = input.attr('autoslug'),
    	val = input.val();

    if (autoslug) {

        $.ajax({
            type:"POST",
            url: document.location.origin + '/' + moduleName + '/to-slug',
            data: {"_token": token, "value": val},
            success: function (res) {
                if (res.slug) {
                    var slugAttrName = 'autoslug-'+autoslug,
                        slugField = $('['+slugAttrName+']');

                    $.each(slugField, function (sKey, sVal) {
                    	var slugReadOnly = ($(sVal).attr('readonly')) ? true : false;
                        if ($(sVal).attr(slugAttrName) == "off") { return; }

                        if ($(sVal).attr(slugAttrName) == "once") {
                            $(sVal).attr(slugAttrName, "off");
                        }

                        if (!slugReadOnly) {
                        	$(sVal).val(res.slug).trigger('change');
                        }
                    });
                }
            },
        });

        $('#autoslug-warning').remove();
    }
}

function uniqueChecker(input){
	var uniqueMsg = input.attr('unique-message'),
		val = input.val(),
		slugId = (input.attr('slugId')) ? '#'+input.attr('slugId') : '',
		slugReadOnly = ($(slugId).attr('readonly')) ? true : false;

    if (val != '' && uniqueMsg && input.attr('autoslug') && !slugReadOnly) {
        var fieldName = input.attr('name'),
        	valSlug = slug(val);

        uniqueMsg = JSON.parse(uniqueMsg);

        $.ajax({
            type:"POST",
            url: document.location.origin + '/' + moduleName + '/check-unique',
            data: {"_token": token, "name": fieldName, "value": val, "slug": valSlug},
            success: function (res) {
            	var info = $("form").find('#help-'+input.attr('id'));
                if (res.count) {
                	$('#article-status button').attr('disabled', false);
                    info.find('[help-original]').text(uniqueMsg.unique).css('color', 'green');
                    info.find('.help-info').addClass('hide');
                    info.find('.help-validated-check').removeClass('hide').css('fill', 'green');
                } else {
                	$('#article-status button').attr('disabled', true);
                    info.find('[help-original]').text(uniqueMsg.hasDuplicate).css('color', 'red');
                    info.find('.help-info').addClass('hide');
                    info.find('.help-validated-error').removeClass('hide').css('fill', 'red');
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

/* tinymce word count */
var wordCount = function (editor) {
	var words = editor.replace(/(\r\n|\n|\r)/gm, " ")
                    .replace(/<div class="credits">(.*?)<\/div>/ig,"")
                    .replace(/<span class="credits"(.*?)<\/span>/ig,"")
                    .replace(/\[(gallery|gallerylistview|poll|quiz|video|ArticleReco|facebook|twitter|pin|instagram|previous|page|next|mobilestripad|youtube|survey|ImageFlip|CustomButton|spotify):((\d+)|(\[{.+?}\])|({.+?})|(.+?))\]/g,' ')
                    .replace(/\[(searchbox)\]/,' ')
                    .replace('/&#?[a-z0-9]{2,8};/i', '')
                    .replace(/(&nbsp;|<([^>]+)>)/ig,"")
                    .replace(',',"")
                    .replace(':',"")
                    .replace(/-/g, '')
                    .replace(/\s\s+/g, ' ');

    var count = 0;
    if ($.trim(words) != '') {
        words = words.split(/(\s+)/);
        $.each(words, function(i, str){
            str = $.trim(str);
            if (str) {
                count++;
            }
        });
    }

    return count;
}
