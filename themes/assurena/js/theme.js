"use strict";

is_visible_init();
assurena_slick_navigation_init();

jQuery(document).ready(function($) {
	assurena_split_slider();
	assurena_sticky_init();
	assurena_search_init();
	assurena_side_panel_init();
	assurena_mobile_header();
	assurena_woocommerce_helper();
	assurena_woocommerce_login_in();
	assurena_init_timeline_appear();
	assurena_accordion_init();
	assurena_services_accordion_init();
	assurena_progress_bars_init();
	assurena_carousel_slick();
	assurena_image_comparison();
	assurena_counter_init();
	assurena_countdown_init ();
	assurena_circuit_services();
	assurena_circuit_services_resize();
	assurena_img_layers();
	assurena_page_title_parallax();
	assurena_extended_parallax();
	assurena_portfolio_parallax();
	assurena_message_anim_init();
	assurena_scroll_up();
	assurena_link_scroll();
	assurena_skrollr_init();
	assurena_sticky_sidebar();
	assurena_videobox_init();
	assurena_parallax_video();
	assurena_tabs_init();
	assurena_select_wrap();
	jQuery( '.stl_module_title .carousel_arrows' ).assurena_slick_navigation();
	jQuery( '.stl-filter_wrapper .carousel_arrows' ).assurena_slick_navigation();
	jQuery( '.stl-products > .carousel_arrows' ).assurena_slick_navigation();
	jQuery( '.assurena_module_custom_image_cats > .carousel_arrows' ).assurena_slick_navigation();
	assurena_scroll_animation();
	assurena_woocommerce_mini_cart();
	assurena_text_background();
	assurena_dynamic_styles();
	assurena_ajax_mega_menu();
});

jQuery(window).load(function() {
	assurena_isotope();
	assurena_blog_masonry_init();
	setTimeout(function(){
		jQuery('#preloader-wrapper').fadeOut();
	},1100);
	particles_custom();

	assurena_menu_lavalamp();
	jQuery(".stl-currency-stripe_scrolling").each(function(){
		jQuery(this).simplemarquee({
			speed: 40,
			space: 0,
			handleHover: true,
			handleResize: true
		});
	})
});
