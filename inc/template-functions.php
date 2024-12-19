<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package LearningMole
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function learningmole_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	if ( has_active_subscription() ) {
		$classes[] = 'user-have-subscription';
	} else {
		$classes[] = 'no-subscription';
	}

	return $classes;
}
add_filter( 'body_class', 'learningmole_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function learningmole_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'learningmole_pingback_header' );

/**
 * Get svg file content.
 *
 * @param string $path path of the SVG file.
 * @param string $echo print|return.
 *
 * @return string
 */
function get_svg( $path, $echo = true ) {

	$file = get_template_directory() . '/images/' . $path . '.svg';

	if ( ! file_exists( $file ) ) {
		return;
	}

	$svg = file_get_contents( $file ); // phpcs:ignore

	if ( $echo ) {
		echo $svg; // phpcs:ignore
	} else {
		return $svg;
	}
}

/**
 * Strip spaces and special characters.
 *
 * @param string $string string needed to clean.
 */
function clean_string( $string ) {
	$string = str_replace( ' ', '', $string ); // Replaces all spaces with hyphens.
	return preg_replace( '/[^A-Za-z0-9\-]/', '', $string ); // Removes special chars.
}

/**
 * Shortcode for heading color classes.
 *
 * @param Array  $atts default\override attributes.
 * @param String $content content of field.
 */
function highlight( $atts, $content = null ) { // phpcs:ignore
	return '<span class="text-primary-color">' . $content . '</span>';
}
add_shortcode( 'H', 'highlight' );

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * Check if WooCommerce is activated
	 */
	function is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check if WooCommerce page
 *
 * @return boolean
 */
function is_woocommerce_page() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) {
			return true;
		}
	}
	return false;
}

/**
 * Output login/logout button.
 */
function add_login_logout_button() {
	$user_id  = get_current_user_id();
	$group_id = learndash_get_users_group_ids( $user_id );

	if ( is_user_logged_in() ) {
		echo '<div x-data="{ open: false }" class="relative">';
		printf(
			'<button
				@click="open = !open"
				@click.outside="open = false"
				class="button gap-1"
				><span class="w-5 h-5">%s</span>%s<span class="w-5 h-5">%s</span></button>',
			get_svg( 'icons/user', false ), //phpcs:ignore
			esc_html__( 'Dashboard', 'learningmole' ),
			get_svg( 'icons/carret-down', false ) //phpcs:ignore
		);
		echo '<div x-show="open" x-cloak class="w-40 grid gap-2 bg-white text-text-color tracking-px rounded-lg shadow-glass p-4 absolute top-12">';
		echo '<a class="flex hover:text-primary-color" href="/dashboard/">' . esc_html__( 'Dashboard', 'learningmole' ) . '</a>';
		if ( get_free_group_id() === $group_id ) {
			echo '<a class="flex hover:text-primary-color" href="/pricing/">' . esc_html__( 'Upgrade', 'learningmole' ) . '</a>';
		}
		echo '<a class="flex hover:text-primary-color border-t border-border-color pt-2" href="' . esc_url( wp_logout_url() ) . '">' . esc_html__( 'Logout', 'learningmole' ) . '</a>';
		echo '</div>';
		echo '</div>';
	} else {
		printf(
			'<div><a href="%s" class="button gap-1.5 items-center">%s<span class="w-4 h-4">%s</span></a></div>',
			esc_url( home_url( '/login/' ) ),
			esc_html__( 'Login', 'learningmole' ),
			get_svg( 'icons/login', false ) //phpcs:ignore
		);
	}
}

/**
 * Output the link of modified post author.
 */
function get_modified_author_posts_url() {
	global $post;
	$id = get_post_meta( $post->ID, '_edit_last', true );
	if ( $id ) {
		return esc_url( get_author_posts_url( $id ) );
	}
}

/**
 * Output the number paginated links.
 *
 * @param array   $query custom query to override default\override attributes.
 * @param boolean $results true|false for results to show.
 */
function get_learnmole_pagination( $query = '', $results = false ) {

	if ( ! $query ) {
		global $wp_query;
		$query = $wp_query;
	}
	$big = 999999999; // need an unlikely integer.
	echo '<div class="pagination | mt-16">';
	echo paginate_links( // phpcs:ignore
		[
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $query->max_num_pages,
			'prev_text' => get_svg( 'icons/next', false ),
			'next_text' => get_svg( 'icons/next', false ),
		]
	);
	echo '</div>';
	if ( $query->found_posts && $results ) {
		echo '<div class="flex justify-center gap-1 mt-6">';
		$start = ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] ) + 1;
		$end   = $start + $query->post_count - 1;
		echo esc_html__( 'Showing ', 'learningmole' ) . $start . '-' . $end . esc_html__( ' of ', 'learningmole' ) . $query->found_posts . esc_html__( ' Results', 'learningmole' ); // phpcs:ignore
		echo '</div>';
	}
}

