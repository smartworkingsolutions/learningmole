<?php
/**
 * The template part for displaying search box in header.
 *
 * @package LearningMole
 */

?>

<div x-data="{ open: false }">
	<div
		class="w-full h-full grid items-center bg-white absolute top-0 z-20"
		x-show="open"
		x-on:search-open.window="open = ! open"
		@click.outside="open = false"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="translate-x-[9999px]"
		x-transition:leave="transition ease-in duration-300"
		x-transition:leave-end="translate-x-0"
		x-cloak
		>
		<div class="container">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>
