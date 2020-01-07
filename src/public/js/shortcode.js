var d = document;
var shortcode_field = d.querySelector('#shortcode');
var shortcode_value = shortcode_field.value;
var shortcode_regex = /\[(\w+):((\d+)|(\[{.+?}\])|({.+?})|(.+?))\]/;
var parameters;

function setCookie(cname, cvalue, exdays) {
    var date = new Date();
    date.setTime(date.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + date.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie() {
    var user = getCookie("username");
    if (user != "") {
        alert("Welcome again " + user);
    } else {
        user = prompt("Please enter your name:", "");
        if (user != "" && user != null) {
            setCookie("username", user, 365);
        }
    }
}

function registerCookieToLaravel(url, data) {
    // fetch(url, {
    //     method: 'post',
    //     headers: {
    //         // "Content-type": "application/json;",
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     body: encodeURI('shortcode=' + value)
    //     // {
    //     // 'shortcode': value
    //     // } //'shortcode='+ value
    // }).then(function(response) {
    //     response.json();
    // }).then(function(data) {
    //     console.log('Request succeeded with JSON response', data);
    // }).catch(function(error) {
    //     console.log('Request failed', error);
    // });
    $.extend(data, {_token: $('meta[name="csrf-token"]').attr('content')});
    console.log(data);
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: data,
        success: function(data) {
            //do success
        }
    });
}
shortcode_value.replace(shortcode_regex, function(match, code, param) {
    param = JSON.parse(param);
    parameters = {
        code: code,
        value: param
    };
});
var elements = d.querySelectorAll('[data-shortcode]');
var values = parameters.value;

function objectShortcodes(key, field, currentValue) {
    if (field.checked) {
        values[key].push(currentValue);
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
    if (this instanceof MutationObserver) {
        var key = item[0].target.dataset.shortcode;
        var tagName = 'OBSERVE';
    } else {
        var key = this.dataset.shortcode;
        var currentValue = this.value;
        var tagName = this.tagName;
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

    var shortcode = "[" + parameters.code + ":" + JSON.stringify(parameters.value) + "]";
    // var input = JSON.stringify(getTextfromCells(this));
    var input = getTextfromCells(this);
    console.log(input);

    registerCookieToLaravel('/article-reco', {shortcode, input});
    shortcode_field.value = shortcode;
}

function getTextfromCells(item)
{
	var cells = $(item).parent().parent().find('.table-cell');
	var textFromCells = [];

	for(var i = 0; i<cells.length;i++) {
		var cell = cells[i].textContent.trim();
		if(cell === '') continue;
		textFromCells.push(cell);
	}

	return textFromCells;
}

for (var i = 0; i < elements.length; i++) {
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
