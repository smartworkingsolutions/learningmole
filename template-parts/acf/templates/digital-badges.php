<?php
/**
 * The ACF template part for displaying Digital badges.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );

if ( ! $heading && ! have_rows( 'add_badge' ) ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

	<?php
	if ( $heading ) {
		echo '<h2 class="text-3xl md:text-4xl text-primary-color text-center leading-none mb-10">' . esc_html( $heading ) . '</h2>';
	}

	// Badges.
	if ( have_rows( 'add_badge' ) ) :

		echo '<div class="grid md:grid-cols-2 gap-10">';

		// Loop through rows.
		while ( have_rows( 'add_badge' ) ) :
			the_row();

			// Load sub field value.
			$icon     = get_sub_field( 'icon' );
			$b_title  = get_sub_field( 'title' );
			$content  = get_sub_field( 'content' );
			$btn      = get_sub_field( 'button' );
			$alt_link = get_sub_field( 'alt_link' );

			$icon_html  = '';
			$button_url = '';

			if ( $btn ) {
				$button_url = $btn['url'];
			}

			if ( $icon ) {
				$icon_html = '<img class="w-44 h-44 mx-auto object-scale-down border border-primary-color" src="' . $icon . '" alt="' . $b_title . '">';
			}

			if ( is_user_logged_in() && $alt_link ) {
				$button_url = $alt_link;
			}

			printf(
				'<div class="grid gap-4 text-center px-6 py-7 rounded-md border border-primary-color">
					%s
					<h3 class="text-xl font-semibold text-primary-color">%s</h3>
					<p class="text-base">%s</p>
					<div><a href="%s" class="button" target="%s">%s</a></div>
				</div>',
				wp_kses_post( $icon_html ),
				esc_html( $b_title ),
				wp_kses_post( $content ),
				esc_url( $button_url ),
				esc_html( $btn['target'] ),
				esc_html( $btn['title'] )
			);

		endwhile;

		echo '</div>';

	endif;
	?>

	</div>
</section>
