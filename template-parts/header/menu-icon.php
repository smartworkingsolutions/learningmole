<?php
/**
 * The template part for displaying icons in header.
 *
 * @package LearningMole
 */

?>

<div
	x-data="{ open: false }"
	x-on:search-open.window="open = ! open"
	class="hover:text-primary-color cursor-pointer"
>
	<button x-data @click="$dispatch('search-open')" class="w-6 h-6 flex" role="button" aria-label="Search icon"><?php get_svg( 'icons/search' ); ?></button>
</div>
<div
	x-data="{ open: false }"
	x-on:menu-open.window="open = ! open"
	:class="{ 'active-menu': open }"
	class="flex items-center gap-3 xl:hidden"
>
	<button x-data @click="$dispatch('menu-open')" class="mobile-menu-button | grid gap-1.5" role="button" aria-label="Menu icon">
		<span class="w-7 h-0.5 bg-text-color transition ease-out duration-300"></span>
		<span class="w-7 h-0.5 bg-text-color transition ease-out duration-300"></span>
		<span class="w-7 h-0.5 bg-text-color transition ease-out duration-300"></span>
	</button>
</div>
