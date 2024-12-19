<?php
/**
 * The ACF template part for displaying Icon with content.
 *
 * @package LearningMole
 */

if ( ! have_rows( 'add_content' ) ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

	<?php
	if ( have_rows( 'add_content' ) ) :

		echo '<div class="grid md:grid-cols-3 gap-10">';

		// Loop through rows.
		while ( have_rows( 'add_content' ) ) :
			the_row();

			// Load sub field value.
			$icon    = get_sub_field( 'icon' );
			$heading = get_sub_field( 'title' );

			$icon_html = '';

			if ( $icon ) {
				$icon_html = '<img class="w-[104px] h-[100px] object-scale-down" src="' . $icon . '" alt="' . $heading . '">';
			}

			printf(
				'<div class="flex items-center gap-10 bg-light-color p-6 rounded-md">
					%s
					<h3 class="text-xl font-bold text-primary-color">%s</h3>
				</div>',
				wp_kses_post( $icon_html ),
				wp_kses_post( $heading )
			);

		endwhile;

		echo '</div>';

	endif;
	?>

	</div>
</section>
