<?php
/**
 * ACF Options Panel
 *
 * @package LearningMole
 */

defined( 'WPINC' ) || exit;

/**
 * Main Class.
 */
class ACF_Options_Panel {

	/**
	 * The Constructor
	 */
	public function __construct() {
		add_action( 'acf/init', [ $this, 'acf_op_init' ] );
	}

	/**
	 * ACF Options panel init.
	 */
	public function acf_op_init() {

		// Check function exists.
		if ( function_exists( 'acf_add_options_page' ) ) {

			// Add parent.
			$parent = acf_add_options_page(
				[
					'page_title' => __( 'Theme Settings', 'learningmole' ),
					'menu_title' => __( 'Theme Settings', 'learningmole' ),
					'icon_url'   => 'dashicons-admin-settings',
					'position'   => '5.3',
				]
			);

			// Add sub page.
			$child = acf_add_options_page(
				[
					'page_title'  => __( 'General Settings', 'learningmole' ),
					'menu_title'  => __( 'General', 'learningmole' ),
					'parent_slug' => $parent['menu_slug'],
				]
			);

			// Add sub page.
			$child = acf_add_options_page(
				[
					'page_title'  => __( 'Header Settings', 'learningmole' ),
					'menu_title'  => __( 'Header', 'learningmole' ),
					'parent_slug' => $parent['menu_slug'],
				]
			);

			// Add sub page.
			$child = acf_add_options_page(
				[
					'page_title'  => __( 'Footer Settings', 'learningmole' ),
					'menu_title'  => __( 'Footer', 'learningmole' ),
					'parent_slug' => $parent['menu_slug'],
				]
			);

		}
	}

}

new ACF_Options_Panel();
