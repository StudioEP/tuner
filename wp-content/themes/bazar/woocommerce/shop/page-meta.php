<?php
/**
 * Content Wrappers
 */
?>
            <!-- START PAGE META -->
            <div id="page-meta" class="group<?php if ( is_product() ) echo ' span12' ?>">
                <?php if ( ! is_single() ) : ?>
        		<h1 class="product-title page-title">
        			<?php if ( is_search() ) : ?>
        				<?php
        					printf( __( 'Search Results: &ldquo;%s&rdquo;', 'yit' ), get_search_query() );
        					if ( get_query_var( 'paged' ) )
        						printf( __( '&nbsp;&ndash; Page %s', 'yit' ), get_query_var( 'paged' ) );
        				?>
        			<?php elseif ( is_tax() ) : ?>
        				<?php if ( yit_get_option('shop-category-title') ):
        					echo single_term_title( "", false );
        				endif; ?>
        			<?php elseif ( is_single() ) : ?>
        				<?php the_title() ?>
        			<?php else : ?>
        				<?php
        					if ( yit_get_option('shop-products-title') ):
	        					$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
	        
	        					echo apply_filters( 'the_title', ( $shop_page_title = get_option( 'woocommerce_shop_page_title' ) ) ? $shop_page_title : $shop_page->post_title );
							endif;
        				?>
        			<?php endif; ?>
        		</h1>            
        		<?php endif; ?>
        		                                     
        		<?php do_action( 'shop_page_meta' ) ?>
        		
        		<?php if ( is_single() && yit_get_option('shop-show-back') ) : ?>
        			<div class="back-shop"> <a href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ) ?>">&lsaquo; <?php _e('Back to the shop', 'yit' ) ?></a> </div> 
				<?php endif; ?>
        	</div>
        	<!-- END PAGE META -->   