/**
 * Alter the pagination next and prev links to have rel.
 *
 * @param string $r    HTML output.
 * @param array  $args An array of arguments. See paginate_links() for information on accepted arguments.
 *
 * @return sting - The HTML output of the pagination.
 */
function scaffolding_add_rel_pagination( $r, $args ) { // phpcs:ignore

	$r = str_replace( 'class="prev', 'rel="prev" class="prev', $r );
	$r = str_replace( 'class="next', 'rel="next" class="next', $r );

	return $r;
}
add_filter( 'paginate_links_output', 'scaffolding_add_rel_pagination', 20, 2 );

/**
 * Outputs the courses under current user.
 */
function get_dashboard() {
	?>
	<div class="grid bg-primary-color-200 p-4 rounded-10">
		<div class="grid lg:grid-cols-4 items-start gap-10" x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'dashboard' }">
			<?php get_template_part( 'template-parts/dashboard/dashboard', 'tabs' ); ?>
			<?php get_template_part( 'template-parts/dashboard/dashboard', 'contents' ); ?>
		</div>
	</div>
	<?php
}

/**
 * Get all courses ids under group.
 */
function get_all_courses_ids_under_group() {
	$user_id         = get_current_user_id();
	$group_ids       = learndash_get_users_group_ids( $user_id );
	$a               = [];
	$all_courses_ids = '';

	foreach ( $group_ids as $group_id ) {
		$group_courses[] = learndash_group_enrolled_courses( $group_id );
		$all_courses_ids = array_merge( $a, ...$group_courses );
	}
	return $all_courses_ids;
}

/**
 * Outputs the courses titles with link.
 */
