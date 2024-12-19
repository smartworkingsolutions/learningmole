<?php
/**
 * The ACF template part for displaying Tab videos.
 *
 * @package LearningMole
 */

$count1 = 1;
$count2 = 1;

if ( ! have_rows( 'tabs' ) && ! have_rows( 'cards' ) ) {
	return;
}
?>

<section class="tab-videos | w-full">
	<div class="container">
	<div class="sm:shadow-custom-big | sm:p-8 lg:p-12">

		<div x-data="{ currentTab: 1 }" class="grid gap-10">
			<?php
			if ( have_rows( 'tabs' ) ) :

				// Loop through tab titles.
				echo '<ul class="grid grid-cols-2 sm:flex sm:flex-wrap gap-2 sm:gap-8">';
				while ( have_rows( 'tabs' ) ) :
					the_row();

					// Load sub field value.
					$tab_title = get_sub_field( 'title' );

					if ( $tab_title ) {
						?>
						<li @click="currentTab = <?php echo esc_html( $count1 ); ?>">
							<button class="grid place-content-center w-full sm:w-fit h-10 text-sm sm:text-base font-semibold border-2 border-primary-color rounded-10 px-4 sm:px-6" :class="currentTab === <?php echo esc_html( $count1 ); ?> ? 'bg-primary-color text-white' : 'text-primary-color'"><?php echo esc_html( $tab_title ); ?></button>
						</li>
						<?php
					}
					++$count1;

				endwhile;
				echo '</ul>';

				// Loop through tab contents.
				echo '<div>';
				while ( have_rows( 'tabs' ) ) :
					the_row();

					$tab_title = get_sub_field( 'title' );

					if ( $tab_title ) {
						?>
						<div x-show="currentTab === <?php echo esc_html( $count2 ); ?>">
							<?php
							// Inside loop for tab columns.
							if ( have_rows( 'columns' ) ) :

								echo '<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">';

								while ( have_rows( 'columns' ) ) :
									the_row();

									// Load sub field value.
									$column = get_sub_field( 'column' );

									if ( $column ) {
										echo '<div class="wysiwyg-editor | w-full gap-2.5 text-center">';
										echo do_shortcode( $column );
										echo '</div>';
									}

								endwhile;

								echo '</div>';

							endif;
							?>
						</div>
						<?php
					}
					++$count2;

				endwhile;
				echo '</div>';

			endif;
			?>

		</div>

		<!-- Bottom cards -->
		<?php
		if ( have_rows( 'cards' ) ) :

			// Loop through tab titles.
			echo '<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-9">';
			while ( have_rows( 'cards' ) ) :
				the_row();

				// Load sub field value.
				$text_1 = get_sub_field( 'text_1' );
				$text_2 = get_sub_field( 'text_2' );

				if ( $text_1 || $text_2 ) {
					echo '<div class="grid place-content-center gap-6 bg-light-color px-8 py-12 text-center border-b-8 border-primary-color rounded-10">';
					if ( $text_1 ) {
						echo '<div class="text-42 leading-none font-semibold">';
						echo wp_kses_post( $text_1 );
						echo '</div>';
					}
					if ( $text_2 ) {
						echo '<div class="text-32 leading-none text-primary-color font-semibold">';
						echo wp_kses_post( $text_2 );
						echo '</div>';
					}
					echo '</div>';
				}

			endwhile;
			echo '</div>';

		endif;
		?>

	</div>
	</div>
</section>
