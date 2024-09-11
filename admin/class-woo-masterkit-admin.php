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

		wp_enqueue_script($this->woo_masterkit, plugin_dir_url(__FILE__) . 'js/woo-masterkit-admin.js', array('jquery', 'select2'), $this->version, true);

		// Localize script to pass AJAX URL and nonce 
		wp_localize_script($this->woo_masterkit, 'woo_masterkit_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('woo_masterkit_nonce')
		));

		wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
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
?>
		<div class="wrap">
			<h1><?php _e('Bulk Change Product Prices', 'woo-masterkit'); ?></h1>

			<form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
				<?php wp_nonce_field('woo_masterkit_bulk_price_change_action', 'woo_masterkit_nonce'); ?>

				<h2><?php _e('Price Change Type', 'woo-masterkit'); ?></h2>
				<p>
					<label>
						<input type="radio" name="woo_masterkit_price_change_type" value="increase" checked>
						<?php _e('Increase Price', 'woo-masterkit'); ?>
					</label>
					<label>
						<input type="radio" name="woo_masterkit_price_change_type" value="decrease">
						<?php _e('Decrease Price', 'woo-masterkit'); ?>
					</label>
					<label>
						<input type="radio" name="woo_masterkit_price_change_type" value="exact">
						<?php _e('Exact Price', 'woo-masterkit'); ?>
					</label>
				</p>

				<h2><?php _e('Price Amount', 'woo-masterkit'); ?></h2>
				<p>
					<label for="woo_masterkit_price_amount"><?php _e('Enter the price amount:', 'woo-masterkit'); ?></label>
					<input type="number" step="0.01" id="woo_masterkit_price_amount" name="woo_masterkit_price_amount" required>
				</p>

				<h2><?php _e('Regular/Sale Price', 'woo-masterkit'); ?></h2>
				<p>
					<label for="woo_masterkit_price_type_regular">
						<input type="checkbox" id="woo_masterkit_price_type_regular" name="woo_masterkit_price_type[]" value="regular" checked>
						<?php _e('Regular', 'woo-masterkit'); ?>
					</label>
					<label for="woo_masterkit_price_type_sale">
						<input type="checkbox" id="woo_masterkit_price_type_sale" name="woo_masterkit_price_type[]" value="sale">
						<?php _e('Sale', 'woo-masterkit'); ?>
					</label>
				</p>

				<h2><?php _e('Rounding Option', 'woo-masterkit'); ?></h2>
				<p>
					<label for="woo_masterkit_round_price">
						<input type="checkbox" id="woo_masterkit_round_price" name="woo_masterkit_round_price" value="1">
						<?php _e('Round up prices', 'woo-masterkit'); ?>
					</label>
				</p>

				<h2><?php _e('Select Products', 'woo-masterkit'); ?></h2>
				<p>
					<label for="woo_masterkit_product_select"><?php _e('Select the products to apply the changes to:', 'woo-masterkit'); ?></label>
					<select id="woo_masterkit_product_select" name="woo_masterkit_product_select[]" multiple="multiple" style="width: 100%;" required>
						<!-- Options will be populated via AJAX -->
					</select>
				</p>

				<p>
					<input type="hidden" name="action" value="woo_masterkit_bulk_price_change">
					<input type="submit" name="woo_masterkit_bulk_change_btn" class="button button-primary" value="<?php _e('Apply Changes', 'woo-masterkit'); ?>">
				</p>
			</form>
		</div>
