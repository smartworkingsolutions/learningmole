<?php
/**
 * Template Name: Register Page
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
	<div class="custom-register">
		<form id="custom-registration-form" class="w-full h-screen max-w-xl mx-auto flex flex-col gap-6 justify-center items-center p-10" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
			<input type="hidden" name="action" value="custom_register_user">
			<h1 class="text-3xl font-bold"><?php esc_html_e( 'Register', 'learningmole' ); ?></h1>

			<p class="w-full">
				<label for="username">Username</label>
				<input type="text" name="username" required>
			</p>

			<p class="w-full">
				<label for="email">Email</label>
				<input type="email" name="email" required>
			</p>

			<p class="w-full">
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" required>
				<small>Password should contain at least 8 characters including uppercase, lowercase letters, numbers, and special characters.</small>
				<span id="password-error" class="text-red-500 italic mt-2 hidden">Password does not meet the criteria.</span>
			</p>

			<p class="w-full">
				<input type="submit" class="w-full button cursor-pointer" value="Register">
			</p>
			<p class="flex justify-center">OR</p>
			<a class="w-full button button-secondary" rel="nofollow" href="/login/"><?php esc_html_e( 'Login', 'learningmole' ); ?></a>
		</form>
	</div>
</div>
<?php
get_footer();
