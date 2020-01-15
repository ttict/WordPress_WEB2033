<?php
// Add custom Theme Functions here
/**
 * Remove product tabs
 *
 */
function woo_remove_product_tab($tabs) {
 
        unset( $tabs['reviews'] );                                  // Remove the reviews tab
    unset( $tabs['additional_information'] );   // Remove the additional information tab
 
        return $tabs;
 
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tab', 98);
function custom_admin_footer() { 
 echo '<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src="https://embed.tawk.to/5bbe9fdcd045746918561766/default";
s1.charset="UTF-8";
s1.setAttribute("crossorigin","*");
s0.parentNode.insertBefore(s1,s0);
})();
</script>';}
 add_filter('admin_footer_text', 'custom_admin_footer');
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
$tabs['description']['title'] = __( 'Thông tin sản phẩm' );     // đổi tên description tab
return $tabs;
}
add_filter('add_to_cart_redirect', 'custom_add_to_cart_redirect');
 
function custom_add_to_cart_redirect() {
     /**
      * Replace with the url of your choosing
      * e.g. return 'http://www.yourshop.com/'
      */
     return get_permalink( get_option('woocommerce_checkout_page_id') );
}