<?php
/**
 * The ACF template part for displaying lessons cards.
 *
 * @package LearningMole
 */

$course_ids = get_sub_field( 'select_course' );
if ( ! $course_ids ) {
	return;
}
?>

<section class="lesson-cards | w-full">
	<div class="container">

		<?php
		$card_link = '';

		echo '<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">';

		foreach ( $course_ids as $course_id ) {

			$lessons = learndash_get_course_lessons_list( $course_id );

			foreach ( $lessons as $lesson ) {
				$bg_color = get_random_light_color();

				if ( $lesson['post']->post_name ) {
					$card_link = '/lessons/' . $lesson['post']->post_name . '/';
				}

				printf(
					'<a class="flex flex-col justify-center gap-3 w-full bg-primary-color-100 p-6 rounded-lg overflow-hidden relative" href="%s" style="background-color: %s;">
						<h2 class="text-2xl md:text-3xl font-bold">%s</h2>
						<p class="relative z-10">%s</p>
						<div class="w-64 h-64 flex absolute top-1/2 -right-20 -translate-y-1/2 opacity-10 z-10">%s</div>
						<div><button class="button mt-3">%s</button></div>
					</a>',
					esc_url( $card_link ),
					$bg_color, // phpcs:ignore.
					esc_html( $lesson['post']->post_title ),
					esc_html( wp_strip_all_tags( $lesson['post']->post_content ) ),
					get_svg( 'cat/badge-full', false ), // phpcs:ignore.
					esc_html__( 'Learn now', 'learningmole' )
				);
			}
		}

		echo '</div>';
		?>
	</div>
</section>
