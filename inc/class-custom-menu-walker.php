<?php
/**
 * Menu Walker.
 *
 * @package LearningMole
 */

defined( 'WPINC' ) || exit;

/**
 * Main class
 */
class Custom_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Menu start.
	 *
	 * @param string  $output output of menu.
	 * @param integer $depth depth/level of menu items.
	 * @param array   $args default args of menu.
	 *
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) { // phpcs:ignore
		$indent  = str_repeat( "\t", $depth );
		$submenu = ( $depth > 0 ) ? 'submenu' : '';
		$output .= "\n$indent<ul class=\"dropdown-menu | xl:space-y-3 absolute top-[112px] hidden $submenu bg-white p-4 shadow-md\">\n";
	}

	/**
	 * Menu el.
	 *
	 * @param string  $output output of menu.
	 * @param array   $item default menu item.
	 * @param integer $depth depth/level of menu items.
	 * @param array   $args default args of menu.
	 * @param integer $id default ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? [] : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$caret = '';
		$count = 0;

		// Check if mega menu is enabled.
		$enable_mega_menu = get_field( 'enable_mega_menu', $item );

		if ( 0 === $depth && $enable_mega_menu ) {
			$classes[] = 'mega-menu';
			$caret     = '<span class="caret | w-4 h-4 fill-text-color translate-y-px">' . get_svg( 'icons/carret-down', false ) . '</span>';
		}
		if ( 0 === $depth && $args->walker->has_children ) {
			$caret = '<span class="caret | w-4 h-4 fill-text-color translate-y-px">' . get_svg( 'icons/carret-down', false ) . '</span>';
		}

		$args = (object) $args;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts               = [];
		$atts['title']      = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']     = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']        = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']       = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-label'] = ! empty( $item->description ) ? $item->description : '';

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . ' class="flex items-center gap-1 justify-between xl:justify-normal font-semibold lg:tracking-px">';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= $caret . '</a>';

		// Mega Menu Content.
		if ( 0 === $depth && $enable_mega_menu ) {
			$item_output .= '<div class="mega-menu-container | w-full bg-light-color xl:border-b xl:border-border-color hidden xl:absolute xl:left-0 xl:right-0 xl:top-[112px] xl:p-12 z-10">';

			$item_output .= '<div class="grid xl:grid xl:grid-flow-col xl:auto-cols-fr xl:gap-6 items-start">';

			if ( have_rows( 'mega_menu_columns', $item ) ) :
				while ( have_rows( 'mega_menu_columns', $item ) ) :
					the_row();

					$menu_title   = get_sub_field( 'title', $item );
					$menu_content = get_sub_field( 'content', $item );

					$menu_title_text = wp_strip_all_tags( $menu_title );

					if ( $menu_title || $menu_content ) {
						$item_output .= '<div class="hidden xl:flex flex-col gap-6 items-start w-full h-full bg-white p-8 rounded-md shadow border border-primary-color">';
						$item_output .= '<div class="text-xl text-primary-color font-bold">' . wp_kses_post( $menu_title ) . '</div>';
						$item_output .= '<div class="mega-menu-content | grid gap-4 font-semibold">' . wp_kses_post( $menu_content ) . '</div>';
						$item_output .= '</div>';

						// Mobile mega menu.
						$item_output .= '<div x-data="{ open: false }" class="grid gap-3 items-start w-full mt-3 xl:hidden">';

						$item_output .= '<div class="flex justify-between items-center gap-2 cursor-pointer" @click="open=!open">';

							$item_output .= '<div class="font-bold">' . wp_strip_all_tags( $menu_title ) . '</div>';
							$item_output .= '<span class="w-4 h-4 fill-text-color" :class="open ? \'rotate-180\' : \'\'">' . get_svg( 'icons/carret-down', false ) . '</span>';

						$item_output .= '</div>';

						$item_output .= '<div class="grid gap-2 bg-black/5 -mx-6 px-6 py-3" x-show="open" x-cloak>' . wp_kses_post( $menu_content ) . '</div>';

						$item_output .= '</div>';

					}

				endwhile;
			endif;

			$item_output .= '</div>';
			$item_output .= '</div>';
		}

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
