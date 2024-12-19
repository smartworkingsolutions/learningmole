<?php
/**
 * The ACF template part for displaying USPs.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );
$desc    = get_sub_field( 'description' );

if ( ! $heading && ! $desc && ! have_rows( 'add_usps' ) ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

		<?php
		if ( $heading || $desc ) {
			echo '<div class="grid gap-6 justify-center text-center">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color font-bold leading-none">' . wp_kses_post( $heading ) . '</h2>';
			}
			if ( $desc ) {
				echo '<p class="text-lg">' . wp_kses_post( $desc ) . '</p>';
			}
			echo '</div>';
		}

		if ( have_rows( 'add_usps' ) ) :

			echo '<div class="grid md:grid-cols-3 gap-10 xl:gap-16 mt-8 md:mt-16">';

			// Loop through rows.
			while ( have_rows( 'add_usps' ) ) :
				the_row();

				// Load sub field value.
				$image     = get_sub_field( 'image' );
				$usp_title = get_sub_field( 'title' );
				$content   = get_sub_field( 'content' );
				$btn       = get_sub_field( 'button' );

				if ( $image || $usp_title || $content || $btn ) {
					echo '<div class="grid gap-6 text-center">';
					if ( $image ) {
						echo '<div class="relative">';
						echo '<img class="fancy-border | w-full aspect-[193/180] object-cover md:mb-6" src="' . esc_url( $image ) . '" alt="' . esc_html( $usp_title ) . '" />';
						echo '<div class="fancy-border | w-full aspect-[193/180] md:border-2 md:border-secondary-color md:border-dashed absolute top-3"></div>';
						echo '</div>';
					}
					if ( $usp_title ) {
						echo '<h2 class="text-xl font-bold text-secondary-color">' . esc_html( $usp_title ) . '</h2>';
					}
					if ( $content ) {
						echo '<div class="wysiwyg-editor gap-8">' . wp_kses_post( $content ) . '</div>';
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

			endwhile;

			echo '</div>';

		endif;
		?>

	</div>
</section>
