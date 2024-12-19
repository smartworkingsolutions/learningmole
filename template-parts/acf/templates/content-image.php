<?php
/**
 * The ACF template part for displaying Content with image.
 *
 * @package LearningMole
 */

$select_layout    = get_sub_field( 'select_layout' );
$top_image        = get_sub_field( 'top_image' );
$background_color = get_sub_field( 'background_color' );
$count            = get_sub_field( 'count' );
$heading          = get_sub_field( 'heading' );
$s_title          = get_sub_field( 'title' );
$content          = get_sub_field( 'content' );
$image            = get_sub_field( 'image' );
$btn              = get_sub_field( 'button' );
$class            = '';
$layout_class     = '';

if ( ! $top_image && ! $background_color && ! $heading && ! $s_title && ! $content && ! $image && ! $btn ) {
	return;
}

if ( $background_color ) {
	$class = ' bg-light-color';
}
if ( 'image' === $select_layout ) {
	$layout_class = ' lg:-order-1';
}
?>

<section class="w-full<?php echo esc_html( $class ); ?>">
	<?php
	if ( $top_image ) {
		echo '<img class="w-full object-cover -translate-y-full" src="' . esc_url( $top_image ) . '" alt="Section top image" />';
	}
	?>
	<div class="container">

		<?php
		if ( $heading ) {
			echo '<h2 class="text-3xl md:text-4xl text-primary-color text-center leading-none mb-8 md:mb-16">' . esc_html( $heading ) . '</h2>';
		}
		?>

		<div class="grid lg:grid-cols-2 items-center gap-6 lg:gap-10">
			<div class="grid">
				<?php
				if ( $count ) {
					echo '<div class="text-42 font-bold text-primary-color mb-10">' . esc_html( $count ) . '</div>';
				}
				if ( $s_title ) {
					echo '<h2 class="text-2xl font-bold mb-6">' . esc_html( $s_title ) . '</h2>';
				}
				if ( $content ) {
					echo '<div class="wysiwyg-editor gap-8 mb-6">' . wp_kses_post( $content ) . '</div>';
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
			<?php
			if ( $image ) {
				echo '<div class="flex relative hover:scale-105 transition-all duration-300' . esc_html( $layout_class ) . '">';
				echo '<img class="w-full max-w-[600px] max-h-[310px] aspect-[60/31] object-cover md:shadow-green rounded-10" src="' . esc_url( $image ) . '" alt="' . esc_html( $s_title ) . '">';
				echo '<div class="hidden md:block w-full max-w-[600px] max-h-[310px] h-full border-dashed border-2 border-primary-color rounded-10 absolute top-2.5 left-2.5"></div>';
				echo '</div>';
			}
			?>
		</div>

	</div>
</section>
