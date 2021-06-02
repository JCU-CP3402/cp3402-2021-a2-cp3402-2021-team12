<?php
/**
 * The template for displaying testimonial items
 *
 * @package Catch_Starter
 */
?>

<?php
$number = get_theme_mod( 'catch_starter_testimonial_number', 3 );

if ( ! $number ) {
	// If number is 0, then this section is disabled
	return;
}

$args = array(
	'orderby'             => 'post__in',
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$args['post_type'] = 'jetpack-testimonial';

for ( $i = 1; $i <= $number; $i++ ) {
	$post_id = '';

		$post_id =  get_theme_mod( 'catch_starter_testimonial_cpt_' . $i );

	if ( $post_id && '' !== $post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$post_id = pll_get_post( $post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $post_id ) );

	}
}

$args['post__in'] = $post_list;


$args['posts_per_page'] = $number;
$loop     = new WP_Query( $args );

$slider_select = 1;

$layouts = 1;

if ( $loop -> have_posts() ) :
	while ( $loop -> have_posts() ) :
		$loop -> the_post();

		get_template_part( 'template-parts/testimonial/content', 'testimonial' );

		$i = absint( $loop->current_post + 1 );

		//end and start testimonial_slider_wrap div based on logic
		if ( 0 === ( $i % $layouts ) && $i < $number && $slider_select ) : ?>
			</div><!-- .testimonial_slider_wrap -->

			<div class="testimonial_slider_wrap">
		<?php
		endif;
	endwhile;
	wp_reset_postdata();
endif;
