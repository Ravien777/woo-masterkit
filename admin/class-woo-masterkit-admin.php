<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Woo_Masterkit
 * @subpackage Woo_Masterkit/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Masterkit
 * @subpackage Woo_Masterkit/admin
 * @author     Ravien Sewpal <raviensewpal@outlook.com>
 */
class Woo_Masterkit_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $woo_masterkit    The ID of this plugin.
	 */
	private $woo_masterkit;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $woo_masterkit       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($woo_masterkit, $version)
	{

		$this->woo_masterkit = $woo_masterkit;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Masterkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Masterkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->woo_masterkit, plugin_dir_url(__FILE__) . 'css/woo-masterkit-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Masterkit_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Masterkit_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->woo_masterkit, plugin_dir_url(__FILE__) . 'js/woo-masterkit-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * Add the admin menu and submenu pages for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function woo_masterkit_add_admin_menu()
	{
		add_menu_page(
			__('Woo MasterKit', 'woo-masterkit'),
			__('Woo MasterKit', 'woo-masterkit'),
			'manage_options',
			'woo-masterkit',
			array($this, 'woo_masterkit_display_home_page'),
			'dashicons-admin-tools',
			6
		);

		add_submenu_page(
			'woo-masterkit',
			__('Home', 'woo-masterkit'),
			__('Home', 'woo-masterkit'),
			'manage_options',
			'woo-masterkit',
			array($this, 'woo_masterkit_display_home_page')
		);

		add_submenu_page(
			'woo-masterkit',
			__('Bulk Change Price', 'woo-masterkit'),
			__('Bulk Change Price', 'woo-masterkit'),
			'manage_options',
			'woo-masterkit-bulk-change-price',
			array($this, 'woo_masterkit_display_bulk_change_price_page')
		);

		add_submenu_page(
			'woo-masterkit',
			__('Go Pro', 'woo-masterkit'),
			__('Go Pro', 'woo-masterkit'),
			'manage_options',
			'woo-masterkit-go-pro',
			array($this, 'woo_masterkit_display_go_pro_page')
		);

		add_submenu_page(
			'woo-masterkit',
			__('Settings', 'woo-masterkit'),
			__('Settings', 'woo-masterkit'),
			'manage_options',
			'woo-masterkit-settings',
			array($this, 'woo_masterkit_display_settings_page')
		);
	}

	/**
	 * Display the content for the Home submenu page.
	 *
	 * @since    1.0.0
	 */
	public function woo_masterkit_display_home_page()
	{
		echo '<h1>' . __('Hello World - Home', 'woo-masterkit') . '</h1>';
	}

	/**
	 * Display the content for the Bulk Change Price submenu page.
	 *
	 * @since    1.0.0
	 */
	public function woo_masterkit_display_bulk_change_price_page()
	{
		echo '<h1>' . __('Hello World - Bulk Change Price', 'woo-masterkit') . '</h1>';
	}

	/**
	 * Display the content for the Go Pro submenu page.
	 *
	 * @since    1.0.0
	 */
	public function woo_masterkit_display_go_pro_page()
	{
		echo '<h1>' . __('Go Pro', 'woo-masterkit') . '</h1>';
		echo '<form method="post" action="">';
		echo '<label for="woo_masterkit_license_key">' . __('Enter your license key:', 'woo-masterkit') . '</label><br>';
		echo '<input type="text" id="woo_masterkit_license_key" name="woo_masterkit_license_key" value="" /><br><br>';
		echo '<input type="submit" value="' . __('Submit Key', 'woo-masterkit') . '" />';
		echo '<a href="" class="button button-primary">' . __('Purchase Key', 'woo-masterkit') . '</a>';
		echo '</form>';
	}

	/**
	 * Display the content for the Settings submenu page.
	 *
	 * @since    1.0.0
	 */
	public function woo_masterkit_display_settings_page()
	{
		echo '<h1>' . __('Hello World - Settings', 'woo-masterkit') . '</h1>';
	}
}
