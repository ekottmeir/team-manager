<?php
/**
 * Created by PhpStorm.
 * User: emilkottmeir
 * Date: 18.04.17
 * Time: 14:39
 */

function tm_child_styles() {
    wp_deregister_style( 'parallax-one-style');
    wp_register_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style('parallax-one-style', get_template_directory_uri(). '/style.css');
    wp_enqueue_style( 'tm-style', get_stylesheet_directory_uri().'/style.css', array('parallax-one-style') );
}
add_action( 'wp_enqueue_scripts', 'tm_child_styles' );