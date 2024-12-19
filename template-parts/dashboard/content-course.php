<?php
/**
 * The template part for displaying Content of course in dashboard page.
 *
 * @package LearningMole
 */

$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

if ( $img_url ) {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . $img_url . '" alt="' . get_the_title() . '"></div>';
} else {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="' . get_the_title() . '"></div>';
}

$tax_cat   = 'ld_course_category';
$tax_tag   = 'ld_course_tag';
$terms     = get_the_terms( get_the_ID(), $tax_cat );
$terms_tag = get_the_terms( get_the_ID(), $tax_tag );

printf(
	'<article class="grid bg-white shadow-course rounded-10">
		%s
		<div class="grid p-6">
			<h3 class="text-xl font-bold mb-3">%s</h3>
			<div class="wysiwyg-editor gap-8 pb-4">%s</div>
			<div><a href="/%s/" class="button button-medium">%s</a></div>
		</div>
	</article>',
	wp_kses_post( $img_html ),
	esc_html( get_the_title() ),
	html_entity_decode( wp_trim_words( get_the_content(), 16, '...' ) ), // phpcs:ignore
	esc_html( get_post_field( 'post_name', get_the_ID() ) ),
	esc_html__( 'Read more', 'learningmole' )
);