<?php
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

	/**
	 * Handle AJAX request for product search
	 * 
	 * @since	1.0.0
	 */
	public function woo_masterkit_ajax_search_products()
	{
		check_ajax_referer('woo_masterkit_nonce', 'nonce');

		$search_term = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

		$args = array(
			'post_type' => 'product',
			's' => $search_term,
			'posts_per_page' => 10
		);

		$query = new WP_Query($args);

		$results = array();

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$results[] = array(
					'id' => get_the_ID(),
					'text' => get_the_title()
				);
			}
		}

		wp_send_json($results);
	}

	/**
	 * Process the bulk price change form submission.
	 *
	 * This function handles the form submission logic for the Bulk Change Price page,
	 * updating the product prices based on the selected operation and input values.
	 *
	 * @since 1.0.0
	 */
	public function woo_masterkit_process_bulk_price_change()
	{
		if (!isset($_POST['woo_masterkit_nonce']) || !wp_verify_nonce($_POST['woo_masterkit_nonce'], 'woo_masterkit_bulk_price_change_action')) {
			wp_die(__('Nonce verification failed', 'woo-masterkit'));
		}

		// Check if the form is submitted and the required fields are set
		if (isset($_POST['woo_masterkit_price_change_type']) && !empty($_POST['woo_masterkit_product_select'])) {

			// Sanitize input data
			$price_change_type = sanitize_text_field($_POST['woo_masterkit_price_change_type']);
			$price_amount = floatval($_POST['woo_masterkit_price_amount']);
			$round_price = isset($_POST['woo_masterkit_round_price']) ? true : false;
			$price_type = array_map('sanitize_text_field', $_POST['woo_masterkit_price_type']);
			$product_ids = array_map('sanitize_text_field', $_POST['woo_masterkit_product_select']);

			foreach ($product_ids as $product_id) {
				if (empty($product_id)) {
					continue; // Skip if product ID is empty
				}

				$product = wc_get_product(intval(trim($product_id)));
				if (!$product) {
					continue; // Skip if product is not found
				}

				// Prepare common variables
				$currency = get_woocommerce_currency_symbol();
				$thumbnail = wp_get_attachment_image($product->get_image_id(), array(50, 50)) ?: wc_placeholder_img(array(50, 50));
				$html = '<td>' . $thumbnail . '</td><td>' . $product->get_id() . '</td><td>' . $product->get_name() . '</td><td>' . $product->get_type() . '</td><td><table><tbody>';
				$results = [];

				// Handle simple and variable products separately
				if ($product->is_type('simple')) {
					$this->handle_simple_product($product, $price_change_type, $round_price, $price_amount, $results, $html, $currency, $price_type);
				} elseif ($product->is_type('variable')) {
					$this->handle_variable_product($product, $price_change_type, $round_price, $price_amount, $results, $html, $currency, $price_type);
				}

				// If no results, display a message
				if (empty($results)) {
					$html .= '<tr><td><p>Empty</p></td></tr>';
				}

				echo wp_kses_post('<tr>' . $html . '</tr>');
			}

			// Redirect back to the Bulk Change Price page with a success message
			$redirect_url = add_query_arg('bulk_price_change_success', '1', admin_url('admin.php?page=woo-masterkit-bulk-change-price'));
			wp_redirect($redirect_url);
			exit;
		}
	}


	/**
	 * Handle price update logic for simple products.
	 */
	private function handle_simple_product($product, $price_change_type, $round_price, $price_amount, &$res, &$html, $currency, $price_type)
	{
		// Initialize variables for current prices
		$current_regular_price = floatval($product->get_regular_price());
		$current_sale_price = floatval($product->get_sale_price());

		// Check if the regular price needs to be updated
		if (in_array('regular', $price_type)) {
			$new_regular_price = $this->calculate_new_price($current_regular_price, $price_change_type, $price_amount, $round_price);
			$product->set_regular_price($new_regular_price);
			$res[] = $new_regular_price;
			$html .= '<tr><td>Regular Price:</td><td>' . $currency . $current_regular_price . ' → ' . $currency . $new_regular_price . '</td></tr>';
		}

		// Check if the sale price needs to be updated
		if (in_array('sale', $price_type)) {
			$new_sale_price = $this->calculate_new_price($current_sale_price, $price_change_type, $price_amount, $round_price);
			$product->set_sale_price($new_sale_price);
			$res[] = $new_sale_price;
			$html .= '<tr><td>Sale Price:</td><td>' . $currency . $current_sale_price . ' → ' . $currency . $new_sale_price . '</td></tr>';
		}

		// Save product changes
		$product->save();
	}

	/**
	 * Handle price update logic for variable products.
	 */
	private function handle_variable_product($product, $price_change_type, $round_price, $price_amount, &$res, &$html, $currency, $price_type)
	{
		// Get all variations of the variable product
		$available_variations = $product->get_available_variations();

		// Loop through each variation
		foreach ($available_variations as $variation_data) {
			$variation_id = $variation_data['variation_id'];
			$variation = wc_get_product($variation_id);

			// Initialize variables for current prices
			$current_regular_price = floatval($variation->get_regular_price());
			$current_sale_price = floatval($variation->get_sale_price());

			// Check if the regular price needs to be updated
			if (in_array('regular', $price_type)) {
				$new_regular_price = $this->calculate_new_price($current_regular_price, $price_change_type, $price_amount, $round_price);
				$variation->set_regular_price($new_regular_price);
				$res[] = $new_regular_price;
				$html .= '<tr><td>Variation ID: ' . $variation_id . ' - Regular Price:</td><td>' . $currency . $current_regular_price . ' → ' . $currency . $new_regular_price . '</td></tr>';
			}

			// Check if the sale price needs to be updated
			if (in_array('sale', $price_type)) {
				$new_sale_price = $this->calculate_new_price($current_sale_price, $price_change_type, $price_amount, $round_price);
				$variation->set_sale_price($new_sale_price);
				$res[] = $new_sale_price;
				$html .= '<tr><td>Variation ID: ' . $variation_id . ' - Sale Price:</td><td>' . $currency . $current_sale_price . ' → ' . $currency . $new_sale_price . '</td></tr>';
			}

			// Save variation changes
			$variation->save();
		}
	}

	/**
	 * Update prices based on the change type (increase, decrease, exact).
	 */
	private function calculate_new_price($current_price, $price_change_type, $price_amount, $round_price)
	{
		if ($price_change_type === 'increase') {
			$new_price = $current_price + $price_amount;
		} elseif ($price_change_type === 'decrease') {
			$new_price = max(0, $current_price - $price_amount); // Ensure price doesn't go below zero
		} elseif ($price_change_type === 'exact') {
			$new_price = $price_amount;
		}

		// Round the price if the option is checked
		if ($round_price) {
			$new_price = round($new_price, 0); // Round to nearest whole number
		}

		return $new_price;
	}
}
