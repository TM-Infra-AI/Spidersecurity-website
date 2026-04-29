<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="main">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package    WordPress
 * @subpackage assurena
 * @since      1.0
 * @version    1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <?php
    if ( is_singular() && pings_open() ) : ?>
        <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
        <?php
    endif;
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    
    <?php 
    
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        } else {
            do_action( 'wp_body_open' );
        }
    
        assurena_Theme_Helper::preloader();
        get_template_part('templates/header/section','header');
        if(is_404() && assurena_Theme_Helper::get_option('404_page_title_switcher') == 1) {    
            get_template_part('templates/header/section','page_title');
        }elseif(!is_404()){
            get_template_part('templates/header/section','page_title');
        }
    ?>
    <main id="main">