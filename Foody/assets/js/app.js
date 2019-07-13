;(function(d,w,$){
	
	var $doc = $(d);
	var $win = $(w);


		
		$doc.ready(function(){ 
			var $canvasMobileOpen = $('#mobile-open');
			var $canvasMobileClose = $('#mobile-close');
			var $canvasMenu = $('#menu');

			$canvasMobileOpen.on('click',function(){
				$canvasMenu.addClass('mobile-open');
			})

			$canvasMobileClose.on('click',function(){
				$canvasMenu.removeClass('mobile-open');
			})
		})
	

})(document,window,jQuery)