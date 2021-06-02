<?php
/**
 * Display Header Media Text
 *
 * @package Catch_Starter
 */
?>

<?php
$header_media_title = get_theme_mod( 'catch_starter_header_media_title', esc_html__( 'Welcome to Catch Starter', 'catch-starter' ) );

$header_media_text = get_theme_mod( 'catch_starter_header_media_text', esc_html__( 'Make things as simple as possible but no simpler.', 'catch-starter' ) );

if ( '' !== $header_media_title || '' !== $header_media_text ) : ?>
<div class="custom-header-content sections header-media-section">
		<?php if ( '' !== $header_media_title ) : ?>
		<h2 class="entry-title section-title"><?php echo wp_kses_post( $header_media_title ); ?></h2>
		<?php endif; ?>

		<p class="site-header-text"><?php echo wp_kses_post( $header_media_text ); ?>
		<a class="more-link"  href="<?php echo esc_url( get_theme_mod( 'catch_starter_header_media_url', '#' ) ); ?>" target="<?php echo get_theme_mod( 'catch_starter_header_url_target' ) ? '_blank' : '_self'; ?>"  > <span class="more-button"><?php echo esc_html( get_theme_mod( 'catch_starter_header_media_url_text', esc_html__( 'Continue reading', 'catch-starter' ) ) ); ?><span class="screen-reader-text"><?php echo wp_kses_post( $header_media_title ); ?></span></span></a></p>
</div>
<?php endif; ?>

