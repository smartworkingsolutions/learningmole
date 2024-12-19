<?php
/**
 * The ACF template part for displaying Resources posts.
 *
 * @package LearningMole
 */

$heading  = get_sub_field( 'heading' );
$desc     = get_sub_field( 'description' );
$post_ids = get_sub_field( 'select_posts' );

if ( ! $heading && ! $desc && ! $post_ids ) {
	return;
}
?>

<section class="w-full">
	<div class="container">

		<?php
		if ( $heading || $desc ) {
			echo '<div class="grid gap-6 justify-center text-center">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color font-bold leading-none">' . wp_kses_post( $heading ) . '</h2>';
			}
			if ( $desc ) {
				echo '<p class="text-lg">' . wp_kses_post( $desc ) . '</p>';
			}
			echo '</div>';
		}

		if ( $post_ids ) {
			?>

			<div class="text-lg font-semibold text-primary-color mt-8 mb-3">Filter by Category</div>
			<div class="flex flex-wrap gap-4 text-base">
				<button class="bg-primary-color text-white px-6 py-1" data-filter="all">All</button>
				<?php
				$unique = [];
				foreach ( $post_ids as $ids ) {
					$terms = wp_get_object_terms( $ids, 'resource-categories', [ 'hide_empty' => true ] );

					foreach ( $terms as $tm ) {
						if ( 0 === $tm->parent ) {
							continue;
						}
						if ( ! in_array( $tm->slug, $unique, true ) ) {
							$unique[] = $tm->slug;
							printf(
								'<button class="bg-primary-color text-white px-6 py-1" data-filter=".%1$s">%2$s</button>',
								esc_html( $tm->slug ),
								esc_html( $tm->name )
							);
						}
					}
				}
				?>
			</div>

			<?php
		}

		$args = [
			'post_type'      => 'learning-resources',
			'posts_per_page' => '-1',
			'post__in'       => $post_ids,
			'orderby'        => 'post__in',
		];

		$query = new WP_Query( $args );

		if ( ! $query->have_posts() ) {
			echo '<p class="mt-8">No posts found.</p>';
		}
		if ( ! $post_ids ) {
			echo '<p class="mt-8">Please select posts.</p>';
		}

		echo '<div class="filter-posts | grid md:grid-cols-2 lg:grid-cols-4 gap-6 mt-10">';

		while ( $query->have_posts() ) :
			$query->the_post();

			$img_url  = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			$file_url = get_field( 'resource_file', get_the_ID() );
			$unique   = [];

			$terms = get_the_terms( get_the_id(), 'resource-categories' );
			if ( $terms ) {
				foreach ( $terms as $tm ) {
					if ( 0 === $tm->parent ) {
						continue;
					}
					if ( ! in_array( $tm->slug, $unique, true ) ) {
						$unique[]       = $tm->slug;
						$filter_classes = $tm->slug;
					}
				}
			}

			if ( $img_url ) {
				$img_html = '<img class="w-auto h-[250px] mx-auto object-scale-down border border-primary-color rounded" src="' . $img_url . '" alt="' . get_the_title() . '">';
			}

			$categories_list = get_the_category_list( ', ', 'learningmole' );

			if ( $post_ids ) {
				printf(
					'<article class="mix | grid bg-white border border-primary-color rounded p-4 %s">
						<a class="grid gap-4 justify-center text-center" href="%s" target="_blank">
							%s
							<h3 class="text-primary-color text-lg font-bold">%s</h3>
						</a>
					</article>',
					esc_html( $filter_classes ),
					esc_url( $file_url ),
					wp_kses_post( $img_html ),
					esc_html( get_the_title() )
				);
			}

		endwhile;
		wp_reset_postdata();

		echo '</div>';
		?>

	</div>
</section>
<?php
// Mix it up JS.
wp_enqueue_script( 'learningmole-mixitup-js', get_template_directory_uri() . '/js/mixitup.min.js', [], null ); //phpcs:ignore
