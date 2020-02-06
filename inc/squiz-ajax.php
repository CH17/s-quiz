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


if(isset($_POST['post_array']) && isset($_POST['answer_array'])){

	$post_array = $_POST['post_array'];
	$answer_array = $_POST['answer_array'];
	$sq_username = $_POST['sq_username'];
	$sq_email = $_POST['sq_email'];
	$subject_type = $_POST['subject_type'];
	$result_type = $_POST['result_type'];

	$correct_result = 0;

	for ($i=0; $i<count($post_array) ; $i++) { 

		$quiz_ans = get_post_meta( $post_array[$i], 'squiz_answer_group', false );

		if($quiz_ans){

			$answer='';

			foreach ($quiz_ans as $key => $ans_list) {

				foreach ($ans_list as $key => $list) {

					if($list['correct_answer'] == 'yes')
						$answer = $key;
				}

		  }

		  if( $answer == $answer_array[$i]){

				$correct_result= $correct_result+1;

		  }

    }

	}

	$result = array(
		'correct_result' => $correct_result,
		'total_qustn' => count($post_array)
	);

	if ($result_type=='percentage'){ 

		$percent = $result['correct_result'] / $result['total_qustn'];
		$total_mark = number_format( $percent * 100).'%';

	}else{

		$total_mark = $result['correct_result'] .'/'. $result['total_qustn'];

	}


	
	global $wpdb;

	$table_name = $wpdb->prefix . "sq_participates";

	$insert_sqdata = $wpdb->insert($table_name, array(
		"username" => $sq_username,
		"emailaddress" => $sq_email,
		"sq_subject" => $subject_type,
		"total_question" => $result['total_qustn'] ,
		"currect_answer" => $correct_result ,
		"total_mark" => $total_mark ,
 	));
	
 	if($insert_sqdata) {
		echo json_encode($result);
	} else {
		echo 'Something wrong';
	}

}


?>