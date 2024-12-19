<?php
/**
 * The ACF template part for displaying Price.
 *
 * @package LearningMole
 */

$heading    = get_sub_field( 'heading' );
$desc       = get_sub_field( 'description' );
$background = get_sub_field( 'enable_background' );

if ( ! $heading && ! $desc && ! have_rows( 'price_lists' ) ) {
	return;
}
if ( $background ) {
	$class = ' bg-light-color';
}
?>

<section id="price" class="w-full<?php echo esc_html( $class ); ?>">
	<div class="container">
	<div class="grid lg:grid-cols-2 items-center gap-10">

		<?php
		if ( $heading || $desc ) {
			echo '<div class="w-full max-w-4xl mx-auto grid gap-6">';
			if ( $heading ) {
				echo '<h2 class="text-3xl md:text-4xl text-primary-color leading-none">' . esc_html( $heading ) . '</h2>';
			}
			if ( $desc ) {
				echo '<div class="wysiwyg-editor | gap-8">';
				echo do_shortcode( $desc );
				echo '</div>';
			}
			echo '</div>';
		}
		if ( have_rows( 'price_lists' ) ) :

			echo '<div class="max-w-3xl mx-auto grid md:grid-cols-2 gap-10">';

			// Loop through rows.
			while ( have_rows( 'price_lists' ) ) :
				the_row();

				// Load sub field value.
				$price_title        = get_sub_field( 'title' );
				$price              = get_sub_field( 'price' );
				$small_text         = get_sub_field( 'small_text' );
				$content            = get_sub_field( 'content' );
				$is_tab             = get_sub_field( 'enable_tab' );
				$m_regular_price    = get_sub_field( 'monthly_regular_price' );
				$m_discount_price   = get_sub_field( 'monthly_discount_price' );
				$y_regular_price    = get_sub_field( 'yearly_regular_price' );
				$y_discount_price   = get_sub_field( 'yearly_discount_price' );
				$monthly_small_text = get_sub_field( 'monthly_small_text' );
				$yearly_small_text  = get_sub_field( 'yearly_small_text' );
				$tab_content1       = get_sub_field( 'tab_content_1' );
				$tab_content2       = get_sub_field( 'tab_content_2' );
				$monthly_button     = get_sub_field( 'monthly_button' );
				$yearly_button      = get_sub_field( 'yearly_button' );
				$button             = get_sub_field( 'button' );
				?>
				<div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'monthly' }" class="grid gap-6 items-start bg-primary-color-200 p-6 rounded-2xl">
					<div class="grid gap-6">
					<?php
					if ( $price_title ) {
						echo '<h2 class="text-base font-bold tracking-px">' . wp_kses_post( $price_title ) . '</h2>';
					}
					if ( ! $is_tab ) {
						if ( $price || $small_text ) {
							echo '<div class="flex items-baseline gap-1">';
							if ( $price ) {
								echo '<p>from</p><span class="text-32 font-bold text-primary-color">' . esc_html( $price ) . '</span>';
							}
							if ( $small_text ) {
								echo '<p class="text-primary-color/50 ml-2">' . esc_html( $small_text ) . '</p>';
							}
							echo '</div>';
						}
					} else {
						if ( $m_regular_price || $m_discount_price ) {
							?>
							<div x-show="tab === 'monthly'" class="flex gap-1 text-32 font-bold text-primary-color">
								<?php
								if ( $m_regular_price ) {
									echo '<span class="!line-through opacity-50">' . esc_html( $m_regular_price ) . '</span>';
								}
								if ( $m_discount_price ) {
									echo '<span>' . esc_html( $m_discount_price ) . '</span>';
								}
								?>
								</div>
							<?php
						}
						if ( $y_regular_price || $y_discount_price ) {
							?>
							<div x-show="tab === 'yearly'" class="flex gap-1 text-32 font-bold text-primary-color">
								<?php
								if ( $y_regular_price ) {
									echo '<span class="!line-through opacity-50">' . esc_html( $y_regular_price ) . '</span>';
								}
								if ( $y_discount_price ) {
									echo '<span>' . esc_html( $y_discount_price ) . '</span>';
								}
								?>
								</div>
							<?php
						}
					}
					if ( ! $is_tab ) {
						// if ( $small_text ) {
						// 	echo '<p class="text-primary-color/50">' . esc_html( $small_text ) . '</p>';
						// }
						if ( $content ) {
							echo '<div class="wysiwyg-editor price">' . wp_kses_post( $content ) . '</div>';
						}
					} else {
						if ( $monthly_small_text ) {
							?>
							<p x-show="tab === 'monthly'" class="text-primary-color/50"><?php echo esc_html( $monthly_small_text ); ?></p>
							<?php
						}
						if ( $yearly_small_text ) {
							?>
							<p x-show="tab === 'yearly'" class="text-primary-color/50"><?php echo esc_html( $yearly_small_text ); ?></p>
							<?php
						}
						?>
						<div>
						<nav class="flex justify-stretch border-2 border-primary-color rounded-md text-base font-bold">
							<button class="w-full h-10" :class="{ 'bg-primary-color text-white': tab === 'monthly' }" @click.prevent="tab = 'monthly'; window.location.hash = 'monthly'">Monthly</button>
							<button class="w-full h-10" :class="{ 'bg-primary-color text-white': tab === 'yearly' }" @click.prevent="tab = 'yearly'; window.location.hash = 'yearly'">Yearly</button>
						</nav>

						<!-- The tabs content -->
						<?php
						if ( $tab_content1 ) {
							?>
							<div x-show="tab === 'monthly'" class="wysiwyg-editor price mt-4"><?php echo wp_kses_post( $tab_content1 ); ?></div>
							<?php
						}
						if ( $tab_content2 ) {
							?>
							<div x-show="tab === 'yearly'" class="wysiwyg-editor price mt-4"><?php echo wp_kses_post( $tab_content2 ); ?></div>
							<?php
						}
						?>

						</div>
						<?php
					}
					echo '</div>';
					if ( ! $is_tab ) {
						if ( $button ) {
							printf(
								'<a href="%s" class="button mt-auto" target="%s">%s</a>',
								esc_url( $button['url'] ),
								esc_html( $button['target'] ),
								esc_html( $button['title'] )
							);
						}
					} else {
						if ( $monthly_button || $yearly_button ) {
							if ( $monthly_button ) {
								?>
								<a x-show="tab === 'monthly'" href="<?php echo esc_url( $monthly_button['url'] ); ?>" class="button mt-auto" target="<?php echo esc_html( $monthly_button['target'] ); ?>"><?php echo esc_html( $monthly_button['title'] ); ?></a>
								<?php
							}
							if ( $yearly_button ) {
								?>
								<a x-show="tab === 'yearly'" href="<?php echo esc_url( $yearly_button['url'] ); ?>" class="button mt-auto" target="<?php echo esc_html( $yearly_button['target'] ); ?>"><?php echo esc_html( $yearly_button['title'] ); ?></a>
								<?php
							}
						}
					}
					?>
				</div>

				<?php
			endwhile;

			echo '</div>';

		endif;
		?>

	</div>
	</div>
</section>
