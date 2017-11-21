<?php
/**
 * Generate child theme functions and definitions
 *
 * @package Generate
 */

add_action( 'wp_enqueue_scripts', 'generate_custom_scripts', 100 );
function generate_custom_scripts() {
  if ( is_child_theme() ) :
		      wp_dequeue_style( 'generate-child' );
  wp_enqueue_style( 'generate-custom-child', get_stylesheet_uri(), true, '', 'all' );
  endif;
}

add_filter( 'generate_number_of_fonts','tu_show_all_available_google_fonts' );
function tu_show_all_available_google_fonts()
{
	return 'all';
}


// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 32;' ), 20 );

// Change the add to cart button INTO View Product button
// =================================================================================================================

add_filter( 'woocommerce_loop_add_to_cart_link', 'add_product_link' );
function add_product_link( $link ) {
  global $product;
  echo '<form action="' . esc_url( $product->get_permalink( $product->id ) ) . '" method="get">
	            <button type="submit" class="tinybutton button product_type_simple">' . __('Learn More', 'woocommerce') . '</button>
	          </form>';

  echo '<form action="' . esc_url( $product->get_permalink( $product->id ) ) . '" method="get">
            <button type="submit" class="tinybutton button add_to_cart_button product_type_simple">' . __('Add to Cart', 'woocommerce') . '</button>
          </form>';

}


function yrb_do_button( $atts ) {
  $a = shortcode_atts( array(
    'link' => '/contact',
    'text' => 'Get Started',
    'target' => ''
  ), $atts );

  $target = "";
  
  if($a['target'] == "blank") $target = " target='_blank' ";

  $returnme .= "<p class='callout'><a class='button' href='".$a['link']."?inquiry_type=".$a['inquiry_type']."' ".$target." >".$a['text']."</a></p>";

  return $returnme;
}
add_shortcode( 'yrb_button', 'yrb_do_button' );
 
function yrb_box1_shortcode( $atts, $content){
  return "<div class='yrb_box yrb_box1'>".$content."</div>";
}
add_shortcode( 'yrb_box1', 'yrb_box1_shortcode' );

function yrb_box2_shortcode( $atts, $content ){
  return "<div class='yrb_box yrb_box2'>".$content."</div>";
}
add_shortcode( 'yrb_box2', 'yrb_box2_shortcode' );
 
function yrb_box3_shortcode( $atts, $content){
  return "<div class='yrb_box yrb_box3'>".$content."</div>";
}
add_shortcode( 'yrb_box3', 'yrb_box3_shortcode' ); 
 
add_action( 'generate_after_header', 'tu_after_featured_image', 20);
function tu_after_featured_image() {
  if(is_front_page() || is_page(47) || is_page(677)) {
?>

<div class='signup-ribbon'>
  <div class='grid-container'>
  <p>Sign up for my monthly newsletter and receive 7 special bonus videos:</p>
  <?php echo do_shortcode('[gravityform id="3" title="true" description="false" ajax="true" title="false"]'); ?>
</div>
</div>
<?php
 }

}

