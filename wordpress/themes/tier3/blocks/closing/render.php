<?php
/**
 * Closing questions.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$questions = $attributes['questions'] ?? array();
if ( ! is_array( $questions ) ) {
	$questions = array();
}
?>
<section class="closing section-wrap" aria-labelledby="closing-title">
	<div class="closing-title">
		<h2 id="closing-title">
			<?php echo esc_html( tier3_str( $attributes, 'titleLine1' ) ); ?><br>
			<?php echo esc_html( tier3_str( $attributes, 'titleLine2' ) ); ?><br>
			<span><?php echo esc_html( tier3_str( $attributes, 'titleLine3' ) ); ?></span>
		</h2>
		<svg class="closing-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
			<path d="M5 19 19 5M5 5h14v14"/>
		</svg>
	</div>
	<div class="closing-content">
		<ul class="questions">
			<?php foreach ( $questions as $question ) : ?>
				<li><?php echo tier3_kses( (string) $question ); ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="closing-actions">
			<?php echo tier3_link( tier3_str( $attributes, 'primaryUrl' ), tier3_str( $attributes, 'primaryLabel' ), 'button button-violet', 'arrow-up' ); ?>
			<?php echo tier3_link( tier3_str( $attributes, 'secondaryUrl' ), tier3_str( $attributes, 'secondaryLabel' ), 'text-link', 'arrow' ); ?>
		</div>
	</div>
</section>
