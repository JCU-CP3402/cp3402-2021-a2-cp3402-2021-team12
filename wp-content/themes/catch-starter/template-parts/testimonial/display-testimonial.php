<?php
/**
 * The template for displaying testimonial items
 *
 * @package Catch_Starter
 */
?>

<?php
$enable = get_theme_mod( 'catch_starter_testimonial_option', 'disabled' );

if ( ! catch_starter_check_section( $enable ) ) {
	// Bail if featured content is disabled
	return;
}
	// Get Jetpack options for testimonial.
	$jetpack_defaults = array(
		'page-title' => esc_html__( 'Testimonials', 'catch-starter' ),
	);

	// Get Jetpack options for testimonial.
	$jetpack_options = get_theme_mod( 'jetpack_testimonials', $jetpack_defaults );

	$headline = isset( $jetpack_options['page-title'] ) ? $jetpack_options['page-title'] : esc_html__( 'Testimonials', 'catch-starter' );

	$subheadline = isset( $jetpack_options['page-content'] ) ? $jetpack_options['page-content'] : '';

$layouts = 1;

$classes[] = 'section testimonial-wrapper';

$classes[] = 'layout-one';

if ( ! $headline && ! $subheadline ) {
	$classes[] = 'no-headline';
}

?>

<div id="testimonial-content-section" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="wrapper">

	<?php if ( $headline || $subheadline ) : ?>
		<div class="section-heading-wrapper testimonial-section-headline">
		<?php if ( $headline ) : ?>
			<div class="section-title-wrapper">
				<h2 class="section-title"><?php echo wp_kses_post( $headline ); ?></h2>
			</div><!-- .section-title-wrapper -->
		<?php endif; ?>

		<?php if ( $subheadline ) : ?>
			<div class="taxonomy-description-wrapper">
				<?php echo wp_kses_post( $subheadline ); ?>
			</div><!-- .taxonomy-description-wrapper -->
		<?php endif; ?>
		</div><!-- .section-heading-wrapper -->
	<?php endif; ?>

		<div class="section-content-wrapper testimonial-content-wrapper">
			<div class="cycle-slideshow"
				data-cycle-log="false"
				data-cycle-pause-on-hover="true"
				data-cycle-swipe="true"
				data-cycle-auto-height=container
				data-cycle-loader=false
				data-cycle-slides=".testimonial_slider_wrap"
				data-cycle-pager="#testimonial-slider-pager"
				data-cycle-prev="#testimonial-slider-prev"
				data-cycle-next="#testimonial-slider-next"
				>

				<div class="controller">
					<!-- prev/next links -->
					<button id="testimonial-slider-prev" class="cycle-prev" aria-label="Previous">
						<span class="screen-reader-text"><?php esc_html_e( 'Previous Slide', 'catch-starter' ); ?></span><?php echo catch_starter_get_svg( array( 'icon' => 'angle-down' ) ); ?>
					</button>

					<!-- empty element for pager links -->
					<div id="testimonial-slider-pager" class="cycle-pager"></div>

					<button id="testimonial-slider-next" class="cycle-next" aria-label="Next">
						<span class="screen-reader-text"><?php esc_html_e( 'Next Slide', 'catch-starter' ); ?></span><?php echo catch_starter_get_svg( array( 'icon' => 'angle-down' ) ); ?>
					</button>
				</div><!-- .controller -->

				<div class="testimonial_slider_wrap">


			<?php
				get_template_part( 'template-parts/testimonial/post-types', 'testimonial' );
			?>
				</div><!-- .testimonial_slider_wrap -->
			</div><!-- .cycle-slideshow -->
		</div><!-- .section-content-wrapper -->
	</div><!-- .wrapper -->
</div><!-- .testimonial-section -->
