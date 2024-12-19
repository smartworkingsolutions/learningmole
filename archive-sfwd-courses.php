<?php // phpcs:ignore
/**
 * The template for displaying Archive page of courses.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */


get_header();
?>

	<section class="filter-section | w-full bg-light-color py-10 md:py-16">
		<div class="container">

			<div class="max-w-4xl bg-white border border-border-color px-4 rounded-md mb-10 mx-auto">
				<form id="searchform" class="search-form flex justify-between items-center" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off" accept-charset="utf-8">
					<input type="text" id="keyword" class="search-input | text-sm font-normal tracking-normal w-full border-none focus:border-none focus:outline-none focus:ring-0 bg-transparent px-0" name="s" autocomplete="off" placeholder="Search course..." value="<?php echo get_search_query(); ?>" onkeyup="learnmole_fetch_courses()">
					<input type="hidden" name="post_type" value="sfwd-courses" />
					<button class="search-submit | w-5 h-5 flex text-text-color"><?php get_svg( 'icons/search' ); ?></button>
				</form>
			</div>

			<div class="courses-post-container search-result | grid sm:grid-cols-2 xl:grid-cols-3 gap-10 items-start">

				<?php
				if ( ! have_posts() ) {
					echo '<p>No course found.</p>';
				}

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'course' );

				endwhile; // End of the loop.
				wp_reset_postdata();
				?>

			</div>

			<?php get_learnmole_pagination(); ?>

		</div>
	</section>

<?php
get_footer();
