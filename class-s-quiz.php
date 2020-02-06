<?php
/**
 * S Quiz.
 *
 * @package   S_Quiz
 * @author    Team Systway <hello@systway.com>
 * @license   GPL-2.0+
 * @link      http://systway.com
 * @copyright 2015 Systway
 */

/**
 * Plugin class.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package S_Quiz
 * @author  Team Systway <hello@systway.com>
 */
class S_Quiz {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 's-quiz';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Add the options page and menu item.
		// add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action( 'init', array( $this, 'quiz_module_init' ) );
		add_filter( 'TODO', array( $this, 'filter_method_name' ) );

		add_action( 'media_buttons', array( $this, 'media_buttons' ), 20 );
		add_action( 'admin_footer', array( $this, 'tzsc_popup_html' ) );

	}



	/**
	 * media_buttons function
	 *
	 * @access public
	 * @return void
	 */
	public function media_buttons( $editor_id = 'content' ) {

		global $pagenow;

		// Only run on add/edit screens
		if ( in_array( $pagenow, array('post.php', 'page.php', 'post-new.php', 'post-edit.php') ) ) {
			$output = '<a href="#TB_inline?width=4000&amp;inlineId=tzsc-choose-shortcode" class="thickbox button tzsc-thicbox" title="' . __( 'Insert SQuiz Shortcode', 'tzsc' ) . '">' . __( 'Insert SQuiz Shortcode', 'tzsc' ) . '</a>';
		}
		echo $output;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		wp_register_style( $this->plugin_slug .'dataTables', plugins_url( 'css/dataTables.min.css', __FILE__ ), array(), $this->version );
		wp_register_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );

		wp_enqueue_style($this->plugin_slug .'dataTables');
		wp_enqueue_style($this->plugin_slug .'-admin-styles');

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

			wp_enqueue_script( $this->plugin_slug . 'dataTables', plugins_url( 'js/dataTables.min.js', __FILE__ ), array( 'jquery' ), $this->version );
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );	

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

		/*
		 * TODO:
		 *
		 * Change 'Page Title' to the title of your plugin admin page
		 * Change 'Menu Text' to the text for menu item for the plugin settings page
		 * Change 'plugin-name' to the name of your plugin
		 */
		$this->plugin_screen_hook_suffix = add_plugins_page(
			__( 'Page Title', $this->plugin_slug ),
			__( 'Menu Text', $this->plugin_slug ),
			'read',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */

	/*******************************************************
	## Custom Post Type s_quiz and and taxonomy
	## Integrate Multiple image Upload Option
	*******************************************************/

	public function quiz_module_init(){


		register_post_type(
				'quiz',
				array(
					'labels' => array(
						'name' => 'Quizzes ',
						'all_items' => 'All Quizzes',
						'singular_name' => 'Quiz',
						'add_new_item'=>'Add New Quiz'
					),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'quiz'),
					'supports' => array('title', 'page-attributes'),
					'can_export' => true,
					'menu_icon'=> plugins_url( 'img/quiz.png' , __FILE__ ),
					
				)
		);

		register_taxonomy(
				'subject',
				'quiz',
				array(
						'labels' => array(
								'name' => 'Subjects',
								'add_new_item' => 'Add New Subject',
								'new_item_name' => "New Quiz Subject"
						),
						'show_ui' => true,
						'show_tagcloud' => false,
						'hierarchical' => true
				)
		);
				
		add_action( 'admin_menu', 'mt_add_pages' );

		function mt_add_pages() {
			add_submenu_page(
				'edit.php?post_type=quiz',
				'Participates', 
				'Participates', 
				'manage_options', 
				'participate',
				'all_participate' 
			);

			function all_participate(){
				
			?>

				<div class="participate-area wrap">
					<h1 class="wp-heading-inline"> All Participate List</h1>
					<table id="all_participates_list" class="cell-border" style="width:100%">
						<thead>
								<tr>
								<th><strong>#</strong></th>
								<td><strong>Name</strong></td>
								<th><strong>Email Address</strong></th>
								<th style="text-align:center;"><strong>Subject</strong></th>
								<th style="text-align:center;"><strong>Total Question</strong></th>
								<th style="text-align:center;"><strong>Currect Answer</strong></th>
								<th style="text-align:center;"><strong>Total Mark</strong></th>
								<th style="text-align:center;"><strong>Action</strong></th>
								</tr>
							</thead>
							<tbody>
							<?php 

								global $wpdb;

								$table_name = $wpdb->prefix . "sq_participates";

								$sq_participates_data = $wpdb->get_results( "SELECT * FROM $table_name" );

								$i=0;

								foreach ($sq_participates_data as $data){

									$i=$i+1;

								?>

									<tr>
										<td><?php echo $i; ?></td>
										<td> <?php echo $data->username;?> </td>
										<td><?php echo $data->emailaddress;?></td>
										<td style="text-align:center;"><?php echo $data->sq_subject;?></td>
										<td style="text-align:center;"><?php echo $data->total_question;?></td>
										<td style="text-align:center;"><?php echo $data->currect_answer;?></td>
										<td style="text-align:center;"><?php echo $data->total_mark;?></td>
										<td style="text-align:center;"><a class="btn participate_delete" data-id="<?php echo $data->id;?>" href="javascript:void(0)">Delete</a></td>
									</tr>
							<?php 
								} 
						?>

							</tbody>
							<tfoot>
								<tr>
									<th><strong>#</strong></th>
									<td><strong>Name</strong></td>
									<th><strong>Email Address</strong></th>
									<th style="text-align:center;"><strong>Subject</strong></th>
									<th style="text-align:center;"><strong>Total Question</strong></th>
									<th style="text-align:center;"><strong>Currect Answer</strong></th>
									<th style="text-align:center;"><strong>Total Mark</strong></th>
									<th style="text-align:center;"><strong>Action</strong></th>
								</tr>
							</tfoot>
					</table>
		
				</div>

			<?php 

			}

		}

	}


	public function action_method_name() {
		// TODO: Define your action hook callback here
	}

	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}


	function tzsc_popup_html() {
		global $pagenow;
		//include(TZSC_PLUGIN_DIR . 'includes/config.php');

		// Only run in add/edit screens
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) { ?>

			<script type="text/javascript">

				function squizInsertShortcode() {


					var subject = jQuery('#select-squiz-subject').val(),
						layout  = jQuery('#select-squiz-layout').val(),
						result_type = jQuery('#select-squiz-result-type').val(),
						show = jQuery('#select-squiz-show').val();
						result_text = jQuery('#squiz-result-text').val();

					
					var contentToEditor ="",
						attributes ="";

					if(subject !=0)
						attributes += ' subject="'+subject+'"';

					if(layout !=0)
						attributes += ' layout="'+layout+'"';

					if(result_type !=0)
						attributes += ' result_type="'+result_type+'"';

					if(show !=0)
						attributes += ' show="'+show+'"';

					if(result_text !='')
						attributes += ' result_text="'+result_text+'"';

					contentToEditor = '[s_quiz '+attributes+'][/s_quiz]';

					// Send the shortcode to the content editor and reset the fields
					window.send_to_editor( contentToEditor );

					squizResetFields();

				}

				// Set the inputs to empty state
				function squizResetFields() {

					jQuery('#select-squiz-subject').val('0'),
				  jQuery('#select-squiz-layout').val('0'),
					jQuery('#select-squiz-result-type').val('0'),
				  jQuery('#select-squiz-show').val('0');
				  jQuery('#squiz-result-text').val('');
					
				}

			
			</script>

			<div id="tzsc-choose-shortcode" style="display: none;">
				<div id="tzsc-shortcode-wrap" class="wrap tzsc-shortcode-wrap">
					<div class="tzsc-shortcode-select">
						<label for="tzsc-shortcode"><?php _e('Select the Subject', 'tzsc'); ?></label>
						<select name="tzsc-shortcode" id="select-squiz-subject">
							<option value="0"><?php _e('Select Subject', 'tzsc'); ?></option>
							<?php

								$taxonomies = array( 
										  'subject',
								);

								$args = array(
								    'orderby'           => 'name', 
								    'order'             => 'ASC',
								    
								); 

								$terms = get_terms($taxonomies, $args);

								if(!empty($terms)){

									foreach ($terms as $key => $subject) {
									
										echo '<option value="'.$subject->slug.'">'.$subject->name.'</option>';
										
									}

								}
								
							?>
							
						</select>
					</div>

					<div class="tzsc-shortcode-select">
						<label for="tzsc-shortcode"><?php _e('Select the Layout', 'tzsc'); ?></label>
						<select name="tzsc-shortcode" id="select-squiz-layout">
							<option value="0"><?php _e('Select Layout', 'tzsc'); ?></option>
							<option value="1"><?php _e('one by one', 'tzsc'); ?></option>
							<option value="2"><?php _e('All', 'tzsc'); ?></option>
						</select>
					</div>

					<div class="tzsc-shortcode-select">
						<label for="tzsc-shortcode"><?php _e('Select the Result Type', 'tzsc'); ?></label>
						<select name="tzsc-shortcode" id="select-squiz-result-type">
							<option value="0"><?php _e('Select Result Type', 'tzsc'); ?></option>
							<option value="percentage"><?php _e('Percentage', 'tzsc'); ?></option>
							<option value="mark"><?php _e('Mark', 'tzsc'); ?></option>
						</select>
					</div>

					<div class="tzsc-shortcode-select">
						<label for="tzsc-shortcode"><?php _e('Show Correct Result', 'tzsc'); ?></label>
						<select name="tzsc-shortcode" id="select-squiz-show">
							<option value="0"><?php _e('Select Correct Result', 'tzsc'); ?></option>
							<option value="correct_result"><?php _e('Yes', 'tzsc'); ?></option>
						</select>
					</div>

					<div class="tzsc-shortcode-select">
						<label for="tzsc-shortcode"><?php _e('Result Text', 'tzsc'); ?></label>
						<input type="text" name="squiz-result-text" id="squiz-result-text" value="">
					</div>
					
					<p class="submit">
						<input type="button" id="tzsc-insert-shortcode" class="button-primary" value="<?php _e('Insert Shortcode', 'tzsc'); ?>" onclick="squizInsertShortcode();" />
						<a href="#" id="tzsc-cancel-shortcode-insert" class="button-secondary tzsc-cancel-shortcode-insert" onclick="tb_remove();"><?php _e('Cancel', 'tzsc'); ?></a>
					</p>
				</div>
			</div>

		<?php
		}
	}

}