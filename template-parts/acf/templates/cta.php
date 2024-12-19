<?php
/**
 * The ACF template part for displaying CTA.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );
$btn     = get_sub_field( 'button' );
$content = get_sub_field( 'content' );

if ( ! $heading && ! $btn && ! $content ) {
	return;
}
?>

<section class="w-full bg-primary-color py-10 md:py-16">
	<div class="container">

		<div class="grid md:grid-cols-2 items-center gap-6 md:gap-10">
		<?php
		if ( $heading || $btn ) {
			echo '<div class="grid gap-6">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl font-bold text-white md:leading-tight">' . wp_kses_post( $heading ) . '</h2>';
			}
			if ( $btn ) {
				printf(
					'<div><a href="%s" class="button button-secondary" target="%s">%s</a></div>',
					esc_url( $btn['url'] ),
					esc_html( $btn['target'] ),
					esc_html( $btn['title'] )
				);
			}
			echo '</div>';
		}

		if ( $content ) {
			echo '<div class="wysiwyg-editor dark gap-8">' . wp_kses_post( $content ) . '</div>';
		}
		?>
		</div>

	</div>
</section>
