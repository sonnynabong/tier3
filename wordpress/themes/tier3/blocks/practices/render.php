<?php
/**
 * Practice logo grid.
 *
 * @var array $attributes
 * @package Tier3
 */

defined( 'ABSPATH' ) || exit;

$logos = $attributes['logos'] ?? array();
if ( ! is_array( $logos ) ) {
	$logos = array();
}
?>
<section class="practices" aria-labelledby="practices-title">
	<div class="section-wrap">
		<div class="section-heading">
			<h2 id="practices-title"><?php echo tier3_kses( tier3_str( $attributes, 'heading' ) ); ?></h2>
			<p><?php echo esc_html( tier3_str( $attributes, 'subheading' ) ); ?></p>
		</div>
		<ul class="logo-grid" aria-label="Client practices">
			<?php foreach ( $logos as $logo ) : ?>
				<?php
				$logo = is_array( $logo ) ? $logo : array();
				$file = isset( $logo['file'] ) ? (string) $logo['file'] : 'allure.webp';
				$alt  = isset( $logo['alt'] ) ? (string) $logo['alt'] : '';
				$img  = tier3_image( (int) ( $logo['id'] ?? 0 ), $file, $alt );
				?>
				<li><?php echo tier3_img_tag( $img, '', array( 'loading' => 'lazy' ) ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php echo tier3_link( tier3_str( $attributes, 'linkUrl' ), tier3_str( $attributes, 'linkLabel' ), 'text-link', 'arrow-up' ); ?>
	</div>
</section>