function get_courses_tiles() {
	$all_courses_ids = get_all_courses_ids_under_group();

	if ( ! $all_courses_ids ) {
		return;
	}

	$args = [
		'post_type'      => 'sfwd-courses',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'asc',
		'post__in'       => $all_courses_ids,
	];

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="grid sm:grid-cols-2 gap-10">';
		while ( $query->have_posts() ) {
			$query->the_post();

			$bgcolor = ' bg-primary-color-100';
			$svg     = '';
			$text    = '';

			$slug = get_post_field( 'post_name', get_the_ID() );

			if ( 'maths' === $slug ) {
				$bgcolor = ' bg-[#F4EAE0]';
				$svg     = get_svg( 'cat/five-full', false );
				$text    = 'Delve into the fascinating world of Maths, where you\'ll discover the beauty and logic of numbers, shapes, and patterns, unraveling their mysteries and applications in daily life, and developing critical thinking and problem-solving skills.';
			}
			if ( 'english' === $slug ) {
				$bgcolor = ' bg-primary-color-100';
				$svg     = get_svg( 'cat/b-full', false );
				$text    = 'Explore the nuances of English language, delving into its rich vocabulary, grammar, and literary styles, and discover how mastering English can enhance your communication skills, creative expression, and understanding of diverse cultures.';
			}
			if ( 'science' === $slug ) {
				$bgcolor = ' bg-[#F1EAFF]';
				$svg     = get_svg( 'cat/dna-full', false );
				$text    = 'Embark on a captivating exploration of science, where you\'ll uncover the wonders of the natural world, from the smallest atoms to the vast universe, and ignite a passion for discovery, experimentation, and understanding the incredible workings of our world.';
			}
			if ( 'geography' === $slug ) {
				$bgcolor = ' bg-[#E0F4FF]';
				$svg     = get_svg( 'cat/location-full', false );
				$text    = 'Dive into the world of geography, where you\'ll explore the diverse landscapes of our planet, understand the complexities of weather and climates, and discover the intricate ways in which human societies and natural environments interact and shape each other.';
			}
			if ( 'history' === $slug ) {
				$bgcolor = ' bg-[#F2FFE9]';
				$svg     = '';
				$text    = 'Embark on a journey through history, where you\'ll uncover the stories of ancient civilizations, pivotal events, and influential figures, gaining insights into how the past has shaped our present and offering a deeper understanding of the world we live in today.';
			}
			if ( 'digital-skills' === $slug ) {
				$bgcolor = ' bg-[#FFDFDF]';
				$svg     = '';
				$text    = 'Embark on an exciting journey to master digital skills, where you\'ll learn about cybersecurity, effective online communication, and basic coding, equipping you with the knowledge and tools needed to thrive in our digitally connected world.';
			}
			if ( 'life-skills' === $slug ) {
				$bgcolor = ' bg-[#F5F5F5]';
				$svg     = get_svg( 'cat/think-full', false );
				$text    = 'Explore the essential realm of life skills, where you\'ll learn practical abilities like problem-solving, effective communication, and time management, equipping you with the tools to navigate everyday challenges and succeed in various aspects of personal and professional life.';
			}
			if ( 'songs' === $slug ) {
				$bgcolor = ' bg-[#DEE5D4]';
				$svg     = get_svg( 'cat/music-full', false );
				$text    = 'Get ready to sing, dance, and learn all at the same time! This fun-filled section is packed with catchy tunes that will teach you about everything from the alphabet to animals in the jungle. Explore different music styles as you sing along and discover new facts with each melody. Perfect for kids who love to move and groove while they learn!';
			}

			$url = '/' . $slug . '-videos/';

			$group_courses_ids = learndash_group_enrolled_courses( 30939 ); // live.
			// $group_courses_ids = learndash_group_enrolled_courses( 18545 );
			if ( in_array( get_the_ID(), $group_courses_ids, true ) ) {
				$aa  = learndash_get_course_lessons_list();
				$url = $aa['1']['permalink'];
			}

			printf(
				'<a class="w-full p-6 rounded-lg overflow-hidden relative%s" href="%s">
					<h3 class="text-3xl font-bold">%s</h3>
					<p class="mt-3 relative z-20">%s</p>
					<div class="w-64 h-64 flex absolute top-1/2 -right-20 -translate-y-1/2 opacity-10 z-10">%s</div>
					<button class="button mt-6">%s</button>
				</a>',
				esc_html( $bgcolor ),
				esc_url( $url ),
				esc_html( get_the_title() ),
				esc_html( $text ),
				$svg, // phpcs:ignore
				esc_html__( 'Learn now', 'learningmole' )
			);
		}

		global $current_user;
		$group_ids     = learndash_get_users_group_ids( $current_user->ID );
		$free_group_id = get_free_group_id();

		if ( $free_group_id !== $group_ids ) {
			$bgcolor = ' bg-primary-color-100';
			$svg     = get_svg( 'cat/badge-full', false );
			$text    = 'Digital badges make learning fun and rewarding by recognising achievements with engaging visuals. They offer a tangible way to showcase skills and knowledge, motivating learners and providing instant feedback. Easy to share and display, digital badges enhance the learning experience and encourage continued growth.';
			$url     = '/free-digital-badges/';
		}

		printf(
			'<a class="w-full p-6 rounded-lg overflow-hidden relative%s" href="%s">
				<h3 class="text-3xl font-bold">%s</h3>
				<p class="mt-3 relative z-20">%s</p>
				<div class="w-64 h-64 flex absolute top-1/2 -right-20 -translate-y-1/2 opacity-10 z-10">%s</div>
				<button class="button mt-6">%s</button>
			</a>',
			esc_html( $bgcolor ),
			esc_url( $url ),
			esc_html__( 'Digital Badges', 'learningmole' ),
			esc_html( $text ),
			$svg, // phpcs:ignore
			esc_html__( 'Learn now', 'learningmole' )
		);

		echo '</div>';
	} else {
		echo 'No course found';
	}
	/* Restore original Post Data */
	wp_reset_postdata();
}

/**
 * Outputs the courses under current user.
 */
function get_enrolled_courses() {
	$user_id = get_current_user_id();
	$courses = learndash_user_get_enrolled_courses( $user_id, [], true );

	$args = [
		'post_type'      => 'sfwd-courses',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'post__in'       => $courses,
	];

	$enrolled = new WP_Query( $args );

	if ( $enrolled->have_posts() && ! empty( $courses ) ) {
		while ( $enrolled->have_posts() ) {
			$enrolled->the_post();
			get_template_part( 'template-parts/dashboard/content', 'course' );
		}
	} else {
		echo '<div class="col-span-full w-full flex items-center gap-4">No enrolled course found. <a class="button" href="/pricing/">' . esc_html__( 'Get Started', 'learningmole' ) . '</a></div>';
	}
	/* Restore original Post Data */
	wp_reset_postdata();
}

/**
 * Return count of the lessons | Topics linked to courses.
 *
 * @param string $post_type post type to override.
 */
