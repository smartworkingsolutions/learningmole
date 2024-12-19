<?php
/**
 * Template Name: Dashboard Page
 * The template for displaying Dashboard page
 *
 * @package LearningMole
 */

get_header();
?>

	<section class="dashboard-wrapper | w-full my-10 md:my-14">
		<div class="container">
			<?php
			if ( ! is_user_logged_in() ) {
				echo '<p>' . esc_html__( 'Please try to login to website to access dashboard. Dashboard are disabled for logout members.', 'learningmole' ) . '</p>';
			} else {
				get_dashboard();
			}
			?>

		</div>
	</section>

<?php
get_footer();
