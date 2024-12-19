<?php
/**
 * The template part for displaying contents in dashboard.
 *
 * @package LearningMole
 */

global $current_user;
$curauth      = get_user_meta( $current_user->ID );
$course_count = get_all_courses_ids_under_group();
$lesson_count = get_count_of_lessons_or_topics_linked_to_courses();
$topic_count  = get_count_of_lessons_or_topics_linked_to_courses( 'sfwd-topic' );

$group_ids = learndash_get_users_group_ids( $current_user->ID );
$free_id   = '';

$free_group_ids = get_free_group_id();
foreach ( $free_group_ids as $g_id ) {
	$free_id = $g_id;
}

$name = '';

if ( $curauth['first_name'][0] ) {
	$name = $curauth['first_name'][0];
} else {
	$name = $curauth['nickname'][0];
}
?> 

<div class="lg:col-span-3 h-full bg-white p-6 lg:p-10 rounded-10">

	<!-- Tab Dashboard -->
	<div x-show="tab === 'dashboard'">
		<div class="grid md:flex justify-between items-center gap-6 bg-primary-color text-white p-6 sm:p-10 -mx-6 lg:-mx-10 -mt-6 lg:-mt-10 rounded-t-lg">
			<div class="flex items-center gap-4">
				<?php
				if ( wp_is_mobile() ) {
					learningmole_author_avatar( '50' );
				} else {
					learningmole_author_avatar( '100' );
				}
				?>
				<div class="grid gap-1">
					<h4 class="text-lg sm:text-xl font-bold capitalize"><?php echo esc_html__( 'Hello, ', 'learningmole' ) . esc_html( $name ); ?></h4>
				</div>
			</div>
			<a href="<?php echo esc_url( wp_logout_url() ); ?>" class="button button-white flex items-center gap-1"><?php esc_html_e( 'Logout', 'learningmole' ); ?><span class="flex w-6 h-6"><?php get_svg( 'icons/logout' ); ?></span></a>
		</div>
		<div class="grid md:flex gap-4 md:gap-10 mt-10">
			<div class="w-full flex justify-center bg-primary-color text-lg font-semibold text-white px-8 py-4 rounded-lg">
				<?php echo esc_html( count( $course_count ) ) . ' ' . esc_html__( 'Subjects', 'learningmole' ); ?>
			</div>
			<a href="/lessons/" class="w-full flex justify-center bg-secondary-color text-lg font-semibold text-white px-8 py-4 rounded-lg">
				<?php if ( count( $lesson_count ) > 0 ) : echo esc_html( count( $lesson_count ) ) . ' ' . esc_html__( 'Topics', 'learningmole' ); else : echo 'View All Topics'; endif; ?>
			</a>
			<a href="/topics/" class="w-full flex justify-center bg-text-color text-lg font-semibold text-white px-8 py-4 rounded-lg">
				<?php if ( count( $topic_count ) > 0 ) : echo esc_html( count( $topic_count ) ) . ' ' . esc_html__( 'Video Lessons', 'learningmole' ); else : echo 'View All Video Lessons'; endif; ?>
			</a>
		</div>
		<!-- Courses -->
		<div class="w-full mt-10">
			<h2 class="text-2xl font-bold mb-6"><?php esc_html_e( 'Let\'s start with:', 'learningmole' ); ?></h2>
			<?php get_courses_tiles(); ?>
		</div>
	</div>

	<!-- Tab Profile -->
	<div x-show="tab === 'profile'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'My Profile', 'learningmole' ); ?></h2>
			<a @click.prevent="tab = 'edit-profile'; window.location.hash = 'edit-profile'" href="/dashboard/#edit-profile" class="button"><?php esc_html_e( 'Edit Profile', 'learningmole' ); ?></a>
		</div>
		<div class="text-base border border-border-color">
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'Registration Date: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2">
				<?php
				echo esc_html( get_the_author_meta( 'user_registered', $current_user->ID ) );
				?>
				</span>
			</div>
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'Username: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2"><?php echo esc_html( $curauth['nickname'][0] ); ?></span>
			</div>
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'First Name: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2"><?php echo esc_html( $curauth['first_name'][0] ); ?></span>
			</div>
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'Last Name: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2"><?php echo esc_html( $curauth['last_name'][0] ); ?></span>
			</div>
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'Email: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2">
				<?php
				echo esc_html( get_the_author_meta( 'user_email', $current_user->ID ) );
				?>
				</span>
			</div>
			<div class="grid sm:flex border-b border-border-color">
				<span class="min-w-[250px] font-semibold px-4 sm:border-r border-border-color py-2"><?php esc_html_e( 'Bio: ', 'learningmole' ); ?></span>
				<span class="px-4 py-2"><?php echo esc_html( $curauth['description'][0] ); ?></span>
			</div>
		</div>
	</div>

	<!-- Tab Edit Profile -->
	<div x-show="tab === 'edit-profile'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Edit Profile', 'learningmole' ); ?></h2>
		</div>
		<?php
		if ( is_woocommerce_activated() ) {
			wc_get_template(
				'myaccount/form-edit-account.php',
				[
					'user' => get_user_by( 'id', get_current_user_id() ),
				]
			);
		}
		?>
	</div>

	<!-- Tab Lesson -->
	<div x-show="tab === 'lesson'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Continue where you left off:', 'learningmole' ); ?></h2>
			<a href="/lessons/" class="button"><?php esc_html_e( 'View all playlists', 'learningmole' ); ?></a>
		</div>
		<div class="w-full">
			<div class="ajax-show-lessons | grid sm:grid-cols-2 xl:grid-cols-3 gap-10 items-start"></div>
			<div class="text-center mt-6"><a href="/lessons/" class="button mx-auto"><?php esc_html_e( 'View all', 'learningmole' ); ?></a></div>
		</div>
	</div>

	<!-- Tab Topic -->
	<div x-show="tab === 'topic'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Continue where you left off:', 'learningmole' ); ?></h2>
			<a href="/topics/" class="button"><?php esc_html_e( 'View all video lessons', 'learningmole' ); ?></a>
		</div>
		<div class="w-full">
			<div class="ajax-show-topics | grid sm:grid-cols-2 xl:grid-cols-3 gap-10 items-start"></div>
			<div class="text-center mt-6"><a href="/topics/" class="button mx-auto"><?php esc_html_e( 'View all', 'learningmole' ); ?></a></div>
		</div>
	</div>

	<!-- Tab Orders -->
	<div x-show="tab === 'order'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Orders', 'learningmole' ); ?></h2>
		</div>
		<?php
		if ( is_woocommerce_activated() ) {
			woocommerce_account_orders( true );
		}
		?>
	</div>

	<!-- Tab Subscription -->
	<div x-show="tab === 'subscription'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Subscriptions', 'learningmole' ); ?></h2>
		</div>
		<?php
		if ( class_exists( 'WC_Subscriptions' ) ) {
			WCS_Template_Loader::get_my_subscriptions();
		}
		?>
	</div>

	<!-- Badge -->
	<div x-show="tab === 'badge'">
		<div class="grid md:flex justify-between items-center gap-4 mb-10">
			<h2 class="text-2xl font-bold"><?php esc_html_e( 'Your Achievements', 'learningmole' ); ?></h2>
		</div>
		<?php
		$quizzies = get_all_quizzes_completed_by_user( $current_user->ID );
		foreach ( $quizzies as $quiz ) {
			$quiz_ids[] = $quiz->quiz_id;
		}
		$quiz_unique_ids = array_unique( $quiz_ids );

		if ( $quiz_unique_ids ) {
			echo '<div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">';
			foreach ( $quiz_unique_ids as $quiz_unique_id ) {
				$certificate_id = get_post_meta( $quiz_unique_id, '_ld_certificate', true );

				echo '<div class="grid gap-4">';

				if ( ! empty( learndash_get_certificate_link( $quiz_unique_id, $current_user->ID ) ) ) {
					echo '<div class="w-full">';
					echo get_the_post_thumbnail( $certificate_id, 'medium', [ 'class' => 'w-full border border-primary-color' ] );
					echo '</div>';
				}

				echo '<div class="wpProQuiz_certificate dashboard-button | w-full">' . wp_kses_post( learndash_get_certificate_link( $quiz_unique_id, $current_user->ID ) ) . '</div>';

				echo '</div>';
			}
			echo '</div>';
		} else {
			echo '<p>' . esc_html__( 'You have not completed any quizzes yet.', 'learningmole' ) . '</p>';
		}

		?>
	</div>
</div>
