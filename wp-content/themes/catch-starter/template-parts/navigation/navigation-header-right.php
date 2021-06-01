<?php
/**
 * Displays Header Right Navigation
 *
 * @package Catch_Starter
 */
?>

<?php if ( has_nav_menu( 'social-header-right' ) ) : ?>
	<button id="menu-toggle-secondary" class="menu-secondary-toggle menu-toggle" aria-controls="secondary-menu" aria-expanded="false">
		<?php
		echo catch_starter_get_svg( array( 'icon' => 'bars' ) );
		echo catch_starter_get_svg( array( 'icon' => 'close' ) );
		echo '<span class="menu-label-prefix">'. esc_attr__( 'Secondary ', 'catch-starter' ) . '</span><span class="menu-label">'. esc_attr__( 'Menu', 'catch-starter' ) . '</span>';
		?>
	</button>

	<div id="site-header-right-menu" class="site-secondary-menu">
		<nav id="social-secondary-navigation-top" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Header Right Social Links Menu', 'catch-starter' ); ?>">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'social-header-right',
					'menu_class'     => 'social-links-menu',
					'depth'          => 1,
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . catch_starter_get_svg( array( 'icon' => 'chain' ) ),
				) );
			?>
		</nav><!-- #social-secondary-navigation -->
	</div><!-- #site-header-right-menu -->

<?php endif;
