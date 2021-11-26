var userAgent = navigator.userAgent.toLowerCase();
jQuery.browser = {
	version: (userAgent.match( /.+(?:rv|it|ra|ie|me)[\/: ]([\d.]+)/ ) || [])[1],
	chrome: /chrome/.test( userAgent ),
	safari: /webkit/.test( userAgent ) && !/chrome/.test( userAgent ),
	opera: /opera/.test( userAgent ),
	msie: /msie/.test( userAgent ) && !/opera/.test( userAgent ),
	mozilla: /mozilla/.test( userAgent ) && !/(compatible|webkit)/.test( userAgent )
};
function play(urlFile){
	var browser = ($.browser.msie || $.browser.chrome) ? 'ie' : '';
	var htmlLoading = '<div class="loading"><img src="images/loading.gif" alt="Cargando..." /></div>';
	
	$('#player').html(htmlLoading);
	$.post('player.php',{'url':urlFile,'browser':browser},
		function(data){
			$('#player').html(data);
		}
	);
	
	return false;
}
function descargar(urlFile){
	var browser = ($.browser.msie || $.browser.chrome) ? 'ie' : '';
	var htmlLoading = '<div class="loading"><img src="images/loading.gif" alt="Cargando..." /></div>';
	
	$('#player').html(htmlLoading);
	$.post('player.php?op=d',{'url':urlFile,'browser':browser},
		function(data){
			$('#player').html(data);
		}
	);
	
	return false;
}
