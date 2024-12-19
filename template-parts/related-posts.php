<?php
/**
 * The template for displaying Related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProfileTree
 */

$num_post = get_field( 'blog_single_number_of_posts', 'option' );
?>

<section class="related-posts | w-full bg-light-color py-10 md:py-14">
	<div class="container">
		<h2 class="text-3xl md:text-4xl text-primary-color text-center leading-none mb-10"><?php echo esc_html__( 'Related Posts', 'learningmole' ); ?></h2>
		<div class="grid md:grid-cols-3 gap-10">

			<?php
			// Get the categories.
			$categories = get_the_category( get_the_ID() );

			// Get the tags.
			$tags = get_the_tags( get_the_ID() );

			$args = [
				'post_type'      => 'post',
				'posts_per_page' => (int) $num_post,
			];

			if ( 'custom' === $posts_type ) {
				$args['post__in'] = $selected_ids;
				$args['orderby']  = 'post__in';
			}

			if ( 'related' === $posts_type && ( $categories || $tags ) ) {
				$args['post__not_in'] = [ get_the_ID() ];
				$args['orderby']      = 'rand';

				// If there are categories, add them to the query.
				if ( $categories ) {
					$category_ids = [];
					foreach ( $categories as $category ) {
						$category_ids[] = $category->term_id;
					}
					$args['category__in'] = $category_ids;
				}

				// If there are tags, add them to the query.
				if ( $tags ) {
					$tag_ids = [];
					foreach ( $tags as $tg ) {
						$tag_ids[] = $tg->term_id;
					}
					$args['tag__in'] = $tag_ids;
				}
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

	</div>
</section>
