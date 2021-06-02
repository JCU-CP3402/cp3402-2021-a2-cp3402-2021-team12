<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Blog Designer - Post and Widget
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Bdpw_Admin {

	function __construct() {

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'bdpw_register_menu'), 12 );

		// Admin Init Processes
		add_action( 'admin_init', array($this, 'bdpw_admin_init_process') );

		add_filter('manage_edit-category_columns', array($this, 'bdpw_manage_category_columns'));

		// Filter to add extra column to post category
		add_filter('manage_category_custom_column', array($this, 'bdpw_cat_columns_data'), 10, 3);
	}

	/**
	 * Function to register admin menus
	 * 
	 * @package Blog Designer - Post and Widget
	 * @since 1.0.4
	 */
	function bdpw_register_menu() {

		// Register plugin how it work page
		add_menu_page( __('Blog Designer', 'blog-designer-for-post-and-widget'), __('Blog Designer', 'blog-designer-for-post-and-widget'), 'manage_options', 'bdpw-about',  array($this, 'bdpw_settings_page'), 'dashicons-sticky', 6 );

		// Register plugin premium page
		add_submenu_page( 'bdpw-about', __('Upgrade to PRO - Blog Designer', 'blog-designer-for-post-and-widget'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'blog-designer-for-post-and-widget').'</span>', 'manage_options', 'bdpw-premium', array($this, 'bdpw_premium_page') );
	}

	/**
	 * Function to display plugin design HTML
	 * 
	 * @package Blog Designer - Post and Widget
	 * @since 2.1
	 */
	function bdpw_settings_page() {
		include_once( BDPW_DIR . '/includes/admin/bdpw-how-it-work.php' );
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Blog Designer - Post and Widget
	 * @since 1.0
	 */
	function bdpw_premium_page() {
		include_once( BDPW_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * Admin prior processes
	 * 
	 * @package Blog Designer - Post and Widget
	 * @since 1.4
	 */
	function bdpw_admin_init_process() {

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'bdpw-plugin-notice' ) {
			set_transient( 'bdpw_install_notice', true, 604800 );
		}
	}

	/**
	 * Admin Class
	 *
	 * Add extra column to post category
	 *
	 * @package Blog Designer - Post and Widget
	 * @since 1.0
	*/
	function bdpw_manage_category_columns($columns) {

		$new_columns['wpos_shortcode'] = __( 'Category ID', 'blog-designer-for-post-and-widget' );

		$columns = bdpw_add_array( $columns, $new_columns, 2 );

		return $columns;
	}

	/**
	 * 
	 * Add data to extra column to post category
	 * 
	 * @package Blog Designer - Post and Widget
	 * @since 1.0
	*/
	function bdpw_cat_columns_data($ouput, $column_name, $tax_id) {

		switch ($column_name) {
			case 'wpos_shortcode':
			echo $tax_id;
			break;
		}
		return $ouput;
	}
}

$bdpw_admin = new Bdpw_Admin();