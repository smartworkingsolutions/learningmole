<?php
/**
 * The template part for displaying tabs in dashboard.
 *
 * @package LearningMole
 */

$lesson_count = get_count_of_lessons_or_topics_linked_to_courses();
$topic_count  = get_count_of_lessons_or_topics_linked_to_courses( 'sfwd-topic' );

global $current_user;
$group_ids     = learndash_get_users_group_ids( $current_user->ID );
$free_group_id = get_free_group_id();

$free_id        = '';
$free_group_ids = get_free_group_id();
foreach ( $free_group_ids as $g_id ) {
	$free_id = $g_id;
}
?>

<ul class="grid grid-cols-2 lg:grid-cols-1 gap-1 gap-y-3 sm:gap-y-0 text-base">

	<span class="mx-auto py-6 lg:py-10 col-span-full"><?php theme_logo(); ?></span>

	<li @click.prevent="tab = 'dashboard'; window.location.hash = 'dashboard'" :class="tab === 'dashboard' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/dashboard' ); ?></span><?php esc_html_e( 'Dashboard', 'learningmole' ); ?></button>
	</li>

	<li @click.prevent="tab = 'profile'; window.location.hash = 'profile'" :class="tab === 'profile' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/profile' ); ?></span><?php esc_html_e( 'Profile', 'learningmole' ); ?></button>
	</li>

	<li @click.prevent="tab = 'edit-profile'; window.location.hash = 'edit-profile'" :class="tab === 'edit-profile' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/edit' ); ?></span><?php esc_html_e( 'Edit Profile', 'learningmole' ); ?></button>
	</li>

	<?php if ( count( $lesson_count ) > 0 && count( $topic_count ) > 0 ) : ?>
	<li class="w-full h-px bg-black/10 px-4 my-3 hidden lg:block"></li>
	<?php endif; ?>

	<?php
	if ( $free_group_id !== $group_ids ) :
		?>

		<?php if ( count( $lesson_count ) > 0 ) : ?>
		<li id="load-lessons" @click.prevent="tab = 'lesson'; window.location.hash = 'lesson'" :class="tab === 'lesson' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
			<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/lesson' ); ?></span><?php esc_html_e( 'My Playlists', 'learningmole' ); ?></button><!-- Default name is Lessons in LearnDash -->
		</li>
		<?php endif; ?>
		<?php if ( count( $topic_count ) > 0 ) : ?>
		<li id="load-topics" @click.prevent="tab = 'topic'; window.location.hash = 'topic'" :class="tab === 'topic' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
			<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/topic' ); ?></span><?php esc_html_e( 'My Video Lessons', 'learningmole' ); ?></button><!-- Default name is Topics in LearnDash -->
		</li>
		<?php endif; ?>

		<?php
	endif;

	?>
	<!-- Badges -->
	<li @click.prevent="tab = 'badge'; window.location.hash = 'badge'" :class="tab === 'badge' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/badge' ); ?></span><?php esc_html_e( 'My Achievements', 'learningmole' ); ?></button>
	</li>
	<?php

	if ( $free_group_id !== $group_ids ) :
		?>

		<li class="w-full h-px bg-black/10 px-4 my-3 hidden lg:block"></li>

		<li @click.prevent="tab = 'order'; window.location.hash = 'order'" :class="tab === 'order' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
			<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/order' ); ?></span><?php esc_html_e( 'Orders', 'learningmole' ); ?></button>
		</li>

		<li @click.prevent="tab = 'subscription'; window.location.hash = 'subscription'" :class="tab === 'subscription' ? 'text-primary-color sm:bg-black/5' : ''" class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
			<button class="flex items-center gap-1"><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/subscribe' ); ?></span><?php esc_html_e( 'Subscriptions', 'learningmole' ); ?></button>
		</li>

		<li class="w-full h-px bg-black/10 px-4 my-3 hidden lg:block"></li>

		<?php
		endif;
	?>

	<li class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<a href="/resources/" class="flex items-center gap-1"><?php esc_html_e( 'Resources', 'learningmole' ); ?><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/launch' ); ?></span></a>
	</li>

	<li class="text-sm sm:text-base sm:text-text-color sm:hover:bg-black/5 sm:py-3 sm:px-4 rounded-lg cursor-pointer">
		<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="flex items-center gap-1"><?php esc_html_e( 'Logout', 'learningmole' ); ?><span class="flex w-5 sm:w-6 h-5 sm:h-6"><?php get_svg( 'icons/logout' ); ?></span></a>
	</li>
</ul>
