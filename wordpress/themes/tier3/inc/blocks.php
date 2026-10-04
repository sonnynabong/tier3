<?php
/**
 * Register homepage section blocks.
 *
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'tier3_register_editor_assets', 5 );
add_action( 'init', 'tier3_register_blocks', 10 );

function tier3_register_editor_assets(): void {
	$path = get_theme_file_path( 'assets/js/editor.js' );
	wp_register_script(
		'tier3-editor',
		get_theme_file_uri( 'assets/js/editor.js' ),
		array(
			'wp-blocks',
			'wp-element',
			'wp-block-editor',
			'wp-components',
			'wp-i18n',
			'wp-server-side-render',
		),
		(string) filemtime( $path ),
		true
	);
}

function tier3_register_blocks(): void {
	$blocks = array( 'hero', 'results', 'case-study', 'growth-band', 'process', 'practices', 'closing' );
	foreach ( $blocks as $block ) {
		register_block_type( get_template_directory() . '/blocks/' . $block );
	}
}
