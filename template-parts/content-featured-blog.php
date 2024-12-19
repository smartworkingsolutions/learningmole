<?php
/**
 * The template part for displaying Content of featured blog.
 *
 * @package LearningMole
 */

$class   = ' aspect-video object-cover';
$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

if ( $img_url ) {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full rounded-t-10 hover:scale-110 transition-all' . $class . '" src="' . $img_url . '" alt="' . wp_strip_all_tags( get_the_title() ) . '"></div>';
} else {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full rounded-t-10 hover:scale-110 transition-all' . $class . '" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="' . wp_strip_all_tags( get_the_title() ) . '"></div>';
}

printf(
	'<article class="grid bg-white shadow-course rounded-10">
		<a href="%1$s">%2$s</a>
		<div class="grid p-5">
			<a href="%1$s"><h2 class="text-base font-bold hover:text-primary-color">%3$s</h2></a>
		</div>
	</article>',
	esc_url( get_the_permalink() ),
	wp_kses_post( $img_html ),
	esc_attr( wp_strip_all_tags( get_the_title() ) ),
);
