<?php
/**
 * Algori Shop Theme Customizer
 *
 * @package nitu_shop
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nitu_shop_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'nitu_shop_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'nitu_shop_customize_partial_blogdescription',
		) );
	}
	
	/**
	* Algori Shop Custom Customizer Customizations [ PS: The order matters ( add_panel, add_section, add_setting, add_control ) ]
	*/
	
	/**
	 * Checkbox sanitization callback.
	 * 
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function theme_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
	
	/**
	 * Create custom control for Algori Shop Documentation link.
	 *
	 * Class WP_Customize_Control is loaded only when theme customizer is acutally used. 
	 * So, I've defined my custom class within the nitu_shop_customize_register function that is binded to the 'customize_register' action.
	 *
	 * @link https://developer.wordpress.org/themes/customize-api/customizer-objects/#custom-controls-sections-and-panels.
	 */ 
	class WP_Documentation_Link_Customize_Control extends WP_Customize_Control {
		public $type = 'nitu_shop_documentation_link';
		/** 
		* Render the control's content. esc_url($my_theme->get( 'AuthorURI' ))
		*/
		public function render_content() {
		?>
<a href="<?php echo esc_url( wp_get_theme()->get( 'AuthorURI' ) ) . 'blog/article/nitu-shop-gutenberg-ready-woocommerce-wordpress-theme'; ?>"
  class="button button-primary" id="nitu-shop-documentation-link" target="_blank"
  tabindex="0"><?php _e( 'Documentation', 'nitu-shop' ); ?></a>
<?php
		}
	}
	
	// Documentation Section
	$wp_customize->add_section( 'nitu_shop_documentation', array(
		'title'				=> __( 'Algori Shop Documentation', 'nitu-shop' ),
		'description'		=> __( 'View Algori Shop Documentation.', 'nitu-shop' ),
		'priority'			=> 1,
		'capability'		=> 'edit_theme_options',
	    'theme_supports' 	=> '', // Rarely needed.
	) );
	
	// Documentation Button ( from custom control WP_Documentation_Link_Customize_Control )
	$wp_customize->add_control( new WP_Documentation_Link_Customize_Control( $wp_customize, 'documentation_button', array(
        'section'			=> 'nitu_shop_documentation',
        'settings'			=> array(),
    ) ) );
	
	// Add Theme Options Panel
	$wp_customize->add_panel( 'theme_options', array(
	  'title'				=> __( 'Theme Options', 'nitu-shop' ),
	  'description'			=> __( 'Adjust Algori Shop Theme Options.', 'nitu-shop' ),
	  'priority'			=> 160,
	) );
	
	// CTA Button Settings Section
	$wp_customize->add_section( 'cta_button_settings', array(
		'title'				=> __( 'CTA Button', 'nitu-shop' ),
		'description'		=> __( 'Edit call-to-action button text and link.', 'nitu-shop' ),
		'panel' 			=> 'theme_options', 
		'priority'			=> 1,
		'capability'		=> 'edit_theme_options',
	    'theme_supports' 	=> '', // Rarely needed.
	) );
	
	
	// Display CTA Button 
	$wp_customize->add_setting( 'nitu_shop_display_cta_button', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> true,
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback'   => 'theme_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'nitu_shop_display_cta_button', array(
	  'label' 				=> __( 'Display CTA Button', 'nitu-shop' ),
	  'type' 				=> 'checkbox',
	  'section' 			=> 'cta_button_settings',
	) );
	
	// CTA Button URL 
	$wp_customize->add_setting( 'nitu_shop_cta_button_url', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> ( class_exists( 'WooCommerce' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#',
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback' 	=> 'esc_url_raw',
	) );

	$wp_customize->add_control( 'nitu_shop_cta_button_url', array(
	  'label' 				=> __( 'CTA Button URL', 'nitu-shop' ),
	  'type' 				=> 'url',
	  'section' 			=> 'cta_button_settings',
	) );
	
	// CTA Button Text 
	$wp_customize->add_setting( 'nitu_shop_cta_button_text', array(
	  'type' 				=> 'theme_mod', // or 'option'
	  'capability' 			=> 'edit_theme_options',
	  'theme_supports'	 	=> '', // Rarely needed.
	  'default' 			=> __( 'Shop Now', 'nitu-shop' ),
	  'transport' 			=> 'refresh', // or postMessage
	  'sanitize_callback' 	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'nitu_shop_cta_button_text', array(
	  'label' 				=> __( 'CTA Button Text', 'nitu-shop' ),
	  'type' 				=> 'text',
	  'section' 			=> 'cta_button_settings',
	) );
	
}
add_action( 'customize_register', 'nitu_shop_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nitu_shop_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nitu_shop_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nitu_shop_customize_preview_js() {
	wp_enqueue_script( 'nitu-shop-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'nitu_shop_customize_preview_js' );

/**
 * Enqueue CSS for styling custom controls in the customizer.
 */
function nitu_shop_customize_preview_assets() {
	wp_enqueue_style( 'nitu-shop-customizer-custom-controls', get_template_directory_uri() . '/style/css/customizer.css', array(), '20190530', 'all' );
}
add_action( 'customize_controls_enqueue_scripts', 'nitu_shop_customize_preview_assets' );