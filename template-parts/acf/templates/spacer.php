<?php
/**
 * The ACF template part for add Custom space.
 *
 * @package LearningMole
 */

?>

<div class="<?php echo get_sub_field( 'background' ) ? esc_html( 'bg-light-color' ) : esc_html( 'w-full' ); ?>">
	<div class="w-full hidden lg:block" style="height: <?php echo esc_html( get_sub_field( 'add_space' ) ) . 'px;'; ?>"></div>
	<div class="w-full block lg:hidden" style="height: <?php echo esc_html( get_sub_field( 'mobile_space' ) ) . 'px;'; ?>"></div>
</div>
