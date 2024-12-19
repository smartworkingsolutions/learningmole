<?php
/**
 * The template for displaying Reviewed author posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProfileTree
 */

$user_id = $args['user_id'];
$user    = get_user_by( 'id', $user_id );

if ( ! $user_id ) {
	return;
}
?>

<section class="w-full my-10 md:my-16">
	<div class="container">
		<h2 class="text-3xl md:text-4xl text-primary-color text-center leading-none mb-10">Posts Reviewed by <?php echo esc_html( $user->display_name ); ?>:</h2>
		<div class="grid md:grid-cols-3 gap-10">

			<?php

			$args = [
				'post_type'      => 'post',
				'posts_per_page' => 9,
				'meta_query'     => [
					'relation' => 'OR',
					[
						'key'     => 'reviewed_by',
						'value'   => '"' . $user_id,
						'compare' => 'LIKE',
					],
				],
			];

			if ( 35 === $user_id ) {
				$args = [
					'meta_query'     => [ // phpcs:ignore
						'relation' => 'OR',
						[
							'key'     => 'reviewed_by',   // The name of your ACF field.
							'value'   => $user_id,        // The value you're looking for.
							'compare' => '=',             // Condition to match the exact value.
							'type'    => 'NUMERIC',       // Type of the custom field (change if needed).
						],
						[
							'key'     => 'reviewed_by',    // Same ACF field.
							'compare' => 'NOT EXISTS',     // Select posts where 'person' field does not exist.
						],
						[
							'key'     => 'reviewed_by',    // Same ACF field.
							'value'   => '',               // Looking for empty (blank) value.
							'compare' => '=',              // Condition to match the empty value.
						],
					],
				];
			}

			$query = new WP_Query( $args );

			if ( ! $query->have_posts() ) {
				echo '<p class="col-span-full flex justify-center">No post found.</p>';
			}

			while ( $query->have_posts() ) :
				$query->the_post();

				get_template_part( 'template-parts/content', 'blog' );

			endwhile; // End of the loop.
			wp_reset_postdata();
			?>

		</div>
		<?php get_learnmole_pagination( $query ); ?>

	</div>
</section>
