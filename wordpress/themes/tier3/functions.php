<?php
/**
 * Tier3 block theme.
 *
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

define( 'TIER3_SEED_VERSION', 1 );

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/blocks.php';
require get_template_directory() . '/inc/seed.php';

add_action(
	'after_setup_theme',
	static function (): void {
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/theme.css' );
		add_filter(
			'document_title_separator',
			static fn () => '—'
		);
	}
);

add_filter(
	'block_categories_all',
	static function ( array $categories ): array {
		array_unshift(
			$categories,
			array(
				'slug'  => 'tier3',
				'title' => 'Tier3',
			)
		);
		return $categories;
	}
);

add_action(
	'enqueue_block_assets',
	static function (): void {
		$path = get_theme_file_path( 'assets/css/theme.css' );
		wp_enqueue_style(
			'tier3-theme',
			get_theme_file_uri( 'assets/css/theme.css' ),
			array(),
			(string) filemtime( $path )
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	static function (): void {
		$path = get_theme_file_path( 'assets/js/theme.js' );
		wp_enqueue_script(
			'tier3-theme',
			get_theme_file_uri( 'assets/js/theme.js' ),
			array(),
			(string) filemtime( $path ),
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}
);

add_action(
	'wp_head',
	static function (): void {
		if ( ! is_front_page() ) {
			return;
		}
		echo '<meta name="description" content="' . esc_attr( 'Discover Tier3 Media’s Growtox Schedule-Filler System for aesthetic practices. Explore client stories and see if your practice qualifies.' ) . '">' . "\n";
		echo '<meta name="theme-color" content="#ff5151">' . "\n";
	},
	1
);

add_filter(
	'upload_mimes',
	static function ( array $mimes ): array {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
);

add_filter(
	'wp_check_filetype_and_ext',
	static function ( array $data, string $file, string $filename, ?array $mimes ): array {
		unset( $file, $mimes );
		if ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) ) === 'svg' ) {
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		return $data;
	},
	10,
	4
);

add_action( 'after_switch_theme', 'tier3_seed' );
