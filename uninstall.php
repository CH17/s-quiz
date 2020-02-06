<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   S_Quiz
 * @author    Team Systway <hello@systway.com>
 * @license   GPL-2.0+
 * @link      http://systway.com
 * @copyright 2015 Systway
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here