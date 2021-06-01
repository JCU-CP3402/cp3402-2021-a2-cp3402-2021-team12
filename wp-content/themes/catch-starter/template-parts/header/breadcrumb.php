<?php
/**
 * Display Breadcrumb
 *
 * @package Catch_Starter
 */
?>

<?php
$enable_breadcrumb = get_theme_mod( 'catch_starter_breadcrumb_option', 1 );

if ( $enable_breadcrumb ) :
        catch_starter_breadcrumb();
endif;
