<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function yourprefix_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}



/*
#############################
## Repeat Answer box
##########################
*/

add_action( 'cmb2_init', 'squiz_register_repeatable_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function squiz_register_repeatable_metabox () {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'squiz_';

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix .'answer_group_meta',
		'title'        => __( 'Question Answers', 'cmb2' ),
		'object_types' => array('quiz'),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix .'answer_group',
		'type'        => 'group',
		'description' => __( '', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Answer {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
			'sortable'      => true, // beta
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
		$cmb_group->add_group_field( $group_field_id, array(
			'name' => __( 'Answer', 'cmb2' ),
			'desc' => __( 'answer (optional)', 'cmb2' ),
			'id'   => 'answer',
			'type' => 'text_medium',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );


		$cmb_group->add_group_field( $group_field_id, array(
			'name'    => __( 'Correct Answer', 'cmb2' ),
			'desc'    => __( 'If answer', 'cmb2' ),
			'id'      => 'correct_answer',
			'type'    => 'radio',
			'options' => array(
				'yes' => __( 'Yes', 'cmb2' ),
				'no' => __( 'No', 'cmb2' ),
			),
		) );

}

