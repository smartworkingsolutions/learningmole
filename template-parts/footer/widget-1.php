<?php
/**
 * The template part for displaying Widget 1 in footer.
 *
 * @package LearningMole
 */

$content       = get_field( 'fw1_content', 'option' );
$facebook_url  = get_field( 'facebook_url', 'option' );
$instagram_url = get_field( 'instagram_url', 'option' );
$twitter_url   = get_field( 'twitter_url', 'option' );
$youtube_url   = get_field( 'youtube_url', 'option' );
$linkedin_url  = get_field( 'linkedin_url', 'option' );
$btn           = get_field( 'fw1_button', 'option' );
?>

<div class="sm:col-span-2 grid gap-6">

	<?php
	theme_logo( 'footer' );

	if ( $content ) {
		echo '<div class="wysiwyg-editor">' . wp_kses_post( $content ) . '</div>';
	}
	if ( $facebook_url || $instagram_url || $twitter_url || $youtube_url || $linkedin_url ) {
		echo '<ul class="flex gap-4">';
		if ( $facebook_url ) {
			echo '<li class="flex"><a class="w-6 h-6 text-secondary-color hover:text-primary-color" href="' . esc_url( $facebook_url ) . '" target="_blank" rel="me" aria-label="Social icon for facebook">' . get_svg( 'icons/facebook', false ) . '</a></li>'; // phpcs:ignore
		}
		if ( $instagram_url ) {
			echo '<li class="flex"><a class="w-6 h-6 text-secondary-color hover:text-primary-color" href="' . esc_url( $instagram_url ) . '" target="_blank" rel="me" aria-label="Social icon for instagram">' . get_svg( 'icons/instagram', false ) . '</a></li>'; // phpcs:ignore
		}
		if ( $twitter_url ) {
			echo '<li class="flex"><a class="w-6 h-6 text-secondary-color hover:text-primary-color" href="' . esc_url( $twitter_url ) . '" target="_blank" rel="me" aria-label="Social icon for twitter">' . get_svg( 'icons/twitter', false ) . '</a></li>'; // phpcs:ignore
		}
		if ( $youtube_url ) {
			echo '<li class="flex"><a class="w-6 h-6 text-secondary-color hover:text-primary-color" href="' . esc_url( $youtube_url ) . '" target="_blank" rel="me" aria-label="Social icon for youtube">' . get_svg( 'icons/youtube', false ) . '</a></li>'; // phpcs:ignore
		}
		if ( $linkedin_url ) {
			echo '<li class="flex"><a class="w-6 h-6 text-secondary-color hover:text-primary-color" href="' . esc_url( $linkedin_url ) . '" target="_blank" rel="me" aria-label="Social icon for linkedin">' . get_svg( 'icons/linkedin', false ) . '</a></li>'; // phpcs:ignore
		}
		echo '</ul>';
	}
	if ( $btn ) {
		printf(
			'<div><a href="%s" class="button" target="%s">%s</a></div>',
			esc_url( $btn['url'] ),
			esc_html( $btn['target'] ),
			esc_html( $btn['title'] )
		);
	}
	?>

</div>
