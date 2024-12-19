<?php
/**
 * The template for displaying Search results.
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
					echo '<p>No posts found.</p>';
				}

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'course' );

				endwhile; // End of the loop.
				wp_reset_postdata();
				?>

			</div>

		</div>
	</section>

<?php
get_footer();
