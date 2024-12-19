<?php
/**
 * The ACF template part for displaying Contact us.
 *
 * @package LearningMole
 */

$content   = get_sub_field( 'content' );
$address   = get_sub_field( 'address' );
$email     = get_sub_field( 'email' );
$heading   = get_sub_field( 'heading' );
$shortcode = get_sub_field( 'shortcode' );

if ( ! $content && ! $address && ! $email && ! $heading && ! $shortcode ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

		<div class="grid lg:grid-cols-2 items-start gap-10">
			<?php
			if ( $content || $address || $email ) {
				echo '<div class="grid gap-8">';
				if ( $content ) {
					echo '<div class="wysiwyg-editor gap-8">' . do_shortcode( $content ) . '</div>';
				}
				if ( $address ) {
					echo '<div class="flex items-center gap-4">';
					echo '<span class="w-5 h-5 flex items-center text-secondary-color">' . get_svg( 'icons/location', false ) . '</span>'; // phpcs:ignore
					echo '<address class="not-italic text-base font-semibold">' . wp_kses_post( $address ) . '</address>';
					echo '</div>';
				}
				if ( $email ) {
					echo '<div class="flex items-center gap-4">';
					echo '<span class="w-5 h-5 flex items-center text-secondary-color">' . get_svg( 'icons/mail', false ) . '</span>'; // phpcs:ignore
					echo '<a href="mailto:' . esc_html( $email ) . '" class="text-base font-semibold hover:text-primary-color">' . esc_html( $email ) . '</a>';
					echo '</div>';
				}
				echo '</div>';
			}
			?>
			<?php
			if ( $heading || $shortcode ) {
				echo '<div class="grid gap-8">';
				if ( $heading ) {
					echo '<h2 class="text-2xl lg:text-3xl font-bold text-primary-color">' . wp_kses_post( $heading ) . '</h2>';
				}
				if ( $shortcode ) {
					echo do_shortcode( $shortcode );
				}
				echo '</div>';
			}
			?>
		</div>

	</div>
</section>
