<?php // phpcs:ignore
/**
 * The template for displaying Taxonomy page of courses category.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */

get_header();
?>

	<section class="filter-section | w-full bg-light-color py-10 md:py-16">
		<div class="container">

			<div class="grid lg:flex gap-10 items-start">
				<!-- Filters -->
				<?php
				get_template_part(
					'template-parts/courses/tax',
					'filters',
					[
						'tax_cat' => 'ld_topic_category',
						'tax_tag' => 'ld_topic_tag',
						'current' => 'topics',
						'parent'  => wp_get_term_taxonomy_parent_id( get_queried_object()->term_id, 'ld_topic_category' ),
					]
				);
				?>

				<div class="topics-post-container search-result | grid sm:grid-cols-2 xl:grid-cols-3 gap-10 items-start">

					<?php
					if ( ! have_posts() ) {
						echo '<p>No topic found.</p>';
					}

					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'topic' );

					endwhile; // End of the loop.
					wp_reset_postdata();
					?>

				</div>
			</div>
			<?php get_learnmole_pagination(); ?>

		</div>
	</section>

<?php
get_footer();
