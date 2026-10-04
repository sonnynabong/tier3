<?php
/**
 * Import reference images, menus, and the homepage on theme activation.
 *
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

const TIER3_QUALIFY_URL = 'https://link.growtoxsystem.com/widget/form/Ck6UhzscRDYhLSr4dPKl';
const TIER3_RESULTS_URL = 'https://tier3media.com/results/';
const TIER3_STORY_URL   = 'https://tier3media.com/our-story/';
const TIER3_GROWTOX_URL = 'https://tier3media.com/growtox/';
const TIER3_CONTACT_URL = 'https://tier3media.com/contact/';
const TIER3_CAREERS_URL = 'https://apply.workable.com/tier3media';
const TIER3_HOME_URL    = 'https://tier3media.com/';
const TIER3_PRIVACY_URL = 'https://tier3media.com/privacy/';

/**
 * @param bool $force Rewrite managed posts even if this seed version already ran.
 */
function tier3_seed( bool $force = false ): void {
	if ( ! $force && (int) get_option( 'tier3_seed_version' ) === TIER3_SEED_VERSION ) {
		return;
	}

	if ( ! is_user_logged_in() ) {
		$admins = get_users(
			array(
				'role'   => 'administrator',
				'number' => 1,
			)
		);
		if ( $admins ) {
			wp_set_current_user( $admins[0]->ID );
		}
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$ids = tier3_seed_media();
	if ( ! empty( $ids['logo-coral.svg'] ) ) {
		set_theme_mod( 'custom_logo', $ids['logo-coral.svg'] );
		update_option( 'site_icon', $ids['logo-coral.svg'] );
	}

	$navs = tier3_seed_navigations( $force );
	tier3_seed_template_part( 'header', 'Header', 'header', tier3_header_markup( $navs['primary'] ), $force );
	tier3_seed_template_part(
		'footer',
		'Footer',
		'footer',
		tier3_footer_markup(
			$ids['logo-white.svg'] ?? 0,
			$navs['company'],
			$navs['resources'],
			$navs['product']
		),
		$force
	);
	tier3_seed_home( $ids, $force );
	tier3_seed_cleanup_defaults();

	update_option( 'blogname', 'Tier3 Media' );
	update_option( 'blogdescription', 'A simple prescription for growth' );
	update_option( 'tier3_seed_version', TIER3_SEED_VERSION );
}

/**
 * @return array<string,int>
 */
function tier3_seed_media(): array {
	$assets = array(
		'logo-coral.svg'           => 'Tier3 Media',
		'logo-white.svg'           => 'Tier3 Media',
		'growtox.webp'             => 'Growtox Aesthetics Schedule-Filler bottle, Tier3 Media’s marketing system artwork',
		'connie-brooks.webp'       => 'Dr. Connie L. Brooks-Fernandez',
		'grace-chung.webp'         => 'Dr. Grace Chung',
		'karisha-madden.webp'      => 'Dr. Karisha Madden standing on a bridge',
		'find-patients.svg'        => '',
		'attract-patients.svg'     => '',
		'fill-schedule.svg'        => '',
		'allure.webp'              => 'Allure Aesthetics',
		'refine.webp'              => 'Refine Medical Spa',
		'destin.webp'              => 'Destin Botox',
		'metro.webp'               => 'Metro Medspa',
		'facial-aesthetics.webp'   => 'Facial Aesthetics Team',
		'lasting-impressions.webp' => 'Lasting Impressions Medical Aesthetics',
		'essential.webp'           => 'Essential Aesthetics',
		'smile-shop.webp'          => 'Smile Shop Aesthetics',
		'trouve.webp'              => 'Trouvé Medspa',
	);

	$ids = array();
	foreach ( $assets as $filename => $alt ) {
		$existing = tier3_find_managed_post( 'attachment', $filename, '_tier3_source' );
		if ( $existing ) {
			$ids[ $filename ] = $existing;
			continue;
		}

		$path = get_theme_file_path( 'assets/images/' . $filename );
		if ( ! is_readable( $path ) ) {
			continue;
		}

		$contents = file_get_contents( $path );
		if ( false === $contents ) {
			continue;
		}

		$upload = wp_upload_bits( $filename, null, $contents );
		if ( ! empty( $upload['error'] ) ) {
			error_log( 'Tier3 seed could not import ' . $filename . ': ' . $upload['error'] );
			continue;
		}

		$filetype = wp_check_filetype( $filename );
		if ( str_ends_with( strtolower( $filename ), '.svg' ) ) {
			$filetype = array(
				'ext'  => 'svg',
				'type' => 'image/svg+xml',
			);
		}

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => $filetype['type'] ?: 'image/webp',
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			),
			$upload['file']
		);

		if ( is_wp_error( $attachment_id ) || ! $attachment_id ) {
			error_log( 'Tier3 seed could not attach ' . $filename );
			continue;
		}

		$metadata = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
		if ( is_array( $metadata ) ) {
			wp_update_attachment_metadata( $attachment_id, $metadata );
		}

		if ( $alt !== '' ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
		}
		update_post_meta( $attachment_id, '_tier3_source', $filename );
		$ids[ $filename ] = (int) $attachment_id;
	}

	return $ids;
}

