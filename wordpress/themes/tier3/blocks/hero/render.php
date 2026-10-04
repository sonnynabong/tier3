<?php
/**
 * Hero section.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$bottle = tier3_image(
	tier3_int( $attributes, 'bottleId' ),
	'growtox.webp',
	'Growtox Aesthetics Schedule-Filler bottle, Tier3 Media’s marketing system artwork'
);
?>
<div class="hero-cointaier">
	<section class="hero" aria-labelledby="hero-title">
		<div class="hero-main">
			<div class="hero-copy">
				<h1 id="hero-title">
					<span class="hero-line"><?php echo esc_html( tier3_str( $attributes, 'titleLine1', 'Inject your' ) ); ?></span>
					<span class="hero-line"><?php echo esc_html( tier3_str( $attributes, 'titleLine2', 'practice with' ) ); ?></span>
					<span class="hero-line hero-emphasis"><?php echo esc_html( tier3_str( $attributes, 'titleLine3', 'more patients!' ) ); ?></span>
				</h1>
				<p class="hero-description"><?php echo esc_html( tier3_str( $attributes, 'description' ) ); ?></p>
				<div class="hero-actions">
					<?php echo tier3_link( tier3_str( $attributes, 'primaryUrl' ), tier3_str( $attributes, 'primaryLabel' ), 'button button-violet', 'arrow-up' ); ?>
					<?php echo tier3_link( tier3_str( $attributes, 'secondaryUrl' ), tier3_str( $attributes, 'secondaryLabel' ), 'text-link', 'arrow' ); ?>
				</div>
			</div>
			<figure class="hero-product">
				<?php echo tier3_img_tag( $bottle, 'bottle', array( 'fetchpriority' => 'high' ) ); ?>
				<figcaption>
					<span><?php echo tier3_kses( tier3_str( $attributes, 'captionBrand', 'Growtox<sup>™</sup>' ) ); ?></span>
					<span><?php echo esc_html( tier3_str( $attributes, 'captionSystem', 'The Schedule-Filler System' ) ); ?></span>
				</figcaption>
			</figure>
		</div>
		<div class="hero-foot">
			<?php echo tier3_link( tier3_str( $attributes, 'footLeftUrl' ), tier3_str( $attributes, 'footLeftLabel' ), '', 'arrow-up' ); ?>
			<?php echo tier3_link( tier3_str( $attributes, 'footRightUrl', '#results' ), tier3_str( $attributes, 'footRightLabel' ), 'scroll-link', 'arrow-down' ); ?>
		</div>
	</section>
</div>
