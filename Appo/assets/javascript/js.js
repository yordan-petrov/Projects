;(function ( d, w, $){

	var $doc = $(d);

	$doc.ready(function() {

			var $mobileMenu = $('#main-navigation');
			var $canvasOpen = $('.canvas-open');
			var $canvasClose = $('.canvas-close');

			$canvasOpen.on('click',function(){
				$mobileMenu.addClass('open');
			})

			$canvasClose.on('click',function(){
				$mobileMenu.removeClass('open');
			})
		});

})( document, window, jQuery);