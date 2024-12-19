<?php
/**
 * The template part for displaying Content of single page.
 *
 * @package LearningMole
 */

?>

<div class="single-page mt-8 mb-10 md:mb-16">
	<div class="container">
		<?php
		if ( has_post_thumbnail() ) {
			$alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
			if ( empty( $alt ) ) {
				$alt = get_the_title();
			}
			?>
			<img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_id(), 'full' ) ); ?>" class="w-full object-scale-down rounded-10 mb-12 hidden md:block" alt="<?php echo esc_html( $alt ); ?>">
			<?php
		}
		?>
		<div class="grid lg:flex gap-10 items-start">
			<div class="grid gap-8 flex-1">
				<?php
				the_title( '<h1 class="text-3xl md:text-4xl font-bold text-blue-dark mb-8">', '</h1>' );
				echo '<div class="wysiwyg-editor | w-full gap-8">';
				the_content();
				echo '</div>';
				get_template_part( 'template-parts/courses/social', 'share' );
				?>
			</div>
			<aside class="grid gap-8 flex-1 max-w-sm sticky top-0">
				<?php
				if ( ! is_user_logged_in() ) {
					get_template_part( 'template-parts/courses/widget', '1' );
				}
				get_template_part( 'template-parts/courses/widget', '2' );
				?>
			</aside>
		</div>

	</div>
</div>
