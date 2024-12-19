<?php
/**
 * The template part for displaying mobile menu in header.
 *
 * @package LearningMole
 */

?>

<div x-data="{ open: false }">
	<div
		class="w-80 h-full bg-light-color p-6 fixed top-0 z-20 overflow-y-scroll"
		x-show="open"
		x-on:menu-open.window="open = ! open"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="-translate-x-[9999px]"
		x-transition:leave="transition ease-in duration-300"
		x-transition:leave-end="translate-x-0"
		x-cloak
		>

		<?php theme_logo(); ?>

		<?php
		// Define arguments for wp_nav_menu().
		$menu_args = [
			'theme_location'  => 'main-menu',
			'container'       => 'nav',
			'container_class' => 'main-menu',
			'menu_class'      => 'menu | grid xl:hidden gap-4 mt-6',
			'walker'          => new Custom_Menu_Walker(),
		];

		// Display the menu.
		wp_nav_menu( $menu_args );
		?>

		<div class="clone | lg:hidden"></div>
	</div>
</div>
