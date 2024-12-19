<?php
/**
 * The template part for displaying Content of single page.
 *
 * @package LearningMole
 */

$reviewed_by = get_field( 'reviewed_by', get_the_ID() );
$counter     = 0;
?>

<div class="single-page mt-8 md:mt-10 mb-10 md:mb-16">
	<div class="container">
		<div class="grid lg:flex gap-10 items-start">
			<div class="grid gap-8 flex-1">
				<?php
				the_title( '<h1 class="text-3xl md:text-4xl font-bold text-blue-dark">', '</h1>' );
				?>
				<div class="meta | flex gap-3 items-center">
					<?php learningmole_author_avatar(); ?>
					<div class="flex flex-wrap gap-x-3 gap-y-1 items-center">
						<?php
						learningmole_posted_on();

						learningmole_posted_by();

						if ( $reviewed_by ) {
							echo '<span>' . esc_html__( 'Educator Review By: ', 'learningmole' );
							foreach ( $reviewed_by as $review ) {
								$nickname = str_replace( ' ', '-', $review['user_nicename'] );
								echo '<a class="font-bold text-primary-color capitalize" href="/author/' . esc_html( strtolower( $nickname ) ) . '/">' . esc_html( $review['display_name'] ) . '</a>';
								if ( count( $reviewed_by ) - 1 !== $counter ) {
									echo ', ';
								}
								++$counter;
							}
							echo '</span>';
						} else {
							echo '<span>' . esc_html__( 'Educator Review By: ', 'learningmole' ) . '<a class="font-bold text-primary-color" href="/author/michelle-connolly/">' . esc_html__( 'Michelle Connolly', 'learningmole' ) . '</a></span>';
						}
						?>
					</div>
				</div>
				<?php
				echo '<div class="wysiwyg-editor | w-full gap-6 sm:gap-8">';
				the_content();
				echo '</div>';
				get_template_part( 'template-parts/courses/social', 'share' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					echo '<div class="grid gap-6">';
					add_filter(
						'comment_form_defaults',
						function( $defaults ) {
							$defaults['title_reply_before'] = '<h2 id="reply-title" class="comment-reply-title">';
							$defaults['title_reply_after']  = '</h2>';
							return $defaults;
						}
					);
					comments_template();
					echo '</div>';
				endif;
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

<?php get_template_part( 'template-parts/related', 'posts' ); ?>
