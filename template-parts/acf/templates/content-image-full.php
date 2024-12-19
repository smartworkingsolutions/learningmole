<?php
/**
 * The ACF template part for displaying Content image as full width.
 *
 * @package LearningMole
 */

$image_position = get_sub_field( 'image_position' );
$column         = get_sub_field( 'column' );
$image          = get_sub_field( 'image' );
?>

<section class="w-full relative">
	<div class="container">

		<div class="grid lg:grid-cols-2 items-center">
			<?php
			if ( $column ) {
				echo '<div class="wysiwyg-editor dark | w-full bg-primary-color rounded-10 gap-8 p-7 sm:p-10 lg:px-16 lg:py-14">';
				echo do_shortcode( $column );
				echo '</div>';
			}
			if ( $image ) {
				printf(
					'<img class="w-full h-full object-cover rounded-10" src="%s" title="%s" alt="%s" width="%s" height="%s" />',
					esc_url( $image['url'] ),
					esc_html( $image['title'] ),
					esc_html( $image['alt'] ),
					esc_html( $image['width'] ),
					esc_html( $image['height'] )
				);
			}
			?>
		</div>

	</div>

</section>
