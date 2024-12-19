<?php
/**
 * Enable SVG file support.
 *
 * @package LearningMole
 */

defined( 'WPINC' ) || exit;

/**
 * Main class for Actions
 */
class Svg_Enable {

	/**
	 * The Construct
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks and Filters.
	 */
	public function hooks() {
		add_filter( 'wp_check_filetype_and_ext', [ $this, 'set_filetype_svg' ], 10, 4 );
		add_filter( 'upload_mimes', [ $this, 'cc_mime_types' ] );
		add_action( 'admin_head', [ $this, 'fix_svg' ] );
	}

	/**
	 * Set filetype.
	 *
	 * @param array $data default.
	 * @param array $file default.
	 * @param array $filename default.
	 * @param array $mimes default.
	 */
	public function set_filetype_svg( $data, $file, $filename, $mimes ) { //phpcs:ignore
		// Wp v4.7.1 and higher.
		$filetype = wp_check_filetype( $filename, $mimes );
		return [
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename'],
		];
	}

	/**
	 * Set mime type.
	 *
	 * @param array $mimes default.
	 */
	public function cc_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Fix SVG styling.
	 */
	public function fix_svg() {
		echo '<style type="text/css">
			.attachment-266x266, .thumbnail img {
				width: 100% !important;
				height: auto !important;
			}
		</style>';
	}

}

// Init.
new Svg_Enable();
