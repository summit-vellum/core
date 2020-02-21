var d = document,
	shortcode_field = d.querySelector('#shortcode'),
 	shortcode_value = shortcode_field.value,
	shortcode_regex = /\[(\w+):((\d+)|(\[{.+?}\])|({.+?})|(.+?))\]/,
	parameters,
	shortcode_trigger = shortcode_field.dataset.shortcodeTrigger,
	checkbox_validation = shortcode_field.dataset.checkboxValidation,
	checkbox_max = shortcode_field.dataset.checkboxMax,
	checkbox_min = shortcode_field.dataset.checkboxMin,
	shortcode_route = shortcode_field.dataset.shortcodeRoute,
	cookie_length = checkBoxLength = 0,
	shortcode_key;

shortcode_value.replace(shortcode_regex, function(match, code, param) {
    param = JSON.parse(param);
    parameters = {
        code: code,
        value: param
    };
});

var elements = d.querySelectorAll('[data-shortcode]'),
	values = parameters.value;

updateCookieInLaravel(shortcode_route, {}, true);

function updateCookieInLaravel(url, data, init) {
    $.extend(data, {_token: $('meta[name="csrf-token"]').attr('content')});
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: data,
        success: function(data) {
        	$('[data-selected]').empty();
            $.each(data['data'], function(index, value) {
            	$.each(value, function(index, item) {
            		var selectedItemContainer = $('[data-selected-item]').clone();

        			selectedItemContainer.removeClass('hide')
	            	.removeAttr('data-selected-item')
	            	.attr('data-id', item.id)
	            	.find('[data-title]').text(item.title);
	            	$('[data-selected]').removeClass('hide').append(selectedItemContainer);

	            	if (init) {
	            		$('[table-row][data-id="'+item.id+'"] td [data-shortcode]').attr('data-init', true).click();
	            	}

            	});
            });

            if (data.removedId && data.deleteCookie) {
    			values[shortcode_key] = values[shortcode_key].filter(value => value !== JSON.stringify(data.removedId));
    			shortcode_field.value = "[" + parameters.code + ":" + JSON.stringify(parameters.value) + "]";
    		}

    		if (init) {
    			$.each($('[data-selected] [selected-item]'), function(index, item) {
	        		if ($('[table-row][data-id="'+$(item).data('id')+'"] td [data-shortcode]').length == 0) {
	        			if ($.inArray(JSON.stringify($(item).data('id')), values[shortcode_key]) == -1){
	        				$(this).attr('data-no-el', true);
	        				values[shortcode_key].push(JSON.stringify($(item).data('id')));
	        				cookie_length++;
	        			}
						shortcode_field.value = "[" + parameters.code + ":" + JSON.stringify(parameters.value) + "]";
	        		}
	            });
    		}

            if (values[shortcode_key].length >= checkbox_min && values[shortcode_key].length <= checkbox_max) {
            	$(shortcode_trigger).removeAttr('disabled');
            }

        }
    });
}


$(document).on('click', '[remove-selected]', function(){
	var selectedId = $(this).parent().attr('data-id'),
		el = $('[table-row][data-id="'+selectedId+'"] td [data-shortcode]');

	if (el.is(':radio')) {
		el.attr('data-delete-item', true);
	}

	updateCookieInLaravel(shortcode_route, {input:{0:{id:selectedId}}, deleteCookie:1});
	el.click();

	console.log('checkboxcookie '+(checkBoxLength + cookie_length));
	if ((checkBoxLength + cookie_length) <= checkbox_min || (checkBoxLength + cookie_length) >= checkbox_max) {
		$(shortcode_trigger).attr('disabled', 'disabled');
	}

	cookie_length--;

	$('[selected-item][data-id="'+selectedId+'"]').remove();
});

