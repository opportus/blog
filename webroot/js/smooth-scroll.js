jQuery(document).ready(function ($) {
	var elems = $('.navbar-left').find('.scroll-to');

	elems.click(function () {
		var href  = $(this).attr('href'),
		    id    = href.substring(href.lastIndexOf('#')),
		    speed = 750;

		$('html, body').animate({scrollTop: $(id).offset().top}, speed);

		return false;
	});
});
