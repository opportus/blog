jQuery(document).ready(function($) {
	if ($('form').length > 0) {
		var busy = null;

		$('.form-send').click(function() {
			var button  = $(this),
				form    = button.closest('form'),
				fields  = form.find('.form-control');

			if (busy)
				busy.abort();

			busy = $.ajax({
				url:     button.attr('ajaxaction'),
				type:    'POST',
				data:    form.serialize(),
				success: function(response) {
					if (response.redirect) {
						window.location.replace(response.redirect);
					}

					if ($('#form-notif').length === 0) {
						$('<p id="form-notif" style="display:none;"></p><hr>').insertBefore('form');
					}
					
					if (response.status === true) {
						$('#form-notif').attr('class', 'form-notif-success').html('<i class="fa fa-check" aria-hidden="true"></i>' + response.notif);

						fields.each(function() {
							$(this).removeAttr('style');
						});

						if (response.refresh) {
							form[0].reset();
						}

					} else {
						$('#form-notif').attr('class', 'form-notif-failure').html('<i class="fa fa-times" aria-hidden="true"></i>' + response.notif);

						fields.each(function() {
							if($(this).attr('name') in response.errors) {
								$(this).css('border-color', '#cc0000');

							} else {
								$(this).css('border-color', '#4BB543');
							}
						});
					}

					$('#form-notif').fadeIn();

					var rect = $('#form-notif')[0].getBoundingClientRect();

					if (!(rect.bottom > 0 &&
						rect.right > 0 &&
						rect.left < (window.innerWidth || document.documentElement.clientWidth) /* or $(window).width() */ &&
						rect.top < (window.innerHeight || document.documentElement.clientHeight) /* or $(window).height() */
					)) {
						$('html, body').animate({scrollTop:0}, 'slow');
					}
				}
			});

			return false;
		});
	}
});

function isElementInViewport(el) {
}
