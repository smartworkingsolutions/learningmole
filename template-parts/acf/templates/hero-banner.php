<?php
/**
 * The ACF template part for displaying Hero banner.
 *
 * @package LearningMole
 */

$heading    = get_sub_field( 'heading' );
$subheading = get_sub_field( 'sub_heading' );
$btn1       = get_sub_field( 'button_1' );
$btn2       = get_sub_field( 'button_2' );
$btn3       = get_sub_field( 'button_3' );
$bg_color   = get_sub_field( 'background_color' ) ? get_sub_field( 'background_color' ) : '#13ABB0';
$bg_image   = get_sub_field( 'background_image' );
$cat_title  = get_sub_field( 'cat_title' );

$style = '';

if ( ! $heading && ! $subheading && ! $btn1 && ! $btn2 && ! $btn3 && ! $cat_title && ! have_rows( 'categories' ) ) {
	return;
}

if ( $bg_image || $bg_color ) {
	$style = 'style="background-image: url(' . $bg_image . '); background-color: ' . $bg_color . ';"';
}
?>

<section class="w-full sm:max-h-[550px] lg:max-h-[500px] bg-cover bg-no-repeat pb-8 sm:pb-0 pt-8 md:pt-20 -mb-36 sm:mb-0 relative" <?php echo $style; //phpcs:ignore ?>>

	<div class="container">

		<div class="grid place-items-center text-center gap-8 md:gap-10 text-white">
		<?php
		if ( $heading ) {
			echo '<h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight md:leading-tight md:tracking-wider">' . esc_html( $heading ) . '</h1>';
		}
		if ( $subheading ) {
			echo '<p class="text-2xl md:text-32 font-bold leading-tight text-white">' . esc_html( $subheading ) . '</p>';
		}
		echo '<div class="grid gap-4">';
		if ( $btn1 || $btn2 ) {
			echo '<div class="w-full max-w-sm flex gap-4">';
			if ( $btn1 ) {
				printf(
					'<div><a href="%s" class="button button-white text-secondary-color" target="%s">%s</a></div>',
					esc_url( $btn1['url'] ),
					esc_html( $btn1['target'] ),
					esc_html( $btn1['title'] )
				);
			}
			if ( $btn2 ) {
				printf(
					'<div><a href="%s" class="button button-secondary" target="%s">%s</a></div>',
					esc_url( $btn2['url'] ),
					esc_html( $btn2['target'] ),
					esc_html( $btn2['title'] )
				);
			}
			echo '</div>';
		}
		echo '<div class="grid md:flex gap-6 items-center">';
		if ( $btn3 ) {
			printf(
				'<a href="%s" class="button button-light-green w-full sm:min-w-[300px] max-w-[300px]" target="%s">%s</a>',
				esc_url( $btn3['url'] ),
				esc_html( $btn3['target'] ),
				esc_html( $btn3['title'] )
			);
		}
		?>
		<div><a href="/digital-badge/" class="button button-secondary text-base w-full sm:min-w-[300px] max-w-[300px] flex gap-1 items-center"><?php get_svg( 'icons/badge' ); ?>Earn a Free Digital Badge</a></div>
		<?php
		echo '</div>';
		echo '</div>';
		?>
		</div>

		<!-- Categories -->
		<?php
		if ( $cat_title ) {
			echo '<h2 class="text-xl text-center text-white leading-tight mt-8">' . esc_html( $cat_title ) . '</h2>';
		}
		if ( have_rows( 'categories' ) ) :

			echo '<div class="relative">';
			echo '<div class="category-slider | pt-10 lg:pt-10 px-3 relative overflow-hidden">';

			// Loop through rows.
			while ( have_rows( 'categories' ) ) :
				the_row();

				// Load sub field value.
				$icon    = get_sub_field( 'icon' );
				$c_title = get_sub_field( 'title' );
				$c_link  = get_sub_field( 'url' );

				$icon_html = '';

				if ( $icon || $c_title ) {
					$icon_html = '<img class="w-full h-24 object-scale-down" src="' . $icon . '" alt="' . $c_title . ' category link">';
				}

				printf(
					'<a href="%s" class="grid text-center gap-6 bg-white border border-primary-color rounded-lg p-7 hover:scale-110 transition-all duration-300">
						%s
						<p class="text-xl text-primary-color font-bold mt-5">%s</p>
					</a>',
					esc_url( $c_link ),
					wp_kses_post( $icon_html ),
					wp_kses_post( $c_title )
				);

			endwhile;

			echo '</div></div>';

		endif;
		?>
	</div>
</section>

<?php
// Slick css.
wp_enqueue_style( 'learningmole-slick-css', get_template_directory_uri() . '/css/slick.css', [], $version );

// Slick JS.
wp_enqueue_script( 'learningmole-slick-js', get_template_directory_uri() . '/js/slick.min.js', [], null ); //phpcs:ignore
