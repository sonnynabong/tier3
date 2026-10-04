<?php
/**
 * Shared markup helpers for section blocks.
 *
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

/**
 * Allow a small HTML subset used in the reference homepage.
 */
function tier3_kses( string $html ): string {
	return wp_kses(
		$html,
		array(
			'br'     => array(),
			'span'   => array( 'class' => true ),
			'strong' => array(),
			'sup'    => array(),
			'em'     => array(),
		)
	);
}

/**
 * Inline stroke icon matching the reference sprite.
 */
function tier3_icon( string $name ): string {
	$paths = array(
		'arrow'      => '<path d="M4 12h15m-6-6 6 6-6 6"/>',
		'arrow-up'   => '<path d="M5 19 19 5M5 5h14v14"/>',
		'arrow-down' => '<path d="M12 4v15m-6-6 6 6 6-6"/>',
	);
	$path = $paths[ $name ] ?? $paths['arrow'];

	return '<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . $path . '</svg>';
}

/**
 * Resolve an attachment or fall back to a theme image file.
 *
 * @return array{src:string,alt:string,width:int,height:int}
 */
function tier3_image( int $id, string $fallback_file, string $fallback_alt = '' ): array {
	if ( $id > 0 ) {
		$src = wp_get_attachment_image_src( $id, 'full' );
		if ( is_array( $src ) ) {
			$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
			return array(
				'src'    => $src[0],
				'alt'    => $alt !== '' ? $alt : $fallback_alt,
				'width'  => (int) $src[1],
				'height' => (int) $src[2],
			);
		}
	}

	return array(
		'src'    => get_theme_file_uri( 'assets/images/' . $fallback_file ),
		'alt'    => $fallback_alt,
		'width'  => 0,
		'height' => 0,
	);
}

function tier3_img_tag( array $image, string $class = '', array $extra = array() ): string {
	$attrs = array(
		'src' => $image['src'],
		'alt' => $image['alt'],
	);
	if ( $class !== '' ) {
		$attrs['class'] = $class;
	}
	if ( $image['width'] > 0 ) {
		$attrs['width'] = (string) $image['width'];
	}
	if ( $image['height'] > 0 ) {
		$attrs['height'] = (string) $image['height'];
	}
	foreach ( $extra as $name => $value ) {
		$attrs[ $name ] = $value;
	}

	$html = '<img';
	foreach ( $attrs as $name => $value ) {
		$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
	}
	return $html . '>';
}

function tier3_link( string $url, string $label, string $class, string $icon = '', bool $blank = false ): string {
	$rel = $blank ? ' target="_blank" rel="noopener noreferrer"' : '';
	$icon_html = $icon !== '' ? ' ' . tier3_icon( $icon ) : '';
	return '<a class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '"' . $rel . '>' . esc_html( $label ) . $icon_html . '</a>';
}

function tier3_str( array $attributes, string $key, string $default = '' ): string {
	$value = $attributes[ $key ] ?? $default;
	return is_string( $value ) ? $value : $default;
}

function tier3_int( array $attributes, string $key, int $default = 0 ): int {
	return isset( $attributes[ $key ] ) ? (int) $attributes[ $key ] : $default;
}
