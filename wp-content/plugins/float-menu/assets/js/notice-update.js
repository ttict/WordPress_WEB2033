jQuery(document).on( 'click', '.wow-plugin-notice .notice-dismiss', function() {
		jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'float_menu_notice_action'
        }
    })
})