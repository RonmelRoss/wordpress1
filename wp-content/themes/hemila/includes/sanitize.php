<?php
/**
 * Customizer: Sanitization Callbacks
 *
 * This file demonstrates how to define sanitization callback functions for various data types.
 * 
 * @package   code-examples
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function hemila_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * CSS sanitization callback example.
 *
 * - Sanitization: css
 * - Control: text, textarea
 * 
 * Sanitization callback for 'css' type textarea inputs. This callback sanitizes
 * `$css` for valid CSS.
 * 
 * NOTE: wp_strip_all_tags() can be passed directly as `$wp_customize->add_setting()`
 * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
 * 
 * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 *
 * @param string $css CSS to sanitize.
 * @return string Sanitized CSS.
 */
function hemila_sanitize_css( $css ) {
	return wp_strip_all_tags( $css );
}

/**
 * Drop-down Pages sanitization callback example.
 *
 * - Sanitization: dropdown-pages
 * - Control: dropdown-pages
 * 
 * Sanitization callback for 'dropdown-pages' type controls. This callback sanitizes `$page_id`
 * as an absolute integer, and then validates that $input is the ID of a published page.
 * 
 * @see absint() https://developer.wordpress.org/reference/functions/absint/
 * @see get_post_status() https://developer.wordpress.org/reference/functions/get_post_status/
 *
 * @param int                  $page    Page ID.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int|string Page ID if the page is published; otherwise, the setting default.
 */
function hemila_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 * 
 * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
 * or not the hash prefix should be stored/retrieved with the hex color value.
 * 
 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function hemila_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Sanitization: image
 * Control: text, WP_Customize_Image_Control
 *
 * Sanitization callback for images.
 *
 * @uses	theme_slug_validate_image()		
 * @uses	esc_url_raw()				http://codex.wordpress.org/Function_Reference/esc_url_raw
 */
function hemila_sanitize_image( $input, $setting ) {
	return esc_url_raw( hemila_validate_image( $input, $setting->default ) );
}

/**
 * Validation: image
 * Control: text, WP_Customize_Image_Control
 *
 * @uses	wp_check_filetype()		https://developer.wordpress.org/reference/functions/wp_check_filetype/
 * @uses	in_array()				http://php.net/manual/en/function.in-array.php
 */
 
function hemila_validate_image( $input, $default = '' ) {
	// Array of valid image file types
	// The array includes image mime types
	// that are included in wp_get_mime_types()
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon'
	);
	// Return an array with file extension
	// and mime_type
	$file = wp_check_filetype( $input, $mimes );
	// If $input has a valid mime_type,
	// return it; otherwise, return
	// the default.
	return ( $file['ext'] ? $input : $default );
}


/**
 * Number sanitization callback example.
 *
 * - Sanitization: number_absint
 * - Control: number
 * 
 * Sanitization callback for 'number' type text inputs. This callback sanitizes `$number`
 * as an absolute integer (whole number, zero or greater).
 * 
 * NOTE: absint() can be passed directly as `$wp_customize->add_setting()` 'sanitize_callback'.
 * It is wrapped in a callback here merely for example purposes.
 * 
 * @see absint() https://developer.wordpress.org/reference/functions/absint/
 *
 * @param int                  $number  Number to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int Sanitized number; otherwise, the setting default.
 */
function hemila_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	
	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}


/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 * 
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function hemila_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize Category.
 * @param $input
 * @return int
 */
function hemila_sanitize_category($input){
	$output=intval($input);
	return $output;
}

if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;

/**
 * Class tromas_Customize_Dropdown_Taxonomies_Control
 */
class hemila_Customize_Dropdown_Taxonomies_Control extends WP_Customize_Control {

  public $type = 'dropdown-taxonomies';

  public $taxonomy = '';

  public function __construct( $manager, $id, $args = array() ) {

    $our_taxonomy = 'category';
    if ( isset( $args['taxonomy'] ) ) {
      $taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
      if ( true === $taxonomy_exist ) {
        $our_taxonomy = esc_attr( $args['taxonomy'] );
      }
    }
    $args['taxonomy'] = $our_taxonomy;
    $this->taxonomy = esc_attr( $our_taxonomy );

    parent::__construct( $manager, $id, $args );
  }

  public function render_content() {

    $tax_args = array(
      'hierarchical' => 1,
      'taxonomy'     => $this->taxonomy,
    );
    $all_taxonomies = get_categories( $tax_args );

    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <select <?php echo esc_attr($this->link()); ?>>
            <?php
              printf('<option value="%s" %s>%s</option>', '', selected(esc_attr($this->value()), '', false),esc_html('Select', 'hemila') );
             ?>
            <?php if ( ! empty( $all_taxonomies ) ): ?>
              <?php foreach ( $all_taxonomies as $key => $tax ): ?>
                <?php
                  printf('<option value="%s" %s>%s</option>',esc_attr( $tax->term_id ), selected($this->value(), esc_attr( $tax->term_id ), false), esc_attr( $tax->name ) );
                 ?>
              <?php endforeach ?>
           <?php endif ?>
         </select>

    </label>
    <?php
  }

}


/**
 * Class to create a custom post control
 */
class hemila_Post_Dropdown_Custom_Control extends WP_Customize_Control
{
	public $type = 'dropdown-posts';
    private $posts = false;
    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $postargs = wp_parse_args($options, array('numberposts' => '-1'));
        $this->posts = get_posts($postargs);
        parent::__construct( $manager, $id, $args );
    }
    /**
    * Render the content on the theme customizer page
    */
    public function render_content()
    {
        if(!empty($this->posts))
        {
            ?>
              <label>
                  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                     <select <?php echo esc_attr($this->link()); ?>>
                        <?php
                          printf('<option value="%s" %s>%s</option>', '', selected(esc_attr($this->value()), '', false),esc_html('Select', 'hemila') );
                         ?>
                        <?php if( !empty( $this->posts ) ): ?>
                          <?php  foreach ( $this->posts as $post ): ?>
                            <?php
                                printf('<option value="%s" %s>%s</option>', esc_attr( $post->ID ), selected($this->value(), $post->ID, false), esc_html($post->post_title));
                             ?>
                          <?php endforeach ?>
                       <?php endif ?>
                     </select>

               </label>
            <?php
        }
    }
}