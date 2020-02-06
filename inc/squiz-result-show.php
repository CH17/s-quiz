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


$wp_root = '../../../..';
	if (file_exists($wp_root.'/wp-load.php')) {

		require_once($wp_root.'/wp-load.php');
		include_once($wp_root.'/wp-includes/wp-db.php');
		require_once($wp_root.'/wp-admin/includes/admin.php');
	} else {
		require_once($wp_root.'/wp-load.php');
		require_once($wp_root.'/wp-config.php');
		include_once($wp_root.'/wp-includes/wp-db.php');
		require_once($wp_root.'/wp-admin/includes/admin.php');
	}

if(isset($_POST['post_array'])){

	$post_array = $_POST['post_array'];
	
	$output = '';

	$count = 1;

	foreach ($post_array as $key => $post) {

		$post_data = get_post($post);

		$output .='<div class="squiz_result_content">';				
		$output .='<h6>Q.'.$count.' : '.$post_data->post_title.'</h6>';

		$quiz_ans = get_post_meta( $post_data->ID, 'squiz_answer_group', false );
	
		if($quiz_ans){

			foreach ($quiz_ans as $key => $ans_list) {

				$ans = 1;
				foreach ($ans_list as $key => $list) {

					if($list['correct_answer'] == 'yes')
						$output .= $ans.'.<span> '.$list['answer'].'</span><span class="right_answer"></span><br>';
					else
						$output .= $ans.'.<span > '.$list['answer'].'</span><br>';

					$ans++;

					}

			}
		}
				
		$output .='</div>';
		$count++;

	}

	echo $output;
	
}