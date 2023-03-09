<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nitu_shop
 */

 
if ( ! is_active_sidebar( 'sidebar-1' ) ):
?>
<aside id="secondary"
  class="widget-area <?php echo ( class_exists( 'WooCommerce' ) && is_woocommerce() ) ? '' : 'col-sm-2' ; ?> sidebar">
</aside><!-- #secondary -->
<?php endif; ?>