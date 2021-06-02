<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package Catch_Starter
 */
?>

<?php
$catch_starter_layout = catch_starter_get_theme_layout();

// Bail early if no sidebar layout is selected.
if ( 'no-sidebar' === $catch_starter_layout ) {
	return;
}

$sidebar = catch_starter_get_sidebar_id();

if ( '' === $sidebar ) {
    return;
}
?>

<aside id="secondary" class="sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- .sidebar .widget-area -->
