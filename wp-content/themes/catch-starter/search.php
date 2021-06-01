<?php
/**
 * The template for displaying search results pages
 *
 * @package Catch_Starter
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'catch-starter' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<div class="section-content-wrapper">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content/content', get_post_format() );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				catch_starter_content_nav();?>
			</div><!-- .section-content-wrapper -->

		<?php else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
