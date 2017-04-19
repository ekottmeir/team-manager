<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage <SingleApp></SingleApp>
 * @since SingleApp 1.0
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function singleapp_widgets_init() {
   register_sidebar( array(
      'name'          => esc_html__( 'Right Sidebar', 'singleapp' ),
      'id'            => 'singleapp-sidebar-right',
      'description'   => esc_html__( 'Add widgets in right sidebar area.', 'singleapp' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4>',
   ) );

   register_sidebar( array(
      'name'          => esc_html__( 'Left Sidebar', 'singleapp' ),
      'id'            => 'singleapp-sidebar-left',
      'description'   => esc_html__( 'Add widgets in left sidebar area.', 'singleapp' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4>',
   ) );

   register_sidebar( array(
      'name'          => esc_html__( 'Front Page Builder', 'singleapp' ),
      'id'            => 'singleapp-front-page-sidebar',
      'description'   => esc_html__( 'Show widgets at Front Page Content Section.', 'singleapp' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h4 class="widget-title">',
      'after_title'   => '</h4>',
   ) );

   register_widget( "singleapp_features_widget" );
   register_widget( "singleapp_featured_page_widget" );
   register_widget( "singleapp_image_showcase_widget" );
   register_widget( "singleapp_call_to_action_widget" );
   register_widget( "singleapp_testimonial_widget" );
   register_widget( "singleapp_contact_widget" );

}
add_action( 'widgets_init', 'singleapp_widgets_init' );

/**************************************************************************************/
/**
 * Features Widget section.
 */
class singleapp_features_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_features_block', 'description' => esc_html__( 'Show your some pages as features.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__( 'TG: Features', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {
      for ( $i=1; $i<=12; $i++ ) {
         $var = 'page_id'.$i;
         $defaults[$var] = '';
      }
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#ffffff';
      $defaults['image'] = '';

      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];
      $image = $instance['image'];
      ?>
      <p><?php esc_html_e( 'Note: Enter the Features Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'image' ); ?>"> <?php esc_html_e( 'Thumb Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
      <?php
      $url = 'http://fontawesome.io/icons/';
      $link = sprintf( wp_kses( __( '<a href="%s" target="_blank">Refer here</a> For Icon Class', 'singleapp' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
      echo $link;
      ?>
      </p>

      <?php
      for( $i=1; $i<=12; $i++) {
         if( $i%2 != 0 ){ ?>
            <p>
               <label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Page', 'singleapp' ); ?>:</label>
               <?php wp_dropdown_pages( array( 'class' => 'widefat','show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => $instance[ key($defaults) ] ) ); ?>
            </p>
         <?php }
         elseif( $i%2 == 0 ) { ?>
            <p>
               <label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Icon Class:', 'singleapp' ); ?></label>
               <input id="<?php echo $this->get_field_id( key($defaults) ); ?>" class="widefat" name="<?php echo $this->get_field_name( key($defaults) ); ?>" placeholder="fa-check" type="text" value="<?php echo $instance[ key($defaults) ]; ?>" />
            </p>
         <?php }
         next( $defaults );// forwards the key of $defaults array
      }?>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php esc_html_e( '1. Background Image and Background Color only used for Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '3. Recommanded Thumb Image size 278 × 450 Pixels.', 'singleapp' ); ?><br/>
      </p>
   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      $instance[ 'image' ] = esc_url_raw( $new_instance[ 'image' ] );
      for( $i=1; $i<=12; $i++ ) {
         $var = 'page_id'.$i;
         if( $i%2 != 0 )
            $instance[ $var] = absint( $new_instance[ $var ] );
         elseif( $i%2 == 0 )
            $instance[ $var ] = wp_filter_nohtml_kses( $new_instance[ $var ] );
      }
      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) );
         // wp_filter_post_kses() expects slashed

      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
      $image = isset( $instance[ 'image' ] ) ? $instance[ 'image' ] : '';

      $page_array = array();
      $icon = array();
      for( $i=1; $i<=12; $i++ ) {
         $var = 'page_id'.$i;
         if( $i%2 != 0 ){
            $page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
            if( !empty( $page_id ) )
               array_push( $page_array, $page_id );// Push the page id in the array
         }
         elseif( $i%2 == 0 && !( empty( $page_id ) ) ) {
            $strn =  $instance[ $var ];
            array_push( $icon, $strn );
         }
      }
      $get_pages = new WP_Query( array(
         'posts_per_page'        => -1,
         'post_type'             =>  array( 'page' ),
         'post__in'              => $page_array,
         'orderby'               => 'post__in'
      ) );

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>
      <div id="<?php echo esc_attr( $menu_id ); ?>" class="features tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
            <div class="section-wrapper clearfix">
               <div class="tg-container">
                  <?php
                  $content['section_title'] = '<div class="section-title-wrapper"><h3 class="section-title wow fadeInUp">'.esc_html( $title ).'</h3><h4 class="sub-title wow fadeInUp">'.esc_textarea( $text ).'</h4></div>';
                  $content['feature_image'] = '<div class="tg-column-3 feature-center-image"><figure class="feature-image tg-screenshot"><img src="'.esc_url( $image ).'" /></figure></div>';
                  ?>
                  <?php if ( singleapp_theme_style() == 'onepage' ) : ?>
                     <?php if( $title || $text ) : ?>
                        <?php echo $content['section_title'];?>
                     <?php endif; ?>
                  <?php else: ?>
                     <?php if( $image ) : ?>
                        <div class="tg-column-wrapper feature-phone-image clearfix">
                           <?php echo $content['feature_image'];?>
                        </div><!-- .tg-column-wrapper end -->
                     <?php endif; ?>
                  <?php endif; ?>

                  <div class="feature-wrapper fullpage-content clearfix">
                     <div class="tg-column-wrapper clearfix">
                     <?php if ( singleapp_theme_style() == 'fullpage' ) : ?>
                        <?php if( $title || $text ) : ?>
                           <?php echo $content['section_title'];?>
                        <?php endif; ?>
                     <?php endif; ?>

                     <?php if ( $get_pages->have_posts() ) : $key_odd=0;?>
                        <div class="tg-column-3 feature-left">
                           <?php while ( $get_pages->have_posts() ) : $get_pages->the_post(); ?>
                              <?php
                              $icon_image_class = '';
                              $feature_image = '';
                              if( !empty ( $icon[$key_odd] ) ) {
                                 $icon_image_class = 'feature-icon';
                                 $feature_image = '<div class="icon-border"></div><i class="fa ' . esc_attr( $icon[$key_odd] ) . '"></i>';
                              }
                              if( has_post_thumbnail() ) {
                                 $icon_image_class = 'feature-image';
                                 $feature_image = get_the_post_thumbnail( $post->ID, 'singleapp-feature-thumb' );
                              } ?>
                              <?php if($key_odd % 2 == 0) :  ?>
                              <div class="feature-block clearfix wow fadeInLeft">
                                 <div class="feature-subheading">
                                    <h3 class="feature-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                    <h4 class="feature-desc"><?php the_excerpt(); ?></h4>
                                 </div>
                                 <figure class="<?php echo esc_attr( $icon_image_class ); ?> fadeInUp">
                                    <?php echo $feature_image; ?>
                                 </figure>

                              </div><!--feature block end-->
                              <?php endif; $key_odd++;?>
                           <?php endwhile; ?>
                           <?php wp_reset_postdata(); ?>
                        </div>
                     <?php endif; ?>

                     <?php if ( singleapp_theme_style() == 'onepage' )   : ?>
                        <?php if( $image ) : ?>
                           <?php echo $content['feature_image'];?>
                        <?php endif; ?>
                     <?php endif; ?>

                     <?php if ( $get_pages->have_posts() ) : $key_even=0;?>
                        <div class="tg-column-3 feature-right">
                           <?php while ( $get_pages->have_posts() ) : $get_pages->the_post(); ?>
                              <?php
                              $icon_image_class = '';
                              $feature_image = '';
                              if( !empty ( $icon[$key_even] ) ) {
                                 $icon_image_class = 'feature-icon';
                                 $feature_image = '<div class="icon-border"></div><i class="fa ' . esc_attr( $icon[$key_even] ) . '"></i>';
                              }
                              if( has_post_thumbnail() ) {
                                 $icon_image_class = 'feature-image';
                                 $feature_image = get_the_post_thumbnail( $post->ID, 'singleapp-feature-thumb' );
                              } ?>

                           <?php if($key_even % 2 == 1) :  ?>
                              <div class="feature-block clearfix wow fadeInRight">
                                 <div class="feature-subheading">
                                    <h3 class="feature-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
                                    <h4 class="feature-desc"><?php the_excerpt(); ?></h4>
                                 </div>
                                 <figure class="<?php echo esc_attr( $icon_image_class ); ?> fadeInUp">
                                    <?php echo $feature_image; ?>
                                 </figure>
                              </div><!--feature block end-->
                           <?php endif; $key_even++;?>
                           <?php endwhile; ?>
                           <?php wp_reset_postdata(); ?>
                        </div><!-- .tg-column-3 end -->
                     <?php endif; ?>
                     </div><!-- .tg-column-wrapper end -->
                  </div><!-- .feature-wrapper end -->
               </div><!-- .tg-container end -->
            </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .feature end -->
   <?php }
}
/**************************************************************************************/
/**
 * Featured Page Widget section.
 */
class singleapp_featured_page_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_featured_page_block', 'description' => esc_html__( 'Display page with thumbnail and content as featured page.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__( 'TG: Featured Page', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#f2f2f2';
      $defaults['page_id'] = '';

      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];
      $page_id = $instance[ 'page_id' ];
      ?>

      <p><?php esc_html_e( 'Note: Enter the Featured Page Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php esc_html_e( 'Select Page', 'singleapp' ); ?>:</label>
         <?php wp_dropdown_pages( array( 'class' => 'widefat', 'show_option_none' =>' ','name' => $this->get_field_name( 'page_id' ), 'selected' => absint($page_id ) ) ); ?>
      </p>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php esc_html_e( '1. Background Image and Background Color only used for Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      </p>
   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      $instance[ 'page_id' ] = absint( $new_instance[ 'page_id' ] );
      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
      $page_id = isset( $instance[ 'page_id' ] ) ? $instance[ 'page_id' ] : '';

      $get_pages = new WP_Query( array(
         'posts_per_page'     => 1,
         'post_type'          =>  array( 'page' ),
         'page_id'           => $page_id
      ) );

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>

      <div id="<?php echo esc_attr( $menu_id ); ?>" class="overview tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
            <div class="section-wrapper clearfix">
               <?php if ( $get_pages->have_posts() ) : ?>
                  <div class="tg-container">
                     <?php if( $title || $text ) : ?>
                        <div class="section-title-wrapper">
                           <?php if( $title ) : ?>
                              <h3 class="section-title wow fadeInUp"><?php echo esc_html( $title );?></h3>
                           <?php endif; ?>

                           <?php if( $text ) : ?>
                              <h4 class="sub-title wow fadeInUp"><?php echo esc_textarea( $text ); ?></h4>
                           <?php endif; ?>
                        </div><!-- .section-title-wrapper end -->
                     <?php endif; ?>
                     <div class="overview-wrapper clearfix">
                        <div class="tg-column-wrapper">
                           <?php while ( $get_pages->have_posts() ) : $get_pages->the_post(); ?>
                              <div class="tg-column-2 overview-content-image clearfix">
                                 <figure class="overview-image tg-screenshot">
                                   <?php if( has_post_thumbnail() ) :
                                       $size = '';
                                       if ( singleapp_theme_style() == 'onepage' ) {
                                             $size = 'singleapp-overview-thumb';
                                          } else {
                                             $size = 'singleapp-overview-thumbs';
                                       }
                                       $attr = array( 'class' => 'wow fadeInUp black-iphone');
                                   ?>
                                       <?php the_post_thumbnail( $size, $attr  ) ?>
                                    <?php endif; ?>
                                 </figure>
                              </div><!-- .tg-column-2 end -->
                              <div class="tg-column-2 overview-inner-content fullpage-content clearfix">
                                 <div class="section-title-wrapper">
                                    <h3 class="overview-title wow fadeInRight"><?php the_title() ?></h3>
                                    <div class="over-desc wow fadeInRight"><?php the_content(); ?></div>
                                 </div><!-- .section-title-wrapper end -->
                              </div><!-- .tg-column-2 end -->
                           <?php endwhile; ?>
                           <?php wp_reset_postdata(); ?>
                        </div><!-- .tg-column-wrapper end -->
                     </div><!-- .verview-wrapper end -->
                  </div><!-- .tg-container end -->
               <?php endif; ?>
            </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .overview Page end -->

   <?php }
}
/**************************************************************************************/
/**
 * Image Showcase Widget section.
 */
class singleapp_image_showcase_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_image_showcase_block', 'description' => esc_html__( 'Display images as in Image Showcase.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__( 'TG: Image Showcase', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {
      for ( $i=1; $i<=6; $i++ ) {
         $var = 'image'.$i;
         $defaults[$var] = '';
      }
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#747a9c';

      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];

      ?>

      <p><?php esc_html_e( 'Note: Enter the Image Showcase Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>
      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <?php
      for( $i=1; $i<=6; $i++) { ?>

      <p>
         <label for="<?php echo $this->get_field_id(key($defaults)); ?>"> <?php esc_html_e( 'Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id(key($defaults)); ?>">
            <div class="custom_media_preview">
               <?php if ( $instance[ key($defaults) ] != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ key($defaults) ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id(key($defaults)); ?>" name="<?php echo $this->get_field_name(key($defaults)); ?>" value="<?php echo $instance[ key($defaults) ]; ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id(key($defaults)); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <?php
         next( $defaults );// forwards the key of $defaults array
      }?>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php esc_html_e( '1. Background Image and Background Color only used for Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '3. Recommanded Image size with 278 × 450 Pixels.', 'singleapp' ); ?><br/>
      </p>
   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      for( $i=1; $i<=6; $i++ ) {
         $var = 'image'.$i;
         $instance[ $var] = esc_url_raw( $new_instance[ $var ] );
      }

      if ( current_user_can('unfiltered_html') )
         $instance[ 'text' ] =  $new_instance[ 'text' ];
      else
         $instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) );
         // wp_filter_post_kses() expects slashed
      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
      $image1 = isset( $instance[ 'image1' ] ) ? $instance[ 'image1' ] : '';

      $image_array = array();
      for( $i=1; $i<=6; $i++ ) {
         $var = 'image'.$i;
         $image = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
         if( !empty( $image ) )
            array_push( $image_array, $image );// Push the image in the array
      }

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>

      <div id="<?php echo esc_attr( $menu_id ); ?>" class="screenshot tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
            <?php if( singleapp_theme_style() == 'onepage' ) : ?>
               <div class="overlay"></div>
            <?php endif; ?>
            <div class="section-wrapper clearfix">
               <div class="tg-container">
                  <?php if( $title || $text ) : ?>
                     <div class="section-title-wrapper fullpage-content">
                        <?php if( $title ) : ?>
                           <h3 class="section-title wow fadeInUp"><?php echo esc_html( $title );?></h3>
                        <?php endif; ?>

                        <?php if( $text ) : ?>
                           <h4 class="sub-title wow fadeInUp"><?php echo esc_textarea( $text ); ?></h4>
                        <?php endif; ?>
                     </div><!-- .section-title-wrapper end -->
                  <?php endif; ?>
                  <?php if ( $image_array ) : ?>
                     <div class="screenshot-wrapper">
                        <ul class="screenshot-slider">
                          <?php foreach ($image_array as $key => $value ) : ?>
                             <li class="tg-screenshot"><img src="<?php echo esc_url( $value ); ?>" class="wow fadeInUp" alt="<?php esc_html_e('Showcase Image', 'singleapp' ); ?>" /></li>
                           <?php endforeach; ?>
                        </ul><!-- .screenshot-slider end -->
                     </div><!-- .screenshot wrapper end -->
                  <?php endif; ?>
               </div><!-- .tg-container end -->
            </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .screenshot end -->

   <?php }
}
/**************************************************************************************/
/**
 * Call to Action Widget section.
 */
class singleapp_call_to_action_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_call_to_action_block section', 'description' => esc_html__( 'Display title, description, image and buttons as call to action.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__('TG: Call to Action', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {

      for ( $i=1; $i<=4; $i++ ) {
         $var = 'call_btn_id'.$i;
         $defaults[$var] = '';
      }
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#ffffff';
      $defaults['image'] = '';
      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];
      $image = $instance['image'];

      ?>

      <p><?php esc_html_e( 'Note: Enter the Call To Action Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'image' ); ?>"> <?php esc_html_e( 'Thumb Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <?php
      for( $i=1; $i<=4; $i++) {
         if( $i%2 != 0 ){ ?>
            <p>
               <label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Button Text:', 'singleapp' ); ?></label>
               <input id="<?php echo $this->get_field_id( key($defaults) ); ?>" class="widefat" name="<?php echo $this->get_field_name( key($defaults) ); ?>" type="text" value="<?php echo $instance[ key($defaults) ]; ?>" />
            </p>
         <?php }
         elseif( $i%2 == 0 ) { ?>
            <p>
               <label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Button URL:', 'singleapp' ); ?></label>
               <input id="<?php echo $this->get_field_id( key($defaults) ); ?>" class="widefat" name="<?php echo $this->get_field_name( key($defaults) ); ?>" type="text" value="<?php echo $instance[ key($defaults) ]; ?>" />
            </p>
         <?php }
         next( $defaults );// forwards the key of $defaults array
      }?>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php esc_html_e( '1. Background Image and Background Color only used for Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '3. Recommanded Thumb Image size with 850 X 212 Pixels for Onepage and 278 × 450 Pixels for Fullpage style.', 'singleapp' ); ?><br/>
      </p>

   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      $instance[ 'image' ] = esc_url_raw( $new_instance[ 'image' ] );
      for( $i=1; $i<=4; $i++ ) {
         $var = 'call_btn_id'.$i;
         if( $i%2 != 0 )
            $instance[ $var] = sanitize_text_field( $new_instance[ $var ] );
         elseif( $i%2 == 0 )
            $instance[ $var ] = esc_url_raw( $new_instance[ $var ] );
      }

      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
      $image = isset( $instance[ 'image' ] ) ? $instance[ 'image' ] : '';

      $text_array = array();
      $url_array = array();
      for( $i=1; $i<=4; $i++ ) {
         $var = 'call_btn_id'.$i;
         if( $i%2 != 0 ){
            $call_btn_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
            if( !empty( $call_btn_id ) )
               array_push( $text_array, $call_btn_id );// Push the page id in the array
         }
         elseif( $i%2 == 0 && !( empty( $call_btn_id ) ) ) {
            $btn_url =  $instance[ $var ];
            array_push( $url_array, $btn_url );
         }
      }

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>


      <div id="<?php echo esc_attr( $menu_id ); ?>" class="share tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
            <div class="section-wrapper clearfix">
               <div class="tg-container">
                  <?php
                  $content['section_title'] = '<div class="section-title-wrapper"><h3 class="section-title wow fadeInUp">'.esc_html( $title ).'</h3><h4 class="sub-title wow fadeInUp">'.esc_textarea( $text ).'</h4></div>';
                  $content['feature_image'] = '<figure class="share-image tg-screenshot"><img src="'.esc_url( $image ).'" /></figure>';
                  ?>
                  <?php if ( singleapp_theme_style() == 'onepage' ) : ?>
                     <?php if( $title || $text ) : ?>
                        <?php echo $content['section_title'];?>
                     <?php endif; ?>
                  <?php else: ?>
                     <?php if( $image ) : ?>
                        <?php echo $content['feature_image'];?>
                     <?php endif; ?>
                  <?php endif; ?>
                  <div class="share-wrapper fullpage-content">
                     <?php if ( singleapp_theme_style() == 'fullpage' ) : ?>
                        <?php if( $title || $text ) : ?>
                           <?php echo $content['section_title'];?>
                        <?php endif; ?>
                     <?php endif; ?>

                     <?php if ( singleapp_theme_style() == 'onepage' )   : ?>
                        <?php if( $image ) : ?>
                           <?php echo $content['feature_image'];?>
                        <?php endif; ?>
                     <?php endif; ?>

                     <?php if ( !empty( $text_array ) ) : ?>
                        <div class="btn-wrapper wow fadeInUp">
                           <?php foreach ($text_array as $key => $value) : ?>
                              <?php if ( !empty( $text_array[$key] ) ) : ?>
                                 <a href="<?php echo esc_url( $url_array[$key] ); ?>"><?php echo esc_attr( $value ); ?></a>
                              <?php endif; ?>
                           <?php endforeach; ?>
                        </div><!-- .btn-wrapper end -->
                     <?php endif; ?>
                  </div><!-- .share-wrapper end -->
               </div><!-- .tg-container end -->
            </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .share end -->

   <?php }
}
/**************************************************************************************/
/**
 * Testimonial Widget section.
 */
class singleapp_testimonial_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_testimonial_block', 'description' => esc_html__( 'Display Testimonial.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__( 'TG: Testimonial', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {
      for ( $i=1; $i<=4; $i++ ) {
         $var = 'page_id'.$i;
         $defaults[$var] = '';
      }
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#06060b';

      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];

      ?>

      <p><?php esc_html_e( 'Note: Enter the Testimonial Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background / Thumb Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <?php for( $i=1; $i<=4; $i++) { ?>
            <p>
               <label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php esc_html_e( 'Page', 'singleapp' ); ?>:</label>
               <?php wp_dropdown_pages( array( 'class' => 'widefat','show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => $instance[ key($defaults) ] ) ); ?>
            </p>
      <?php next( $defaults );// forwards the key of $defaults array
      } ?>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php esc_html_e( '1. Background Image and Background Color only used for Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '3. Recommanded Thumb Image size with 278 × 450 Pixels for Fullpage style.', 'singleapp' ); ?><br/>
      </p>
   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      for( $i=1; $i<=4; $i++ ) {
         $var = 'page_id'.$i;
         $instance[ $var] = absint( $new_instance[ $var ] );
      }

      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed

      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';

      $page_array = array();
      for( $i=1; $i<=4; $i++ ) {
         $var = 'page_id'.$i;
         $page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
         if( !empty( $page_id ) )
            array_push( $page_array, $page_id );// Push the page id in the array
      }
      $get_pages = new WP_Query( array(
         'posts_per_page'        => -1,
         'post_type'             =>  array( 'page' ),
         'post__in'              => $page_array,
         'orderby'               => 'post__in'
      ) );

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>

      <div id="<?php echo esc_attr( $menu_id ); ?>" class="reviews tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
         <?php if( singleapp_theme_style() == 'onepage' ) : ?>
            <div class="overlay"></div>
         <?php endif; ?>
         <div class="section-wrapper clearfix">
            <div class="tg-container">
               <?php if( singleapp_theme_style() == 'fullpage' ) : ?>
                  <div class="testimonials-image tg-screenshot">
                     <img src="<?php echo esc_url( $bg_image ) ;?>">
                  </div><!-- .testimonials-image end -->
               <?php endif; ?>
               <div class="testimonials-wrapper fullpage-content">
                  <?php if( $title || $text ) : ?>
                     <div class="section-title-wrapper">
                        <?php if( $title ) : ?>
                           <h3 class="section-title wow fadeInUp"><?php echo esc_html( $title );?></h3>
                        <?php endif; ?>

                        <?php if( $text ) : ?>
                           <h4 class="sub-title wow fadeInUp"><?php echo esc_textarea( $text ); ?></h4>
                        <?php endif; ?>
                     </div><!-- .section-title-wrapper end -->
                  <?php endif; ?>
                  <?php if ( $get_pages->have_posts() ) : ?>
                     <div class="reviews-wrapper wow fadeInUp">
                        <ul class="reviews-slider">
                           <?php while ( $get_pages->have_posts() ) : $get_pages->the_post(); ?>
                              <li>
                                 <div class="clients-reviews">
                                    <h4 class="reviews-desc"><?php the_excerpt(); ?></h4>
                                    <?php if( has_post_thumbnail() ) : ?>
                                       <figure class="client-image">
                                          <?php the_post_thumbnail( $size = 'singleapp-review-thumb', $attr = '' ) ?>
                                       </figure>
                                    <?php endif; ?>
                                    <h3 class="client-name"><?php the_title(); ?></h3>
                                 </div>
                              </li>

                           <?php endwhile; ?>
                           <?php wp_reset_postdata(); ?>
                        </ul><!-- .reviews-slider end -->
                     </div><!-- .reviews wrapper end -->
                  <?php endif; ?>
               </div><!-- .testimonials-wrapper end -->
            </div><!-- .tg-container end -->
         </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .reviews end -->


   <?php }
}
/**************************************************************************************/
/**
 * Contact us section.
 */
class singleapp_contact_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_contact_block', 'description' => esc_html__( 'Show your Contact page.', 'singleapp' ) );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false, $name = esc_html__( 'TG: Contact', 'singleapp' ), $widget_ops, $control_ops);
   }

   function form( $instance ) {
      $defaults['menu_id'] = '';
      $defaults['title'] = '';
      $defaults['text'] = '';
      $defaults['bg_image'] = '';
      $defaults['bg_color'] = '#f8f8f8';
      $defaults['scode_cntct'] = '';
      $defaults['scode_social'] = '';

      $instance = wp_parse_args( (array) $instance, $defaults );

      $menu_id = $instance['menu_id'];
      $title = $instance['title'];
      $text = $instance['text'];
      $bg_image = $instance['bg_image'];
      $bg_color = $instance['bg_color'];
      $scode_cntct = $instance['scode_cntct'] ;
      $scode_social = $instance['scode_social'] ;


      ?>
      <p><?php esc_html_e( 'Note: Enter the Contact Section ID and use same for Menu item. Only used for One Page Menu.', 'singleapp' ); ?></p>

      <p>
         <label for="<?php echo $this->get_field_id('menu_id'); ?>"><?php esc_html_e( 'Section ID:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('menu_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_id'); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>
      <?php esc_html_e( 'Description','singleapp' ); ?>
      <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>
      <p>
         <label for="<?php echo $this->get_field_id( 'bg_image' ); ?>"> <?php esc_html_e( 'Background / Thumb Image:', 'singleapp' ); ?> </label> <br />
         <div class="media-uploader" id="<?php echo $this->get_field_id( 'bg_image' ); ?>">
            <div class="custom_media_preview">
               <?php if ( $bg_image != '' ) : ?>
                  <img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="max-width:100%;" />
               <?php endif; ?>
            </div>
            <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" name="<?php echo $this->get_field_name( 'bg_image' ); ?>" value="<?php echo esc_url( $instance[ 'bg_image' ] ); ?>" style="margin-top:5px;" />
            <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'bg_image' ); ?>" data-choose="<?php echo esc_attr( 'Choose an image', 'singleapp' ); ?>" data-update="<?php echo esc_attr( 'Use image', 'singleapp' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php echo esc_html( 'Select an Image', 'singleapp' ); ?></button>
         </div>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'bg_color' ); ?>"><?php esc_html_e( 'Background Color:', 'singleapp' ); ?></label><br/>
         <input id="<?php echo $this->get_field_id( 'bg_color' ); ?>" class="widefat tg-color-picker" name="<?php echo $this->get_field_name( 'bg_color' ); ?>" type="text" value="<?php echo esc_attr( $bg_color ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'scode_cntct' ); ?>"><?php esc_html_e( 'Contact Form 7 Shortcode', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id( 'scode_cntct' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'scode_cntct' ); ?>" type="text" value='<?php echo esc_attr( $scode_cntct ); ?>' />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id( 'scode_social' ); ?>"><?php esc_html_e( 'Social Icons Shortcode', 'singleapp' ); ?></label>
         <input id="<?php echo $this->get_field_id( 'scode_social' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'scode_social' ); ?>" type="text" value='<?php echo esc_attr( $scode_social ); ?>' />
      </p>

      <p>
      <strong><?php esc_html_e( 'Note:', 'singleapp'); ?></strong><br/>
      <?php
      $url_wp_contact_form = 'https://wordpress.org/plugins/contact-form-7/';
      $url_wp_social_icom = 'https://wordpress.org/plugins/social-icons/';
      $required_plugins = sprintf( wp_kses( __( 'Install <a href="%s" target="_blank">Contact Form 7</a> and <a href="%1s" target="_blank">Social Icons</a> Plugins.', 'singleapp' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $url_wp_contact_form ), esc_url( $url_wp_social_icom ) );
      ?>

      <?php esc_html_e( '1. Background Image and Background Color only used in Onepage Style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '2. Recommanded Background Image size with 1920 X 800 Pixels.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '3. Recommanded Thumb Image size with 278 × 450 Pixels for Fullpage style.', 'singleapp' ); ?><br/>
      <?php esc_html_e( '4. ', 'singleapp' ); echo $required_plugins; ?><br/>
      </p>

   <?php }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );
      $instance[ 'menu_id' ] = sanitize_text_field( $new_instance[ 'menu_id' ] );
      $instance[ 'bg_image' ] = esc_url_raw( $new_instance[ 'bg_image' ] );
      $instance[ 'bg_color' ] = esc_attr( $new_instance[ 'bg_color' ] );
      $instance[ 'scode_cntct' ] = strip_tags( $new_instance[ 'scode_cntct' ] );
      $instance[ 'scode_social' ] = strip_tags( $new_instance[ 'scode_social' ] );

      if ( current_user_can('unfiltered_html') )
         $instance[ 'text' ] =  $new_instance[ 'text' ];
      else
         $instance[ 'text' ] = stripslashes( wp_filter_post_kses( addslashes( $new_instance[ 'text' ] ) ) ); // wp_filter_post_kses() expects slashed
      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
      $menu_id = isset( $instance[ 'menu_id' ] ) ? $instance[ 'menu_id' ] : '';
      $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
      $bg_image = isset( $instance[ 'bg_image' ] ) ? $instance[ 'bg_image' ] : '';
      $bg_color = isset( $instance[ 'bg_color' ] ) ? $instance[ 'bg_color' ] : '';
      $scode_cntct = isset( $instance[ 'scode_cntct' ] ) ? $instance[ 'scode_cntct' ] : '';
      $scode_social = isset( $instance[ 'scode_social' ] ) ? $instance[ 'scode_social' ] : '';

      $bg_style = '';
      if ( singleapp_theme_style() == 'onepage' ) {
         if ( !empty( $bg_image ) ) {
            $bg_style = 'background:url(' . esc_url($bg_image) . ') no-repeat center center;';
         } else {
            $bg_style = 'background-color:' . esc_attr($bg_color) . ';';
         }
      } else { $menu_id = ''; }?>

      <div id="<?php echo esc_attr( $menu_id ); ?>" class="contact tg-fullpage-section" style="<?php echo $bg_style; ?>">
         <?php echo $before_widget; ?>
            <div class="section-wrapper clearfix">
               <div class="tg-container">
                  <?php if( singleapp_theme_style() == 'fullpage' ) : ?>
                     <div class="contact-image tg-screenshot">
                        <img src="<?php echo esc_url( $bg_image ) ;?>">
                     </div><!-- .contact-image end -->
                  <?php endif; ?>
                  <div class="contact-block-wrapper fullpage-content">
                     <?php if( $title || $text ) : ?>
                        <div class="section-title-wrapper">
                           <?php if( $title ) : ?>
                              <h3 class="section-title wow fadeInUp"><?php echo esc_html( $title );?></h3>
                           <?php endif; ?>

                           <?php if( $text ) : ?>
                              <h4 class="sub-title wow fadeInUp"><?php echo esc_textarea( $text ); ?></h4>
                           <?php endif; ?>
                        </div><!-- .section-title-wrapper end -->
                     <?php endif; ?>
                     <?php if ( $scode_social !== '' && singleapp_theme_style() == 'onepage') : ?>
                        <div class="social-icons">
                           <?php echo do_shortcode( wp_kses_post( $scode_social ) ); ?>
                        </div><!-- .social-icons end -->
                     <?php endif; ?>
                     <?php if ( $scode_cntct !== '' ) : ?>
                        <div class="contact-wrapper">
                           <?php echo do_shortcode( wp_kses_post( $scode_cntct ) ); ?>
                        </div><!-- .contact-wrapper end -->
                     <?php endif; ?>
                  </div><!-- .contact wrapper end -->
               </div><!-- .tg-container end -->
            </div><!-- .section-wrapper end -->
         <?php echo $after_widget; ?>
      </div><!-- .contact end -->

   <?php }
}
/**************************************************************************************/