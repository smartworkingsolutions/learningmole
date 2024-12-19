<?php
/**
 * The template part for displaying Main menu in header.
 *
 * @package LearningMole
 */

// Define arguments for wp_nav_menu().
$menu_args = [
	'theme_location'  => 'main-menu',
	'container'       => 'nav',
	'container_class' => 'main-menu',
	'menu_class'      => 'menu | hidden xl:flex gap-10',
	'walker'          => new Custom_Menu_Walker(),
];

// Display the menu.
wp_nav_menu( $menu_args );
