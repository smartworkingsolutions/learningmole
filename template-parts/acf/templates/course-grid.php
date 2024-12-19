<?php
/**
 * The ACF template part for displaying Course Grid.
 *
 * @package LearningMole
 */

$heading   = get_sub_field( 'heading' );
$btn       = get_sub_field( 'button' );
$shortcode = get_sub_field( 'shortcode' );
$class     = ' justify-center';

if ( ! $heading && ! $btn && ! $shortcode ) {
	return;
}
if ( $heading && $btn ) {
	$class = ' justify-between';
}
?>

<section class="w-full bg-light-color py-10 md:py-16">
	<div class="container">

		<?php
		if ( $heading || $btn ) {
			echo '<div class="w-full grid sm:flex items-center gap-8 mb-12' . esc_html( $class ) . '">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color leading-none">' . esc_html( $heading ) . '</h2>';
			}
			if ( $btn ) {
				printf(
					'<div><a href="%s" class="button" target="%s">%s</a></div>',
					esc_url( $btn['url'] ),
					esc_html( $btn['target'] ),
					esc_html( $btn['title'] )
				);
			}
			echo '</div>';
		}
		?>

		<?php echo do_shortcode( $shortcode ); ?>

	</div>
</section>
