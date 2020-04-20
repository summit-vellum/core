var ajaxModal = $('[data-ajax-modal]'),
	ajaxButtons = $('[data-ajax-button]')
	postConfig = ($('#post_config').length != 0) ? JSON.parse($('#post_config').val()) : '';

	console.log(postConfig);

var url = function(channel, slug, element) {
	var segments = postConfig.protocol+postConfig.domain;
		segments += '/';
        segments += (channel != '') ? channel : 'channel/subcannel/';
        segments += slug;

    $(element).val(segments);
}

ajaxModal.on('click', function(event) {
	var
        el          = $(this),
        config      = el.data('ajaxModal'),
        targetModal = $(el.data('target')),
        items       = config.items,
        id          = config.id,
        submit      = targetModal.find('[data-ajax-button]'),
        params      = config.params;

    event.preventDefault();
    submit.data('ajaxButton', params);

    $.each(items, function(key, val) {
    	var attr = '[data-modal-' + key + ']';
        targetModal.find(attr).text(val);
    });

});

ajaxButtons.on('click', function(event) {
    var
        config = $(this).data('ajaxButton'),
        url    = config.url,
        type   = (typeof config.type !== 'undefined' ? config.type : 'PATCH' ),
        params = config.data,
        callback = config.callback;

    event.preventDefault();
    /* Act on the event */

    ajaxPartialUpdate(url, type, params).then(function(response){
        // if (response.status.code == 200) {
            if (typeof callback !== 'undefined') {
            	if (callback == 'directToUrl') {
            		directToUrl(config.link);
            	} else {
            		window[callback](response);
            	}
            } else {
               location.reload();
            }
        // }
    });
});

var directToUrl = function(url) {
	window.location.href = url;
}

var ajaxPartialUpdate = function(url, type, params) {
    var data = { '_token': $('meta[name="csrf-token"]').attr('content') };

    if (typeof params !== 'undefined') {
        $.extend(data, params);
    }

    return $.ajax({
        type: type,
        url: url,
        data: data,
        success: function (response) {
            return response;
        }
    });
}
var removeModalSrc = function(){
	var toolModal = $('#toolModal', window.parent.document);
	toolModal.find('iframe').attr('src', '');

	 if (toolModal.hasClass('preventUniversalClick')) {
		toolModal.removeClass('preventUniversalClick');
	}
}

$('#toolModal', window.parent.document).click(function(){
	if (!$(this).hasClass('preventUniversalClick')) {
		removeModalSrc();
	}
 });

$(document).on('click','[close-modal]' ,function(){
    $('#toolModal', window.parent.document).trigger('click');
});

$(document).on('click','[data-toggle]' ,function(){
    var target = $(this).attr('data-target'),
        url = $(this).attr('data-url');

    $(target).find('iframe').attr('src', url);
});
