<?php
	
function stl_child_scripts() {
	wp_enqueue_style( 'stl-parent-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'stl_child_scripts' );

/**
 * Your code here.
 *
 */
 
 function services_custom_sidebar() {
	register_sidebar(
		array (
			'name' => __( 'Servives Sidebar'),
			'id' => 'services_custom_sidebar',
			'description' => __( 'Custom Servives Sidebar' ),
			'before_widget' => '<div class=”widget-content”>',
			'after_widget' => "</div>",
			'before_title' => '<h3 class=”widget-title”>',
			'after_title' => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'services_custom_sidebar' );
