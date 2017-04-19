<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */

?>

	<footer class="copyright">

		<div class="section-wrapper">

			<div class="tg-container">

				<div class="footer-content">

	   				<?php if ( has_custom_logo() && singleapp_theme_style() == 'onepage' ) : ?>

		   				<h3 class="footer-logo wow fadeInUp"><?php singleapp_the_custom_logo() ?></h3>

		   			<?php endif; ?>

		   			<?php if ( singleapp_theme_style() == 'fullpage'  && get_theme_mod('singleapp_footer_social_icon','') !== '' ) : ?>

		   				<div class="social-icons">

		   					<?php echo do_shortcode( wp_kses_post( get_theme_mod('singleapp_footer_social_icon') ) ); ?>
		   				</div>

		   			<?php endif; ?>

     
		   			<?php singleapp_footer_copyright_info(); ?>	

				</div>

			</div><!-- end tg-container -->

		</div><!-- #section-wrapper -->

	</footer><!-- end copyright -->

</div><!-- #page -->

<?php wp_footer(); ?>

<a id="scroll-up" href="#masthead" style="display: inline;">
	<i class="fa fa-long-arrow-up"></i>
</a>

</body>

</html>