/**
 * @return array{primary:int,company:int,resources:int,product:int}
 */
function tier3_seed_navigations( bool $force ): array {
	$menus = array(
		'primary'   => array(
			'title' => 'Primary',
			'items' => array(
				array( 'label' => 'Results', 'url' => TIER3_RESULTS_URL ),
				array( 'label' => 'Our story', 'url' => TIER3_STORY_URL ),
				array( 'label' => 'The Growtox System™', 'url' => TIER3_GROWTOX_URL ),
			),
		),
		'company'   => array(
			'title' => 'Footer Company',
			'items' => array(
				array( 'label' => 'Our story', 'url' => TIER3_STORY_URL ),
				array( 'label' => 'Contact', 'url' => TIER3_CONTACT_URL ),
				array(
					'label'     => 'Careers',
					'url'       => TIER3_CAREERS_URL,
					'className' => 'has-arrow',
				),
			),
		),
		'resources' => array(
			'title' => 'Footer Resources',
			'items' => array(
				array( 'label' => 'Results', 'url' => TIER3_RESULTS_URL ),
				array(
					'label'          => 'Case study',
					'url'            => TIER3_HOME_URL,
					'className'      => 'has-arrow',
					'opensInNewTab'  => true,
				),
			),
		),
		'product'   => array(
			'title' => 'Footer Product',
			'items' => array(
				array( 'label' => 'Growtox System™', 'url' => TIER3_GROWTOX_URL ),
				array(
					'label'     => 'See if I qualify',
					'url'       => TIER3_QUALIFY_URL,
					'className' => 'has-arrow',
				),
			),
		),
	);

	$ids = array();
	foreach ( $menus as $key => $menu ) {
		$content  = tier3_navigation_content( $menu['items'] );
		$ids[ $key ] = tier3_upsert_post(
			array(
				'post_type'    => 'wp_navigation',
				'post_title'   => $menu['title'],
				'post_name'    => 'tier3-' . $key,
				'post_status'  => 'publish',
				'post_content' => $content,
			),
			$key,
			$force
		);
	}

	return $ids;
}

/**
 * @param array<int,array<string,mixed>> $items
 */
function tier3_navigation_content( array $items ): string {
	$blocks = array();
	foreach ( $items as $item ) {
		$attrs = array(
			'label'         => $item['label'],
			'type'          => 'custom',
			'url'           => $item['url'],
			'kind'          => 'custom',
			'isTopLevelLink'=> true,
		);
		if ( ! empty( $item['className'] ) ) {
			$attrs['className'] = $item['className'];
		}
		if ( ! empty( $item['opensInNewTab'] ) ) {
			$attrs['opensInNewTab'] = true;
		}
		$blocks[] = array(
			'blockName'    => 'core/navigation-link',
			'attrs'        => $attrs,
			'innerBlocks'  => array(),
			'innerContent' => array(),
		);
	}

	return serialize_blocks( $blocks );
}

