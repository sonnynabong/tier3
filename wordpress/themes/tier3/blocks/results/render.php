<?php
/**
 * Results testimonials.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$lead = tier3_image(
	tier3_int( $attributes, 'leadImageId' ),
	'connie-brooks.webp',
	'Dr. Connie L. Brooks-Fernandez'
);
$secondary = tier3_image(
	tier3_int( $attributes, 'secondaryImageId' ),
	'grace-chung.webp',
	'Dr. Grace Chung'
);
?>
<section class="results section-wrap" id="results" aria-labelledby="results-title">
	<div class="section-heading">
		<h2 id="results-title"><?php echo esc_html( tier3_str( $attributes, 'heading', 'See the results.' ) ); ?></h2>
		<?php echo tier3_link( tier3_str( $attributes, 'storiesUrl' ), tier3_str( $attributes, 'storiesLabel' ), 'text-link', 'arrow-up' ); ?>
	</div>
	<div class="testimonials">
		<figure class="testimonial testimonial-lead" data-reveal="quote">
			<div class="quote-mark" aria-hidden="true">“</div>
			<blockquote><p><?php echo esc_html( tier3_str( $attributes, 'leadQuote' ) ); ?></p></blockquote>
			<figcaption>
				<?php echo tier3_img_tag( $lead, '', array( 'loading' => 'lazy' ) ); ?>
				<div>
					<strong><?php echo esc_html( tier3_str( $attributes, 'leadName' ) ); ?></strong>
					<span><?php echo tier3_kses( tier3_str( $attributes, 'leadMeta' ) ); ?></span>
				</div>
			</figcaption>
		</figure>
		<figure class="testimonial testimonial-secondary" data-reveal="quote">
			<div class="quote-mark" aria-hidden="true">“</div>
			<blockquote><p><?php echo esc_html( tier3_str( $attributes, 'secondaryQuote' ) ); ?></p></blockquote>
			<figcaption>
				<?php echo tier3_img_tag( $secondary, '', array( 'loading' => 'lazy' ) ); ?>
				<div>
					<strong><?php echo esc_html( tier3_str( $attributes, 'secondaryName' ) ); ?></strong>
					<span><?php echo tier3_kses( tier3_str( $attributes, 'secondaryMeta' ) ); ?></span>
				</div>
			</figcaption>
		</figure>
	</div>
</section>
