<?php
/**
 * Case study band.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$photo = tier3_image(
	tier3_int( $attributes, 'imageId' ),
	'karisha-madden.webp',
	'Dr. Karisha Madden standing on a bridge'
);
?>
<section class="case-study" aria-labelledby="case-title">
	<div class="case-image" data-reveal="image">
		<?php echo tier3_img_tag( $photo, '', array( 'loading' => 'lazy' ) ); ?>
	</div>
	<div class="case-content" data-reveal="quote">
		<blockquote>
			<h2 id="case-title"><?php echo esc_html( tier3_str( $attributes, 'quote' ) ); ?></h2>
			<p><?php echo esc_html( tier3_str( $attributes, 'subquote' ) ); ?></p>
		</blockquote>
		<div class="case-attribution">
			<strong><?php echo esc_html( tier3_str( $attributes, 'name' ) ); ?></strong>
			<span><?php echo esc_html( tier3_str( $attributes, 'meta' ) ); ?></span>
		</div>
		<div class="case-links">
			<?php echo tier3_link( tier3_str( $attributes, 'caseUrl' ), tier3_str( $attributes, 'caseLabel' ), 'text-link', 'arrow-up', true ); ?>
			<?php echo tier3_link( tier3_str( $attributes, 'moreUrl' ), tier3_str( $attributes, 'moreLabel' ), 'text-link', 'arrow' ); ?>
		</div>
	</div>
</section>
