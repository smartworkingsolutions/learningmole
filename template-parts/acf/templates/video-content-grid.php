<?php
/**
 * The ACF template part for displaying Video with content.
 *
 * @package LearningMole
 */

$heading = get_sub_field( 'heading' );
$columns = get_sub_field( 'columns' );
$classes = ' md:grid-cols-3';

if ( ! $heading && ! have_rows( 'add_content' ) ) {
	return;
}

if ( 2 === (int) $columns ) {
	$classes = ' md:grid-cols-2';
}
?>

<section class="w-full">
	<div class="container">

	<?php
	if ( $heading ) {
		echo '<h2 class="text-3xl md:text-4xl text-primary-color font-bold text-center leading-none mb-10">' . wp_kses_post( $heading ) . '</h2>';
	}

	if ( have_rows( 'add_content' ) ) :

		echo '<div class="grid gap-10' . esc_html( $classes ) . '">';

		// Loop through rows.
		while ( have_rows( 'add_content' ) ) :
			the_row();

			// Load sub field value.
			$video_id    = get_sub_field( 'video_id' );
			$video_title = get_sub_field( 'title' );
			$content     = get_sub_field( 'content' );

			if ( $video_id || $video_title || $content ) {
				echo '<div class="w-full grid gap-5 border border-primary-color p-6 rounded-lg text-center">';
				if ( $video_id ) {
					?>
					<iframe class="w-full aspect-video" src="https://player.vimeo.com/video/<?php echo esc_html( $video_id ); ?>&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
					<?php
				}
				if ( $video_title ) {
					echo '<h2 class="text-xl font-bold text-primary-color">' . esc_html( $video_title ) . '</h2>';
				}
				if ( $content ) {
					echo '<div class="wysiwyg-editor gap-8">' . wp_kses_post( $content ) . '</div>';
				}
				echo '</div>';
			}

		endwhile;

		echo '</div>';

	endif;
	?>

	</div>
</section>
