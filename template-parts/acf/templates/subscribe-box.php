<?php
/**
 * The ACF template part for displaying Subscribe box.
 *
 * @package LearningMole
 */

$heading  = get_sub_field( 'heading' );
$content  = get_sub_field( 'content' );
$btn      = get_sub_field( 'button' );
$bg_image = get_sub_field( 'background_image' );
$bg_color = '#13ABB0';
$style    = '';

if ( ! $heading && ! $content && ! $btn && ! $bg_image ) {
	return;
}
if ( $bg_image || $bg_color ) {
	$style = 'style="background-image: url(' . $bg_image . '); background-color: ' . $bg_color . ';"';
}
?>

<section class="w-full py-10 lg:py-14 relative" <?php echo $style; //phpcs:ignore ?>>
	<div class="container">
		<div class="grid lg:flex justify-between items-center gap-10">
		<?php
		if ( $heading || $content ) {
			echo '<div class="grid">';
			if ( $heading ) {
				echo '<h2 class="text-2xl md:text-3xl font-bold text-white leading-tight">' . do_shortcode( $heading ) . '</h2>';
			}
			if ( $content ) {
				echo '<h2 class="text-2xl md:text-3xl text-primary-color-100 font-bold leading-tight">' . wp_kses_post( $content ) . '</h2>';
			}
			echo '</div>';
		}
		if ( $btn ) {
			printf(
				'<div><a href="%s" class="button button-light-green" target="%s">%s</a></div>',
				esc_url( $btn['url'] ),
				esc_html( $btn['target'] ),
				esc_html( $btn['title'] )
			);
		}
		?>
		</div>
	</div>
</section>
