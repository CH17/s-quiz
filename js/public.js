
/***************************************
## Public js File
## Package@ S-Quiz
*******************************************/

jQuery(function  () {

		/*
		###########################
		### Default and One by one
		############################
		*/

			var total_qstn = jQuery('#total_qstn').val();
			var current = jQuery('#current_qstn').val();
			
			var option = jQuery('#squiz_post'+current).val();

			//first page load
			jQuery('input:radio[name=squiz_ans_'+option+']').change(function(){

				if(current==1){

					var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();

					if(typeof answer  === "undefined"){

					}else{
						jQuery("#next_btn").css("display", "inline-block");
					}
				
				}

			});


			//Next buttun event

			jQuery('#next_btn').click(function(){  //nex button event

				jQuery("#submit_btn").css("display", "none");
				
				var total_qstn = jQuery('#total_qstn').val();
				var current = jQuery('#current_qstn').val();

				var option = jQuery('#squiz_post'+current).val();

				var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();

				if(typeof answer  === "undefined"){

				}else{

					/* dispaly active or inactive of quiz*/
					jQuery('#squiz_qustn_'+current).removeClass('squiz_active');

					var next_qstn = parseInt(current)+1;

					jQuery('#squiz_qustn_'+next_qstn).addClass('squiz_active');

					//alert('current>>'+current+'prev>>'+prev+'next>>'+next);
						
					if(next_qstn== total_qstn ){

						jQuery("#next_btn").css("display", "none");
						jQuery("#prev_btn").css("display", "inline-block");
						jQuery("#sq_submit").css("display", "block");
						jQuery("#submit_btn").css("display", "inline-block");

						jQuery('#current_qstn').val(total_qstn);
						
					}else{

						jQuery("#prev_btn").css("display", "inline-block");
						jQuery('#current_qstn').val(next_qstn);

					}

				}

			});


			//prev button event
			jQuery('#prev_btn').click(function(){

				jQuery("#submit_btn").css("display", "none");
				jQuery("#next_btn").css("display", "inline-block");

				var total_qstn = jQuery('#total_qstn').val();
				var current = jQuery('#current_qstn').val();
				
				//if(current==2)

				var prev_qstn = parseInt(current)-1;

				/* dispaly active or inactive of quiz*/
				jQuery('#squiz_qustn_'+current).removeClass('squiz_active');
				jQuery('#squiz_qustn_'+prev_qstn).addClass('squiz_active');

				if(prev_qstn==1){
					jQuery("#prev_btn").css("display", "none");
					jQuery('#current_qstn').val(prev_qstn);

				}

				jQuery('#current_qstn').val(prev_qstn);

			});

			
			//submit button event
			jQuery('#submit_btn').click(function(){

				var sq_username = jQuery('#sq_username').val();
				var sq_email = jQuery('#sq_email').val();
				var subject_type = jQuery('#subject_type').val();
				var result_type = jQuery('#result_type').val();
				
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

				if((sq_username !="") && (filter.test(sq_email))){

					var total_qstn = jQuery('#total_qstn').val();
					var current = jQuery('#current_qstn').val();
				
					var option = jQuery('#squiz_post'+current).val();

					var answer = jQuery('input:radio[name=squiz_ans_'+option+']:checked').val();

					if(typeof answer  === "undefined"){

					}else{

						jQuery("#prev_btn").css("display", "none");

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
							data: {post_array: post_array, answer_array:answer_array, sq_username:sq_username, sq_email:sq_email, subject_type:subject_type, result_type:result_type },
			       	 
			       	success: function(msg) {

			       	 	jQuery('#squiz_qustn_'+current).removeClass('squiz_active');

			       	 	jQuery("#submit_btn").css("display", "none");
			       	 	jQuery("#sq_submit").css("display", "none");

			       	 	var result_type = jQuery('#result_type').val();

			       	 	var show_answer = jQuery('#show_answer').val();

			       	 	var result = jQuery.parseJSON(msg);

			       	 	var html='';

			       	 	if(show_answer =="correct_result"){

			       	 		showCorrectAnswer();
			       	 		jQuery('#loading_icon').removeClass("loading_icon");

			       	 	}

			       	 	jQuery('#loading_icon').removeClass("loading_icon");

			       	 	var result_text = jQuery('#result_text').val();

			       	 	if(result_text ==""){
									result_text = 'Result';
								}
			       	 													
			       	 	if(result_type =='percentage'){

									var percentage = (result.correct_result / result.total_qustn) * 100;
											
									console.log(percentage);

			       	 		html = '<h6> '+result_text+' : '+percentage+'%</h6>';

			       	 	}else{

				       	 	html = '<h6> '+result_text+' : '+result.correct_result+'/'+result.total_qustn+'</h6>';
			       	 	}
										
								jQuery('.result').html(html);
								console.log(msg);

			       	},
			       	error: function(ob,errStr) {
				        
				      }

						});
					}
				}
			});


	/*
	##################
	### All layout
	##################
	*/

	jQuery('#submit_btn_all').click(function(){

		var sq_username = jQuery('#sq_username').val();
		var sq_email = jQuery('#sq_email').val();
		var subject_type = jQuery('#subject_type').val();
		var result_type = jQuery('#result_type').val();

		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		if((sq_username !="") && (filter.test(sq_email))){

			var total_qstn = jQuery('#total_qstn').val();

			var post_array = [];

			var answer_array = [];

			var post='';
			var ans ='';
			var no_answer =0;

			for (var i = 1; i <= total_qstn ; i++) {
				
				post = jQuery('#squiz_post'+i).val();
				ans  = jQuery('input:radio[name=squiz_ans_'+post+']:checked').val();


				if(typeof ans  === "undefined"){

					no_answer++;

				}else{
					post_array.push(post);
					answer_array.push(ans);
				}

			}

			//if seletcd all answer
			if(no_answer ==0){

				jQuery('#loading_icon').addClass("loading_icon");

				var plugin_dir_path =jQuery('#plugin_dir_path').val();

				jQuery.ajax({

					type: "POST",
					url: plugin_dir_path+'/squiz-ajax.php',
					async: false,
					data: {post_array: post_array, answer_array:answer_array, sq_username:sq_username, sq_email:sq_email, subject_type:subject_type, result_type:result_type},
						
					success: function(msg) {

						jQuery("#sq_submit").css("display", "none");

						for (var i = 1; i <= total_qstn ; i++) {

							jQuery('#squiz_qustn_'+i).removeClass('squiz_active');
								
						}

						jQuery("#submit_btn_all").css("display", "none");

						var result_type = jQuery('#result_type').val();

						var show_answer = jQuery('#show_answer').val();

						var result = jQuery.parseJSON(msg);

						var html='';

						if(show_answer =="correct_result"){

							showCorrectAnswer();
							jQuery('#loading_icon').removeClass("loading_icon");

						}

						jQuery('#loading_icon').removeClass("loading_icon");

						var result_text = jQuery('#result_text').val();

						if(result_text ==""){
							result_text = 'Result';
						}

						if(result_type =='percentage'){

							var percentage = (result.correct_result / result.total_qustn) * 100;

							html = '<h6> '+result_text+' : '+percentage+'%</h6>';

						}else{

							html = '<h6> '+result_text+' : '+result.correct_result+'/'+result.total_qustn+'</h6>';
						
						}
								
						jQuery('.result').html(html);

						console.log(msg);

					},
					
					error: function(ob,errStr) {
							
					}

				});

		}
	}

	});


	function showCorrectAnswer(){

			var post_array = [];
			var post='';

			for (var i = 1; i <= total_qstn ; i++) {
				
				 post = jQuery('#squiz_post'+i).val();
				 post_array.push(post);
				 
			}

			var plugin_dir_path =jQuery('#plugin_dir_path').val();

			jQuery.ajax({

				type: "POST",
	      url: plugin_dir_path+'/squiz-result-show.php',
	      async: false,
				data: {post_array: post_array},
	      success: function(msg) {
	       	 		
	       	jQuery('.show_result').html(msg);

	      },
	    	error: function(ob,errStr) {
		        
		    }

			});

	}
	
});