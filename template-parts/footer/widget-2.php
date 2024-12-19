<?php
/**
 * The template part for displaying Widget 2 in footer.
 *
 * @package LearningMole
 */

$heading = get_field( 'fw2_heading', 'option' );

if ( ! $heading && ! have_rows( 'fw2_links', 'option' ) ) {
	return;
}
?>
<div class="grid gap-4">
	<?php

	if ( $heading ) {
		echo '<div class="text-xl font-bold">' . esc_html( $heading ) . '</div>';
	}

	if ( have_rows( 'fw2_links', 'option' ) ) :

		echo '<nav><ul class="grid gap-3">';

		while ( have_rows( 'fw2_links', 'option' ) ) :
			the_row();

			$links = get_sub_field( 'fw2_link' );

			if ( $links ) {
				printf(
					'<li>
						<a class="font-semibold hover:text-primary-color" href="%s" target="%s">%s</a>
					</li>',
					esc_url( $links['url'] ),
					esc_html( $links['target'] ),
					esc_html( $links['title'] )
				);
			}

		endwhile;

		echo '</ul></nav>';

	endif;
	?>
</div>
