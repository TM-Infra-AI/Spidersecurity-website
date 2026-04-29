<?php
function assurena_import_files() {
	return array(
		array(
			'import_file_name'             => 'Import Demo Data',
			'import_file_url'            => 'http://assurena.stylusthemes.com/demo-content/assurena.xml',
			'import_widget_file_url'     => 'http://assurena.stylusthemes.com/demo-content/assurena.wie',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'core/includes/demos/theme-options.json',
					'option_name' => 'assurena_set',
					),
			),
			'import_preview_image_url'     => 'http://assurena.stylusthemes.com/demo-content/assurena.jpg',
			'preview_url'                => 'https://assurena.stylusthemes.com',
			'import_notice'              => esc_html__('Everything that is listed in our demo will be imported via this option.', 'assurena'),
		),
		);
}
add_filter( 'pt-ocdi/import_files', 'assurena_import_files' );

if ( ! function_exists( 'assurena_after_import_setup' ) ) :
function assurena_after_import_setup() {

	//Import Revolution Slider
	if ( class_exists( 'RevSlider' ) ) {
			$slider_path = array(
				get_template_directory() . "/core/includes/demos/home-1.zip",
				get_template_directory() . "/core/includes/demos/home-2.zip",
			);

			foreach ($slider_path as $slide) {
				$slider = new RevSlider();
				$slider->importSliderFromPost(true, true, $slide);  
			}
		
	}

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home 1' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Navigation', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'main_menu' => $main_menu->term_id,
		)
	);
	
	
	update_option( 'elementor_disable_color_schemes', 'yes' );
	update_option( 'elementor_disable_typography_schemes', 'yes' );
	update_option( 'elementor_load_fa4_shim', 'yes' );
	
	//if exists, assign to $cpt_support var
	$cpt_support = get_option( 'elementor_cpt_support' );

	//check if option DOESN'T exist in db
	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'portfolio', 'header', 'side_panel', 'footer', 'team' ];
	    update_option( 'elementor_cpt_support', $cpt_support );
	}
	
	// #### Replace demo site URL with current site URL
	global $wpdb;
	$from = 'https://assurena.stylusthemes.com/'; // with str_replace:---> https:\\/\\/assurena.stylusthemes.com\\/
	$from_url = str_replace( '/', '\\\/', $from );
	$to = get_site_url().'/';
	$to_url = str_replace( '/', '\\\/', $to );

	$wpdb->query($wpdb->prepare( " UPDATE {$wpdb->postmeta} " . "SET `meta_value` = REPLACE(`meta_value`, '" . $from_url . "', '" . $to_url . "') " . "WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;") );
	wp_reset_postdata();

}
add_action( 'pt-ocdi/after_import', 'assurena_after_import_setup' );
endif;
?>