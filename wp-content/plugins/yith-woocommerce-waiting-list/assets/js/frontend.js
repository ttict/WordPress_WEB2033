/**
 * frontend.js
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

jQuery(document).ready(function($) {
    "use strict";

    var get_mail = function(){
        var var_email_input = $(document).find( '#yith-wcwtl-email' ),
                var_email_link  = var_email_input.parents( '#yith-wcwtl-output' ).find( 'a.button' ),
                link_href  = var_email_link.attr( 'href' );

            if( ! var_email_input.length ) {
                return;
            }

        var_email_input.on( 'input', function(e){

                var email_val  = var_email_input.val(),
                email_name = var_email_input.attr( 'name' );

            var_email_link.prop( 'href', link_href + '&' + email_name + '=' + email_val );
        });
    };

    // event
    get_mail();
    $('form.variations_form').on( 'show_variation', get_mail );
    $(document).on( 'qv_loader_stop', get_mail );
});