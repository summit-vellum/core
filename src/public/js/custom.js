$(function() {
    $('.btn-delete').click(function(e) {
        $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: {
                _method: "delete",
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                window.location.reload();
            },
            error: function(status) {
                console.log(status);
            }
        });
        e.preventDefault();
    });
});

$(function() {
    $('.btn-unlock').click(function(e) {
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'POST',
            data: {
                _method: "post",
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
            },
            error: function(status) {
                console.log(status);
            }
        });
        e.preventDefault();
    });
});
