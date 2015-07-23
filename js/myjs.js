$(document).ready(function () {
		$('#cssmenu > ul > li > a').click(function () {
        var href = $(this).attr('href');
        alert(href);
			});
});
