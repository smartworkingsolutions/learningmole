<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package LearningMole
 */

/**
 * Prints HTML of logo.
 *
 * @param string $loc location of logo.
 */
function theme_logo( $loc = '' ) {
	?>
	<div class="logo">
	<?php
	if ( has_custom_logo() ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image          = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$alt            = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		$image_url      = $image[0];
		$footer_logo    = get_theme_mod( 'footer_logo' );

		if ( 'footer' === $loc ) {
			$image_url = $footer_logo;
		}

		printf(
			'<a href="%s" rel="home">
				<img class="max-h-16 sm:max-h-[74px]" src="%s" alt="%s">
			</a>',
			esc_url( get_home_url() ),
			esc_url( $image_url ),
			esc_html( $alt )
		);
	} else {
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-3xl text-primary-color font-semibold" rel="home"><?php bloginfo( 'name' ); ?></a>
		<?php
	}
	?>
	</div>
	<?php
}

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'learningmole_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function learningmole_posted_on() {

		if ( get_the_modified_date() ) {
			learningmole_updated_on();
		} else {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( DATE_W3C ) ),
				esc_html( get_the_date() )
			);

			$posted_on = sprintf(
				/* translators: %s: post date. */
				esc_html_x( 'Posted on: %s', 'post date', 'learningmole' ),
				'<a class="font-bold text-primary-color" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
			);

			echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

	}
endif;

if ( ! function_exists( 'learningmole_updated_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function learningmole_updated_on() {
		$time_string = '<time class="update-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="update-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$updated_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Updated on: %s', 'post date', 'learningmole' ),
			'<a class="font-bold text-primary-color" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="updated-on">' . $updated_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'learningmole_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function learningmole_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'By: %s', 'post author', 'learningmole' ),
			'<span class="author vcard | capitalize"><a class="url fn n | font-bold text-primary-color" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'learningmole_author_avatar' ) ) :
	/**
	 * Prints HTML with author image for the current author.
	 *
	 * @param string $size size of avatar image.
	 */
	function learningmole_author_avatar( $size = '50' ) {
		if ( function_exists( 'get_avatar' ) ) :
			echo get_avatar(
				get_the_author_meta( 'email' ),
				$size,
				$default = '',
				$alt     = '',
				$args    = [
					'class' => 'rounded-full',
				]
			);
		endif;
	}
endif;

/**
 * Prints HTML of header.
 */
function theme_header_html() {
	if ( is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) ) {
		return;
	}
	get_template_part( 'template-parts/header/mobile', 'menu' );
	?>

	<!-- Header start -->
	<header class="site-header | w-full bg-white shadow-custom relative z-10">
		<?php get_template_part( 'template-parts/header/search', 'box' ); ?>
		<div class="container">

			<div class="header-wrap | min-h-[112px] flex justify-between items-center">

				<!-- Logo -->
				<?php theme_logo(); ?>

				<!-- Nav bar -->
				<?php get_template_part( 'template-parts/header/primary', 'nav' ); ?>

				<div class="flex items-center gap-6">
					<!-- Icons -->
					<?php get_template_part( 'template-parts/header/menu', 'icon' ); ?>

					<!-- Buttons -->
					<?php get_template_part( 'template-parts/header/header', 'buttons' ); ?>
				</div>

			</div>

		</div><!-- Container end -->

	</header>
	<?php
}

/**
 * Prints HTML of footer.
 */
function theme_footer_html() {
	if ( is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) ) {
		return;
	}
	?>

	<footer class="w-full pt-8 md:pt-14">
		<div class="container">

			<div class="grid sm:grid-cols-2 lg:grid-cols-4 items-start gap-10">
				<?php
				/**
				 * Widgets here
				 */
				get_template_part( 'template-parts/footer/widget', '1' );
				get_template_part( 'template-parts/footer/widget', '2' );
				get_template_part( 'template-parts/footer/widget', '3' );
				?>
			</div>

			<?php theme_copyrights_html(); ?>

		</div><!-- container end -->
	</footer>
	<?php
}

/**
 * Prints HTML of Copyrights.
 */
function theme_copyrights_html() {
	$copyright_text  = get_field( 'c_text', 'option' );
	$middle_text     = get_field( 'middle_text', 'option' );
	$copyright_text2 = get_field( 'c_text_2', 'option' );
	?>

	<!-- Copyrights start -->
	<div class="copyrights | w-full border-t border-border-color mt-8 md:mt-12 py-8">

		<div class="grid md:flex justify-between gap-3 md:gap-10">
			<?php
			if ( $copyright_text ) {
				echo '<div class="flex">' . esc_html__( '© ', 'learningmole' ) . esc_html( gmdate( 'Y' ) ) . ' ' . wp_kses_post( $copyright_text ) . '</div>';
			}
			if ( $middle_text ) {
				echo '<div>' . wp_kses_post( $middle_text ) . '</div>';
			}
			if ( $copyright_text2 && is_front_page() ) {
				echo '<div class="flex">' . wp_kses_post( $copyright_text2 ) . '</div>';
			}
			?>
		</div>

	</div>
	<!-- Copyrights end -->

	<?php
}
