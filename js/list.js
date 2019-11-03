$(document).ready(function(){
	$('.list > li a').click(function() {
		$(this).parent().children('ul').toggle();
	});
});