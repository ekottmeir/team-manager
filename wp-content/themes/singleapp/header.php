<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php do_action( 'singleapp_before' ); ?>

<div id="page" class="hfeedsite">

	<?php if ( singleapp_theme_style() == 'fullpage' ) : ?>

		<div id="fullpage-bg-image"><img src="<?php echo get_background_image();?>"></div>
		<div class="fullpage-overlay"></div>

	<?php endif; ?>
	

	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'singleapp' ); ?></a>

	<?php if( get_theme_mod( 'singleapp_jumbotron_enable', '' ) == '1' && is_front_page() && singleapp_theme_style() == 'onepage' ) {

		get_template_part( 'sections/jumbotron' );

     } ?>
	
	<?php do_action( 'singleapp_before_header' ); ?>

	<header id="masthead" class="site-header">

		<div class="header-wrapper clearfix">

			<div class="tg-container">

				<?php if( ( get_theme_mod( 'singleapp_header_logo_placement', 'header_text_only' ) == 'show_both' || get_theme_mod( 'singleapp_header_logo_placement', 'header_text_only' ) == 'header_logo_only' ) && has_custom_logo() ) : ?>
					<div class="logo">
						<?php singleapp_the_custom_logo(); ?>
					</div><!--end logo-->
				<?php endif; ?>

				<?php $screen_reader = 'normal-header';

				if ( ( get_theme_mod( 'singleapp_header_logo_placement', 'header_text_only' ) == 'header_logo_only' || get_theme_mod( 'singleapp_header_logo_placement', 'header_text_only' ) == 'disable' ) ) {
					$screen_reader = 'screen-reader-text';
				}

				if ( get_theme_mod( 'singleapp_header_logo_placement', 'header_text_only' ) == 'show_both' ) {					$screen_reader = 'tg-seperate';
				} ?>

				<div id="header-text"  class="<?php echo esc_attr( $screen_reader ); ?>">

					<?php if ( is_front_page() && is_home() ) : ?>

						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

					<?php else : ?>

						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>

					<?php endif;

					$description = get_bloginfo( 'description', 'display' );

					if ( $description || is_customize_preview() ) : ?>

						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>

					<?php endif; ?>

				</div><!--#header-text-->

				<nav id="site-navigation" class="main-navigation">

					<div class="menu-toggle">

						<i class="fa fa-bars"></i>

					</div>

					<?php if ( is_front_page() && has_nav_menu( 'singleapp' ) ) : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'singleapp', 'menu_id' => 'nav', 'menu_class' => 'menu tg-menu-wrapper' ) ); ?>
					<?php else : ?>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'nav', 'menu_class' => 'menu tg-menu-wrapper' ) ); ?>
					<?php endif; ?>		

				</nav><!--nav end-->

			</div><!-- end tg-container -->

		</div><!--header wrapper end-->

	</header><!--header end-->
	
	<?php do_action( 'singleapp_after_header' ); ?>