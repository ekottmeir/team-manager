<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

?>

<?php get_header(); ?>

	<?php do_action( 'singleapp_before_body_content' );

	$singleapp_layout = singleapp_layout_class(); ?>

	<div id="content" class="site-content">

	   	<main id="main" class="clearfix <?php echo esc_attr( $singleapp_layout ); ?>">

		   	<div class="tg-container">

			   	<div id="primary">

			   		<section class="error-404 not-found">
							<span class="num-404">404</span>
						<header class="page-header">

							<h1 class="page-title"><span><?php esc_html_e( 'Oops! ', 'singleapp'); ?></span><?php esc_html_e( 'That page can&rsquo;t be found.', 'singleapp' ); ?></h1>
							
						</header><!-- .page-header -->

						<div class="page-content">

							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'singleapp' ); ?></p>

							<?php get_search_form(); ?>

						</div><!-- .page-content -->

					</section><!-- .error-404 -->
					
				</div><!-- #primary -->

				<?php  singleapp_sidebar_select(); ?>
		   		
		   	</div><!-- end tg-container -->
	      
		</main><!-- #main -->
		
	</div><!-- #content -->

	<?php do_action( 'singleapp_after_body_content' ); ?>

<?php get_footer(); ?>