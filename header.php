<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and header
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package LearningMole
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width"> -->
	<meta name="viewport" content="initial-scale=1, maximum-scale=2, width=device-width">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text sr-only" href="#menu-primary-1"><?php esc_html_e( 'Skip to content', 'learningmole' ); ?></a>

<div id="page" class="main-content w-full max-w-full">

	<?php theme_header_html(); ?>

	<?php
	/**
	 * Add content after header.
	 *
	 * @hooked get_featured_section - 10
	 * (outputs Featured title with BG)
	 */
	do_action( 'learningmole_after_header' );
	?>
