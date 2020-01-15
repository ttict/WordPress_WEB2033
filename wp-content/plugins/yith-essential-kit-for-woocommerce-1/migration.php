<?php
add_action( 'admin_menu', 'yith_essential_kit_welcome_screen_do_activation_redirect' );

function yith_essential_kit_welcome_screen_do_activation_redirect() {

	if ( get_site_option( 'yith_essential_kit_main_version', '1.0' ) != '2.0' ) {
		wp_safe_redirect( add_query_arg( array( 'page' => 'yith-essential-kit-migration-page' ), admin_url( 'index.php' ) ) );
		update_site_option( 'yith_essential_kit_main_version', '2.0' );
	}

}

add_action( 'admin_menu', 'yith_essential_kit_welcome_screen_pages' );

function yith_essential_kit_welcome_screen_pages() {
	add_dashboard_page(
		__( 'YITH Essential Kit Migration', 'yith-essential-kit-for-woocommerce-1' ),
		__( 'YITH Essential Kit Migration', 'yith-essential-kit-for-woocommerce-1' ),
		'install_plugins',
		'yith-essential-kit-migration-page',
		'yith_essential_kit_migration_page_content'
	);
}

function yith_essential_kit_migration_page_content() {
	global $yith_jetpack_1;
	?>
    <style>
        .yith-essential-kit-migration div[class^="loading-bar"] {
            display: block;
            max-width: 890px;
            border: 1px solid #b4b9be;
            border-radius: 5px;
            height: 30px;
            margin-bottom: 15px;
        }

        .yith-essential-kit-migration div[class^="loading-bar"] .loading-inner {
            background: #b4b9be;
            height: inherit;
            text-indent: -1000px;
            overflow: hidden;
        }
    </style>
    <div class="yith-essential-kit-migration">
        <div class="wrap">
            <h2><?php _e( 'YITH Essential Kit for WooCommerce migration panel', 'yith-essential-kit-for-woocommerce-1' ) ?></h2>

            <p>
				<?php _e( 'From version 2.0 of our plugin, modules are no longer bundled with the zip file. This means you should download them from wordpress.org repository first.', 'yith-essential-kit-for-woocommerce-1' ) ?>
            </p>
            <p>
				<?php _e( 'This page will do the job for you.', 'yith-essential-kit-for-woocommerce-1' ) ?>
            </p>
        </div>
		<?php
		$yith_jetpack_1->add_missing_modules();
		?>
    </div>
	<?php
}

add_action( 'admin_head', 'yith_essential_kit_welcome_screen_remove_menus' );

function yith_essential_kit_welcome_screen_remove_menus() {
	remove_submenu_page( 'index.php', 'yith-essential-kit-migration-page' );
}