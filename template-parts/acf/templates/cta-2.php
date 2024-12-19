<?php
/**
 * The ACF template part for displaying CTA.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );
$btn     = get_sub_field( 'button' );

if ( ! $heading && ! $btn ) {
	return;
}
?>

<section class="cta-2 | w-full bg-primary-color py-10 md:py-12">
	<div class="container">

		<div class="grid md:flex justify-center items-center gap-7">
			<?php
			if ( $btn ) {
				?>
				<a href="<?php echo esc_url( $btn['url'] ); ?>" target="<?php echo esc_html( $btn['target'] ); ?>" aria-label="Link to our YouTube Channel"><svg class="hidden md:block" width="136" height="95" viewBox="0 0 136 95" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M133.233 14.9362C132.459 12.071 130.947 9.45803 128.846 7.35737C126.746 5.25671 124.13 3.74161 121.26 2.96286C110.619 0.0475094 68.0471 5.15035e-05 68.0471 5.15035e-05C68.0471 5.15035e-05 25.482 -0.0474092 14.8339 2.73913C11.9658 3.55371 9.35578 5.09024 7.25433 7.20121C5.15287 9.31218 3.63058 11.9267 2.83361 14.7938C0.0271918 25.4111 9.95597e-06 47.4322 9.95597e-06 47.4322C9.95597e-06 47.4322 -0.0271706 69.5618 2.75886 80.0706C4.32175 85.881 8.90851 90.471 14.7388 92.0371C25.4888 94.9525 67.9451 95 67.9451 95C67.9451 95 110.517 95.0474 121.158 92.2676C124.029 91.4903 126.647 89.9787 128.753 87.8823C130.859 85.7859 132.38 83.1774 133.165 80.3147C135.979 69.7042 135.999 47.6898 135.999 47.6898C135.999 47.6898 136.135 25.5535 133.233 14.9362ZM54.4295 67.8329L54.4635 27.1535L89.846 47.5271L54.4295 67.8329Z" fill="white"/>
				</svg></a>			
				<?php
			}
			if ( $heading || $btn ) {
				echo '<div class="grid gap-4">';
				if ( $heading ) {
					echo '<h2 class="text-3xl md:text-32 font-normal text-white md:leading-tight">' . wp_kses_post( $heading ) . '</h2>';
				}
				if ( $btn ) {
					printf(
						'<a href="%s" class="button button-border" target="%s">%s</a>',
						esc_url( $btn['url'] ),
						esc_html( $btn['target'] ),
						esc_html( $btn['title'] )
					);
				}
				echo '</div>';
			}
			?>
		</div>

	</div>
</section>
