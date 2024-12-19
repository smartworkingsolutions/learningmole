<?php
/**
 * The ACF template part for displaying custom categories.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );
$parent  = get_sub_field( 'parent' );

if ( ! $heading && ! have_rows( 'add_categories' ) ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

		<?php
		if ( $heading ) {
			echo '<h3 class="w-full text-xl font-bold border-b-2 border-primary-color leading-none pb-6 mb-10">' . esc_html( $heading ) . '</h3>';
		}
		if ( have_rows( 'add_categories' ) ) :

			echo '<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10 xl:gap-14 xl:px-20">';

			// Loop through rows.
			while ( have_rows( 'add_categories' ) ) :
				the_row();

				// Load sub field value.
				$icon    = get_sub_field( 'icon' );
				$c_title = get_sub_field( 'title' );
				$c_cat   = get_sub_field( 'select_category' );

				$icon_html   = '';
				$filter_link = '/filter/';

				if ( $icon ) {
					$icon_html = '<div class="w-full h-full bg-white px-8 py-6"><img class="w-full aspect-square object-cover" src="' . $icon . '" alt="' . $c_cat . '"></div>';
				}

				if ( $parent || $c_cat ) {
					if ( $parent ) {
						$filter_link .= '?parent=' . $parent;
					}
					if ( $c_cat ) {
						$filter_link .= '&cat=' . $c_cat;
					}
				}

				if ( $filter_link ) {
					printf(
						'<a href="%s" class="grid text-center gap-6 bg-light-color border border-border-color rounded-lg shadow-custom p-4 hover:scale-110 transition-all duration-300">
							%s
							<p class="text-base text-primary-color font-bold">%s</p>
						</a>',
						esc_url( $filter_link ),
						wp_kses_post( $icon_html ),
						wp_kses_post( $c_title )
					);
				} else {
					printf(
						'<div class="grid text-center gap-6 bg-light-color border border-border-color rounded-lg shadow-custom p-4 hover:scale-110 transition-all duration-300">
							%s
							<p class="text-base text-primary-color font-bold">%s</p>
						</div>',
						wp_kses_post( $icon_html ),
						wp_kses_post( $c_title )
					);
				}

			endwhile;

			echo '</div>';

		endif;
		?>
	</div>
</section>
