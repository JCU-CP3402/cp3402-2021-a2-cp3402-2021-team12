<?php
/**
 * The template for displaying Services
 *
 * @package Catch_Starter
 */



if ( ! function_exists( 'catch_starter_service_display' ) ) :
	/**
	* Add Featured content.
	*
	* @uses action hook catch_starter_before_content.
	*
	* @since Catch Starter 0.1
	*/
	function catch_starter_service_display() {
		$output = '';

		// get data value from options
		$enable_content = get_theme_mod( 'catch_starter_service_option', 'disabled' );

		if ( catch_starter_check_section( $enable_content ) ) {
			$headline   = get_option( 'ect_service_title', esc_html__( 'Services', 'catch-starter' ) );
			$subheadline = get_option( 'ect_service_content' );
			$classes[] = 'section';
			$classes[] = 'ect-service';

			$output = '
				<div id="service-section" class="' . esc_attr( implode( ' ', $classes ) ) . '">
					<div class="wrapper">';

			$output .= '<div class="service-content-area layout-three">';

			if ( ! empty( $headline ) || ! empty( $subheadline ) ) {
				$output .= '<div class="section-heading-wrapper service-section-headline">';

				if ( ! empty( $headline ) ) {
					$output .= '<div class="section-title-wrapper"><h2 class="section-title">' . wp_kses_post( $headline ) . '</h2></div>';
				}

				if ( ! empty( $subheadline ) ) {
					$output .= '<div class="taxonomy-description-wrapper">' . wp_kses_post( $subheadline ) . '</div>';
				}

				$output .= '
				</div><!-- .section-heading-wrapper -->';
			}
			$output .= '
				<div class="section-content-wrapper service-content-wrapper layout-three">';

			// Select content
				$output .= catch_starter_post_page_category_service();
			$output .= '
						</div><!-- .service-wrapper -->
					</div><!-- .service-content-area -->
				</div><!-- .wrapper -->
			</div><!-- #service-section -->';

		}

		echo $output;
	}
endif;
add_action( 'catch_starter_service', 'catch_starter_service_display', 10 );


if ( ! function_exists( 'catch_starter_post_page_category_service' ) ) :
	/**
	 * This function to display featured posts content
	 *
	 * @param $options: catch_starter_theme_options from customizer
	 *
	 * @since Catch Starter 0.1
	 */
	function catch_starter_post_page_category_service() {
		global $post;

		$quantity   = get_theme_mod( 'catch_starter_service_number', 6 );
		$post_list  = array();// list of valid post/page ids
		$output     = '';

		$args = array(
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1 // ignore sticky posts
		);
			$args['post_type'] = 'ect-service';

			for ( $i = 1; $i <= $quantity; $i++ ) {
				$post_id = '';
					$post_id = get_theme_mod( 'catch_starter_service_cpt_' . $i );
				if ( $post_id && '' !== $post_id ) {
					// Polylang Support.
					if ( class_exists( 'Polylang' ) ) {
						$post_id = pll_get_post( $post_id, pll_current_language() );
					}

					$post_list = array_merge( $post_list, array( $post_id ) );
				}
			}

			$args['post__in'] = $post_list;

		$args['posts_per_page'] = $quantity;

		$loop     = new WP_Query( $args );

		while ( $loop->have_posts() ) {
			$loop->the_post();

			$title_attribute = the_title_attribute( 'echo=0' );

			$i = absint( $loop->current_post + 1 );

			$output .= '
				<article id="service-post-' . $i . '" class="status-publish has-post-thumbnail hentry ect-service">';

				// Default value if there is no first image
				$image = '<img class="wp-post-image" src="' . trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'assets/images/no-thumb.jpg" >';

				if ( has_post_thumbnail() ) {
					$image = get_the_post_thumbnail( $post->ID, 'catch-starter-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );
				}
				else {
					// Get the first image in page, returns false if there is no image.
					$first_image = catch_starter_get_first_image( $post->ID, 'catch-starter-featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) );

					// Set value of image as first image if there is an image present in the page.
					if ( $first_image ) {
						$image = $first_image;
					}
				}

				$output .= '
					<a class="post-thumbnail" href="' . esc_url( get_permalink() ) . '" title="' . $title_attribute . '">
						'. $image . '
					</a>
					<div class="entry-container">';

					$output .= the_title( '<header class="entry-header"><h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2></header><!-- .entry-header -->', false );
					//Show Excerpt
					$output .= '
						<div class="entry-summary"><p>' . get_the_excerpt() . '</p></div><!-- .entry-summary -->';
				$output .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-' . $i . ' -->';
			} //endwhile

		wp_reset_postdata();

		return $output;
	}
endif; // catch_starter_post_page_category_service