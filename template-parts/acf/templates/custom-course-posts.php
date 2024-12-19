<?php
/**
 * The ACF template part for displaying Course Grid.
 *
 * @package LearningMole
 */

$heading       = get_sub_field( 'heading' );
$btn           = get_sub_field( 'button' );
$sort_by       = get_sub_field( 'sort_by' );
$post_ids      = get_sub_field( 'select_posts' );
$selected_cats = get_sub_field( 'select_category' );
$post_num      = get_sub_field( 'number_of_posts' ) ? get_sub_field( 'number_of_posts' ) : -1;
$class         = ' justify-center';

if ( ! $heading && ! $btn && ! $shortcode ) {
	return;
}
if ( $heading && $btn ) {
	$class = ' justify-between';
}
?>

<section class="w-full bg-light-color">
	<div class="container">

		<?php
		if ( $heading || $btn ) {
			echo '<div class="w-full grid sm:flex items-center gap-8 mb-12' . esc_html( $class ) . '">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color leading-none">' . esc_html( $heading ) . '</h2>';
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

		// Posts start.
		// $aa = learndash_user_get_enrolled_courses( get_current_user_id(), array(), true );
		$args = [
			'post_type'      => 'sfwd-courses',
			'posts_per_page' => $post_num,
		];

		if ( 'name' === $sort_by ) {
			$args['orderby'] = 'name';
		}
		if ( 'title' === $sort_by ) {
			$args['orderby'] = 'title';
		}
		if ( 'date' === $sort_by ) {
			$args['orderby'] = 'date';
		}
		if ( 'rand' === $sort_by ) {
			$args['orderby'] = 'rand';
		}
		if ( 'cat' === $sort_by ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'ld_course_category',
					'field'    => 'term_id',
					'terms'    => $selected_cats,
				],
			];
		}
		if ( 'custom' === $sort_by ) {
			$args['post__in'] = $post_ids;
			$args['orderby']  = 'post__in';
		}

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p>No course found.</p>';
		}

		echo '<div class="grid md:grid-cols-3 gap-10 items-start">';

		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'template-parts/content', 'course' );

		endwhile;
		wp_reset_postdata();

		echo '</div>';
		?>

	</div>
</section>
