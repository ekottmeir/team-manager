<?php
/**
 * SingleApp Theme Customizer.
 *
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 * 
 */

function singleapp_customize_register( $wp_customize ) {

/**
 * Loads wp customizer classes.
 */
require_once get_template_directory() . '/inc/wp-customize-class.php';
   
/********************************* IMPORTANT-LINKS ****************************************/
   $wp_customize->add_section(
      'singleapp_important_links', 
      array(
         'priority'     => 1,
         'title'        => esc_html__('SingleApp Important Links', 'singleapp')
      )
   );

   /**
    * This setting has the dummy Sanitization function as it contains no value to be sanitized
    */
   $wp_customize->add_setting(
      'singleapp_important_links', 
      array(
         'capability'          => 'edit_theme_options',
         'sanitize_callback'   => 'singleapp_sanitize_links'
      )
   );

   $wp_customize->add_control(
      new Singleapp_Important_Links($wp_customize, 
         'important_links', 
         array(
            'section'         => 'singleapp_important_links',
            'settings'        => 'singleapp_important_links'
         )
      )
   );
    
/********************************* SITE-IDENTITY-OPTIONS ****************************************/
    // logo and site title position options
   $wp_customize->add_setting(
      'singleapp_header_logo_placement',
      array(
         'default'            => 'header_text_only',
         'capability'         => 'edit_theme_options',
         'sanitize_callback'  => 'singleapp_sanitize_radio'
      )
   );

   $wp_customize->add_control(
      'singleapp_header_logo_placement',
      array(
         'type'               => 'radio',
         'priority'           => 20,
         'label'              => esc_html__('Choose the option that you want from below.', 'singleapp'),
         'section'            => 'title_tagline',
         'choices'            => array(
            'header_logo_only'   => esc_html__('Header Logo Only', 'singleapp'),
            'header_text_only'   => esc_html__('Header Text Only', 'singleapp'),
            'show_both'          => esc_html__('Show Both', 'singleapp'),
            'disable'            => esc_html__('Disable', 'singleapp')
         )
      )
   );

/**************************************************************************************************************/
   // Theme style setting
   $wp_customize->add_section(
      'singleapp_style_settings', 
      array(
         'priority'           => 180,
         'title'              => esc_html__('Theme Style', 'singleapp'),
      )
   );

   $wp_customize->add_setting(
      'singleapp_style_layout', 
      array(
         'default'            => 'onepage_layout',
         'capability'         => 'edit_theme_options',
         'sanitize_callback'  => 'singleapp_sanitize_radio'
      )
   );

   $wp_customize->add_control(
         'singleapp_style_layout', 
         array(
            'type'            => 'radio',
            'priority'        => 10,
            'label'           => esc_html__('Choose Theme Style', 'singleapp'),
            'section'         => 'singleapp_style_settings',
            'settings'        => 'singleapp_style_layout',
            'choices'         => array(
               'onepage_layout'  => esc_html__('Onepage Style', 'singleapp'),
               'fullpage_layout' => esc_html__('Fixed Fullpage Style', 'singleapp')
            )
         )
   );


/**************************************************************************************************************/
   
   // Header Image call to action Settings
   $wp_customize->add_section(
      'header_image',
      array(
         'title'           => esc_html__('Header Image Call To Action', 'singleapp'),
         'priority'        => 60
      )
   );

   $wp_customize->add_setting(
      'singleapp_jumbotron_enable',
      array(
         'default'            => '',
         'capability'         => 'edit_theme_options',
         'sanitize_callback'  => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_jumbotron_enable',
      array(
         'label'              => esc_html__('Check to show.', 'singleapp'),
         'section'            => 'header_image',
         'settings'           => 'singleapp_jumbotron_enable',
         'type'               => 'checkbox',
         'priority'           => 10
      )
   );

   $wp_customize->add_setting( 
      'singleapp_jumbotron_title', 
      array( 
         'default'            => '', 
         'capability'         => 'edit_theme_options', 
         'sanitize_callback'  => 'singleapp_sanitize_allow_span' 
      )
   );
    $wp_customize->add_control(
      'singleapp_jumbotron_title',
      array(
         'label'              => esc_html__( 'Title', 'singleapp' ),
         'section'            => 'header_image',
         'priority'           => 20
      )
   );

   // description
   $wp_customize->add_setting(
      'singleapp_jumbotron_desc', 
      array(
         'default'               => '',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'wp_filter_nohtml_kses',
         'sanitize_js_callback'  => 'wp_filter_nohtml_kses'
      )
   );

   $wp_customize->add_control( 
      'singleapp_jumbotron_desc', 
      array(
         'type'                  => 'textarea',
         'label'                 => esc_html__('Description', 'singleapp'),
         'section'               => 'header_image',
         'settings'              => 'singleapp_jumbotron_desc',
         'priority'              => 30
      )
   );

   // jumbotron thumb image
   $wp_customize->add_setting(
      'singleapp_jumbotron_thumb', 
      array(
         'default'               => '',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'esc_url_raw'
      )
   );

   $wp_customize->add_control( 
      new WP_Customize_Image_Control( 
         $wp_customize, 
         'singleapp_jumbotron_thumb',
         array(
            'description'        => esc_html__( 'Recommanded Thumb Image size 278 × 450 Pixels.', 'singleapp' ),
            'label'              => esc_html__('Thumb Image','singleapp'),
            'section'            => 'header_image',
            'settings'           => 'singleapp_jumbotron_thumb',
            'priority'           => 40
         )
      )
   );


   for( $i = 1; $i <= 2; $i++ ) {
      $wp_customize->add_setting(
         'singleapp_jumbotron_btn_text'.$i,
         array(
            'default'            => '',
            'capability'         => 'edit_theme_options',
            'sanitize_callback'  => 'singleapp_sanitize_allow_span'
         )
      );

      $wp_customize->add_control(
         'singleapp_jumbotron_btn_text'.$i,
         array(
            'label'              => esc_html__( 'Button Text ' , 'singleapp' ).$i,
            'section'            => 'header_image',
            'priority'           =>  $i*50
         )
      );

      $wp_customize->add_setting(
         'singleapp_button_url'.$i,
         array(
            'default'            => '#',
            'capability'         => 'edit_theme_options',
            'sanitize_callback'  => 'esc_url_raw'
         )
      );

      $wp_customize->add_control(
         'singleapp_button_url'.$i,
         array(
            'label'              => esc_html__( 'Button URL ' , 'singleapp' ).$i,
            'section'            => 'header_image',
            'priority'           =>  $i*50
         )
      );

      $wp_customize->add_setting(
         'singleapp_button_icon'.$i,
         array(
            'default'            => '',
            'capability'         => 'edit_theme_options',
            'sanitize_callback'  => 'wp_filter_nohtml_kses'
         )
      );

      $wp_customize->add_control(
         'singleapp_button_icon'.$i,
         array(
            'label'              => sprintf(esc_html__( 'Button Font Icon %1$d. Add the font-awesome icon class below. For eg: fa-play' , 'singleapp' ), $i),
            'section'            => 'header_image',
            'priority'           =>  $i*50
         )
      );
   }


/**************************************************************************************************************/
   $wp_customize->add_panel(
      'singleapp_design_options', 
      array(
         'capabitity'            => 'edit_theme_options',
         'priority'              => 220,
         'title'                 => esc_html__('Design Options', 'singleapp')
      )
   );

   
   // Default Layout
   $wp_customize->add_section(
      'singleapp_global_layout_section',
      array(
         'priority'              => 30,
         'title'                 => esc_html__( 'Default Layout', 'singleapp' ),
         'panel'                 => 'singleapp_design_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_global_layout',
      array(
         'default'               => 'right_sidebar',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'singleapp_sanitize_radio'
      )
   );

   $wp_customize->add_control(
      new Singleapp_Image_Radio_Control (
         $wp_customize,
         'singleapp_global_layout',
         array(
            'label'              => esc_html__( 'Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options', 'singleapp' ),
            'section'            => 'singleapp_global_layout_section',
            'type'               => 'radio',
            'choices'            => array(
               'right_sidebar'               => SINGLEAPP_ADMIN_IMAGES_URL . '/right-sidebar.png',
               'left_sidebar'                => SINGLEAPP_ADMIN_IMAGES_URL . '/left-sidebar.png',
               'no_sidebar_full_width'       => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
               'no_sidebar_content_centered' => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
            )
         )
      )
   );

   // Default Pages Layout
   $wp_customize->add_section(
      'singleapp_default_page_layout_section',
      array(
         'priority'              => 45,
         'title'                 => esc_html__( 'Default Page Layout', 'singleapp' ),
         'panel'                 => 'singleapp_design_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_default_page_layout',
      array(
         'default'               => 'right_sidebar',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'singleapp_sanitize_radio'
      )
   );

   $wp_customize->add_control(
      new Singleapp_Image_Radio_Control (
         $wp_customize,
         'singleapp_default_page_layout',
         array(
            'label'              => esc_html__( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page', 'singleapp' ),
            'section'            => 'singleapp_default_page_layout_section',
            'type'               => 'radio',
            'choices'            => array(
               'right_sidebar'               => SINGLEAPP_ADMIN_IMAGES_URL . '/right-sidebar.png',
               'left_sidebar'                => SINGLEAPP_ADMIN_IMAGES_URL . '/left-sidebar.png',
               'no_sidebar_full_width'       => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
               'no_sidebar_content_centered' => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
            )
         )
      )
   );

   // Default Single Post Layout
   $wp_customize->add_section(
      'singleapp_default_single_post_layout_section',
      array(
         'priority'              => 60,
         'title'                 => esc_html__( 'Default Single Post Layout', 'singleapp' ),
         'panel'                 => 'singleapp_design_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_default_single_post_layout',
      array(
         'default'               => 'right_sidebar',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'singleapp_sanitize_radio'
      )
   );

   $wp_customize->add_control(
      new Singleapp_Image_Radio_Control (
         $wp_customize,
         'singleapp_default_single_post_layout',
         array(
            'label'              => esc_html__( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'singleapp' ),
            'section'            => 'singleapp_default_single_post_layout_section',
            'type'               => 'radio',
            'choices'            => array(
               'right_sidebar'               => SINGLEAPP_ADMIN_IMAGES_URL . '/right-sidebar.png',
               'left_sidebar'                => SINGLEAPP_ADMIN_IMAGES_URL . '/left-sidebar.png',
               'no_sidebar_full_width'       => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
               'no_sidebar_content_centered' => SINGLEAPP_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
            )
         )
      )
   );

   // Primary Color Setting
   $wp_customize->add_section(
      'singleapp_primary_color_section',
      array(
         'priority'              => 75,
         'title'                 => esc_html__( 'Primary Color', 'singleapp' ),
         'panel'                 => 'singleapp_design_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_primary_color',
      array(
         'default'              => '#00aced',
         'capability'           => 'edit_theme_options',
         'sanitize_callback'    => 'singleapp_hex_color_sanitize',
         'sanitize_js_callback' => 'singleapp_color_escaping_sanitize'
      )
   );

   $wp_customize->add_control(
      new WP_Customize_Color_Control(
         $wp_customize,
         'singleapp_primary_color',
         array(
            'label'              => esc_html__( 'This will reflect in links, buttons and many others. Choose a color to match your site', 'singleapp' ),
            'section'            => 'singleapp_primary_color_section'
         )
      )
   );


   // Custom CSS Box
   $wp_customize->add_section(
      'singleapp_custom_css_setting', 
      array(
         'priority'              => 90,
         'title'                 => esc_html__('Custom CSS', 'singleapp'),
         'panel'                 => 'singleapp_design_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_custom_css', 
      array(
         'default'               => '',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'wp_filter_nohtml_kses',
         'sanitize_js_callback'  => 'wp_filter_nohtml_kses'
      )
   );

   $wp_customize->add_control(
      'singleapp_custom_css', 
      array(
         'label'                 => esc_html__('Write your custom css', 'singleapp'),
         'section'               => 'singleapp_custom_css_setting',
         'settings'              => 'singleapp_custom_css',
         'priority'              => 10,
         'type'                  => 'textarea'
      )
   );

/**************************************************************************************************************/
   $wp_customize->add_panel(
      'singleapp_additional_options', 
      array(
         'capabitity'            => 'edit_theme_options',
         'priority'              => 240,
         'title'                 => esc_html__('Additional Options', 'singleapp')
      )
   );

   // WOW 
   $wp_customize->add_section(
      'singleapp_wow_disable_setting', 
      array(
         'priority'              => 15,
         'title'                 => esc_html__('Animation Settings', 'singleapp'),
         'panel'                 => 'singleapp_additional_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_wow_enable',
      array(
         'default'               => '',
         'capability'            => 'edit_theme_options',
         'sanitize_callback'     => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_wow_enable', 
      array(
         'label'                    => esc_html__('Check to hide animation effect.', 'singleapp'),
         'section'                  => 'singleapp_wow_disable_setting',
         'settings'                 => 'singleapp_wow_enable',
         'type'                     => 'checkbox',
         'priority'                 => 10
      )
   );

   // Post Meta Settings
   $wp_customize->add_section(
      'singleapp_post_meta_setting', 
      array(
         'priority'                 => 30,
         'title'                    => esc_html__('Post Meta Settings', 'singleapp'),
         'panel'                    => 'singleapp_additional_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_post_date_disable',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_post_date_disable', 
      array(
         'label'                    => esc_html__('Check to hide post date.', 'singleapp'),
         'section'                  => 'singleapp_post_meta_setting',
         'settings'                 => 'singleapp_post_date_disable',
         'type'                     => 'checkbox',
         'priority'                 => 10
      )
   );

   $wp_customize->add_setting(
      'singleapp_post_author_disable',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_post_author_disable', 
      array(
         'label'                    => esc_html__('Check to hide post author.', 'singleapp'),
         'section'                  => 'singleapp_post_meta_setting',
         'settings'                 => 'singleapp_post_author_disable',
         'type'                     => 'checkbox',
         'priority'                 => 20
      )
   );

   $wp_customize->add_setting(
      'singleapp_post_comment_disable',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_post_comment_disable', 
      array(
         'label'                    => esc_html__('Check to hide post comment count.', 'singleapp'),
         'section'                  => 'singleapp_post_meta_setting',
         'settings'                 => 'singleapp_post_comment_disable',
         'type'                     => 'checkbox',
         'priority'                 => 30
      )
   );

   $wp_customize->add_setting(
      'singleapp_post_category_disable',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_post_category_disable', 
      array(
         'label'                    => esc_html__('Check to hide post category.', 'singleapp'),
         'section'                  => 'singleapp_post_meta_setting',
         'settings'                 => 'singleapp_post_category_disable',
         'type'                     => 'checkbox',
         'priority'                 => 40
      )
   );

   $wp_customize->add_setting(
      'singleapp_post_tags_disable',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'singleapp_sanitize_checkbox'
      )
   );

   $wp_customize->add_control(
      'singleapp_post_tags_disable',
      array(
         'label'                    => esc_html__('Check to hide post tag.', 'singleapp'),
         'section'                  => 'singleapp_post_meta_setting',
         'settings'                 => 'singleapp_post_tags_disable',
         'type'                     => 'checkbox',
         'priority'                 => 50
      )
   );

   /**************************************************************************************************************/
   $wp_customize->add_panel(
      'singleapp_footer_options', 
      array(
         'capabitity'               => 'edit_theme_options',
         'priority'                 => 260,
         'title'                    => esc_html__('Footer Options', 'singleapp')
      )
   );

   // Footer social icons

   $url_wp_social_icom = 'https://wordpress.org/plugins/social-icons/';
   $link_social_icon = sprintf( wp_kses( __( 'Please install <a href="%s" target="_blank">Social Icons</a> Plugin, generate Shortcode and use Shortcode below', 'singleapp' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url_wp_social_icom ) );

   $wp_customize->add_section(
      'singleapp_footer_social_icons_setting', 
      array(
         'description'              => '<strong>'.esc_html__( 'Note', 'singleapp').'</strong><br/>'.$link_social_icon,
         'priority'                 => 15,
         'title'                    => esc_html__('Footer Social Icons', 'singleapp'),
         'panel'                    => 'singleapp_footer_options'
      )
   );

   $wp_customize->add_setting(
      'singleapp_footer_social_icon',
      array(
         'default'                  => '',
         'capability'               => 'edit_theme_options',
         'sanitize_callback'        => 'sanitize_text_field'
      )
   );

   $wp_customize->add_control(
      'singleapp_footer_social_icon', 
      array(
         'label'                    => esc_html__('Enter social icon shortcode.', 'singleapp'),
         'section'                  => 'singleapp_footer_social_icons_setting',
         'settings'                 => 'singleapp_footer_social_icon',
         'type'                     => 'input',
         'priority'                 => 10
      )
   );


   // radio sanitization
   function singleapp_sanitize_radio( $input, $setting ) {
      // Ensuring that the input is a slug.
      $input = sanitize_key( $input );
      // Get the list of choices from the control associated with the setting.
      $choices = $setting->manager->get_control( $setting->id )->choices;
      // If the input is a valid key, return it, else, return the default.
      return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
   }

   // checkbox sanitize
   function singleapp_sanitize_checkbox($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }

   // sanitization of integer
   function singleapp_sanitize_integer( $input ) {
      if( is_numeric( $input ) ) {
         return intval( $input );
      }
   }

   // sanitization of links
   function singleapp_sanitize_links() {
      return false;
   }
   // sanitization of links
   function singleapp_sanitize_allow_span($input) {
      $cus_allowed_tags = array(
         'span' => array()
      );
      $input_fil = wp_kses($input, $cus_allowed_tags);
      return $input_fil;        
   }
   // Sanitize Color
   function singleapp_hex_color_sanitize( $color ) {
      return sanitize_hex_color( $color );
   }
   // Escape Color
   function singleapp_color_escaping_sanitize( $input ) {
      $input = esc_attr($input);
      return $input;
   }


}
add_action( 'customize_register', 'singleapp_customize_register' );