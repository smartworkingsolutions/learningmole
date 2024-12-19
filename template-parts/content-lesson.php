<?php
/**
 * The template part for displaying Content of lesson.
 *
 * @package LearningMole
 */

$img_url    = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$enrolled   = $args['enrolled'];
$enroll_tag = '';

$tax_cat   = 'ld_lesson_category';
$tax_tag   = 'ld_lesson_tag';
$terms     = get_the_terms( get_the_ID(), $tax_cat );
$terms_tag = get_the_terms( get_the_ID(), $tax_tag );

global $post;
$post_slug = $post->post_name;

$custom_link = '/topic-category/' . $post_slug . '/';

// Check if the lesson is in progress.
$progress = learndash_lesson_progress( get_the_ID() );

// Progress bar.
$progress_bar   = '';
$completed_html = '';

if ( $progress ) {
	$progress_bar = '<div class="w-full h-1 absolute left-0 bottom-0 right-0"><div class="h-1 bg-secondary-color absolute" style="width: ' . esc_attr( $progress['percentage'] ) . '%;"></div></div>';
}
if ( $progress && 100 !== (int) $progress['percentage'] ) {
	$progress_html = '<span class="flex max-w-fit bg-secondary-color px-2 py-1 mb-2 text-xs text-white">' . esc_html__( 'In Progress', 'learningmole' ) . '</span>';
}
if ( 0 === (int) $progress['percentage'] ) {
	$progress_html = '';
}
if ( 100 === (int) $progress['percentage'] ) {
	$completed_html = '<span class="flex max-w-fit bg-secondary-color px-2 py-1 mb-2 text-xs text-white">' . esc_html__( 'Completed', 'learningmole' ) . '</span>';
}

if ( $enrolled && in_array( get_the_ID(), $enrolled, true ) ) {
	$enroll_tag = '<span class="bg-primary-color px-2 py-1 text-xs text-white absolute top-3 right-3">' . esc_html__( 'Enrolled', 'learningmole' ) . '</span>';
}

if ( $img_url ) {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative">' . $enroll_tag . $progress_bar . '<img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . $img_url . '" alt="' . get_the_title() . '"></div>';
} else {
	$img_html = '<div class="grid rounded-t-10 overflow-hidden relative">' . $enroll_tag . $progress_bar . '<img class="w-full aspect-video object-cover rounded-t-10 hover:scale-110 transition-all" src="' . get_template_directory_uri() . '/images/no-thumb.jpg" alt="' . get_the_title() . '"></div>';
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

printf(
	'<article class="grid bg-white shadow-course rounded-10">
		%s
		<div class="grid p-6">
			%s%s
			<h3 class="text-xl font-bold mb-3">%s</h3>
			<div class="grid gap-4 mb-4">
			%s
			%s
			</div>
			<div><a href="%s" class="button button-medium">%s</a></div>
		</div>
	</article>',
	wp_kses_post( $img_html ),
	wp_kses_post( $completed_html ),
	wp_kses_post( $progress_html ),
	esc_html( get_the_title() ),
	wp_kses_post( $all_terms ),
	wp_kses_post( $tag_terms ),
	esc_url( $custom_link ),
	esc_html__( 'Read more', 'learningmole' )
);
