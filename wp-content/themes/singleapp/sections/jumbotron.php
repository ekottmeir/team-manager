<?php
/**
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */
?>
<?php
$menu_id = 'home';
if ( singleapp_theme_style() == 'fullpage' ) { 
	$menu_id = '';
}?>
<div id="<?php echo esc_attr( $menu_id ); ?>" class="home-slider tg-fullpage-section">
	<?php if ( singleapp_theme_style() == 'onepage' ) : ?>
		<?php singleapp_admin_header_image(); ?>
		<div class="overlay"></div>
	<?php endif; ?>
	<div class="banner-wrapper">
		<div class="banner-container">
			<?php if ( get_theme_mod( 'singleapp_jumbotron_thumb' ) != '' ) : ?>
				<div class="iphone-screen tg-screenshot">
                    <img src="<?php echo esc_url( get_theme_mod( 'singleapp_jumbotron_thumb','#' ) );?>">
				</div><!-- .iphone-screen end -->
			<?php endif; ?>

			<div class="banner-inner-content fullpage-content">
				<?php if ( get_theme_mod( 'singleapp_jumbotron_title' ) != '' ) : ?>
					<h3 class="banner-title"><?php echo wp_kses( get_theme_mod( 'singleapp_jumbotron_title'), array('span' => array('class' => array() ) ) ) ;?></h3>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'singleapp_jumbotron_desc' ) != '' ) : ?>
					<div class="banner-content">
						<?php echo esc_textarea( get_theme_mod( 'singleapp_jumbotron_desc') ) ;?>
					</div><!-- .banner-content end -->
				<?php endif; ?>
				<div class="banner-btn-wrapper">
					<?php if ( get_theme_mod( 'singleapp_jumbotron_btn_text1' ) != '' ) : ?>
						<a href="<?php echo esc_url( get_theme_mod( 'singleapp_button_url1','#' ) ); ?>">
							<?php if( get_theme_mod( 'singleapp_button_icon1' ) && singleapp_theme_style() == 'onepage' ) : ?>
                           		<i class="fa <?php echo esc_attr( get_theme_mod( 'singleapp_button_icon1' ) );?>"></i>
                        	<?php endif; ?>
							<div class="btn-text">
								<h4><?php echo wp_kses( get_theme_mod( 'singleapp_jumbotron_btn_text1'), array('span' => array('class' => array() ) ) ) ; ?></h4>
							</div><!-- .btn-text end -->
							<?php if( get_theme_mod( 'singleapp_button_icon1' ) && singleapp_theme_style() == 'fullpage' ) : ?>
                           		<i class="fa <?php echo esc_attr( get_theme_mod( 'singleapp_button_icon1' ) );?>"></i>
                        	<?php endif; ?>
						</a>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'singleapp_jumbotron_btn_text2' ) != '' ) : ?>
						<a href="<?php echo esc_url( get_theme_mod( 'singleapp_button_url2','#' ) ); ?>">
							<?php if( get_theme_mod( 'singleapp_button_icon2' ) && singleapp_theme_style() == 'onepage' ) : ?>
                           		<i class="fa <?php echo esc_attr( get_theme_mod( 'singleapp_button_icon2' ) );?>"></i>
                        	<?php endif; ?>
							<div class="btn-text">
								<h4><?php echo wp_kses( get_theme_mod( 'singleapp_jumbotron_btn_text2'), array('span' => array('class' => array() ) ) ) ; ?></h4>
							</div><!-- .btn-text end -->
							<?php if( get_theme_mod( 'singleapp_button_icon2' ) && singleapp_theme_style() == 'fullpage' ) : ?>
                           		<i class="fa <?php echo esc_attr( get_theme_mod( 'singleapp_button_icon2' ) );?>"></i>
                        	<?php endif; ?>
						</a>
					<?php endif; ?>
					
				</div><!-- .banner-btn-wrapper end -->
			</div><!-- .banner-inner-content end -->
		</div><!-- .banner-container -->
	</div><!-- .banner-wrapper end -->
</div><!-- .home-slider end -->

