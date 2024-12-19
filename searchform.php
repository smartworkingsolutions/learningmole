<?php
/**
 * The template for displaying search form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package LearningMole
 */

?>

<form id="searchform" class="search-form flex justify-between items-center" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" accept-charset="utf-8">
	<input type="text" class="search-input w-full border-none focus:border-none focus:outline-none focus:ring-0 bg-transparent px-0" name="s" autocomplete="off" placeholder="Search here..." value="<?php echo get_search_query(); ?>">
	<input type="hidden" name="post_type[]" value="post" />
	<?php if ( is_user_logged_in() ) { ?>
	<input type="hidden" name="post_type[]" value="sfwd-courses" />
	<!-- <input type="hidden" name="post_type[]" value="sfwd-lessons" /> -->
	<input type="hidden" name="post_type[]" value="sfwd-topic" />
	<?php } ?>
	<button class="search-submit | w-6 h-6 flex text-text-color" type="submit"><?php get_svg( 'icons/search' ); ?></button>
</form>
