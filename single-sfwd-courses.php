<?php
/**
 * The template for displaying all single page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/content-single', 'course' );

endwhile; // End of the loop.

get_footer();
