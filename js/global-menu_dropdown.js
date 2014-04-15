/* ==========================================================
 * Dropdown menu
 * ========================================================== */


jQuery(document).ready(function($){
    
    //Activar el dropdown del menu principal
    $('#menu-navmenu li').hover(
        function () {
            $('ul', this).slideDown(100);
        },
        function () {
            $('ul', this).slideUp(100);   		
        }
    );
	$('ul.sub-menu').hover(
        function () {
			$(this).parent().addClass('parentselected');
        },
        function () {  
			$(this).parent().removeClass('parentselected');			
        }
    );
});





