<?php
/**
 * The ACF template part for displaying Tags.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );

if ( ! $heading && ! have_rows( 'tags' ) ) {
	return;
}
?>

<section class="tags | w-full">
	<div class="container">

		<?php
		if ( $heading ) {
			echo '<h2 class="text-3xl md:text-4xl text-primary-color leading-none text-center">' . esc_html( $heading ) . '</h2>';
		}

		if ( have_rows( 'tags' ) ) :

			echo '<div class="grid sm:grid-cols-2 lg:grid-cols-12 gap-8 mt-10 md:mt-12">';

			// Loop through rows.
			while ( have_rows( 'tags' ) ) :
				the_row();

				// Load sub field value.
				$tags  = get_sub_field( 'select_tag' );
				$image = get_sub_field( 'background_image' );
				$size  = get_sub_field( 'card_size' );

				$term_link = get_term_link( $tags->slug, $tags->taxonomy );

				$class = ' lg:col-span-5';
				if ( 'Big' === $size ) {
					$class = ' lg:col-span-7';
				}

				if ( $tags || $image ) {
					echo '<div class="w-full h-72 rounded-10 relative' . esc_html( $class ) . '">';
					if ( $image ) {
						printf(
							'<img class="w-full h-full object-cover rounded-10 absolute inset-0" src="%s" title="%s" alt="%s" />',
							esc_url( $image['url'] ),
							esc_html( $image['title'] ),
							esc_html( $image['alt'] )
						);
						echo '<div class="bg-black/40 rounded-10 absolute inset-0"></div>';
					}
					if ( $tags ) {
						echo '<div class="grid gap-6 absolute left-6 bottom-6">';
						echo '<h3 class="text-4xl text-white">' . esc_html( $tags->name ) . '</h3>';
						printf(
							'<div><a href="%s" class="button" title="%s">%s</a></div>',
							esc_attr( $term_link ),
							esc_html( $tags->name ),
							esc_html__( 'View Resource', 'learningmole' )
						);
						echo '</div>';
					}
					echo '</div>';
				}

			endwhile;

			echo '</div>';

		endif;
		?>

	</div>
</section>