function get_count_of_lessons_or_topics_linked_to_courses( $post_type = 'sfwd-lessons' ) {
	$user_id         = get_current_user_id();
	$courses         = learndash_user_get_enrolled_courses( $user_id, [], true );
	$all_courses_ids = get_all_courses_ids_under_group();

	$count = 0;

	// Check if there are courses.
	if ( ! empty( $courses ) ) {
		// Loop through each course.
		foreach ( $courses as $course_id ) {

			$lessons_query = new WP_Query(
				[
					'post_type'      => $post_type,
					'posts_per_page' => -1,
					'meta_query'     => [
						[
							'key'     => 'course_id',
							'value'   => $course_id,
							'compare' => '=',
						],
					],
				]
			);

			if ( $lessons_query->have_posts() ) {
				while ( $lessons_query->have_posts() ) {
					$lessons_query->the_post();
					if ( in_array( learndash_get_course_id( get_the_ID() ), $all_courses_ids, true ) ) {
						$ids[] = get_the_ID();
						++$count;
					}
				}
			}
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		return $ids;
	}
}

/**
 * Return all the lessons | Topics linked to courses.
 *
 * @param string $post_type post type to override.
 */
function fetch_learndash_lessons_with_progress( $post_type = 'sfwd-lessons' ) {

	$current_user_id = get_current_user_id();
	$content         = 'lesson';
	$count           = 0;
	$max_count       = 9;

	if ( 'sfwd-topic' === $post_type ) {
		$content = 'topic';
	}

	// Arguments for getting all the published LearnDash lessons.
	$args = [
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'nopaging'    => true,
	];

	// Perform the query to get the lessons.
	$lm_query = new WP_Query( $args );

	// Loop through the lessons obtained in the query.
	if ( $lm_query->have_posts() ) {
		while ( $lm_query->have_posts() && $count < $max_count ) {
			$lm_query->the_post();

			// Get the current lesson ID.
			$lesson_id = get_the_ID();
			// Get course ID that the lesson is associated with.
			$course_id = learndash_get_course_id( $lesson_id );
			// Check if the course exists and get the user's progress.
			if ( $course_id ) {
				$course_progress = learndash_user_get_course_progress( $current_user_id, $course_id );
				$progress        = learndash_lesson_progress( get_the_ID() );
				if ( 0 < $progress['percentage'] && ( 'in_progress' === $course_progress['status'] || 'completed' === $course_progress['status'] ) ) {
					get_template_part(
						'template-parts/content',
						$content,
						[
							'enrolled' => [ get_the_ID() ],
						]
					);
					$count++;
				}
			}
		}
		wp_reset_postdata();
	} else {
		echo 'No lessons found.';
	}
}

/**
 * AJAX handler function - Fetch lessons.
 *
 * @return void
 */
function fetch_learndash_lessons_ajax() {
	fetch_learndash_lessons_with_progress();
	wp_die();
}
add_action( 'wp_ajax_fetch_learndash_lessons', 'fetch_learndash_lessons_ajax' );
add_action( 'wp_ajax_nopriv_fetch_learndash_lessons', 'fetch_learndash_lessons_ajax' );

/**
 * AJAX handler function - Fetch Topics.
 *
 * @return void
 */
function fetch_learndash_topics_ajax() {
	fetch_learndash_lessons_with_progress( 'sfwd-topic' );
	wp_die();
}
add_action( 'wp_ajax_fetch_learndash_topics', 'fetch_learndash_topics_ajax' );
add_action( 'wp_ajax_nopriv_fetch_learndash_topics', 'fetch_learndash_topics_ajax' );

/**
 * Shortcode for SVG.
 *
 * @param Array  $atts default\override attributes.
 * @param String $content content of field.
 */
function svg_shortcode( $atts, $content = null ) { // phpcs:ignore
	$svg = '';
	if ( is_array( $atts ) && 'badge-check' === $atts['icon'] ) {
		$svg = get_svg( 'icons/badge-check', false );
	}
	if ( is_array( $atts ) && 'badge' === $atts['icon'] ) {
		$svg = get_svg( 'icons/badge', false );
	}
	return '<span>' . $svg . '</span>';
}
add_shortcode( 'SVG', 'svg_shortcode' );

/**
 * Shortcode for Quiz 100% result.
 *
 * @param Array  $atts default\override attributes.
 * @param String $content content of field.
 */
function quiz_complete_shortcode( $atts, $content = null ) { // phpcs:ignore
	return '<p class="text-center font-semibold">Yay! You\'ve won a Badge. Go to <a class="text-primary-color" href="/dashboard/#badge" target="_blank" rel="noopener">Dashboard</a> to download it.</p>';
}
add_shortcode( 'QuizPassed', 'quiz_complete_shortcode' );

/**
 * Shortcode for Quiz 0% result.
 *
 * @param Array  $atts default\override attributes.
 * @param String $content content of field.
 */
function quiz_failed_shortcode( $atts, $content = null ) { // phpcs:ignore
	return '<p class="text-center font-semibold">Let\'s try again?</p>';
}
add_shortcode( 'QuizFailed', 'quiz_failed_shortcode' );

/**
 * Remove RankMath's TOC div and video URLs from content
 *
 * @param array $num_words number of words.
 * @param array $more more text.
 *
 * @return updated $content.
 */
function lm_clean_content( $num_words = 30, $more = '...' ) {
	// Removing RankMath TOC.
	$content = get_the_content();
	$content = preg_replace( "/<div[^>]*id=\"rank-math-toc\"[^>]*>.*?<\/div>/is", '', $content ); // phpcs:ignore.

	// Pattern for videos.
	$regex_pattern = '/\bhttps?:\/\/\S+/i';

	return html_entity_decode( preg_replace( $regex_pattern, '', wp_trim_words( $content, $num_words, $more ) ) );
}

/**
 * Get Quiz Id completed by user.
 *
 * @param number $user_id current user id.
 */
function get_all_quizzes_completed_by_user( $user_id ) {
	global $wpdb;

	// Table name with prefix.
	$user_activity_table = $wpdb->prefix . 'learndash_user_activity';

	// Get all completed quiz attempts by the user.
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT activity_id, post_id AS quiz_id, activity_completed
			FROM $user_activity_table
			WHERE user_id = %d AND activity_type = %s AND activity_completed > 0",
			$user_id,
			'quiz'
		)
	);

	// Debugging: Check the query.
	if ( is_null( $results ) ) {
		return 'Query returned null';
	} elseif ( empty( $results ) ) {
		return 'No completed quizzes found';
	}

	return $results;
}

