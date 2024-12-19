<?php
/**
 * The ACF template part for displaying PDFs.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );

if ( ! $heading && ! have_rows( 'pdfs' ) ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

		<?php
		if ( $heading ) {
			echo '<h2 class="text-3xl md:text-4xl text-primary-color font-bold text-center leading-none">' . wp_kses_post( $heading ) . '</h2>';
		}

		if ( have_rows( 'pdfs' ) ) :

			echo '<div class="grid md:grid-cols-3 gap-10 xl:gap-16 mt-16">';

			// Loop through rows.
			while ( have_rows( 'pdfs' ) ) :
				the_row();

				// Load sub field value.
				$pdf_title = get_sub_field( 'title' );
				$content   = get_sub_field( 'content' );
				$btn       = get_sub_field( 'button' );

				if ( $pdf_title || $content || $btn ) {
					echo '<div class="grid justify-center gap-6 text-center">';
					if ( $pdf_title ) {
						echo '<h3 class="text-lg font-bold">' . esc_html( $pdf_title ) . '</h3>';
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