function tier3_seed_template_part( string $slug, string $title, string $area, string $content, bool $force ): void {
	$post_id = tier3_find_managed_post( 'wp_template_part', $slug );
	if ( $post_id && ! $force ) {
		return;
	}

	$postarr = array(
		'post_type'    => 'wp_template_part',
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_status'  => 'publish',
		'post_content' => $content,
	);

	if ( $post_id ) {
		$postarr['ID'] = $post_id;
		wp_update_post( wp_slash( $postarr ) );
	} else {
		$post_id = wp_insert_post( wp_slash( $postarr ), true );
		if ( is_wp_error( $post_id ) ) {
			error_log( 'Tier3 seed could not save template part ' . $slug . ': ' . $post_id->get_error_message() );
			return;
		}
		update_post_meta( $post_id, '_tier3_managed', $slug );
	}

	wp_set_object_terms( $post_id, get_stylesheet(), 'wp_theme' );
	wp_set_object_terms( $post_id, $area, 'wp_template_part_area' );
}

/**
 * @param array<string,int> $ids
 */
function tier3_seed_home( array $ids, bool $force ): void {
	$content = serialize_blocks(
		array(
			tier3_self_closing_block( 'tier3/hero', tier3_hero_attrs( $ids ) ),
			tier3_self_closing_block( 'tier3/results', tier3_results_attrs( $ids ) ),
			tier3_self_closing_block( 'tier3/case-study', tier3_case_study_attrs( $ids ) ),
			tier3_self_closing_block( 'tier3/growth-band', tier3_growth_band_attrs() ),
			tier3_self_closing_block( 'tier3/process', tier3_process_attrs( $ids ) ),
			tier3_self_closing_block( 'tier3/practices', tier3_practices_attrs( $ids ) ),
			tier3_self_closing_block( 'tier3/closing', tier3_closing_attrs() ),
		)
	);

	$home_id = tier3_upsert_post(
		array(
			'post_type'    => 'page',
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_content' => $content,
		),
		'home',
		$force
	);

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
}

/**
 * @param array<string,mixed> $attrs
 * @return array<string,mixed>
 */
function tier3_self_closing_block( string $name, array $attrs ): array {
	return array(
		'blockName'    => $name,
		'attrs'        => $attrs,
		'innerBlocks'  => array(),
		'innerContent' => array(),
	);
}

/**
 * @param array<string,int> $ids
 * @return array<string,mixed>
 */
function tier3_hero_attrs( array $ids ): array {
	return array(
		'titleLine1'     => 'Inject your',
		'titleLine2'     => 'practice with',
		'titleLine3'     => 'more patients!',
		'description'    => 'The Growtox Schedule-Filler System™ is your secret weapon to building a wildly successful aesthetics practice.',
		'primaryLabel'   => 'See if my practice qualifies',
		'primaryUrl'     => TIER3_QUALIFY_URL,
		'secondaryLabel' => 'See the results',
		'secondaryUrl'   => TIER3_RESULTS_URL,
		'bottleId'       => $ids['growtox.webp'] ?? 0,
		'captionBrand'   => 'Growtox<sup>™</sup>',
		'captionSystem'  => 'The Schedule-Filler System',
		'footLeftLabel'  => 'A simple prescription for profits',
		'footLeftUrl'    => TIER3_GROWTOX_URL,
		'footRightLabel' => 'Explore the results',
		'footRightUrl'   => '#results',
	);
}

/**
 * @param array<string,int> $ids
 * @return array<string,mixed>
 */
