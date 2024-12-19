<?php
/**
 * The template for displaying Author details
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ProfileTree
 */

get_header();
$curauth = get_queried_object();
$user    = get_user_by( 'id', $curauth->ID );
?>

	<section class="w-full bg-light-color py-10 md:py-16">
		<div class="container">
			<h2 class="text-3xl md:text-4xl text-primary-color text-center leading-none mb-10">Latest Posts by <?php echo esc_html( $user->display_name ); ?>:</h2>
			<div class="grid md:grid-cols-3 gap-10">

				<?php
				if ( ! have_posts() ) {
					echo '<p class="col-span-full flex justify-center">' . esc_html__( 'No post found.', 'learningmole' ) . '</p>';
				}

				while ( have_posts() ) :
					the_post();

					get_template_part( 'template-parts/content', 'blog' );

				endwhile; // End of the loop.
				wp_reset_postdata();
				?>

			</div>
			<?php // get_learnmole_pagination(); ?>

		</div>
	</section>

<?php
get_footer();
