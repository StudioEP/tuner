<?php
/**
 * Frontend class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Magnifier
 * @version 1.0.0
 */

if ( !defined( 'YITH_WCMG' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCMG_Frontend' ) ) {
    /**
     * Admin class. 
	 * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCMG_Frontend {

		/**
		 * Constructor
		 * 
		 * @access public
		 * @since 1.0.0
		 */
    	public function __construct() {
			if( yith_wcmg_is_enabled() ) {
				//change the templates
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
				add_action( 'woocommerce_before_single_product_summary', array($this, 'show_product_images'), 20 );
				add_action( 'woocommerce_product_thumbnails', array($this, 'show_product_thumbnails'), 20 );
				
				//custom styles and javascripts
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
				
				//add attributes to product variations
				add_filter( 'woocommerce_available_variation', array( $this, 'available_variation' ), 10, 3);
			}
    	}
		
		
		/**
		 * Change product-single.php template
		 * 
		 * @access public
		 * @return void
		 * @since 1.0.0
		 */
		public function show_product_images() {
			woocommerce_get_template( 'single-product/product-image-magnifier.php', array(), '', YITH_WCMG_DIR . 'templates/' );
		}
		
		
		/**
		 * Change product-thumbnails.php template
		 * 
		 * @access public
		 * @return void
		 * @since 1.0.0
		 */
		public function show_product_thumbnails() {
			woocommerce_get_template( 'single-product/product-thumbnails-magnifier.php', array(), '', YITH_WCMG_DIR . 'templates/' );
		}


		/**
		 * Enqueue styles and scripts
		 * 
		 * @access public
		 * @return void 
		 * @since 1.0.0
		 */
		public function enqueue_styles_scripts() {
			global $post;
			
			if( is_product() || ( ! empty( $post->post_content ) && strstr( $post->post_content, '[product_page' ) ) ) {
				wp_enqueue_script('jquery-caroufredsel', YITH_WCMG_URL . 'assets/js/carouFredSel.js', array('jquery'), '6.1.0', true);
				wp_enqueue_script('yith-magnifier', YITH_WCMG_URL . 'assets/js/yith_magnifier.js', array('jquery'), '1.0', true);
				wp_enqueue_script('yith_wcmg_frontend', YITH_WCMG_URL . 'assets/js/frontend.js', array('jquery', 'yith-magnifier'), '1.0', true);
				wp_enqueue_style( 'yith-magnifier', YITH_WCMG_URL . 'assets/css/yith_magnifier.css' );
				wp_enqueue_style( 'yith_wcmg_frontend', YITH_WCMG_URL . 'assets/css/frontend.css' );
			}
		}
		
		
		/**
		 * Add attributes to product variations
		 * 
		 * @access public
		 * @return void
		 * @since 1.0.0
		 */
		public function available_variation( $data, $wc_prod, $variation ) {
			$attachment_id = get_post_thumbnail_id( $variation->get_variation_id() );
			$attachment = wp_get_attachment_image_src( $attachment_id, 'shop_magnifier' );

			$data['image_magnifier'] = $attachment ? current( $attachment ) : '';
			return $data;
		}
    }
}