function tier3_results_attrs( array $ids ): array {
	return array(
		'heading'            => 'See the results.',
		'storiesLabel'       => 'More client stories',
		'storiesUrl'         => TIER3_RESULTS_URL,
		'leadQuote'          => 'Over 80 bookings. My entire month was filled up in about two weeks! Tier3 Media is top notch!!',
		'leadName'           => 'Dr. Connie L. Brooks - Fernandez MD',
		'leadMeta'           => 'Allure Aesthetics',
		'leadImageId'        => $ids['connie-brooks.webp'] ?? 0,
		'secondaryQuote'     => 'I’m a startup practice that now has more than 44 new patients per week. I’d highly recommend Tier3 Media.',
		'secondaryName'      => 'Dr. Grace Chung',
		'secondaryMeta'      => 'Owner of Smile Shop Dental & Aesthetics<br>Henderson, Nevada',
		'secondaryImageId'   => $ids['grace-chung.webp'] ?? 0,
	);
}

/**
 * @param array<string,int> $ids
 * @return array<string,mixed>
 */
function tier3_case_study_attrs( array $ids ): array {
	return array(
		'imageId'     => $ids['karisha-madden.webp'] ?? 0,
		'quote'       => '“I did $71k in brand new patients in one month.”',
		'subquote'    => '“Best investment ever.”',
		'name'        => 'Dr. Karisha Madden',
		'meta'        => 'Voted Houston’s #1 Dentist in 2018',
		'caseLabel'   => 'View case study on Tier3 Media',
		'caseUrl'     => TIER3_HOME_URL,
		'moreLabel'   => 'See more results',
		'moreUrl'     => TIER3_RESULTS_URL,
	);
}

/**
 * @return array<string,mixed>
 */
function tier3_growth_band_attrs(): array {
	return array(
		'heading'        => 'Are you ready<br>to grow?',
		'primaryLabel'   => 'See if my practice qualifies',
		'primaryUrl'     => TIER3_QUALIFY_URL,
		'secondaryLabel' => 'See more results',
		'secondaryUrl'   => TIER3_RESULTS_URL,
	);
}

/**
 * @param array<string,int> $ids
 * @return array<string,mixed>
 */
function tier3_process_attrs( array $ids ): array {
	return array(
		'title'       => 'A simple<br>prescription<br><span>for profits.</span>',
		'description' => 'The Growtox System is a proven, done-for-you aesthetic practice marketing solution.',
		'steps'       => array(
			array(
				'number'    => '01',
				'title'     => 'We find your<br>ideal patients.',
				'body'      => 'Your practice doesn’t need patients. It needs the right kinds of patients. Let our experienced team dig into your area to find exactly the kinds of patients that will help you grow and keep growing a profitable practice.',
				'linkLabel' => 'See the system',
				'linkUrl'   => TIER3_GROWTOX_URL,
				'iconId'    => $ids['find-patients.svg'] ?? 0,
				'iconFile'  => 'find-patients.svg',
			),
			array(
				'number'    => '02',
				'title'     => 'We attract your<br>ideal patients.',
				'body'      => 'We use the newest methods of targeting and combine them with highly converting media that lead highly qualified candidates through our new patient scheduling funnels and directly into your chair.',
				'linkLabel' => 'See the system',
				'linkUrl'   => TIER3_GROWTOX_URL,
				'iconId'    => $ids['attract-patients.svg'] ?? 0,
				'iconFile'  => 'attract-patients.svg',
			),
			array(
				'number'    => '03',
				'title'     => 'We fill<br>your schedule.',
				'body'      => 'We aren’t satisfied with a few new patients or a few great months. We work diligently to ensure that your schedule is full and so you can focus on incredible results for your brand-new patients.',
				'linkLabel' => 'See the system',
				'linkUrl'   => TIER3_GROWTOX_URL,
				'iconId'    => $ids['fill-schedule.svg'] ?? 0,
				'iconFile'  => 'fill-schedule.svg',
			),
		),
	);
}

/**
 * @param array<string,int> $ids
 * @return array<string,mixed>
 */