/**
 * Add missing alt text to images for Topic Materials tab.
 *
 * @param array $content default content.
 */
function add_missing_alt_text_to_images( $content ) {
	if ( false === strpos( $content, 'ld-tab-content ld-visible' ) ) {
		return $content;
	}
	$content = preg_replace_callback(
		'/<img([^>]*?)src="([^"]+)"([^>]*?)>/',
		function ( $matches ) {
			$img_tag                   = $matches[0];
			$img_attributes_before_src = $matches[1];
			$img_src                   = $matches[2];
			$img_attributes_after_src  = $matches[3];

			$img_filename = pathinfo( $img_src, PATHINFO_FILENAME );

			// Replace hyphens and underscores with spaces, and capitalize words.
			$alt_text = ucwords( str_replace( [ '-', '_' ], ' ', $img_filename ) );

			// Check if alt attribute is missing or empty.
			if ( strpos( $img_tag, 'alt=' ) === false ) {
				// Add new alt attribute.
				$new_img_tag = '<img' . $img_attributes_before_src . ' alt="Materials for ' . $alt_text . '" src="' . $img_src . '"' . $img_attributes_after_src . '>';
			} else {
				// Replace empty alt attribute.
				$new_img_tag = preg_replace( '/alt=""/', 'alt="Materials for ' . $alt_text . '"', $img_tag );
			}

			return $new_img_tag;
		},
		$content
	);
	return $content;
}
add_filter( 'learndash_content', 'add_missing_alt_text_to_images' );

/**
 * Limit image upload to 750 KB.
 *
 * @param string $file default image file type.
 */
function limit_image_size_to_750kb( $file ) {
	// Check if the uploaded file is an image.
	if ( strpos( $file['type'], 'image' ) !== false ) {
		// Convert file size to KB.
		$file_size_in_kb = $file['size'] / 1024;
		// Set the limit to 750KB.
		$max_file_size_in_kb = 750;

		// Check if the file size exceeds the limit.
		if ( $file_size_in_kb > $max_file_size_in_kb ) {
			$file['error'] = 'Image size must be less than 750KB';
		}
	}
	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'limit_image_size_to_750kb' );

/**
 * Get random light colors.
 */
function get_random_light_color() {
	$hue        = wp_rand( 0, 360 );
	$saturation = wp_rand( 20, 40 );
	$lightness  = wp_rand( 85, 95 );
	return "hsl($hue, $saturation%, $lightness%)";
}

/**
 * Show 36 posts on author posts.
 *
 * @param array $query default query.
 */
function modify_author_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_author() ) {
		$query->set( 'posts_per_page', 36 );
	}
}
add_action( 'pre_get_posts', 'modify_author_query' );
