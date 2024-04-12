$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on("click", function(e) {
		e.preventDefault(); 
		e.stopPropagation(); 
		$(this).parent().siblings().removeClass('open');
		$(this).parent().toggleClass('open');
	   });
	   
	   if(window.innerWidth > 668) {
		$( "ul.dropdown-menu [data-toggle=dropdown]" ).mouseover(function(e) {
		 e.preventDefault(); 
		 e.stopPropagation(); 
		 $(this).parent().siblings().removeClass('open');
		 $(this).parent().toggleClass('open');
		});
	   }
	});