<?php
/**
 * The ACF template part for displaying Custom HTML.
 *
 * @package LearningMole
 */

?>

<section class="w-full<?php echo get_sub_field( 'background' ) ? esc_html( ' bg-light-color' ) : ''; ?>">
	<div class="container">

		<div class="wysiwyg-editor gap-8">
			<?php
			if ( get_sub_field( 'custom_html_code' ) ) {
				echo do_shortcode( get_sub_field( 'custom_html_code' ) );
			}
			?>
		</div>

	</div>
</section>
