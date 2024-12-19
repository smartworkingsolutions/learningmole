<?php
/**
 * The template part for displaying Theme changer and button in header.
 *
 * @package LearningMole
 */

$btn = get_field( 'header_button', 'option' );

echo '<div class="header-buttons | items-center gap-4 hidden lg:flex">';

if ( $btn && ! is_user_logged_in() ) {
	echo '<div class="flex items-center gap-16">';
	printf(
		'<div class="hidden md:block"><a href="%s" class="button button-white" target="%s">%s</a></div>',
		esc_url( $btn['url'] ),
		esc_html( $btn['target'] ),
		esc_html( $btn['title'] )
	);
	echo '</div>';
}

add_login_logout_button();

echo '</div>';
