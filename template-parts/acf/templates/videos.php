<?php
/**
 * The ACF template part for displaying Videos.
 *
 * @package LearningMole
 */

$columns       = get_sub_field( 'select_columns' );
$heading       = get_sub_field( 'heading' );
$desc          = get_sub_field( 'description' );
$is_background = get_sub_field( 'enable_background' );
$class         = ' grid md:grid-cols-3';

if ( ! $heading && ! $desc && ! have_rows( 'add_videos' ) ) {
	return;
}
if ( '1' === $columns ) {
	$class = ' flex max-w-[720px] mx-auto';
}
if ( '2' === $columns ) {
	$class = ' grid md:grid-cols-2';
}
?>

<section class="w-full<?php echo $is_background ? ' bg-primary-color py-10 md:py-24' : ''; ?>">
	<div class="container">

		<?php
		if ( $heading || $desc ) {
			echo '<div class="grid gap-6 justify-center text-center mb-10">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color font-bold leading-none">' . wp_kses_post( $heading ) . '</h2>';
			}
			if ( $desc ) {
				echo '<p class="text-lg mb-2">' . wp_kses_post( $desc ) . '</p>';
			}
			echo '</div>';
		}
		if ( have_rows( 'add_videos' ) ) :

			echo '<div class="gap-x-8 gap-y-8 md:gap-y-14 items-start' . esc_html( $class ) . '">';

			// Loop through rows.
			while ( have_rows( 'add_videos' ) ) :
				the_row();

				// Load sub field value.
				$video_type  = get_sub_field( 'video_type' );
				$video_id    = get_sub_field( 'video_id' );
				$video_id_m  = get_sub_field( 'video_id_m' );
				$video_id_v  = get_sub_field( 'video_id_v' );
				$video_title = get_sub_field( 'title' );
				$content     = get_sub_field( 'content' );
				$btn         = get_sub_field( 'button' );

				if ( $video_id || $video_id_m || $video_id_v || $video_title || $content || $btn ) {
					echo '<div class="w-full grid gap-6">';
					if ( 'youtube' === $video_type ) {
						if ( $video_id ) {
							?>
							<iframe class="w-full aspect-video" src="https://www.youtube.com/embed/<?php echo esc_html( $video_id ); ?>?autoplay=0&mute=1&controls=0" frameborder="0" allowfullscreen="" include=""></iframe>
							<?php
						}
					}
					if ( 'mindstamp' === $video_type ) {
						?>
						<iframe
							class="w-full aspect-video"
							loading='lazy'
							src='https://embed.mindstamp.io/embed/<?php echo esc_html( $video_id_m ); ?>' 
							allowfullscreen allow='encrypted-media; microphone; camera; geolocation' 
							scrolling='no'>
						</iframe>
						<?php
					}
					if ( 'vimeo' === $video_type ) {
						?>
						<iframe class="w-full aspect-video" src="https://player.vimeo.com/video/<?php echo esc_html( $video_id_v ); ?>?h=8a528f2864&title=0&byline=0&portrait=0" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
						<?php
					}
					if ( $video_title ) {
						echo '<h2 class="text-lg font-bold text-primary-color">' . esc_html( $video_title ) . '</h2>';
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
