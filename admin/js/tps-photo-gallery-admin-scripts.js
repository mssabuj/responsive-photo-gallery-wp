(function( $ ) {
	'use strict';
		$(document).on('click', '.tab-nav li', function(){
			$(".active").removeClass("active");
			$(this).addClass("active");
			var nav = $(this).attr("nav");
			$(".box li.tab-box").css("display","none");
			$(".box"+nav).css("display","block");
			$("#tpsgallery_nav_value").val(nav);
		});
		
		
		$("#tpsgallery_types_id").on('change', function(){
			var getTypeVal = $(this).val();

			if(getTypeVal  == 1){
				$("#ctlhide").hide('slow');
			}
			else{
				$("#ctlhide").show('slow');
			}
		});

		
})( jQuery );
