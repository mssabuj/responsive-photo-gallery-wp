(function( $ ) {
	'use strict';
	
	var $featImgDiv = $('#ctlhide');
	$('#tpsgallery_types_id').change(function() {
	    if ( $(this).val() == 1 ) {
	      $featImgDiv.hide('slow');
	    } else {
	       $featImgDiv.show('slow');
	    }
	}).change();
})( jQuery );