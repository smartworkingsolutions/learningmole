<?php
/**
 * Template Name: Login Page
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
<div class="grid md:grid-cols-2">
	<div class="h-screen hidden md:grid place-content-center bg-primary-color-100 p-10">
		<?php theme_logo(); ?>
	</div>
	<div class="custom-login | h-screen grid gap-6 place-content-center p-10">
		<?php
		if ( is_user_logged_in() ) {
			// User is already logged in.
			echo '<p>' . esc_html__( 'You are already logged in.', 'learningmole' ) . '</p>';
			echo '<a href="' . esc_url( home_url() ) . '" class="button button-primary">' . esc_html__( 'Go to Homepage', 'learningmole' ) . '</a>';
			echo '<a href="' . esc_url( wp_logout_url( home_url( '/login/' ) ) ) . '" class="button button-secondary">' . esc_html__( 'Logout', 'learningmole' ) . '</a>';
		} else {
			if ( $_GET['login'] && 'failed' === $_GET['login'] ) { // phpcs:ignore
				echo '<p class="text-red-400"><strong>Error</strong>: Something went wrong. Please try again.</p>';
			}
			?>
			<div class="md:hidden mx-auto"><?php theme_logo(); ?></div>
			<h1 class="text-3xl font-bold"><?php esc_html_e( 'Login', 'learningmole' ); ?></h1>
			<?php
			wp_login_form();
			?>
			<a class="flex justify-center text-primary-color underline" href="<?php echo esc_url( wp_lostpassword_url() ); ?>" alt="<?php esc_attr_e( 'Lost Password', 'learningmole' ); ?>">
				<?php esc_html_e( 'Lost Password?', 'learningmole' ); ?>
			</a>
			<p class="flex justify-center">OR</p>
			<a class="button button-secondary" rel="nofollow" href="/pricing/"><?php esc_html_e( 'Get Started', 'learningmole' ); ?></a>
			<?php
		}
		?>
	</div>
</div>
<?php
get_footer();
