<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */

get_header();
?>

	<section class="w-full my-10 md:my-16">
		<div class="container">

			<?php
			while ( have_posts() ) :
				the_post();

				echo '<div class="wysiwyg-editor | w-full gap-8">';
				the_content();
				echo '</div>';

			endwhile; // End of the loop.
			?>

		</div>
	</section>

<?php
get_footer();
