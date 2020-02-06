(function ($) {
	"use strict";
	$(function () {

		// Place your administration-specific JavaScript here
		$(document).ready(function() {
			$('#all_participates_list').DataTable();
		});

		jQuery(".participate_delete").on("click",function(e){

      e.preventDefault();

			var dele_id = $(this).attr("data-id");

			jQuery.ajax({
        type : 'GET',
				url: ajaxurl,
				data: { 'action': 'all_participates_data', 'dele_id': dele_id },
				success: function(msg) {

					if(msg='success'){
						window.location.reload(true); 
					}
					
					console.log(msg);
					
				},
				
				error: function(ob,errStr) {
		
				}

			});

	 	})

	});

}(jQuery));