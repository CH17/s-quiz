
/*
##################
### S-Quiz Js
##################
*/



jQuery(document).ready(function(){

	
	 //display the next button

	var total_qstn = jQuery('#total_qstn').val();
	var current = jQuery('#current_qstn').val();
	var prev = jQuery('#prev_qstn').val();
	var next = jQuery('#next_qstn').val();

	var option = jQuery('#squiz_post'+current).val();


	jQuery('input:radio[name=squiz_ans_'+option+']').change(function(){

		if(current==1){

			var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();

			if(typeof answer  === "undefined"){

			}else{
				jQuery("#next_btn").css("display", "inline-block");
			}
		
		}

	});


	//next button event

	jQuery('#next_btn').click(function(){  //nex button event

		jQuery("#submit_btn").css("display", "none");


		
		var total_qstn = jQuery('#total_qstn').val();
		var current = jQuery('#current_qstn').val();
		var prev = jQuery('#prev_qstn').val();
		var next = jQuery('#next_qstn').val();

		var option = jQuery('#squiz_post'+current).val();


		var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();


		if(typeof answer  === "undefined"){


		}else{

			/* dispaly active or inactive of quiz*/
				jQuery('#squiz_qustn_'+current).removeClass('squiz_active');
				jQuery('#squiz_qustn_'+next).addClass('squiz_active');

				
				
				
				if(next== total_qstn ){

					jQuery("#next_btn").css("display", "none");
					jQuery("#prev_btn").css("display", "inline-block");
					jQuery("#submit_btn").css("display", "inline-block");

					prev = current;
					current = next;
					next = total_qstn;

					jQuery('#current_qstn').val(current);
				    jQuery('#prev_qstn').val(prev);
				    jQuery('#next_qstn').val(next);


				}else{

					jQuery("#prev_btn").css("display", "inline-block");

					var temp = next;
					if(current==1)
						prev= current
					else prev =parseInt(current) - 1;
					
					next = parseInt(current) + 1;
					current = temp;
					

					jQuery('#current_qstn').val(current);
				    jQuery('#prev_qstn').val(prev);
				    jQuery('#next_qstn').val(next);


				}
		}

	});

	//prev button event
	jQuery('#prev_btn').click(function(){

		jQuery("#submit_btn").css("display", "none");
		jQuery("#next_btn").css("display", "inline-block");

		var total_qstn = jQuery('#total_qstn').val();
		var current = jQuery('#current_qstn').val();
		var prev = jQuery('#prev_qstn').val();
		var next = jQuery('#next_qstn').val();

		alert('current>>'+current+'prev>>'+prev+'next>>'+next);


		/* dispaly active or inactive of quiz*/
		jQuery('#squiz_qustn_'+current).removeClass('squiz_active');
		jQuery('#squiz_qustn_'+prev).addClass('squiz_active');

		

		next = parseInt(current) + 1;
		prev = parseInt(current)-1;
		current = prev;
		

		jQuery('#current_qstn').val(current);
	    jQuery('#prev_qstn').val(prev);
	    jQuery('#next_qstn').val(next);

		if(prev==1){
			jQuery("#prev_btn").css("display", "none");

		}

	});


	//submit button event
	jQuery('#submit_btn').click(function(){

		

		var total_qstn = jQuery('#total_qstn').val();
		var current = jQuery('#current_qstn').val();
		var prev = jQuery('#prev_qstn').val();
		var next = jQuery('#next_qstn').val();

		var option = jQuery('#squiz_post'+current).val();


		var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();


		if(typeof answer  === "undefined"){


		}else{

			jQuery('#loading_icon').addClass("loading_icon");

			var plugin_dir_path =jQuery('#plugin_dir_path').val();

			var post_array = [];

			var answer_array = [];

			var post='';
			var ans ='';

			for (var i = 1; i <= total_qstn ; i++) {
				
				 post = jQuery('#squiz_post'+i).val();
				 ans  = jQuery('input:radio[name=squiz_ans_'+post+']:checked').val();

				 post_array.push(post);
				 answer_array.push(ans);

			}

			

			jQuery.ajax({

				type: "POST",
	        	url: plugin_dir_path+'/squiz-ajax.php',
	        	async: false,
				data: {post_array: post_array, answer_array:answer_array},
	       	 
	       	 	success: function(msg) {

	       	 		jQuery('#loading_icon').removeClass("loading_icon");

	       	 		jQuery("#submit_btn").css("display", "none");
	       	 		jQuery("#prev_btn").css("display", "none");

	       	 		var result = jQuery.parseJSON(msg);
	       	 		var html = '<h6> Result : '+result.correct_result+'/'+result.total_qustn+'</h6>';

	       	 		jQuery('.result').html(html);

	       	 	},
	       	 	error: function(ob,errStr) {
		        
		        
		        }



			});


				
		}

	});




});





