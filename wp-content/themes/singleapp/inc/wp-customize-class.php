<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 * @package ThemeGrill
 * @subpackage SingleApp
 * @since SingleApp 1.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;

/**
 * Class theme important links starts.
 */
   class Singleapp_Important_Links extends WP_Customize_Control {

      public $type = "singleapp-important-links";

      public function render_content() {
         //Add Theme instruction, Support Forum, Demo Link, Rating Link
         $important_links = array(
            'theme-info' => array(
               'link' => esc_url('http://themegrill.com/themes/singleapp/'),
               'text' => esc_html__('Theme Info', 'singleapp'),
            ),
            'support' => array(
               'link' => esc_url('http://themegrill.com/support-forum/'),
               'text' => esc_html__('Support Forum', 'singleapp'),
            ),
            'documentation' => array(
               'link' => esc_url('http://docs.themegrill.com/singleapp/'),
               'text' => esc_html__('Documentation', 'singleapp'),
            ),
            'demo' => array(
               'link' => esc_url('http://demo.themegrill.com/singleapp/'),
               'text' => esc_html__('View Demo', 'singleapp'),
            ),
            'rating' => array(
               'link' => esc_url('http://wordpress.org/support/view/theme-reviews/singleapp?filter=5'),
               'text' => esc_html__('Rate this theme', 'singleapp'),
            ),
         );
         foreach ($important_links as $important_link) {
            echo '<p><a target="_blank" href="' . esc_url( $important_link['link'] ) . '" >' . esc_attr($important_link['text']) . ' </a></p>';
         }
      }

   }

/**
 * Class Singleapp_Image_Radio_Control
 */
class Singleapp_Image_Radio_Control extends WP_Customize_Control {

	public function render_content() {

	if ( empty( $this->choices ) )
		return;

	$name = '_customize-radio-' . $this->id;

	?>
	<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

	<ul class="controls" id = 'singleapp-img-container'>

	<?php	foreach ( $this->choices as $value => $label ) :

			$class = ($this->value() == $value)?'singleapp-radio-img-selected singleapp-radio-img-img':'singleapp-radio-img-img';

			?>

			<li style="display: inline;">

			<label>

				<input <?php $this->link(); ?>style = 'display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />

				<img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo esc_attr( $class) ; ?>' />

			</label>

			</li>

			<?php	endforeach;	?>

	</ul>

	<?php
	}
}
