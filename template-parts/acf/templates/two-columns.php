<?php
/**
 * The ACF template part for displaying Custom HTML in 2 columns.
 *
 * @package LearningMole
 */

$column1        = get_sub_field( 'two_columns_text_1' );
$column2        = get_sub_field( 'two_columns_text_2' );
$col_graphics_1 = get_sub_field( 'column_graphics_1' );
$col_graphics_2 = get_sub_field( 'column_graphics_2' );
$reverse        = get_sub_field( 'reverse' );

$class = '';
if ( $reverse ) {
	$class = ' order-first lg:order-none';
}
?>

<section class="w-full overflow-hidden">
	<div class="container relative">

		<div class="grid lg:grid-cols-2 items-center gap-10">
			<?php
			if ( $column1 ) {
				echo '<div class="wysiwyg-editor | w-full gap-8 relative">';
				echo do_shortcode( $column1 );
				if ( $col_graphics_1 ) {
					echo '<svg class="hidden lg:block absolute -left-[107px] top-1/2 -translate-y-1/2" width="107" height="16" viewBox="0 0 107 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M91 8.00001C91 12.4183 94.5817 16 99 16C103.418 16 107 12.4183 107 8.00001C107 3.58173 103.418 9.04111e-06 99 8.65486e-06C94.5817 8.2686e-06 91 3.58173 91 8.00001ZM-1.31134e-07 9.5L99 9.50001L99 6.50001L1.31134e-07 6.5L-1.31134e-07 9.5Z" fill="#13ABB0"/></svg>';
				}
				echo '</div>';
			}
			if ( $column2 ) {
				echo '<div class="wysiwyg-editor | w-full gap-8 relative' . esc_html( $class ) . '">';
				echo do_shortcode( $column2 );
				if ( $col_graphics_2 ) {
					echo '<svg class="hidden lg:block absolute -right-[107px] top-1/2 -translate-y-1/2" width="107" height="16" viewBox="0 0 107 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 8C-3.86258e-07 12.4183 3.58172 16 8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 3.86258e-07 8 0C3.58172 -3.86258e-07 3.86258e-07 3.58172 0 8ZM8 9.5L107 9.50001L107 6.50001L8 6.5L8 9.5Z" fill="#13ABB0"/></svg>';
				}
				echo '</div>';
			}
			?>
		</div>

	</div>
</section>
