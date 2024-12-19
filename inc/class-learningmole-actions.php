<?php
/**
 * All custom actions here.
 *
 * @package LearningMole
 */

defined( 'WPINC' ) || exit;

/**
 * Main class for Actions
 */
class LearningMole_Actions {

	/**
	 * The Construct
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks and Filters.
	 */
	public function hooks() {
		add_action( 'learningmole_after_header', [ $this, 'get_featured_section' ], 10 );
		add_action( 'learningmole_after_header', [ $this, 'get_featured_for_other_pages' ], 20 );
		add_action( 'learningmole_after_header', [ $this, 'get_breadcrumb' ], 30 );
		add_action( 'learningmole_after_header', [ $this, 'user_more_info' ], 40 );

		add_action( 'learningmole_before_footer', [ $this, 'extra_category_text' ], 10 );
	}

	/**
	 * Prints HTML of title section after header.
	 */
	public function get_featured_section() {
		if ( is_front_page() || is_page_template( 'page-home.php' ) || is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) || ! is_page() ) {
			return;
		}

		$bg_color      = '#13ABB0';
		$style         = '';
		$default_class = ' py-10 sm:pt-16 sm:pb-16 md:pb-60 mb-10 md:mb-0';
		$cat_class     = ' py-10 sm:pt-16 sm:pb-16 md:pb-56';
		$height        = ' min-h-[550px]';

		$layout_style     = get_field( 'layout_style', get_the_id() );
		$is_wave_diable   = get_field( 'wave_animation', get_the_id() );
		$background_style = get_field( 'background_style', get_the_id() );
		$bg_image         = get_field( 'background_image', get_the_id() );
		$heading          = get_field( 'heading', get_the_id() );
		$content          = get_field( 'content', get_the_id() );
		$btn              = get_field( 'button', get_the_id() );

		if ( $bg_image || $bg_color ) {
			$style = 'style="background-image: url(' . $bg_image . '); background-color: ' . $bg_color . ';"';
		}
		if ( $is_wave_diable ) {
			$default_class = ' py-10 sm:py-16';
			$cat_class     = ' py-10 sm:py-16';
		}
		if ( is_page( 'Pricing' ) ) {
			$btn = '<a href="#price" class="button button-secondary mt-4">' . __( 'Get Started Now', 'learningmole' ) . '</a>';
		}
		if ( is_page( 'maths-videos' ) || is_page( 'english-videos' ) || is_page( 'science-videos' ) || is_page( 'geography-videos' ) || is_page( 'history-videos' ) || is_page( 'digital-skills-videos' ) || is_page( 'life-skills-videos' ) ) {
			$batch = '<div class="flex items-center gap-1.5 text-lg font-semibold text-primary-color bg-primary-color-100 border-2 border-primary-color px-3 py-1 rounded-md absolute top-4 right-4 z-10"><span class="flex w-5 h-5">' . get_svg( 'icons/subscribe', false ) . '</span>Premium Resources</div>';
		}
		if ( 'default' === $layout_style || is_search() ) {
			?>
			<section class="w-full p-16 text-center relative overflow-hidden<?php echo esc_html( $default_class ); ?>" <?php echo $style; //phpcs:ignore ?>>

				<!-- Animate waves -->
				<?php $this->get_waves(); ?>

				<div class="container">
					<?php
					if ( $batch ) {
						echo $batch; // phpcs:ignore
					}
					if ( $heading ) {
						echo '<h1 class="text-3xl md:text-42 font-bold text-white leading-tight">' . esc_html( $heading ) . '</h1>';
					}
					if ( $content ) {
						echo '<p class="text-white text-lg font-semibold leading-relaxed mt-4">' . wp_kses_post( $content ) . '</p>';
					}
					if ( $btn ) {
						echo $btn; // phpcs:ignore
					}
					?>
				</div>
			</section>
			<?php
		}

