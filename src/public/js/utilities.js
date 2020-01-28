
var ajaxModal = $('[data-ajax-modal]'),
	ajaxButtons = $('[data-ajax-button]');

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

    console.log(items);

    $.each(items, function(key, val) {
    	var attr = '[data-modal-' + key + ']';
        targetModal.find(attr).text(val);
    });

});

ajaxButtons.on('click', function(event) {
	console.log('ajax buttons clicked');
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
            if(typeof callback !== 'undefined') {
                window[callback](response);
            } else {
                location.reload();
            }
        // }
    });
});

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
