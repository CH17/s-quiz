<?php

/**
 * S-Quiz.
 *
 * @package   S_Quiz
 * @author    CH17 <contact.choyon@gmail.com>
 * @license   GPL-2.0+
 * @link      http://choyon.net
 * @copyright 2019 Ch17
 */


/***************************************
## Shortcode Files
## Package@ S-Quiz
*******************************************/


/********************************************************************
## Shortcode: Quizzes
## Usage: [s_quiz subject="subjects" layout="1/2"]Content goes here[/s_quiz]
*********************************************************************/

function quiz_func( $atts, $content = null ) {  

	extract(shortcode_atts(array(
		    'subject' => '',
		    'layout' => '',
		    'result_type' => '',
		    'show' => '',
		    'result_text' => '',
		    
		    
	    ), $atts));

	$output='';


	if($subject==''){

		$args=array(
			'post_type'      => 'quiz',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'		 => 'rand'	
			
		);

	}else{

		$args=array(
			'post_type'      => 'quiz',
			'post_status'    => 'publish',
			'is_single'		=> true,	
			'posts_per_page' => -1,
			'orderby'		 => 'rand',
			'tax_query' => array(
		        array(
		            'taxonomy' => 'subject',
		            'field' => 'slug',
	            	'terms' => $subject
				    )	
			)
		);
	}
	
	
	$my_posts = get_posts( $args );

	if(!empty($my_posts)){

		
			$count = 1;
			$total_qstn = count($my_posts);

			foreach ($my_posts as $key => $post) {

				if($layout==2){

					$output .='<div id="squiz_qustn_'.$count.'" class="squiz_content squiz_active">';

				}else{

					if($count==1)
						$output .='<div id="squiz_qustn_'.$count.'" class="squiz_content squiz_active">';
					else
						$output .='<div id="squiz_qustn_'.$count.'" class="squiz_content">';
					
				}
				
				$output .='<h3>Q.'.$count.' : '.$post->post_title.'</h3>';
				$output .= '<span class="answer_result wrong_answer" id="question_'.$count.'"></span>';

				$quiz_ans = get_post_meta( $post->ID, 'squiz_answer_group', false );

				if($quiz_ans){

					foreach ($quiz_ans as $key => $ans_list) {

						$ans= 0;
						$ans_list = shuffle_assoc($ans_list);

						foreach ($ans_list as $key => $list) {

							$output .= '<input type="radio" name="squiz_ans_'.$post->ID.'" value="'.$key.'"> '.$list['answer'].'<br>';

							$ans++;
						}

					}

				}
				$output .= '<input type="hidden" id="squiz_post'.$count.'" name="squiz_'.$count.'" value="'.$post->ID.'">';

				$output .='</div>';

				$count++;

			}

			$output .='<input type="hidden" name="total_qstn" id="total_qstn" value="'.$total_qstn.'">';
			$output .='<input type="hidden" name="current_qstn" id="current_qstn" value="1">';
			
			if($layout==2){
				$output .='<form action="" method="post" class="sq_submit" id="sq_submit">
				<div class="form-group">
				<label>Username</label>
				<input type="text" name="sq_username" class="sq_username" id="sq_username" placeholder="Enter Username"/>
				</div>
				<div class="form-group">
				<label>Email Address</label>
				<input type="email" name="email" class="sq_email" id="sq_email" placeholder="Enter Email Address"/>
				</div>
				<input type="hidden" name="subject_type" class="subject_type" id="subject_type" value="'.$subject.'"/>
				</form>';
				$output .='<button class="button button-primary button-medium" id="submit_btn_all">Submit</button>';

			}else{
				$output .='<div class="squiz_btn_paginate">';

				$output .='<button class="button button-primary button-medium" id="prev_btn" style="display: none;">Prev</button>';
				$output .='<button class="button button-primary button-medium" id="next_btn" style="display: none;">Next</button>';
				$output .='<form action="" method="post" class="sq_submit" id="sq_submit" style="display: none;">
				<div class="form-group">
				<label>Username</label>
				<input type="text" name="sq_username" class="sq_username" id="sq_username" placeholder="Enter Username"/>
				</div>
				<div class="form-group">
				<label>Email Address</label>
				<input type="email" name="email" class="sq_email" id="sq_email" placeholder="Enter Email Address"/>
				</div>
				<input type="hidden" name="subject_type" class="subject_type" id="subject_type" value="'.$subject.'"/>
				</form>';
				$output .='<button class="button button-primary button-medium" id="submit_btn" style="display: none;">Submit</button>';

				$output .='</div>';

			}

		
		$output .='<input type="hidden" id="result_type" value="'.$result_type.'">';
		$output .='<input type="hidden" id="show_answer" value="'.$show.'">';
		$output .='<input type="hidden" id="result_text" value="'.$result_text.'">';
		
		$output .='<input type="hidden" id="plugin_dir_path" value="'. plugins_url( '/', __FILE__ ).'">';
		$output .= '<div id="loading_icon"></div> <div class="show_result"></div> <div class="result"></div>';	
		
	}
    
    return $output;
}

add_shortcode('s_quiz', 'quiz_func');


//array shufflinf function

function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) { 
    $random[$key] = $list[$key]; 
  }
  return $random; 
} 



/***************** Content Box End ************************/