		if ( 'cat' === $layout_style ) {
			if ( ! $heading && ! $content && ! $btn ) {
				$height = ' min-h-[350px]';
			}
			?>
			<section class="w-full bg-primary-color-200 overflow-hidden<?php echo $is_wave_diable ? '' : '  mb-10 md:mb-0'; ?>">
				<!-- Animate waves -->
				<?php $this->get_waves( $background_style ); ?>

				<div class="container relative">
					<div class="w-full grid items-start<?php echo esc_html( $cat_class ); ?>">
						<div class="max-w-lg grid gap-6">
							<?php
							if ( $batch ) {
								echo $batch; // phpcs:ignore
							}
							if ( $heading ) {
								echo '<h1 class="text-3xl md:text-42 text-primary-color tracking-wide leading-snug drop-shadow-white
								 relative z-[1px]">' . esc_html( $heading ) . '</h1>';
							}
							if ( $content ) {
								echo '<p class="text-primary-color text-lg font-semibold leading-relaxed relative z-[1px]">' . do_shortcode( $content ) . '</p>';
							}
							if ( $btn ) {
								printf(
									'<div><a href="%s" class="button" target="%s">%s</a></div>',
									esc_url( $btn['url'] ),
									esc_html( $btn['target'] ),
									esc_html( $btn['title'] )
								);
							}
							?>
						</div>
						<?php $this->get_cat_bg( $background_style ); ?>
					</div>
				</div>
			</section>
			<?php
		}
	}

	/**
	 * Prints HTML of Background of category pages.
	 *
	 * @param string $layout taget cat/page.
	 */
	public function get_cat_bg( $layout ) {

		if ( 'maths' === $layout ) {
			?>
			<div class="light-svg | absolute left-[38%] top-0 drop-shadow-white"><?php get_svg( 'cat/four' ); ?></div>
			<div class="light-svg | absolute left-[38%] bottom-20 drop-shadow-white"><?php get_svg( 'cat/five' ); ?></div>
			<div class="light-svg | absolute left-[55%] top-[37%] drop-shadow-white"><?php get_svg( 'cat/nine' ); ?></div>
			<div class="light-svg | absolute left-[63%] top-[10%] drop-shadow-white"><?php get_svg( 'cat/plus' ); ?></div>
			<div class="light-svg | absolute left-[74%] top-[9%]"><?php get_svg( 'cat/pi' ); ?></div>
			<div class="light-svg | absolute left-[86%] top-[6%] drop-shadow-white"><?php get_svg( 'cat/divide' ); ?></div>
			<?php
		}
		if ( 'eng' === $layout ) {
			?>
			<div class="light-svg | absolute left-[40%] top-[57%]"><?php get_svg( 'cat/chat' ); ?></div>
			<div class="light-svg | absolute left-[61%] top-[10%]"><?php get_svg( 'cat/b' ); ?></div>
			<div class="light-svg | absolute left-[48%] top-[20%]"><?php get_svg( 'cat/comment' ); ?></div>
			<div class="light-svg | absolute left-[77%] top-[43%]"><?php get_svg( 'cat/text' ); ?></div>
			<div class="light-svg | absolute left-[83%] top-[21%]"><?php get_svg( 'cat/c' ); ?></div>
			<?php
		}
		if ( 'geo' === $layout ) {
			?>
			<div class="light-svg | absolute left-[43%] top-[8%]"><?php get_svg( 'cat/compass' ); ?></div>
			<div class="light-svg | absolute left-[58%] top-[40%]"><?php get_svg( 'cat/pic' ); ?></div>
			<div class="light-svg | absolute left-[38%] top-1/2"><?php get_svg( 'cat/mountain' ); ?></div>
			<div class="light-svg | absolute left-[60%] top-[20%]"><?php get_svg( 'cat/location' ); ?></div>
			<div class="light-svg | absolute left-[77%] top-0"><?php get_svg( 'cat/earth' ); ?></div>
			<?php
		}
		if ( 'skill' === $layout ) {
			?>
			<div class="light-svg | absolute left-[48%] top-[6%]"><?php get_svg( 'cat/think' ); ?></div>
			<div class="light-svg | absolute left-[38%] top-[54%]"><?php get_svg( 'cat/idea' ); ?></div>
			<div class="light-svg | absolute left-[70%] top-[8%]"><?php get_svg( 'cat/zap' ); ?></div>
			<div class="light-svg | absolute left-[53%] top-[43%]"><?php get_svg( 'cat/typing' ); ?></div>
			<div class="light-svg | absolute left-[82%] top-[6%]"><?php get_svg( 'cat/cloud' ); ?></div>
			<?php
		}
		if ( 'science' === $layout ) {
			?>
			<div class="light-svg | absolute left-[90%] top-[35%]"><?php get_svg( 'cat/x' ); ?></div>
			<div class="light-svg | absolute left-[70%] top-[10%]"><?php get_svg( 'cat/dna' ); ?></div>
			<div class="light-svg | absolute left-[55%] top-[15%]"><?php get_svg( 'cat/x-small' ); ?></div>
			<div class="light-svg | absolute left-[40%] top-[35%]"><?php get_svg( 'cat/chain' ); ?></div>
			<?php
		}
		?>
		<div class="light-svg | rounded-full absolute left-[86%] right-0 bottom-0"><?php get_svg( 'cat/mole' ); ?></div>
		<?php
	}

	/**
	 * Prints HTML breadcrumbs.
	 */
	public function get_breadcrumb() {

		if ( is_front_page() || is_page_template( 'page-home.php' ) || is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) || is_404() ) {
			return;
		}
		if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
			echo '<div class="breadcrumb-wrapper | border-b border-border-color py-2">';
			echo '<div class="container text-base">';
			rank_math_the_breadcrumbs();
			echo '</div>';
			echo '</div>';
		}
	}

	/**
	 * Prints HTML of animated waves.
	 */
	public function get_waves() {
		if ( get_field( 'wave_animation', get_the_id() ) || is_archive() || is_search() || is_home() ) {
			return;
		}
		?>
		<div class="w-[6400px] h-[198px] absolute -bottom-7 z-10 animate-waves hidden md:block" style="background-image: url(<?php echo get_template_directory_uri() . '/images/wave.svg'; // phpcs:ignore ?>);"></div>
		<div class="w-[6400px] h-[198px] absolute -bottom-7 z-10 animate-wave-swell hidden md:block" style="background-image: url(<?php echo get_template_directory_uri() . '/images/wave.svg'; // phpcs:ignore ?>);"></div>
		<?php
	}

	/**
	 * Prints HTML of title section after header.
	 */
	public function get_featured_for_other_pages() {
		if ( is_front_page() || is_page_template( 'page-home.php' ) || is_page() || is_404() || is_single() ) {
			return;
		}

		$bg_color = '#13ABB0';
		$bg_image = get_template_directory_uri() . '/images/pattern.png';
		$style    = '';

		$heading = get_the_title( get_the_id() );
		if ( is_archive() ) {
			$heading = get_the_archive_title();
			$desc    = category_description();
		}
		if ( is_search() ) {
			// translators: Search title.
			$heading = sprintf( __( 'Search Results for: %s', 'learningmole' ), '<span>' . get_search_query() . '</span>' );
		}
		if ( is_home() ) {
			$batch   = '<div class="flex items-center gap-1.5 text-lg font-semibold text-primary-color bg-primary-color-100 border-2 border-primary-color-100 px-3 py-1 rounded-md absolute top-4 right-4 z-10"><span class="flex w-5 h-5">' . get_svg( 'icons/book', false ) . '</span>Free Resources</div>';
			$heading = __( 'All Free Resources', 'learningmole' );
		}
		if ( is_post_type_archive( 'sfwd-lessons' ) ) {
			$heading = __( 'Playlists', 'learningmole' );
		}
		if ( is_post_type_archive( 'sfwd-topic' ) ) {
			$heading = __( 'Videos', 'learningmole' );
		}

		if ( $bg_image || $bg_color ) {
			$style = 'style="background-image: url(' . $bg_image . '); background-color: ' . $bg_color . ';"';
		}

		if ( ! is_author() ) {
			?>
			<section class="w-full py-10 sm:py-16 text-center relative overflow-hidden" <?php echo $style; //phpcs:ignore ?>>

				<!-- Animate waves -->
				<?php $this->get_waves(); ?>

				<div class="container">
					<?php
					if ( $batch ) {
						echo $batch; // phpcs:ignore
					}
					if ( $heading ) {
						echo '<h1 class="text-3xl md:text-42 font-bold text-white leading-tight">' . wp_kses_post( $heading ) . '</h1>';
					}
					if ( $desc ) {
						echo '<p class="text-white text-lg font-semibold leading-relaxed relative mt-6 z-[1px]">' . esc_html( $desc ) . '</p>';
					}
					?>
				</div>
			</section>
			<?php
		}
		if ( is_author() ) {
			$curauth = get_queried_object();
			$date    = get_the_author_meta( 'user_registered', $curauth->ID );

			$twitter                = get_field( 'user_twitter_url', 'user_' . $curauth->ID );
			$linkedin               = get_field( 'user_linkedin_url', 'user_' . $curauth->ID );
			$desc                   = get_field( 'short_description', 'user_' . $curauth->ID );
			$favourite_subject      = get_field( 'favourite_subject', 'user_' . $curauth->ID );
			$favourite_tv_character = get_field( 'favourite_tv_character', 'user_' . $curauth->ID );
			?>
			<section class="w-full py-10 md:py-16 relative overflow-hidden" <?php echo $style; //phpcs:ignore ?>>
				<div class="container">

					<div class="grid lg:grid-cols-12 items-start gap-10 lg:gap-16">
						<div class="lg:col-span-7 grid gap-6">
							<div class="grid sm:flex items-center gap-5">
								<?php learningmole_author_avatar( '62' ); ?>
								<div class="grid">
									<div class="flex items-center gap-4">
										<h1 class="text-xl sm:text-2xl font-semibold text-white capitalize"><?php echo esc_html( $curauth->display_name ); ?></h1>
										<?php
										if ( $twitter ) {
											echo '<a class="w-6 h-6 text-white hover:text-secondary-color" href="' . esc_url( $twitter ) . '" target="_blank" rel="nofollow">' . get_svg( 'icons/twitter', false ) . '</a>'; // phpcs:ignore
										}
										if ( $linkedin ) {
											echo '<a class="text-white hover:text-secondary-color" href="' . esc_url( $linkedin ) . '" target="_blank" rel="nofollow">' . get_svg( 'icons/linkedin2', false ) . '</a>'; // phpcs:ignore
										}
										?>
									</div>
									<p class="flex gap-1 text-sm sm:text-base font-semibold text-white">
										<?php
										echo '<span>' . esc_html( count_user_posts( $curauth->ID ) ) . '</span>';
										esc_html_e( 'articles published since', 'learningmole' );
										echo '<span>' . esc_html( gmdate( 'F j, Y', strtotime( $date ) ) ) . '</span>';
										?>
									</p>
								</div>
							</div>
							<?php
							if ( $desc ) {
								echo '<p class="text-base text-white">' . wp_kses_post( $desc ) . '</p>';
							}

							if ( $favourite_subject || $favourite_tv_character ) {
								echo '<div class="grid sm:flex gap-9 mt-10 text-white">';
								if ( $favourite_subject ) {
									echo '<div class="flex items-center gap-2">';
									get_svg( 'icons/book-reader' );
									echo '<div class="grid text-base">';
									echo '<span>' . esc_html__( 'Favourite Subject', 'learningmole' ) . '</span>';
									echo '<span class="font-semibold leading-none">' . esc_html( $favourite_subject ) . '</span>';
									echo '</div>';
									echo '</div>';
								}
								if ( $favourite_tv_character ) {
									echo '<div class="flex items-center gap-2">';
									get_svg( 'icons/tv' );
									echo '<div class="grid text-base">';
									echo '<span>' . esc_html__( 'Favourite TV Character', 'learningmole' ) . '</span>';
									echo '<span class="font-semibold leading-none">' . esc_html( $favourite_tv_character ) . '</span>';
									echo '</div>';
									echo '</div>';
								}
								echo '</div>';
							}
							?>
						</div>
						<div class="lg:col-span-5">
							<?php $this->get_featured_posts_of_author( $curauth ); ?>
						</div>
					</div>

				</div>
			</section>
			<?php
		}
	}

	/**
	 * Featured post cards of Current Author.
	 *
	 * @param array $curauth current user array.
	 */
	public function get_featured_posts_of_author( $curauth ) {

		$featured_posts = get_field( 'featured_posts', 'user_' . $curauth->ID );
		if ( ! $featured_posts ) {
			return;
		}
		$args = [
			'post_type'           => 'post',
			'posts_per_page'      => 2,
			'ignore_sticky_posts' => 1,
			'post__in'            => $featured_posts,
		];

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p class="col-span-full flex justify-center text-white">No post found.</p>';
		}

		echo '<p class="text-white text-base font-semibold text-center capitalize mb-2">' . esc_html( $curauth->display_name ) . esc_html__( '\'s Featured Posts', 'learningmole' ) . '</p>';
		echo '<div class="grid grid-cols-2 gap-4">';
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part( 'template-parts/content-featured', 'blog' );

		endwhile; // End of the loop.
		wp_reset_postdata();

		echo '</div>';
	}

	/**
	 * Get user's more info from ACF fields.
	 */
	public function user_more_info() {
		if ( ! is_author() ) {
			return;
		}
		$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );

		$more_info = get_the_author_meta( 'more_about_user', $curauth->ID );

		?>
		<section class="w-full py-10 md:pt-10 md:pb-14">
			<div class="container">
				<?php
				echo '<div class="wysiwyg-editor | w-full gap-4">';
				echo wp_kses_post( wpautop( $more_info ) );
				echo '</div>';
				?>
			</div>
		</section>
		<?php
	}

	/**
	 * Prints extra category content from ACF fields.
	 */
	public function extra_category_text() {
		$term     = get_queried_object();
		$cat_text = get_field( 'category_content', $term );

		if ( ! is_category() || ! $cat_text ) {
			return;
		}

		?>
		<section class="w-full py-10 md:py-14 border-b border-border-color">
			<div class="container">
				<?php
				echo '<div class="wysiwyg-editor | w-full gap-4">';
				echo wp_kses_post( $cat_text );
				echo '</div>';
				?>
			</div>
		</section>
		<?php
	}

}

// Init.
new LearningMole_Actions();
