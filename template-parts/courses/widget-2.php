<?php
/**
 * The template part for displaying Widget 2 in course single page.
 *
 * @package LearningMole
 */

?>

<div class="widget">
	<h2 class="text-2xl font-bold text-primary-color mb-6">Other Resources</h2>
	<?php
	$args = [
		'post_type'      => 'post' === get_post_type() ? 'post' : 'sfwd-topic',
		'posts_per_page' => '2',
		'orderby'        => 'rand',
	];

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		echo '<p>No course found.</p>';
	}

	echo '<div class="grid gap-10">';

	while ( $query->have_posts() ) :
		$query->the_post();

		if ( 'post' === get_post_type() ) {
			get_template_part(
				'template-parts/content',
				'blog',
				[
					'loc' => 'sidebar',
				]
			);
		} else {
			get_template_part( 'template-parts/content', 'topic' );
		}

	endwhile;
	wp_reset_postdata();

	echo '</div>';
	?>
</div>
