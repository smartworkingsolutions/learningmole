<?php // phpcs:ignore
/**
 * The template for displaying Archive page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */

get_header();
?>

	<section class="w-full bg-light-color py-10 md:py-16">
		<div class="container">

			<div class="grid md:grid-cols-3 gap-10">

				<?php
				if ( ! have_posts() ) {
					echo '<p>No post found.</p>';
				}

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'blog' );

				endwhile; // End of the loop.
				wp_reset_postdata();
				?>

			</div>
			<?php // Custom_Pagination::get_pagination(); ?>
			<?php get_learnmole_pagination(); ?>

		</div>
	</section>

<?php
get_footer();
