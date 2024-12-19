<?php
/**
 * The template part for displaying Content of blog.
 *
 * @package LearningMole
 */

$class = ' aspect-video object-cover';
if ( $args['loc'] && 'sidebar' === $args['loc'] ) {
	$class = ' object-scale-down';
}
$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );

if ( $img_url ) {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full rounded-t-10 hover:scale-110 transition-all' . $class . '" src="' . $img_url . '" alt="' . wp_strip_all_tags( get_the_title() ) . '"></div>';
} else {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full rounded-t-10 hover:scale-110 transition-all' . $class . '" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="' . wp_strip_all_tags( get_the_title() ) . '"></div>';
}

$categories = get_the_category( get_the_ID() );

if ( $categories ) {
	$cat_links = [];
	foreach ( $categories as $category ) {
		$cat_links[] = '<a class="max-w-fit text-xs flex bg-primary-color-100 text-primary-color px-2 py-1" href="' . get_category_link( $category->cat_ID ) . '">' . $category->name . '</a>';
	}
}

$join_cats = join( '', $cat_links );
$all_cats  = '<div class="flex flex-wrap gap-2">' . $join_cats . '</div>';
$h_tag     = 'h3';

if ( is_category() || is_home() ) {
	$h_tag = 'h2';
}

printf(
	'<article class="grid bg-white shadow-course rounded-10">
		<a href="%1$s">%2$s</a>
		<div class="grid items-start p-6">
			<a href="%1$s"><%6$s class="text-xl font-bold mb-3 hover:text-primary-color">%3$s</%6$s></a>
			%4$s
			<div class="wysiwyg-editor gap-8 py-4">%5$s</div>
		</div>
	</article>',
	esc_url( get_the_permalink() ),
	wp_kses_post( $img_html ),
	esc_attr( wp_strip_all_tags( get_the_title() ) ),
	wp_kses_post( $all_cats ),
	lm_clean_content(), // phpcs:ignore
	esc_html( $h_tag )
);
