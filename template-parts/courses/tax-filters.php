<?php
/**
 * The template part for displaying filters in course archive.
 *
 * @package LearningMole
 */

$tax_cat = $args['tax_cat'];
$tax_tag = $args['tax_tag'];
$current = $args['current'];

$current_cat = '';
$current_tag = '';
$parent_cat  = $args['parent'];

$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

if ( isset( $_GET['cat'] ) || isset( $_GET['tag'] ) || isset( $_GET['parent'] ) ) { // phpcs:ignore
	$current_cat = $_GET['cat']; // phpcs:ignore
	$current_tag = $_GET['tag']; // phpcs:ignore
	$parent_cat  = $_GET['parent']; // phpcs:ignore
}
?>
<aside class="w-full min-w-[280px] lg:max-w-[280px] grid gap-6">

	<h2 class="text-2xl font-bold"><?php esc_html_e( 'Filters', 'learningmole' ); ?></h2>

	<div class="widget | grid gap-3 bg-white border border-border-color px-4 rounded-md">
		<form id="searchform" class="search-form | flex justify-between items-center m-0" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" autocomplete="off" accept-charset="utf-8">
			<input type="text" id="keyword" class="search-input | text-sm font-normal tracking-normal w-full border-none focus:border-none focus:outline-none focus:ring-0 bg-transparent px-0" name="s" autocomplete="off" placeholder="Search video..." value="<?php echo get_search_query(); ?>" onkeyup="learnmole_fetch_topics()">
			<?php if ( is_user_logged_in() ) { ?>
			<input type="hidden" name="post_type[]" value="sfwd-topic" />
			<?php } ?>
			<button class="search-submit | w-5 h-5 flex text-text-color"><?php get_svg( 'icons/search' ); ?></button>
		</form>
	</div>

	<div class="widget | hidden lg:grid gap-3 bg-white border border-border-color p-6 rounded-md">
		<h3 class="text-base font-bold tracking-px">Categories</h3>
		<div class="grid gap-2">
			<?php
			$terms_cat = get_terms(
				$tax_cat,
				[
					'parent'     => $parent_cat,
					'orderby'    => 'slug',
					'hide_empty' => false,
				]
			);
			if ( $terms_cat && ! is_wp_error( $terms_cat ) ) :
				foreach ( $terms_cat as $tm ) :
					?>
					<div class="radio-group | flex gap-2">
						<input type="checkbox" value="<?php echo esc_attr( $tm->slug ); ?>" name="cat_filter[]" class="tax-filter | focus:ring-0 focus:ring-offset-0 mt-px" id="<?php echo esc_attr( $tm->slug ); ?>" <?php echo $tm->slug === $current_term->slug || $tm->term_id === (int) $current_cat ? 'checked' : ''; ?> />
						<label class="text-sm font-normal tracking-normal" for="<?php echo esc_attr( $tm->slug ); ?>"><?php echo esc_html( ucfirst( $tm->name ) ); ?></label>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>

	<div class="widget | hidden lg:grid gap-3 bg-white border border-border-color p-6 rounded-md">
		<h3 class="text-base font-bold tracking-px">Tags</h3>
		<div class="grid gap-2">
			<?php
			$terms_tag = get_terms( $tax_tag );
			if ( $terms_tag && ! is_wp_error( $terms_tag ) ) :
				foreach ( $terms_tag as $tm ) :
					?>
					<div class="radio-group | flex gap-2">
						<input type="checkbox" value="<?php echo esc_attr( $tm->slug ); ?>" name="tag_filter[]" class="tax-filter | focus:ring-0 focus:ring-offset-0 mt-px" id="<?php echo esc_attr( $tm->slug ); ?>" <?php echo $tm->slug === $current_term->slug || $tm->term_id === (int) $current_tag ? 'checked' : ''; ?> />
						<label class="text-sm font-normal tracking-normal" for="<?php echo esc_attr( $tm->slug ); ?>"><?php echo esc_html( ucfirst( $tm->name ) ); ?></label>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
	<a href="/<?php echo esc_html( $current ); ?>/" class="hidden lg:flex button"><?php esc_html_e( 'Reset all filters', 'learningmole' ); ?></a>
</aside>
