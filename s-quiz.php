<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   S_Quiz
 * @author    Team Systway <hello@systway.com>
 * @license   GPL-2.0+
 * @link      http://systway.com
 * @copyright 2015 Systway
 *
 * @wordpress-plugin
 * Plugin Name: S-Quiz
 * Plugin URI:  TODO
 * Description: A simple Quiz plugin.
 * Version:     1.0.0
 * Author:      Team Systway
 * Author URI:  http://systway.com
 * Text Domain: s-quiz-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



// TODO: replace `class-plugin-name.php` with the name of the actual plugin's class file
require_once( plugin_dir_path( __FILE__ ) . 'class-s-quiz.php' );

if ( ! class_exists( 'Some_CMB2_Class' ) ) {
	require_once( plugin_dir_path( __FILE__ ).'/cmb2/init.php' );
}

require_once( plugin_dir_path( __FILE__ ).'/cmb2/squiz-functions.php' );
require_once( plugin_dir_path( __FILE__ ).'/inc/squiz-shortcode.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-name.php`
register_activation_hook( __FILE__, array( 'S_Quiz', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'S_Quiz', 'deactivate' ) );

// TODO: replace Plugin_Name with the name of the plugin defined in `class-plugin-name.php`
S_Quiz::get_instance();

	function pt_my_activation_function() {

		global $wpdb;

    $table_name = $wpdb->prefix . "sq_participates"; 

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
      id bigint(9) NOT NULL AUTO_INCREMENT,      
      username tinytext NOT NULL,
      emailaddress tinytext NOT NULL,
      sq_subject tinytext NOT NULL,      
      total_question tinytext NOT NULL,      
      currect_answer tinytext NOT NULL,      
      total_mark tinytext NOT NULL,      
      UNIQUE KEY ( id ), PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
		dbDelta( $sql );	

	}
	
	register_activation_hook(__FILE__,'pt_my_activation_function');

	add_action( 'wp_ajax_all_participates_data', 'all_participates_data' );
	add_action( 'wp_ajax_nopriv_all_participates_data', 'all_participates_data' );

  function all_participates_data(){

    $dele_id = $_REQUEST['dele_id'];
    
    global $wpdb;

    $table_name = $wpdb->prefix . "sq_participates"; 
    $delete_data = $wpdb->delete( $table_name, array( 'id' => $dele_id ) );


    if($delete_data){
      echo 'success';
    }else{
      echo 'Something wrong';
    }

		exit(); 
		 
	}

