<?php
/**
 * The ACF template part for displaying all Sub categories under parent category.
 *
 * @package LearningMole
 */

?>

<section class="w-full">
	<div class="container">

		<?php
		$parent_cat  = get_sub_field( 'select_category' );
		$filter_link = '';

		$terms_cat = get_terms(
			'ld_topic_category',
			[
				'parent'     => $parent_cat,
				'orderby'    => 'slug',
				'hide_empty' => false,
			]
		);

		if ( $terms_cat && ! is_wp_error( $terms_cat ) ) :
			echo '<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-10">';
			foreach ( $terms_cat as $tm ) :

				$icon  = get_field( 'icon', 'term_' . $tm->term_id );
				$color = get_field( 'color', 'term_' . $tm->term_id );

				if ( $tm->slug ) {
					// $filter_link = '/filter/?parent=' . $parent_cat . '&cat=' . $tm->term_id;
					$filter_link = '/topic-category/' . $tm->slug . '/';
				}
				if ( $icon ) {
					$icon_html = '<img class="w-64 h-64 flex absolute top-1/2 -right-10 -translate-y-1/2 opacity-10 z-10" src="' . $icon . '" alt="' . $tm->name . '">';
				} else {
					$icon_html = '';
				}

				printf(
					'<a class="flex flex-col justify-center gap-3 w-full bg-primary-color-100 p-6 rounded-lg overflow-hidden relative" href="%s" style="background-color: %s;">
						<h2 class="text-2xl md:text-3xl font-bold">%s</h2>
						<p class="relative z-10">%s</p>
						%s
						<div><button class="button mt-3">%s</button></div>
					</a>',
					esc_attr( $filter_link ),
					esc_html( $color ),
					esc_html( $tm->name ),
					esc_html( $tm->description ),
					$icon_html, // phpcs:ignore
					esc_html__( 'Learn now', 'learningmole' )
				);
			endforeach;
			echo '</div>';
		endif;
		?>
	</div>
</section>
