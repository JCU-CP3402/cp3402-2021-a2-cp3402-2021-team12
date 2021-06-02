<?php
/**
 * Displays Primary Navigation
 *
 * @package Catch_Starter
 */
?>

<div id="header-navigation-area">
	<div class="wrapper">
		<button id="primary-menu-toggle" class="menu-primary-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<?php
			echo catch_starter_get_svg( array( 'icon' => 'bars' ) );
			echo catch_starter_get_svg( array( 'icon' => 'close' ) );
			echo '<span class="menu-label-prefix">'. esc_attr__( 'Primary ', 'catch-starter' ) . '</span><span class="menu-label">'. esc_attr__( 'Menu', 'catch-starter' ) . '</span>';
			?>
		</button>

		<div id="site-header-menu" class="site-primary-menu">
			<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
				<nav id="site-primary-navigation" class="main-navigation site-navigation custom-primary-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'catch-starter' ); ?>">
					<?php wp_nav_menu( array(
						'theme_location'	=> 'menu-1',
						'container_class'	=> 'primary-menu-container',
						'menu_class'		=> 'primary-menu',
					) ); ?>
				</nav><!-- #site-primary-navigation.custom-primary-menu -->
			<?php else : ?>
				<nav id="site-primary-navigation" class="main-navigation site-navigation default-page-menu" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'catch-starter' ); ?>">
					<?php wp_page_menu(
						array(
							'menu_class' => 'primary-menu-container',
							'before'     => '<ul id="primary-page-menu" class="primary-menu">',
							'after'      => '</ul>',
						)
					); ?>
				</nav><!-- #site-primary-navigation.default-page-menu -->

			<?php endif; ?>
				<div class="primary-search-wrapper">
					<button id="search-toggle" class="menu-search-toggle menu-toggle search-toggle"><?php echo catch_starter_get_svg( array(
						'icon' => 'search',
					), true ); echo catch_starter_get_svg( array(
						'icon' => 'close',
					), true ); ?><span class="screen-reader-text"><?php esc_html_e( 'Search', 'catch-starter' ); ?></span></button>

			        <div id="search-social-container" class="search-social-container displaynone">
			        	<div id="search-container">
			            	<?php get_search_form(); ?>
			            </div><!-- #search-container -->
					</div><!-- #search-social-container -->
				</div><!-- .primary-search-wrapper -->
		</div><!-- .site-header-main -->
	</div><!-- .wrapper -->
</div><!-- #header-navigation-area -->