function tier3_practices_attrs( array $ids ): array {
	$logos = array(
		array( 'file' => 'allure.webp', 'alt' => 'Allure Aesthetics' ),
		array( 'file' => 'refine.webp', 'alt' => 'Refine Medical Spa' ),
		array( 'file' => 'destin.webp', 'alt' => 'Destin Botox' ),
		array( 'file' => 'metro.webp', 'alt' => 'Metro Medspa' ),
		array( 'file' => 'facial-aesthetics.webp', 'alt' => 'Facial Aesthetics Team' ),
		array( 'file' => 'lasting-impressions.webp', 'alt' => 'Lasting Impressions Medical Aesthetics' ),
		array( 'file' => 'essential.webp', 'alt' => 'Essential Aesthetics' ),
		array( 'file' => 'smile-shop.webp', 'alt' => 'Smile Shop Aesthetics' ),
		array( 'file' => 'trouve.webp', 'alt' => 'Trouvé Medspa' ),
	);

	$items = array();
	foreach ( $logos as $logo ) {
		$items[] = array(
			'id'   => $ids[ $logo['file'] ] ?? 0,
			'alt'  => $logo['alt'],
			'file' => $logo['file'],
		);
	}

	return array(
		'heading'    => 'Join these<br>growing practices.',
		'subheading' => 'And many more.',
		'linkLabel'  => 'See what they’re saying',
		'linkUrl'    => TIER3_RESULTS_URL,
		'logos'      => $items,
	);
}

/**
 * @return array<string,mixed>
 */
function tier3_closing_attrs(): array {
	return array(
		'titleLine1'     => 'What’s',
		'titleLine2'     => 'stopping',
		'titleLine3'     => 'you?',
		'questions'      => array(
			'Do you feel stagnant and want to <strong>grow exponentially?</strong>',
			'Are you stuck in the weeds with marketing and aren’t getting the <strong>results you desperately need?</strong>',
			'Are you looking for <strong>proven shortcuts</strong> to increase brand awareness, get leads and have more bookings?',
			'Do you have a great practice but don’t know how to <strong>attract the right patients?</strong>',
			'Is your competition beating you with better marketing and you want a <strong>competitive edge?</strong>',
		),
		'primaryLabel'   => 'See if my practice qualifies',
		'primaryUrl'     => TIER3_QUALIFY_URL,
		'secondaryLabel' => 'See more results',
		'secondaryUrl'   => TIER3_RESULTS_URL,
	);
}

