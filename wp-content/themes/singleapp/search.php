<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
						
					<?php if ( have_posts() ) : ?>

						<header class="page-header">

							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for : %s', 'singleapp' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
							
						</header><!-- .page-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'blog' );

						endwhile;

						singleapp_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif; ?>
						
				</div><!-- #primary -->

				<?php  singleapp_sidebar_select(); ?>

		   	</div><!-- .tg-container -->

		</main><!-- #main -->
		
	</div><!-- #content -->

	<?php do_action( 'singleapp_after_body_content' ); ?>

<?php get_footer(); ?>