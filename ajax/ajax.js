$(document).ready(function() {
	$(document).on('submit', '#form', function(e) {
		e.preventDefault();

		var form = $(this);
		var action = form.attr('action');
		var method = form.attr('method');
		var data = new FormData(form[0]);

		$.ajax({
			url: action,
			type: method,
			data: data,
			contentType: false,
			cache: false,
			processData: false,

			success: function(data) {
				var response = $.parseJSON(data);

				if (response['status'] == 'success') {
					$('.alert-danger').hide();
					$('.alert-success').removeClass('invisible').text(response.message);
					setTimeout(function() {
						$(location).attr('href', '/');
					}, 1000);
				} else if (response['status'] == 'fail') {
					$('.alert-danger').removeClass('invisible').text(response.errors);
				}
			},
			error: function(e) {
				var errors = e.responseJSON;
				
				for(err in errors) {
					form.find('*[name="' + err + '"]').closest('.form-group').append('<span class="error">' + errors[err] + '</span>');
				}
			}
		});
	});
});

// В контроллере echo json_encode($response);