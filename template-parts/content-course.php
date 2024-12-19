<?php
/**
 * The template part for displaying Content of course.
 *
 * @package LearningMole
 */

$img_url   = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$tax_cat   = 'ld_course_category';
$tax_tag   = 'ld_course_tag';
$terms     = get_the_terms( get_the_ID(), $tax_cat );
$terms_tag = get_the_terms( get_the_ID(), $tax_tag );
$ribbon    = '';

$regex_pattern = '/\bhttps?:\/\/\S+/i';

$classes = get_post_class( 'grid bg-white shadow-course rounded-10 |', get_the_ID() );

if ( is_search() ) {
	$ribbon_text = 'Post';
	if ( 'sfwd-topic' === get_post_type() ) {
		$ribbon_text = 'Video';
	}
	if ( 'sfwd-lessons' === get_post_type() ) {
		$ribbon_text = 'Lesson';
	}
	if ( 'sfwd-courses' === get_post_type() ) {
		$ribbon_text = 'Course';
	}

	$ribbon = '<span class="max-w-fit text-xs flex bg-primary-color-100 text-text-color px-2 py-1 rounded absolute top-2 right-2">' . $ribbon_text . '</span>';
}

if ( $img_url ) {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . $img_url . '" alt="' . wp_strip_all_tags( get_the_title() ) . '">' . $ribbon . '</div>';
} else {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative"><img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="' . wp_strip_all_tags( get_the_title() ) . '">' . $ribbon . '</div>';
}

// Categories.
if ( $terms && ! is_wp_error( $terms ) ) :
	$term_links = [];
	foreach ( $terms as $tm ) {
		$term_links[] = '<a class="max-w-fit text-xs flex bg-primary-color-100 text-primary-color px-2 py-1" href="' . esc_attr( get_term_link( $tm->slug, $tax_cat ) ) . '">' . $tm->name . '</a>';
	}
	$join_terms = join( '', $term_links );
	$all_terms  = '<div class="flex flex-wrap gap-2">' . $join_terms . '</div>';
endif;

// Tags.
if ( $terms_tag && ! is_wp_error( $terms_tag ) ) :
	$term_tag_links = [];
	foreach ( $terms_tag as $term_tag ) {
		$term_tag_links[] = '<a class="max-w-fit text-xs flex bg-primary-color-100 text-primary-color px-2 py-1" href="' . esc_attr( get_term_link( $term_tag->slug, $tax_tag ) ) . '">' . $term_tag->name . '</a>';
	}
	$join_tag_terms = join( '', $term_tag_links );
	$tag_terms      = '<div class="flex flex-wrap gap-2">' . $join_tag_terms . '</div>';
endif;

$h_tag = 'h3';

if ( is_post_type_archive( 'sfwd-courses' ) ) {
	$h_tag = 'h2';
}

printf(
	'<article id="post-%s" class="%s %s">
		%s
		<div class="grid p-6">
			<%s class="text-xl font-bold mb-3">%s</%s>
			<div class="grid gap-4">
			%s
			%s
			</div>
			<div class="wysiwyg-editor gap-8 py-4">%s</div>
			<div><a href="%s" class="button button-medium">%s</a></div>
		</div>
	</article>',
	get_the_ID(),
	esc_attr( implode( ' ', $classes ) ),
	esc_html( get_post_type() ),
	wp_kses_post( $img_html ),
	esc_html( $h_tag ),
	esc_html( wp_strip_all_tags( get_the_title() ) ),
	esc_html( $h_tag ),
	wp_kses_post( $all_terms ),
	wp_kses_post( $tag_terms ),
	lm_clean_content( 16 ), // phpcs:ignore
	esc_url( get_the_permalink() ),
	esc_html__( 'Read more', 'learningmole' )
);