function objectShortcodes(key, field, currentValue) {
    if (field.checked) {
    	if ($(field).is(':radio')) {
    		values[key].length = [];
		}

    	if ($.inArray(currentValue, values[key]) == -1){
    		values[key].push(currentValue);
		}

    } else {
        values[key] = values[key].filter(value => value !== currentValue);
    }
}

function nonObjectShortcodes(key, field, currentValue) {
    values[key] = currentValue;
}

function mutationObserverShortcodes(key, element) {
    for (let mutation of element) {
        if (mutation.type === 'attributes') {
            values[key] = mutation.target[mutation.attributeName];
        }
    }
}
// create a new instance of `MutationObserver` named `observer`,
// passing it a callback function
var observer = new MutationObserver(refreshShortcodeValue);

function refreshShortcodeValue(item, observer) {
	var onInitialize = this.dataset.init ? this.dataset.init : false,
		deleteCookie = isRadio = 0;

	checkBoxLength = $(this).parent().parent().parent().find('input:checked').length;

	$(this).removeAttr('data-init');

	isRadio = ($(this).is(':radio')) ? 1 : isRadio;
    deleteCookie = ($(this).prop('checked') == false) ? 1 : deleteCookie;

    if (($(this).is(':checkbox') && (checkBoxLength + cookie_length) >= checkbox_min && (checkBoxLength + cookie_length) <= checkbox_max) ||
    	(isRadio && $(this).prop('checked') == true)) {
		$(shortcode_trigger).removeAttr('disabled');
	} else {

		if ((checkBoxLength + cookie_length) > checkbox_max) {
			alert(checkbox_validation);
			item.preventDefault();

			return false;
		}

		if (!this.dataset.validationBypass) {
			$(shortcode_trigger).attr('disabled', 'disabled');
		}
	}

    if (this instanceof MutationObserver) {
        var key = item[0].target.dataset.shortcode,
        	tagName = 'OBSERVE';
    } else {
        var key = this.dataset.shortcode,
        	currentValue = (this.dataset.defaultValue && this.value == '') ? this.dataset.defaultValue : this.value,
        	tagName = this.tagName;
    }

    switch (tagName) {
        case 'INPUT':
            var methodName = (this.type !== 'text') ? objectShortcodes : nonObjectShortcodes;
            methodName(key, this, currentValue);
            break;
        case 'OBSERVE':
            mutationObserverShortcodes(key, item);
            break;
        default:
            console.log(this);
    }

    var shortcode = "[" + parameters.code + ":" + JSON.stringify(parameters.value) + "]",
    	input = getTextfromCells(this);

    if ($(this).is(':radio') && $(this).attr('data-delete-item')) {
    	deleteCookie = 1;
    	$(this).prop('checked', false);
    	shortcode = '';
    	$(this).removeAttr('data-delete-item');
    }

    if (!onInitialize) {
    	updateCookieInLaravel(shortcode_route, {shortcode, input, deleteCookie, isRadio}, false);
    }

    shortcode_field.value = shortcode;
}

function getTextfromCells(item)
{
	var cells = $(item).parent().parent().find('td'),
		textFromCells = [];

	for (var i = 0; i<cells.length;i++) {
		if (cells[i].getAttribute('data-field-selected')) {
			var cell = cells[i].textContent.trim();
			if(cell === '') continue;
			textFromCells.push({id: $(cells[i]).parent().attr('data-id'),
								title: cell});
		}
	}

	return textFromCells;
}

for (var i = 0; i < elements.length; i++) {
	if ($(elements[i]).is(':radio') || $(elements[i]).is(':checkbox')) {
		shortcode_key = elements[i].dataset.shortcode;
	}

    var listener = elements[i].dataset.shortcodeListen ? elements[i].dataset.shortcodeListen : false;
    if (listener === 'observe') {
        // call `observe` on that MutationObserver instance,
        // passing it the element to observe, and the options object
        observer.observe(elements[i], {
            attributes: true
        });
    } else {
        elements[i].addEventListener(listener, refreshShortcodeValue);
    }
}
