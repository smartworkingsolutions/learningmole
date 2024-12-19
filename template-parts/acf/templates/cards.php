<?php
/**
 * The ACF template part for displaying Cards.
 *
 * @package LearningMole
 */

if ( ! have_rows( 'cards' ) ) {
	return;
}
?>

<section class="w-full bg-light-color">
	<div class="container">

		<?php
		if ( have_rows( 'cards' ) ) :

			echo '<div class="grid md:grid-cols-2 gap-10">';

			// Loop through rows.
			while ( have_rows( 'cards' ) ) :
				the_row();

				// Load sub field value.
				$card_title = get_sub_field( 'title' );
				$content    = get_sub_field( 'content' );
				$btn        = get_sub_field( 'button' );

				if ( $card_title || $content || $btn ) {
					echo '<div class="grid gap-6 bg-white p-7 rounded-2xl shadow-custom">';
					if ( $card_title ) {
						echo '<h2 class="text-xl font-semibold text-primary-color">' . esc_html( $card_title ) . '</h2>';
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
