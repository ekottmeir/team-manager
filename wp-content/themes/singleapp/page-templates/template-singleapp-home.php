<?php
/**
 * Template Name: Landing Page Template
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */
?>

<?php get_header(); ?>

  <?php do_action( 'singleapp_before_body_content' ); ?>

  <?php $fontpage_id = '';
  if ( singleapp_theme_style() == 'onepage' ) {
    $fontpage_id = 'onepage';
  } else {
    $fontpage_id = 'fullpage';
  } ?>

  <div id="<?php echo esc_attr( $fontpage_id );?>" class="site-content">

  <?php if( get_theme_mod( 'singleapp_jumbotron_enable', '' ) == '1' && is_front_page() && singleapp_theme_style() == 'fullpage' ) {

    get_template_part( 'sections/jumbotron' );

     } ?>

    <?php
      if( is_active_sidebar( 'singleapp-front-page-sidebar' ) ) {
        if ( !dynamic_sidebar( 'singleapp-front-page-sidebar' ) ):
        endif;
      }
    ?>
  </div><!-- #content -->

  <?php if ( singleapp_theme_style() == 'fullpage' ) : ?>
  	<div class="fixed-iphone-wrapper">
    	<div class="fixed-iphone"></div>
	</div>
  <?php endif; ?>

  <?php do_action( 'singleapp_after_body_content' ); ?>

<?php get_footer(); ?>