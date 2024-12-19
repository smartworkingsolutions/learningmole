<?php
/**
 * LearningMole functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package LearningMole
 */

if ( ! defined( 'THEME_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'THEME_VERSION', '1.0.15' );
}

if ( ! function_exists( 'learningmole_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function learningmole_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on LearningMole, use a find and replace
		 * to change 'learningmole' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'learningmole', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			[
				'main-menu' => esc_html__( 'Primary', 'learningmole' ),
			]
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			]
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			[
				'height'      => 36,
				'width'       => 212,
				'flex-width'  => true,
				'flex-height' => true,
			]
		);
	}
endif;
add_action( 'after_setup_theme', 'learningmole_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function learningmole_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'learningmole_content_width', 640 );
}
add_action( 'after_setup_theme', 'learningmole_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function learningmole_widgets_init() {
	register_sidebar(
		[
			'name'          => esc_html__( 'Sidebar', 'learningmole' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'learningmole' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);
}
add_action( 'widgets_init', 'learningmole_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function learningmole_scripts() {

	$version = THEME_VERSION;
	$path    = get_template_directory_uri();

	/**
	 * Styles
	 */
	// Main style css.
	wp_enqueue_style( 'learningmole-style', get_stylesheet_uri(), [], $version );
	wp_enqueue_style( 'learningmole-theme-style', $path . '/css/theme.css', [], $version );

	// Custom css for override.
	wp_enqueue_style( 'learningmole-custom-css', $path . '/css/custom.css', [], $version );

	/**
	 * Scripts
	 */
	// Theme's scrips.
	wp_enqueue_script( 'learningmole-custom-js', $path . '/js/custom.js', [ 'jquery' ], $version, true );

	// Alpine Js.
	wp_enqueue_script( 'alpine', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', [], null ); //phpcs:ignore

	// Filter JS.
	wp_enqueue_script( 'learningmole-filters-js', $path . '/js/filters.js', [], $version, true );

	// WP Localize.
	wp_localize_script(
		'learningmole-filters-js',
		'learningmole_ajax_filter',
		[
			'url' => admin_url( 'admin-ajax.php' ),
		]
	);

}
add_action( 'wp_enqueue_scripts', 'learningmole_scripts' );

/**
 * Add extra attributes to enqueued scripts.
 *
 * @param string $tag default.
 * @param string $handle default.
 */
function add_extra_attributes( $tag, $handle ) {
	return false !== strpos( $handle, 'alpine' )
		? str_replace( ' src', ' defer src', $tag )
		: $tag;
}
add_filter( 'script_loader_tag', 'add_extra_attributes', 10, 2 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * All classes here
 */
require get_template_directory() . '/inc/class-custom-menu-walker.php';
require get_template_directory() . '/inc/class-svg-enable.php';
require get_template_directory() . '/inc/class-learningmole-actions.php';
require get_template_directory() . '/inc/class-custom-post-types.php';
require get_template_directory() . '/inc/class-custom-pagination.php';


/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'wooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';

	// Load WooCommerce extra funtionality.
	require get_template_directory() . '/inc/class-learningmole-woocommerce.php';
}

/**
 * Load ACF Options panel.
 */
require get_template_directory() . '/inc/class-acf-options-panel.php';

/**
 * This will remove the default image sizes and the medium_large size.
 *
 * @param array $sizes default sizes.
 */
function prefix_remove_default_images( $sizes ) {
	unset( $sizes['small'] ); // 150px.
	unset( $sizes['medium'] ); // 300px.
	unset( $sizes['large'] ); // 1024px.
	unset( $sizes['medium_large'] ); // 768px.
	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images' );

/**
 * This will remove the default image sizes and the medium_large size.
 */
function remove_big_image_sizes() {
	remove_image_size( '1536x1536' ); // 2 x Medium Large (1536 x 1536)
	remove_image_size( '2048x2048' ); // 2 x Large (2048 x 2048)
}
add_action( 'init', 'remove_big_image_sizes' );

/**
 * Remove 'Category:', 'Tag:', 'Author:', 'Archives:' and Other 'taxonomy name:' in the archive title
 */
add_filter( 'get_the_archive_title_prefix', '__return_false' );

/**
 * Filter courses by category and tags.
 */
function cat_filter_taxonomy() {

	$filters = $_POST['filter']; // phpcs:ignore

	$args = [
		'post_type'      => 'sfwd-courses',
		'posts_per_page' => -1,
	];

	if ( ! empty( $filters['cats'] ) || ! empty( $filters['tags'] ) ) {
		$args['tax_query'] = [
			'relation' => 'OR',
		];
		if ( ! empty( $filters['cats'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_course_category',
				'field'    => 'slug',
				'terms'    => $filters['cats'],
			];
		}
		if ( ! empty( $filters['tags'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_course_tag',
				'field'    => 'slug',
				'terms'    => $filters['tags'],
			];
		}
	}

	$ajaxposts = new WP_Query( $args );

	if ( ! $ajaxposts->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $ajaxposts->have_posts() ) {
		while ( $ajaxposts->have_posts() ) :
			$ajaxposts->the_post();
			get_template_part( 'template-parts/content', 'course' );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_cat_filter_taxonomy', 'cat_filter_taxonomy' );
add_action( 'wp_ajax_nopriv_cat_filter_taxonomy', 'cat_filter_taxonomy' );

/**
 * Filter lessons by category and tags.
 */
function filter_taxonomy() {

	$filters = $_POST['filter']; // phpcs:ignore

	$args = [
		'post_type'      => 'sfwd-lessons',
		'posts_per_page' => -1,
		'order'          => 'ASC',
	];

	if ( ! empty( $filters['cats'] ) || ! empty( $filters['tags'] ) ) {
		$args['tax_query'] = [
			'relation' => 'OR',
		];
		if ( ! empty( $filters['cats'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_lesson_category',
				'field'    => 'slug',
				'terms'    => $filters['cats'],
			];
		}
		if ( ! empty( $filters['tags'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_lesson_tag',
				'field'    => 'slug',
				'terms'    => $filters['tags'],
			];
		}
	}

	$ajaxposts = new WP_Query( $args );

	if ( ! $ajaxposts->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $ajaxposts->have_posts() ) {
		while ( $ajaxposts->have_posts() ) :
			$ajaxposts->the_post();
			get_template_part( 'template-parts/content', 'lesson' );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_filter_taxonomy', 'filter_taxonomy' );
add_action( 'wp_ajax_nopriv_filter_taxonomy', 'filter_taxonomy' );

/**
 * Filter topics by category and tags.
 */
function topic_filter_taxonomy() {

	$filters = $_POST['filter']; // phpcs:ignore

	$args = [
		'post_type'      => 'sfwd-topic',
		'posts_per_page' => -1,
		'order'          => 'ASC',
	];

	if ( ! empty( $filters['cats'] ) || ! empty( $filters['tags'] ) ) {
		$args['tax_query'] = [
			'relation' => 'AND',
		];
		if ( ! empty( $filters['cats'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_topic_category',
				'field'    => 'slug',
				'terms'    => $filters['cats'],
			];
		}
		if ( ! empty( $filters['tags'] ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'ld_topic_tag',
				'field'    => 'slug',
				'terms'    => $filters['tags'],
			];
		}
	}

	$ajaxposts = new WP_Query( $args );

	if ( ! $ajaxposts->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $ajaxposts->have_posts() ) {
		while ( $ajaxposts->have_posts() ) :
			$ajaxposts->the_post();
			get_template_part( 'template-parts/content', 'topic' );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_topic_filter_taxonomy', 'topic_filter_taxonomy' );
add_action( 'wp_ajax_nopriv_topic_filter_taxonomy', 'topic_filter_taxonomy' );

/**
 * Add the ajax fetch js.
 */
function ajax_fetch() {
	?>
	<script type="text/javascript">
	function learnmole_fetch_courses() {
		const keyword = jQuery('#keyword').val();
		if ( keyword.length > 2 ) {
			jQuery.ajax({
				url: learningmole_ajax_filter.url,
				type: 'post',
				data: { action: 'data_fetch_course', keyword: keyword },
				beforeSend: function(xhr) {
					jQuery('.search-result').html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
				},
				success: function(data) {
					jQuery(".search-submit").prop('disabled', true);
					jQuery('.search-result').html( data );
					jQuery('.pagination').addClass('hidden');
				}
			});
		}
	}
	function learnmole_fetch_lessons() {
		const keyword = jQuery('#keyword').val();
		if ( keyword.length > 2 ) {
			jQuery.ajax({
				url: learningmole_ajax_filter.url,
				type: 'post',
				data: { action: 'data_fetch_lesson', keyword: keyword },
				beforeSend: function(xhr) {
					jQuery('.search-result').html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
				},
				success: function(data) {
					jQuery(".search-submit").prop('disabled', true);
					jQuery('.search-result').html( data );
					jQuery('.pagination').addClass('hidden');
				}
			});
		}
	}
	function learnmole_fetch_topics() {
		const keyword = jQuery('#keyword').val();
		if ( keyword.length > 2 ) {
			jQuery.ajax({
				url: learningmole_ajax_filter.url,
				type: 'post',
				data: { action: 'data_fetch_topic', keyword: keyword },
				beforeSend: function(xhr) {
					jQuery('.search-result').html('<div class="spinner"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 38 38" stroke="#000"><g fill="none" fill-rule="evenodd"><g transform="translate(1 1)" stroke-width="2"><circle stroke-opacity=".5" cx="18" cy="18" r="18"/><path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path></g></g></svg></div>')
				},
				success: function(data) {
					jQuery(".search-submit").prop('disabled', true);
					jQuery('.search-result').html( data );
					jQuery('.pagination').addClass('hidden');
				}
			});
		}
	}
	</script>
	<?php
}
add_action( 'wp_footer', 'ajax_fetch' );

function lessons_topics_filters( $query ) {
	if ( ( $query->is_tax( 'ld_lesson_category' ) || $query->is_tax( 'ld_topic_category' ) ) && $query->is_main_query() ) {
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'lessons_topics_filters' );

/**
 * Filter topics by search query.
 */
function data_fetch_course() {

	$post_type = 'sfwd-courses';
	$content   = 'course';

	$the_query = new WP_Query(
		[
			'posts_per_page' => -1,
			's'              => esc_attr( $_POST['keyword'] ), // phpcs:ignore
			'post_type'      => $post_type,
		]
	);
	if ( ! $the_query->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			get_template_part( 'template-parts/content', $content );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_data_fetch_course', 'data_fetch_course' );
add_action( 'wp_ajax_nopriv_data_fetch_course', 'data_fetch_course' );

/**
 * Filter topics by search query.
 */
function data_fetch_lesson() {

	$post_type = 'sfwd-lessons';
	$content   = 'lesson';

	$the_query = new WP_Query(
		[
			'posts_per_page' => -1,
			's'              => esc_attr( $_POST['keyword'] ), // phpcs:ignore
			'post_type'      => $post_type,
		]
	);
	if ( ! $the_query->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			get_template_part( 'template-parts/content', $content );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_data_fetch_lesson', 'data_fetch_lesson' );
add_action( 'wp_ajax_nopriv_data_fetch_lesson', 'data_fetch_lesson' );

/**
 * Filter topics by search query.
 */
function data_fetch_topic() {

	$post_type = 'sfwd-topic';
	$content   = 'topic';

	$the_query = new WP_Query(
		[
			'posts_per_page' => -1,
			's'              => esc_attr( $_POST['keyword'] ), // phpcs:ignore
			'post_type'      => $post_type,
		]
	);
	if ( ! $the_query->have_posts() ) {
		echo '<p>No result found.</p>';
	}
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			get_template_part( 'template-parts/content', $content );
		endwhile;
		wp_reset_postdata();
	}
	die();
}
add_action( 'wp_ajax_data_fetch_topic', 'data_fetch_topic' );
add_action( 'wp_ajax_nopriv_data_fetch_topic', 'data_fetch_topic' );

/* Wbcom Designs - Use Gravatar */
add_filter(
	'pre_get_avatar_data',
	function( $args, $id_or_email ) { // phpcs:ignore
		// unset( $args['url'] );
		$args['url'] = 'https://wordpress-858454-4166281.cloudwaysapps.com/wp-content/uploads/2024/01/avatar.png';;
		return $args;
	},
	99,
	2
);

/**
 * Update default avatar.
 *
 * @param array $avatar_defaults default.
 */
function lm_new_gravatar( $avatar_defaults ) {
	$myavatar = 'https://wordpress-858454-4166281.cloudwaysapps.com/wp-content/uploads/2024/01/avatar.png';

	$avatar_defaults[ $myavatar ] = 'Default Gravatar';
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'lm_new_gravatar' );

/**
 * Apply Discount Coupon automatically to the cart
 *
 * @param Array $passed return output.
 * @param Array $product_id product ids in cart.
 * @param Array $quantity quantity of products.
 */
function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) { // phpcs:ignore
	if ( ! WC()->cart->is_empty() ) {
		WC()->cart->empty_cart();
	}
	if ( in_array( $product_id, [ 12549, 12547, 12546, 12548 ], true ) ) {
		// WC()->cart->add_discount( 'First Six Months Discount' ); // old.
		WC()->cart->add_discount( 'f6mdisc' );
	}
	return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3 );

/**
 * Redirects a user to a Dashboard page after login.
 *
 * @param Array $redirect_to redirect_to.
 * @param Array $request request.
 * @param Array $user user.
 */
function my_login_redirect( $redirect_to, $request, $user ) { // phpcs:ignore
	$redirect_to = '/dashboard/';
	return $redirect_to;
}
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

/**
 * Action to stop redirect after edit details from my-account/edit-profile page.
 *
 * @param number $ID id.
 */
function custom__woocommerce_save_account_details__redirect( $ID ) { // phpcs:ignore
	wp_safe_redirect( wc_get_endpoint_url( '' ) );
	exit();
}
add_action( 'woocommerce_save_account_details', 'custom__woocommerce_save_account_details__redirect', 90, 1 );

/**
 * Update url of Browse product.
 *
 * @param string $url url.
 */
function learningmole_rediect_browse_product( $url ) { // phpcs:ignore
	return '/pricing/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'learningmole_rediect_browse_product' );

/**
 * Update url of Browse product.
 *
 * @param string $translated_text translated_text.
 * @param string $text text.
 * @param string $domain domain.
 */
function change_browse_product_element( $translated_text, $text, $domain ) { // phpcs:ignore
	switch ( $translated_text ) {
		case 'Browse products':
			$translated_text = __( 'Get Started', 'learningmole' );
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'change_browse_product_element', 20, 3 );

/**
 * Update url/redirect of login page.
 */
function custom_login_redirect() {
	$page_viewed = basename( $_SERVER['REQUEST_URI'] );
	if ( 'wp-login.php' === $page_viewed && 'GET' === $_SERVER['REQUEST_METHOD'] ) {
		wp_safe_redirect( home_url( '/login/' ) );
		exit;
	}
}
add_action( 'init', 'custom_login_redirect' );

/**
 * Filter videos from content.
 *
 * @param string $content default content.
 */
function filter_content_for_embeds( $content ) {
	global $current_user;
	$user_id       = $current_user->ID;
	$group_ids     = learndash_get_users_group_ids( $user_id );
	$free_group_id = get_free_group_id();

	$courses   = get_all_courses_ids_under_group();
	$course_id = learndash_get_course_id( get_the_ID() );

	if ( in_array( $course_id, $courses, true ) ) {
		return $content;
	}

	if ( ( empty( $group_ids ) || $free_group_id === $group_ids ) && 'sfwd-topic' === get_post_type() ) {
		if ( ! $content ) {
			$content = '<p>Content coming soon...</p>';
		}
		if ( has_post_thumbnail() ) {
			$thumbnail = get_the_post_thumbnail(
				get_the_ID(),
				'full',
				[
					'class' => 'w-full',
					'alt'   => get_the_title(),
				]
			);
			$output    = '<div class="video-wrap | relative">' . $thumbnail . '<span class="w-10 sm:w-40 h-10 sm:h-40 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">' . get_svg( 'icons/play', false ) . '</span><span class="absolute inset-0 bg-black/30"></span></div>';
		} else {
			$output = '<div class="video-wrap | relative"><img class="w-full" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="No thumb" /><span class="w-10 sm:w-40 h-10 sm:h-40 text-white absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10">' . get_svg( 'icons/play', false ) . '</span><span class="absolute inset-0 bg-black/30"></span></div>';
		}
		$content  = preg_replace( '/<iframe.*?\/iframe>/i', $output, $content );
		$content .= '<div class="text-center"><a href="/pricing/" class="button button-primary my-3">Get Started</a></div>';
	}
	return $content;
}
add_filter( 'the_content', 'filter_content_for_embeds' );

add_filter(
	'rank_math/snippet/rich_snippet_article_entity',
	function( $data ) {
		$post_id     = get_the_ID();
		$reviewed_by = get_field( 'reviewed_by', $post_id );

		if ( $reviewed_by && is_singular( 'post' ) ) {
			$user_data          = get_userdata( $reviewed_by[0]['ID'] );
			$desc               = get_field( 'short_description', 'user_' . $reviewed_by[0]['ID'] );
			$knows              = get_field( 'knowsabout', 'user_' . $reviewed_by[0]['ID'] );
			$data['reviewedBy'] = [
				'@type'       => 'Person',
				'name'        => $user_data->display_name,
				'description' => $desc,
				'url'         => get_the_permalink( $post_id ),
				'knowsAbout'  => $knows,
			];

			$linkedin_url = get_user_meta( $user_data->ID, 'linkedin', true );
			if ( $linkedin_url ) {
				$data['reviewedBy']['sameAs'] = [ $linkedin_url ];
			}
		}

		return $data;
	},
	99,
	2
);

add_role( 'pt-content-writer', 'Content Writer', get_role( 'editor' )->capabilities );

/**
 * Filter to change the schema data.
 * Replace $schema_type with schema name like article, review, etc.
 *
 * @param array $entity Snippet Data
 * @return array
 */
add_filter(
	'rank_math/snippet/rich_snippet_videoobject_entity',
	function( $entity ) {
		if ( is_singular( 'sfwd-topic' ) ) {
			$entity['isAccessibleForFree'] = 'False';
		}
		return $entity;
	}
);

/**
 * Filter to change the video schema data to learning resource.
 * Replace $schema_type with schema name like article, review, etc.
 *
 * @param array $entity Snippet Data
 * @return array
 */
add_filter(
	'rank_math/snippet/rich_snippet_videoobject_entity',
	function( $entity ) {
		$learning_resource = get_field( 'learning_resource_schema' );
		if ( $learning_resource ) :
			$entity['@type'] = [ 'VideoObject', 'LearningResource' ];
			if ( have_rows( 'learning_resource' ) ) :
				while ( have_rows( 'learning_resource' ) ) :
					the_row();
					$learning_resource_type = get_sub_field( 'learning_resource_type' );
					$educational_level      = get_sub_field( 'educational_level' );
					if ( $learning_resource_type ) :
						$entity['learningResourceType'] = $learning_resource_type;
					endif;
					if ( $educational_level ) :
						$entity['educationalLevel'] = $educational_level;
					endif;
				endwhile;
			endif;
		endif;
		return $entity;
	}
);

/**
 * Remove Customise > Additional CSS.
 *
 * @param array $wp_customize default.
 * @return void
 */
function pt_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'custom_css' );
}
add_action( 'customize_register', 'pt_customize_register' );

add_filter( 'auto_update_plugin', 'return_false' );
add_filter( 'auto_update_theme', 'return_false' );

/**
 * Google Tag Manager script.
 */
function lm_ga() {
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WLB7C56');</script>
	<!-- End Google Tag Manager -->

	<script async src="https://www.googletagmanager.com/gtag/js?id=G-9TR4THMHYX"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-9TR4THMHYX');
	</script>
	<?php
}
add_action( 'wp_head', 'lm_ga', 20 );

/**
 * Google Tag Manager (noscript) script.
 */
function lm_gtm_body() {
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WLB7C56"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
};
add_action( 'wp_body_open', 'lm_gtm_body' );

// Remove p tag in the description.
remove_filter( 'term_description', 'wpautop' );

/**
 * Check if user have active subscription.
 *
 * @param string $user_id user id.
 */
function has_active_subscription( $user_id = '' ) {
	// When a $user_id is not specified, get the current user Id.
	if ( '' === $user_id && is_user_logged_in() ) {
		$user_id = get_current_user_id();
	}
	// User not logged in we return false.
	if ( 0 === $user_id ) {
		return false;
	}

	return wcs_user_has_subscription( $user_id, '', 'active' );
}

/**
 * Retrun free group Id.
 */
function get_free_group_id() {
	return [ 30939 ];
	// return [ 18545 ]; // local for development.
}

/**
 * Register a user.
 *
 * @return void
 */
function custom_register_user() {
	$username = sanitize_user( $_POST['username'] ); // phpcs:ignore
	$email    = sanitize_email( $_POST['email'] ); // phpcs:ignore
	$password = $_POST['password']; // phpcs:ignore

	$user_id = wp_create_user( $username, $password, $email );

	if ( is_wp_error( $user_id ) ) {
		// Handle registration error.
		wp_redirect( home_url( '/lm-register/?registration_error=' . $user_id->get_error_code() ) ); // phpcs:ignore
		exit;
	}

	if ( ! ( empty( $user_id ) ) ) {
		learndash_set_users_group_ids( $user_id, get_free_group_id() );
	}

	// Redirect after successful registration.
	wp_redirect( home_url( '/thanks-for-registering/' ) ); // phpcs:ignore
	exit;
}

add_action( 'admin_post_nopriv_custom_register_user', 'custom_register_user' );
add_action( 'admin_post_custom_register_user', 'custom_register_user' );


/**
 * Replace WP logo to LearningMole logo.
 */
function custom_login_logo() {
	?>
	<style type="text/css">
		.login h1 a {
			background-image: url(https://learningmole.com/wp-content/themes/learningmole/images/LearningMole-Logo.svg);
			background-size: contain;
			width: 168px;
			height: 74px;
		}
		.wp-core-ui .button-primary {
			background-color: #13ABB0;
			border: none;
		}
		.wp-core-ui .button-primary:hover {
			background-color: #3D3D3D;
		}
	</style>
	<?php
}
add_action( 'login_head', 'custom_login_logo' );

/**
 * Replace logo's URL.
 *
 * @param string $url default WP URL.
 */
function my_custom_login_url( $url ) { // phpcs:ignore.
	return 'https://learningmole.com/';
}
add_filter( 'login_headerurl', 'my_custom_login_url' );

/**
 * Remove anchor tag on scaled images - to fix the Screaming Frog issues.
 *
 * @param array $content default content.
 */
function attachment_image_link_remove_filter( $content ) {
	$content = preg_replace(
		'/<a[^>]*href=["\'][^"\']*scaled[^"\']*["\'][^>]*>\s*(<img[^>]+>)\s*<\/a>/i',
		'$1',
		$content
	);
	return $content;
}
add_filter( 'the_content', 'attachment_image_link_remove_filter' );

/**
 * Fix paginate page for the Screaming Frog issues.
 */
add_filter(
	'paginate_links',
	function( $link ) {
		if ( is_paged() ) {
			$link = str_replace( 'page/1/', '', $link );
		}
		return $link;
	}
);

/**
 * Validate password field.
 */
function validate_password_field() {
	if ( ! is_page( 'register' ) ) {
		return;
	}
	?>
	<script type="text/javascript">
		document.getElementById('custom-registration-form').addEventListener('submit', function(event) {
			var password = document.getElementById('password').value;

			if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[^A-Za-z0-9]/.test(password)) {
				alert('Password should contain at least 8 characters including uppercase, lowercase letters, numbers, and special characters.');
				event.preventDefault();
			}
		});
	</script>
	<?php
}
add_action( 'wp_footer', 'validate_password_field' );

/**
 * Filter to remove Schema Data from Posts.
 * Replace $schema_type with schema name like article, review, etc.
 *
 * @param bool  $value true/false Default false
 * @param array $parts Post Data
 * @param array $data  Schema Data
 *
 * @return bool
 */
add_filter(
	'rank_math/snippet/rich_snippet_videoobject',
	function( $value, $parts, $data ) { // phpcs:ignore
		if ( ! function_exists( 'rank_math' ) || ! rank_math( 'options' )->get( 'rich_snippets', 'video_enable' ) ) {
			return $value;
		}
		if ( is_singular( 'sfwd-topic' ) ) {
			return true;
		}
		if ( is_single() && 'post' === get_post_type() ) {
			$content = get_the_content();
			if ( strpos( $content, 'youtube.com' ) !== false || strpos( $content, '<iframe' ) !== false ) {
				return false;
			} else {
				return true;
			}
		}
		return false;
	},
	10,
	3
);

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */
function lm_remove_wp_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS.
}
add_action( 'wp_enqueue_scripts', 'lm_remove_wp_block_library_css', 100 );
