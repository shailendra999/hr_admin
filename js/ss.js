(function ($) {
	/*----------------*/
		$(document).ready(function(){
		/*------------Active link at left sidebar [Code starts]---------------------*/
		var path = window.location.pathname;
			path = path.split('/');
			//alert(path[2]);
		$("#cssmenu li li ").find("a[href='" + path[2] + "']").each(function () {
			//alert('match found');
			jQuery(this).css({"color": "#fff", "color": "#72AA00"});
		});
		/*------------Active link at left sidebar [Code Ends here]---------------------*/		
	});
	/*---------------*/
    $(document).ready(function () {
		 $('#cssmenu > ul > li > a').click(function () {
			$('#cssmenu li').removeClass('active');
			 $(this).closest('li').addClass('active');
		     var checkElement = $(this).next();
			 
	            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
				}
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#cssmenu ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');				
			}
			
			
			 
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;
            }
        });
    });
})(jQuery);
/*
$(document).ready(function () {
		$('#cssmenu > ul > li > a').click(function () {
        alert("hello");
		var href = $(this).attr('href');
        alert(href);
			});
});
*/

