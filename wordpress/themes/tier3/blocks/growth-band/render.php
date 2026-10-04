<?php
/**
 * Growth call-to-action.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="growth-band" aria-labelledby="growth-title">
	<h2 id="growth-title"><?php echo tier3_kses( tier3_str( $attributes, 'heading', 'Are you ready<br>to grow?' ) ); ?></h2>
	<div class="growth-actions">
		<?php echo tier3_link( tier3_str( $attributes, 'primaryUrl' ), tier3_str( $attributes, 'primaryLabel' ), 'button button-dark', 'arrow-up' ); ?>
		<?php echo tier3_link( tier3_str( $attributes, 'secondaryUrl' ), tier3_str( $attributes, 'secondaryLabel' ), 'text-link', 'arrow' ); ?>
	</div>
</section>
