<?php
/**
 * LearningMole Woocommerce class for extra funtionality and overriding.
 *
 * @package LearningMole
 */

defined( 'WPINC' ) || exit;

/**
 * Main class for LearningMole Woocommerce
 */
class LearningMole_Woocommerce {

	/**
	 * The Construct
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks and Filters.
	 */
	public function hooks() {

		// wrapper.
		add_action( 'learningmole_after_header', [ $this, 'wp_add_wrapper_after_header' ], 20 );
		add_action( 'learningmole_before_footer', [ $this, 'wp_close_wrapper_before_footer' ] );

		// Add/Remove breadcrumb.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Remove shop title.
		add_filter( 'woocommerce_show_page_title', [ $this, 'hide_shop_page_title' ] );

		// Wrap results and filter dropdown into div.
		add_action( 'woocommerce_before_shop_loop', [ $this, 'wc_result_count_start' ], 15 );
		add_action( 'woocommerce_before_shop_loop', [ $this, 'wp_close_div' ], 35 );

		// Add custom icon into Add to cart button.
		// Move price and wrap into div with cart icon.
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'wc_price_cart_start' ], 10 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_title', 15 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 20 );
		// add_filter( 'woocommerce_after_shop_loop_item', [ $this, 'wc_custom_add_to_cart_text' ], 10 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'wc_price_cart_end' ], 25 );

		// Add/Close div.
		add_action( 'woocommerce_checkout_after_customer_details', [ $this, 'wp_add_div' ] );
		add_action( 'woocommerce_review_order_after_payment', [ $this, 'wp_close_div' ] );

		// Remove order note from Checkout page.
		add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

		// Remove coupon form from Checkout page.
		// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

		// Remove review stars into products.
		// Add review stars into products next div.
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 15 );

		// WC sidebar.
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
		add_action( 'woocommerce_after_main_content', 'woocommerce_get_sidebar', 10 );
		add_action( 'wp', [ $this, 'wc_remove_sidebar' ] );

		// Update WC Pagination arrow text.
		add_filter( 'woocommerce_pagination_args', [ $this, 'wc_pagination_arrow' ] );

		// Update slider options.
		add_filter( 'woocommerce_single_product_carousel_options', [ $this, 'wc_flexslider_options' ] );

		// Add logo in my-account page.
		add_action( 'woocommerce_before_account_navigation', [ $this, 'wp_add_div' ], 10 );
		add_action( 'woocommerce_before_account_navigation', [ $this, 'add_logo_in_dashboard' ], 20 );
		add_action( 'woocommerce_after_account_navigation', [ $this, 'wp_close_div' ], 10 );

	}

	/**
	 * Add wrapper after header.
	 */
	public function wp_add_wrapper_after_header() {
		if ( ! is_woocommerce() ) {
			return;
		}
		echo '<div class="wc-wrapper"><div class="container">';
	}

	/**
	 * Add wrapper before footer.
	 */
	public function wp_close_wrapper_before_footer() {
		if ( ! is_woocommerce() ) {
			return;
		}
		echo '</div></div>';
	}

	/**
	 * Remove shop title.
	 *
	 * @param string $title default title of shop page.
	 */
	public function hide_shop_page_title( $title ) {
		if ( is_shop() ) {
			$title = false;
		}
		return $title;
	}

	/**
	 * Add div.
	 */
	public function wp_add_div() {
		echo '<div>';
	}

	/**
	 * Close div.
	 */
	public function wp_close_div() {
		echo '</div>';
	}

	/**
	 * Wrap price and cart - start.
	 */
	public function wc_price_cart_start() {
		echo '<div class="mt-2">';
	}
	/**
	 * Wrap price and cart - end.
	 */
	public function wc_price_cart_end() {
		echo '</div>';
	}

	/**
	 * Wrap result count - start.
	 */
	public function wc_result_count_start() {
		echo '<div class="flex justify-between items-center mb-6">';
	}

	/**
	 * Remove sidebar from selecting pages.
	 */
	public function wc_remove_sidebar() {
		if ( is_product() || is_product_category() || is_cart() || is_checkout() || is_account_page() ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_get_sidebar', 10 );
		}
	}

	/**
	 * Update WC Pagination arrow text.
	 *
	 * @param array $args default args.
	 */
	public function wc_pagination_arrow( $args ) {

		$args['prev_text'] = 'Prev';
		$args['next_text'] = 'Next';

		return $args;
	}

	/**
	 * Filer WooCommerce Flexslider options - Add Navigation Arrows.
	 *
	 * @param array $options default array.
	 */
	public function wc_flexslider_options( $options ) {

		$options['directionNav'] = true;
		$options['controlNav']   = false;

		return $options;
	}

	/**
	 * Add logo in my-account dashboard.
	 */
	public function add_logo_in_dashboard() {
		echo '<div class="flex justify-center mx-auto py-6 lg:py-10 col-span-full">';
		theme_logo();
		echo '</div>';
	}

}

/**
 * Init
 */
new LearningMole_Woocommerce();
