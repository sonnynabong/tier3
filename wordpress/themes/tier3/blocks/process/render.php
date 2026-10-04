<?php
/**
 * Process steps.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$steps = $attributes['steps'] ?? array();
if ( ! is_array( $steps ) ) {
	$steps = array();
}
?>
<section class="process section-wrap" id="system" aria-labelledby="process-title">
	<div class="process-intro">
		<h2 id="process-title"><?php echo tier3_kses( tier3_str( $attributes, 'title' ) ); ?></h2>
		<p><?php echo esc_html( tier3_str( $attributes, 'description' ) ); ?></p>
	</div>
	<ol class="process-list">
		<?php foreach ( $steps as $step ) : ?>
			<?php
			$step      = is_array( $step ) ? $step : array();
			$icon_file = isset( $step['iconFile'] ) ? (string) $step['iconFile'] : 'find-patients.svg';
			$icon      = tier3_image( (int) ( $step['iconId'] ?? 0 ), $icon_file, '' );
			?>
			<li class="process-row" data-reveal="step">
				<span class="step-number" aria-hidden="true"><?php echo esc_html( (string) ( $step['number'] ?? '' ) ); ?></span>
				<div class="process-content">
					<h3><?php echo tier3_kses( (string) ( $step['title'] ?? '' ) ); ?></h3>
					<p><?php echo esc_html( (string) ( $step['body'] ?? '' ) ); ?></p>
					<?php echo tier3_link( (string) ( $step['linkUrl'] ?? '' ), (string) ( $step['linkLabel'] ?? '' ), 'text-link', 'arrow-up' ); ?>
				</div>
				<?php echo tier3_img_tag( $icon, '', array( 'loading' => 'lazy' ) ); ?>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