function tier3_header_markup( int $primary_id ): string {
	return '<!-- wp:group {"tagName":"header","className":"site-header","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<header class="wp-block-group site-header"><!-- wp:site-logo {"width":163,"shouldSyncIcon":true} /-->

<!-- wp:group {"className":"header-tools","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group header-tools"><!-- wp:navigation {"ref":' . $primary_id . ',"overlayMenu":"mobile","className":"navigation","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}} /-->

<!-- wp:buttons {"className":"header-cta"} -->
<div class="wp-block-buttons header-cta"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( TIER3_QUALIFY_URL ) . '">Fill my schedule</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></header>
<!-- /wp:group -->';
}

function tier3_footer_markup( int $logo_id, int $company_id, int $resources_id, int $product_id ): string {
	$logo = $logo_id > 0 ? wp_get_attachment_url( $logo_id ) : get_theme_file_uri( 'assets/images/logo-white.svg' );
	$src  = esc_url( $logo ?: '' );
	$home = esc_url( home_url( '/' ) );

	return '<!-- wp:group {"tagName":"footer","className":"site-footer","layout":{"type":"default"}} -->
<footer class="wp-block-group site-footer"><!-- wp:group {"className":"footer-main","layout":{"type":"default"}} -->
<div class="wp-block-group footer-main"><!-- wp:group {"className":"footer-brand","layout":{"type":"default"}} -->
<div class="wp-block-group footer-brand"><!-- wp:image {"id":' . (int) $logo_id . ',"sizeSlug":"full","linkDestination":"custom","className":"footer-logo"} -->
<figure class="wp-block-image size-full footer-logo"><a href="' . $home . '" aria-label="Tier3 Media — back to top"><img src="' . $src . '" alt="Tier3 Media" class="wp-image-' . (int) $logo_id . '"/></a></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"footer-email"} -->
<p class="footer-email"><a href="mailto:info@tier3media.com">info@tier3media.com</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="tel:7328084113">(732) 808-4113</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-address"} -->
<p class="footer-address">197 State Route 18 South<br>Ste 3000-4299<br>East Brunswick, NJ 08816</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"footer-nav","layout":{"type":"default"}} -->
<div class="wp-block-group footer-nav"><!-- wp:group {"className":"footer-nav-col","layout":{"type":"default"}} -->
<div class="wp-block-group footer-nav-col"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Company</h2>
<!-- /wp:heading -->

<!-- wp:navigation {"ref":' . $company_id . ',"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"footer-nav-col","layout":{"type":"default"}} -->
<div class="wp-block-group footer-nav-col"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Resources</h2>
<!-- /wp:heading -->

<!-- wp:navigation {"ref":' . $resources_id . ',"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"footer-nav-col","layout":{"type":"default"}} -->
<div class="wp-block-group footer-nav-col"><!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading">Product</h2>
<!-- /wp:heading -->

<!-- wp:navigation {"ref":' . $product_id . ',"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"footer-bottom","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group footer-bottom"><!-- wp:paragraph -->
<p>© Tier3 Media 2025</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><a href="' . esc_url( TIER3_PRIVACY_URL ) . '">Privacy policy</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"footer-social"} -->
<p class="footer-social"><a href="https://www.facebook.com/tier3media/">Facebook</a><a href="https://www.instagram.com/tier3media/">Instagram</a><a href="https://twitter.com/tier3_media">Twitter</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"back-top"} -->
<p class="back-top"><a href="#main">Back to top</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></footer>
<!-- /wp:group -->';
}

/**
 * @param array<string,mixed> $postarr
 */
function tier3_upsert_post( array $postarr, string $managed, bool $force ): int {
	$existing = tier3_find_managed_post( $postarr['post_type'], $managed );
	if ( $existing && ! $force ) {
		return $existing;
	}

	if ( $existing ) {
		$postarr['ID'] = $existing;
		$result          = wp_update_post( wp_slash( $postarr ), true );
	} else {
		$result = wp_insert_post( wp_slash( $postarr ), true );
	}

	if ( is_wp_error( $result ) ) {
		error_log( 'Tier3 seed could not save ' . $managed . ': ' . $result->get_error_message() );
		return $existing ?: 0;
	}

	update_post_meta( (int) $result, '_tier3_managed', $managed );
	return (int) $result;
}

function tier3_find_managed_post( string $post_type, string $value, string $meta_key = '_tier3_managed' ): int {
	$posts = get_posts(
		array(
			'post_type'              => $post_type,
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_key'               => $meta_key,
			'meta_value'             => $value,
		)
	);

	return isset( $posts[0] ) ? (int) $posts[0] : 0;
}

function tier3_seed_cleanup_defaults(): void {
	foreach ( array( 'hello-world' ) as $slug ) {
		$posts = get_posts(
			array(
				'name'           => $slug,
				'post_type'      => 'post',
				'post_status'    => 'any',
				'posts_per_page' => 1,
			)
		);
		foreach ( $posts as $post ) {
			wp_delete_post( $post->ID, true );
		}
	}

	$sample = get_posts(
		array(
			'name'           => 'sample-page',
			'post_type'      => 'page',
			'post_status'    => 'any',
			'posts_per_page' => 1,
		)
	);
	foreach ( $sample as $post ) {
		if ( get_post_meta( $post->ID, '_tier3_managed', true ) ) {
			continue;
		}
		wp_delete_post( $post->ID, true );
	}
}
