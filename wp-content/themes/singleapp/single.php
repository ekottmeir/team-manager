<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

		   		<!-- Breadcrumbs -->
				<div class="block">

					<?php singleapp_breadcrumbs(); ?>
					
				</div>
		   		
		   		<div id="primary">
					
					<?php while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', get_post_format() );

						singleapp_navigation();

						do_action( 'singleapp_before_comments_template' );
						
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

		      			do_action ( 'singleapp_after_comments_template' );

					endwhile; ?>
					
				</div><!-- #primary -->

				<?php  singleapp_sidebar_select(); ?>

		   	</div><!-- .tg-container -->	   		
	      
		</main><!-- #main -->
		
	</div><!-- #content -->

	<?php do_action( 'singleapp_after_body_content' ); ?>

<?php get_footer(); ?>