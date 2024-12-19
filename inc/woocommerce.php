<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package LearningMole
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function learningmole_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		[
			'thumbnail_image_width' => 424,
			'single_image_width'    => 890,
			'single_image_height'   => 1032,
			'product_grid'          => [
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			],
		]
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'learningmole_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function learningmole_woocommerce_scripts() {
	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'learningmole-custom-css', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'learningmole_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function learningmole_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';
	if ( is_product_category() ) {
		$classes[] = 'woocommerce-category-page';
	}
	return $classes;
}
add_filter( 'body_class', 'learningmole_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function learningmole_woocommerce_related_products_args( $args ) {
	$defaults = [
		'posts_per_page' => 4,
		'columns'        => 4,
	];

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'learningmole_woocommerce_related_products_args' );

/**
 * Update column in product category page
 */
function loop_columns() {
	return is_product_category() ? 4 : 3;
}
add_filter( 'loop_shop_columns', 'loop_columns', 20 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'learningmole_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function learningmole_woocommerce_wrapper_before() {
		if ( is_shop() ) {
			echo '<div class="grid lg:grid-cols-12 items-start gap-8">';
		}
		?>
			<main id="primary" class="site-main woocommerce-page lg:col-span-9">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'learningmole_woocommerce_wrapper_before' );

if ( ! function_exists( 'learningmole_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function learningmole_woocommerce_wrapper_after() {
		?>
		</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'learningmole_woocommerce_wrapper_after' );

if ( ! function_exists( 'learningmole_woocommerce_wrapper_after_sidebar' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs including sidebar.
	 *
	 * @return void
	 */
	function learningmole_woocommerce_wrapper_after_sidebar() {
		if ( is_shop() ) {
			echo '</div>';
		}
	}
}
add_action( 'woocommerce_after_main_content', 'learningmole_woocommerce_wrapper_after_sidebar', 15 );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'learningmole_woocommerce_header_cart' ) ) {
			learningmole_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'learningmole_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function learningmole_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		learningmole_woocommerce_cart_link();
		$fragments['.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'learningmole_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'learningmole_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function learningmole_woocommerce_cart_link() {
		$count = WC()->cart->get_cart_contents_count();
		?>
		<div class="cart-icon hover:text-dark-color">
			<a class="cart-contents relative" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'learningmole' ); ?>">
				<?php
				get_svg( 'icons/ShoppingCart' );
				if ( $count > 0 ) {
					?>
					<span class="w-4 h-4 grid place-content-center text-[10px] bg-primary rounded-full absolute -top-1 -right-2"><?php echo $count; // phpcs:ignore ?></span>
					<?php
				}
				?>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'learningmole_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function learningmole_woocommerce_header_cart() {
		$class = '';
		if ( is_cart() ) {
			$class = 'current-menu-item';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php learningmole_woocommerce_cart_link(); ?>
			</li>
			<li>
				<div class="widget widget_shopping_cart">
					<div class="widget_shopping_cart_content">
						<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</li>
		</ul>
		<?php
	}
}

/**
 * WooCommerce Remove Product Permalink @ Order Table and Cart page.
 */
add_filter( 'woocommerce_order_item_permalink', '__return_false' );
add_filter( 'woocommerce_cart_item_permalink', '__return_null' );

/**
 * Remove my-account tabs links.
 *
 * @param array $menu_links default.
 */
function update_dahsboard_link( $menu_links ) {
	unset( $menu_links['dashboard'] );
	unset( $menu_links['downloads'] );
	unset( $menu_links['edit-address'] );
	unset( $menu_links['edit-account'] );
	return $menu_links;
}
add_filter( 'woocommerce_account_menu_items', 'update_dahsboard_link' );

/**
 * Get a button in Thankyou page.
 */
function add_button_before_thankyou() {
	echo '<a class="button mb-6" href="/dashboard/">Go to Dashboard</a>';
}
add_action( 'woocommerce_before_thankyou', 'add_button_before_thankyou' );

/**
 * Add currency changer
 */
function add_currency_switcher() {
	echo '<div class="flex gap-3 items-center mt-6">';
	echo '<p class="w-full font-bold">Select your currency</p>';
	echo '<div class="w-full">';
	echo do_shortcode( '[woo_multi_currency]' );
	echo '</div>';
	echo '</div>';
}
add_action( 'woocommerce_checkout_before_order_review', 'add_currency_switcher' );
