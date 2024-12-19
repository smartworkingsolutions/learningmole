<?php
/**
 * Register Custom Post Types
 *
 * @package SWS
 */

defined( 'WPINC' ) || exit;

/**
 * Main class of Custom Post Types
 */
class Custom_Post_Types {

	/**
	 * The Construct
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'resources_custom_post_type' ] );
		add_action( 'init', [ $this, 'resources_taxonomy_category' ] );
	}

	/**
	 * Resources CPT
	 */
	public function resources_custom_post_type() {

		// Set UI labels for Custom Post Type.
		$labels = [
			'name'               => _x( 'Resources', 'Post Type General Name', 'learningmole' ),
			'singular_name'      => _x( 'Resource', 'Post Type Singular Name', 'learningmole' ),
			'menu_name'          => __( 'Resources', 'learningmole' ),
			'parent_item_colon'  => __( 'Parent Resource', 'learningmole' ),
			'all_items'          => __( 'All Resources', 'learningmole' ),
			'view_item'          => __( 'View Resource', 'learningmole' ),
			'add_new_item'       => __( 'Add New Resource', 'learningmole' ),
			'add_new'            => __( 'Add New', 'learningmole' ),
			'edit_item'          => __( 'Edit Resource', 'learningmole' ),
			'update_item'        => __( 'Update Resource', 'learningmole' ),
			'search_items'       => __( 'Search Resource', 'learningmole' ),
			'not_found'          => __( 'Not Found', 'learningmole' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'learningmole' ),
		];

		// Set other options for Custom Post Type.
		$args = [
			'label'               => __( 'Resources', 'learningmole' ),
			'menu_icon'           => 'dashicons-open-folder',
			'description'         => __( 'Resource posts', 'learningmole' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor.
			'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
			/**
			 * A hierarchical CPT is like Pages and can have
			 * Parent and child items. A non-hierarchical CPT
			 * is like Posts.
			 */
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => false, // disable single page.
			'capability_type'     => 'post',
			// 'show_in_rest'        => true,

		];

		// Registering your Custom Post Type.
		register_post_type( 'learning-resources', $args );
	}

	/**
	 * Create a custom taxonomy named 'category' for Resources CPT.
	 */
	public function resources_taxonomy_category() {

		$labels = [
			'name'              => _x( 'Categories', 'taxonomy general name', 'learningmole' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'learningmole' ),
			'search_items'      => __( 'Search Categories', 'learningmole' ),
			'all_items'         => __( 'All Categories', 'learningmole' ),
			'parent_item'       => __( 'Parent Category', 'learningmole' ),
			'parent_item_colon' => __( 'Parent Category: ', 'learningmole' ),
			'edit_item'         => __( 'Edit Category', 'learningmole' ),
			'update_item'       => __( 'Update Category', 'learningmole' ),
			'add_new_item'      => __( 'Add New Category', 'learningmole' ),
			'new_item_name'     => __( 'New Category Name', 'learningmole' ),
			'menu_name'         => __( 'Categories', 'learningmole' ),
		];

		register_taxonomy(
			'resource-categories',
			[ 'learning-resources' ],
			[
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => [ 'slug' => 'category' ],
				// 'show_in_rest'      => true,
			]
		);
	}

}

/**
 * Init
 */
new Custom_Post_Types();
