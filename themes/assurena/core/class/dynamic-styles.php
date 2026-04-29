<?php

defined( 'ABSPATH' ) || exit;

/**
* assurena Dynamic Styles
*
*
* @class        assurena_dynamic_styles
* @version      1.0
* @category     Class
* @author       StylusThemes
*/

class assurena_dynamic_styles
{

	public $settings;
	protected static $instance = null;
	private $gtdu;
	private $use_minify;

	private $header_page_select_id;

	public static function instance()
	{
		if (is_null( self::$instance )) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function register_script()
	{
		$this->gtdu = get_template_directory_uri();
		$this->use_minify = assurena_Theme_Helper::get_option('use_minify') ? '.min' : '';
		// Register action
		add_action('wp_enqueue_scripts', array($this,'css_reg') );
		add_action('wp_enqueue_scripts', array($this,'js_reg') );
		// Register action for Admin
		add_action('admin_enqueue_scripts', array($this,'admin_css_reg') );
		add_action('admin_enqueue_scripts', array($this, 'admin_js_reg') );

		//Support Elementor Header Builder
		add_action('wp_enqueue_scripts', array($this,'get_elementor_css_cache') );
	}

	/* Register CSS */
	public function css_reg()
	{
		/* Register CSS */
		wp_enqueue_style('assurena-default-style', get_bloginfo('stylesheet_url'));
		// Flaticon register
		wp_enqueue_style('flaticon', $this->gtdu . '/fonts/flaticon/flaticon.css');
		// Font-Awesome
		wp_enqueue_style('font-awesome', $this->gtdu . '/css/font-awesome.min.css');
		wp_enqueue_style('assurena-main', $this->gtdu . '/css/main'.$this->use_minify.'.css');
		wp_enqueue_style('swipebox', get_template_directory_uri() . '/js/swipebox/css/swipebox.min.css');
	}

	public function get_elementor_css_cache()
	{
		/**
		 * Post CSS file constructor.
		 *
		 * Initializing the CSS file of the post. Set the post ID and initiate the stylesheet.
		 *
		 * @param int $header_page_select_id Post ID.
		 */

		$header_type = assurena_Theme_Helper::get_option('header_type');

		$header_page_select = assurena_Theme_Helper::get_option('header_page_select');

		if (!empty($header_page_select)) {
			$this->header_page_select_id = intval($header_page_select);

			if (class_exists('SitePress')) {
				$this->header_page_select_id = icl_object_id($this->header_page_select_id, 'post', false,ICL_LANGUAGE_CODE);
			}
		}

		$id = !is_category() ? get_queried_object_id() : 0;

		if (class_exists( 'RWMB_Loader' ) && $id !== 0) {

			$customize_header = rwmb_meta('mb_customize_header_layout');
			if ( $customize_header == 'custom') {
				$custom_header = rwmb_meta('mb_header_content_type');
				if($custom_header !== 'default'){
					$header_type = 'custom';
					$this->header_page_select_id = (int) rwmb_meta('mb_customize_header');

					if (class_exists('SitePress')) {
						$this->header_page_select_id = icl_object_id($this->header_page_select_id, 'post', false,ICL_LANGUAGE_CODE);
					}
				}
			}
		}

		if( $header_type == 'custom'){
			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				$css_file = new \Elementor\Core\Files\CSS\Post( $this->header_page_select_id );
				$css_file->enqueue();
			}
		}
	}

	/* Register JS */
	public function js_reg()
	{

		wp_enqueue_script('assurena-theme-addons', $this->gtdu . '/js/theme-addons'.$this->use_minify.'.js', array('jquery'), false, true);
		wp_enqueue_script('assurena-theme', $this->gtdu . '/js/theme.js', array('jquery'), false, true);

		wp_localize_script( 'assurena-theme', 'stl_core', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'slickSlider' => esc_url(get_template_directory_uri() . '/js/slick.min.js'),
			'JarallaxPlugin' => esc_url(get_template_directory_uri() . '/js/jarallax-video.min.js'),
			'JarallaxPluginVideo' => esc_url(get_template_directory_uri() . '/js/jarallax.min.js'),
			'like' => esc_html__( 'Like', 'assurena' ),
			'unlike' => esc_html__( 'Unlike', 'assurena' )
			) );

		if (is_singular() && comments_open() && get_option( 'thread_comments' )) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script('perfect-scrollbar', get_template_directory_uri() . '/js/perfect-scrollbar.min.js', array(), false, false);

		wp_enqueue_script('swipebox', get_template_directory_uri() . '/js/swipebox/js/jquery.swipebox.min.js', array(), false, false);
	}

	/* Register css for admin panel */
	public function admin_css_reg()
	{
		// Font-awesome
		wp_enqueue_style('font-awesome', $this->gtdu . '/css/font-awesome.min.css');
		// Main admin styles
		wp_enqueue_style('assurena-admin', $this->gtdu . '/core/admin/css/admin.css');
		// Add standard wp color picker
		wp_enqueue_style('wp-color-picker');
	}

	/* Register css and js for admin panel */
	public function admin_js_reg()
	{
		/* Register JS */
		wp_enqueue_media();
		wp_enqueue_script('wp-color-picker');
		//Admin Js
		wp_enqueue_script('admin', $this->gtdu . '/core/admin/js/admin.js');
		// If active Metabox IO
		if (class_exists( 'RWMB_Loader' )) {
			wp_enqueue_script('metaboxes', $this->gtdu . '/core/admin/js/metaboxes.js');
		}

		wp_localize_script( 'admin', 'stl_verify', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'   => esc_js( wp_create_nonce( '_notice_nonce' ) )
		) );
	}

	public function init_style() {
		add_action('wp_enqueue_scripts', array($this, 'add_style') );
	}

	public function minify_css($css = null){
		if (!$css) { return; }

		// Combine css
		$css = str_replace( ', ', ',', $css );

		// Remove comments
		$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

		// Remove space after colons
		$css = str_replace(': ', ':', $css);

		// Remove whitespace
		$css = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css );
		$css = trim( $css );

		return $css;
	}

	public function add_style() {
		$css = '';
		/*-----------------------------------------------------------------------------------*/
		/* Body Style
		/*-----------------------------------------------------------------------------------*/
		$page_colors_switch = assurena_Theme_Helper::options_compare('page_colors_switch','mb_page_colors_switch','custom');
		$use_gradient_switch = assurena_Theme_Helper::options_compare('use-gradient','mb_page_colors_switch','custom');
		if ($page_colors_switch == 'custom') {
			$theme_primary_color = assurena_Theme_Helper::options_compare('page_theme_color','mb_page_colors_switch','custom');
			$theme_secondary_color = assurena_Theme_Helper::options_compare('page_theme_secondary_color','mb_page_colors_switch','custom');
			$theme_tertiary_color = assurena_Theme_Helper::options_compare('page_theme_third_color','mb_page_colors_switch','custom');

			$bg_body = assurena_Theme_Helper::options_compare('body_background_color','mb_page_colors_switch','custom');
			// Go top color
			$scroll_up_bg_color = assurena_Theme_Helper::options_compare('scroll_up_bg_color','mb_page_colors_switch','custom');
			$scroll_up_arrow_color = assurena_Theme_Helper::options_compare('scroll_up_arrow_color','mb_page_colors_switch','custom');
			// Gradient colors
			$theme_gradient_from = assurena_Theme_Helper::options_compare('theme-gradient-from','mb_page_colors_switch','custom');
			$theme_gradient_to = assurena_Theme_Helper::options_compare('theme-gradient-to','mb_page_colors_switch','custom');
		} else {
			$theme_primary_color = esc_attr(assurena_Theme_Helper::get_option('theme-primary-color'));
			$theme_secondary_color = esc_attr(assurena_Theme_Helper::get_option('theme-secondary-color'));
			$theme_tertiary_color = esc_attr(assurena_Theme_Helper::get_option('theme-third-color'));

			$bg_body = esc_attr(assurena_Theme_Helper::get_option('body-background-color'));
			// Go top color
			$scroll_up_bg_color = assurena_Theme_Helper::get_option('scroll_up_bg_color');
			$scroll_up_arrow_color = assurena_Theme_Helper::get_option('scroll_up_arrow_color');
			// Gradient colors
			$theme_gradient = assurena_Theme_Helper::get_option('theme-gradient');
			$second_gradient = assurena_Theme_Helper::get_option('second-gradient');
			$theme_gradient_from = $theme_gradient['from'] ?? '';
			$theme_gradient_to = $theme_gradient['to'] ?? '';
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Body style
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Body Add Class
		/*-----------------------------------------------------------------------------------*/
        if ($use_gradient_switch) {
            add_filter( 'body_class', function( $classes) {
                return array_merge( $classes, array( 'theme-gradient' ) );
            } );
            $gradient_class = '.theme-gradient';
        } else {
            $gradient_class = '';
        }
        if (defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0', '>=' )) {
            if(empty(get_option( 'elementor_element_wrappers_legacy_mode' ))){
                add_filter( 'body_class', function( $classes ) {
                    return array_merge( $classes, array( 'new-elementor' ) );
                } );
            }
        }
		/*-----------------------------------------------------------------------------------*/
		/* End Body Add Class
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Header Typography
		/*-----------------------------------------------------------------------------------*/
		$header_font = assurena_Theme_Helper::get_option('header-font');

		$header_font_family = $header_font_weight = $header_font_color = '';
		if (! empty( $header_font)) {
			$header_font_family = esc_attr( $header_font['font-family']);
			$header_font_weight = esc_attr( $header_font['font-weight']);
			$header_font_color = esc_attr( $header_font['color']);
		}

		// Add Heading h1,h2,h3,h4,h5,h6 variables
		for ( $i = 1; $i <= 6; $i++) {
			${'header-h'.$i} = assurena_Theme_Helper::get_option('header-h'.$i);
			${'header-h'.$i.'_family'} = ${'header-h'.$i.'_weight'} = ${'header-h'.$i.'_line_height'} = ${'header-h'.$i.'_size'} = ${'header-h'.$i.'_text_transform'} = '';

			if (! empty( ${'header-h'.$i})) {
				${'header-h'.$i.'_family'} = !empty( ${'header-h'.$i}["font-family"]) ? esc_attr( ${'header-h'.$i}["font-family"]) : '';
				${'header-h'.$i.'_weight'} = !empty( ${'header-h'.$i}["font-weight"]) ? esc_attr( ${'header-h'.$i}["font-weight"]) : '';
				${'header-h'.$i.'_line_height'} = !empty( ${'header-h'.$i}["line-height"]) ? esc_attr( ${'header-h'.$i}["line-height"]) : '';
				${'header-h'.$i.'_size'} = !empty( ${'header-h'.$i}["font-size"]) ? esc_attr( ${'header-h'.$i}["font-size"]) : '';
				${'header-h'.$i.'_text_transform'} = !empty( ${'header-h'.$i}["text-transform"]) ? esc_attr( ${'header-h'.$i}["text-transform"]) : '';
			}
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Header Typography
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Body Typography
		/*-----------------------------------------------------------------------------------*/
		$main_font = assurena_Theme_Helper::get_option('main-font');
		$content_font_family = $content_line_height = $content_font_size = $content_font_weight = $content_color = '';
		if (! empty( $main_font)) {
			$content_font_family = esc_attr( $main_font['font-family']);
			$content_font_size = esc_attr( $main_font['font-size']);
			$content_font_weight = esc_attr( $main_font['font-weight']);
			$content_color = esc_attr( $main_font['color']);
			$content_line_height = esc_attr( $main_font['line-height']);
			$content_line_height = !empty( $content_line_height) ? round(((int)$content_line_height / (int)$content_font_size), 3) : '';
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Body Typography
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Menu, Sub-menu Typography
		/*-----------------------------------------------------------------------------------*/
		$menu_font = assurena_Theme_Helper::get_option('menu-font');
		$menu_font_family = $menu_font_weight = $menu_font_line_height = $menu_font_size = '';
		if (! empty( $menu_font)) {
			$menu_font_family = !empty( $menu_font['font-family']) ? esc_attr( $menu_font['font-family']) : '';
			$menu_font_weight = !empty( $menu_font['font-weight']) ? esc_attr( $menu_font['font-weight']) : '';
			$menu_font_line_height = !empty( $menu_font['line-height']) ? esc_attr( $menu_font['line-height']) : '';
			$menu_font_size = !empty( $menu_font['font-size']) ? esc_attr( $menu_font['font-size']) : '';
		}

		$sub_menu_font = assurena_Theme_Helper::get_option('sub-menu-font');
		$sub_menu_font_family = $sub_menu_font_weight = $sub_menu_font_line_height = $sub_menu_font_size = '';
		if (! empty( $sub_menu_font)) {
			$sub_menu_font_family = !empty( $sub_menu_font['font-family']) ? esc_attr( $sub_menu_font['font-family']) : '';
			$sub_menu_font_weight = !empty( $sub_menu_font['font-weight']) ? esc_attr( $sub_menu_font['font-weight']) : '';
			$sub_menu_font_line_height = !empty( $sub_menu_font['line-height']) ? esc_attr( $sub_menu_font['line-height']) : '';
			$sub_menu_font_size = !empty( $sub_menu_font['font-size']) ? esc_attr( $sub_menu_font['font-size']) : '';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Menu, Sub-menu Typography
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Additional Font
		/*-----------------------------------------------------------------------------------*/

		$additional_font = assurena_Theme_Helper::get_option('additional-font');
		if (! empty($additional_font)) {
			$additional_font_family = esc_attr($additional_font['font-family']);
			$additional_font_weight = esc_attr((int)$additional_font['font-weight']);
		} else {
			$additional_font_family = $additional_font_weight = '';
		}

		/*-----------------------------------------------------------------------------------*/
		/* \End Additional Font
		/*-----------------------------------------------------------------------------------*/

		$menu_color_top = assurena_Theme_Helper::get_option('header_top_color');
		if (! empty( $menu_color_top['rgba'])) {
			$menu_color_top = !empty( $menu_color_top['rgba']) ? esc_attr( $menu_color_top['rgba']) : '';
		}

		$menu_color_middle = assurena_Theme_Helper::get_option('header_middle_color');
		if (! empty( $menu_color_middle['rgba'])) {
			$menu_color_middle = !empty( $menu_color_middle['rgba']) ? esc_attr( $menu_color_middle['rgba']) : '';
		}

		$menu_color_bottom = assurena_Theme_Helper::get_option('header_bottom_color');
		if (! empty( $menu_color_bottom['rgba'])) {
			$menu_color_bottom = !empty( $menu_color_bottom['rgba']) ? esc_attr( $menu_color_bottom['rgba']) : '';
		}

		// Set Queries width to apply mobile style
		$sub_menu_color = assurena_Theme_Helper::get_option('sub_menu_color');
		$sub_menu_bg = assurena_Theme_Helper::get_option('sub_menu_background');
		$sub_menu_bg = $sub_menu_bg['rgba'];

		$sub_menu_border = assurena_Theme_Helper::get_option('header_sub_menu_bottom_border');
		$sub_menu_border_height = assurena_Theme_Helper::get_option('header_sub_menu_border_height');
		$sub_menu_border_height = $sub_menu_border_height['height'];
		$sub_menu_border_color = assurena_Theme_Helper::get_option('header_sub_menu_bottom_border_color');
		if (! empty( $sub_menu_border)) {
			$css .= '.primary-nav ul li ul li:not(:last-child), .sitepress_container > .wpml-ls ul ul li:not(:last-child) {'
				.(!empty( $sub_menu_border_height) ? 'border-bottom-width: '.(int) (esc_attr( $sub_menu_border_height)).'px;' : '')
				.(!empty( $sub_menu_border_color['rgba']) ? 'border-bottom-color: '.esc_attr( $sub_menu_border_color['rgba']).';' : '').'
				border-bottom-style: solid;
			}';
		}

		$mobile_sub_menu_bg = assurena_Theme_Helper::get_option('mobile_sub_menu_background')['rgba'];

		$mobile_sub_menu_overlay = assurena_Theme_Helper::get_option('mobile_sub_menu_overlay')['rgba'];

		$mobile_sub_menu_color = assurena_Theme_Helper::get_option('mobile_sub_menu_color');

		$rgb_h_font_color = assurena_Theme_Helper::HexToRGB( $header_font_color );
		$rgb_primary_color = assurena_Theme_Helper::HexToRGB( $theme_primary_color );
		$rgb_secondary_color = assurena_Theme_Helper::HexToRGB( $theme_secondary_color );
		$rgb_scroll_up_bg = assurena_Theme_Helper::HexToRGB( $scroll_up_bg_color );

		$footer_text_color = assurena_Theme_Helper::get_option('footer_text_color');
		$footer_heading_color = assurena_Theme_Helper::get_option('footer_heading_color');

		$copyright_text_color = assurena_Theme_Helper::options_compare('copyright_text_color','mb_copyright_switch','on');

		// Page Title Background Color
		$page_title_bg_color = assurena_Theme_Helper::get_option('page_title_bg_color');
		$hex_page_title_bg_color = assurena_Theme_Helper::HexToRGB($page_title_bg_color);

		/*-----------------------------------------------------------------------------------*/
		/* Side Panel Css
		/*-----------------------------------------------------------------------------------*/
		$side_panel_title = assurena_Theme_Helper::get_option('side_panel_title_color');
		$side_panel_title = !empty( $side_panel_title['rgba']) ? $side_panel_title['rgba'] : '';

		if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
			$side_panel_switch = rwmb_meta('mb_customize_side_panel');
			if ($side_panel_switch === 'custom') {
				$side_panel_title = rwmb_meta("mb_side_panel_title_color");
			}
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Side Panel CSS
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Parse CSS
		/*-----------------------------------------------------------------------------------*/
		global $wp_filesystem;
		if (empty( $wp_filesystem )) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$files = array('theme_content', 'theme_color', 'footer');
		if (class_exists( 'WooCommerce' )) {
			array_push( $files, 'shop');
		}
		foreach ( $files as $key => $file) {
			$file = get_theme_file_path( '/core/admin/css/dynamic/'.$file.'.css' );
			if ($wp_filesystem->exists( $file)) {
				$file = $wp_filesystem->get_contents( $file );
				preg_match_all('/\s*\\$([A-Za-z1-9_\-]+)(\s*:\s*(.*?);)?\s*/', $file, $vars);

				$found     = $vars[0];
				$varNames  = $vars[1];
				$count     = count( $found);

				for( $i = 0; $i < $count; $i++) {
					$varName  = trim( $varNames[$i]);
					$file = preg_replace('/\\$'.$varName.'(\W|\z)/', (isset( ${$varName}) ? ${$varName} : "").'\\1', $file);
				}

				$line = str_replace( $found, '', $file);

				$css .= $line;
			}
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Parse css
		/*-----------------------------------------------------------------------------------*/

		$css .= 'body {'
			.(!empty( $bg_body) ? 'background:'.$bg_body.';' : '').'
		}
		ol.commentlist:after {
			'.(!empty( $bg_body) ? 'background:'.$bg_body.';' : '').'
		}';

		/*-----------------------------------------------------------------------------------*/
		/* Typography render
		/*-----------------------------------------------------------------------------------*/
		for ( $i = 1; $i <= 6; $i++) {
			$css .= 'h'.$i.',h'.$i.' a, h'.$i.' span {
				'.(!empty( ${'header-h'.$i.'_family'}) ? 'font-family:'.${'header-h'.$i.'_family'}.';' : '' ).'
				'.(!empty( ${'header-h'.$i.'_weight'}) ? 'font-weight:'.${'header-h'.$i.'_weight'}.';' : '' ).'
				'.(!empty( ${'header-h'.$i.'_size'}) ? 'font-size:'.${'header-h'.$i.'_size'}.';' : '' ).'
				'.(!empty( ${'header-h'.$i.'_line_height'}) ? 'line-height:'.${'header-h'.$i.'_line_height'}.';' : '' ).'
				'.(!empty( ${'header-h'.$i.'_text_transform'}) ? 'text-transform:'.${'header-h'.$i.'_text_transform'}.';' : '' ).'
			}';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Typography render
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Mobile Header render
		/*-----------------------------------------------------------------------------------*/
		$mobile_header = assurena_Theme_Helper::get_option('mobile_header');

		// Fetch mobile header height to apply it for mobile styles
		$header_mobile_height = assurena_Theme_Helper::get_option('header_mobile_height');
		$header_mobile_min_height = !empty($header_mobile_height['height']) ? 'calc(100vh - '.esc_attr((int)$header_mobile_height['height']).'px - 30px)' : '';
		$header_mobile_height = !empty($header_mobile_height['height']) ? 'calc(100vh - '.esc_attr((int)$header_mobile_height['height']).'px)' : '';

		// Set Queries width to apply mobile style
		$header_type = assurena_Theme_Helper::get_option('header_type');

		$header_page_select = assurena_Theme_Helper::get_option('header_page_select');
		$header_page_select_id = 0;

		if (!empty($header_page_select)) {
			$header_page_select_id = intval($header_page_select);

			if (class_exists('SitePress')) {
				$header_page_select_id = icl_object_id($header_page_select_id, 'post', false,ICL_LANGUAGE_CODE);
			}
		}

		$id = !is_category() ? get_queried_object_id() : 0;
		if (class_exists( 'RWMB_Loader' ) && $id !== 0) {

	    	$customize_header = rwmb_meta('mb_customize_header_layout');
	    	if ( $customize_header == 'custom') {
	    		$custom_header = rwmb_meta('mb_header_content_type');
	    		if($custom_header !== 'default'){
	    			$header_type = 'custom';
	    			$header_page_select_id = (int) rwmb_meta('mb_customize_header');

					if (class_exists('SitePress')) {
						$header_page_select_id = icl_object_id($header_page_select_id, 'post', false,ICL_LANGUAGE_CODE);
					}
	    		}
	    	}
	    }

		$header_queries = assurena_Theme_Helper::get_option('header_mobile_queris');
		if( $header_type === 'custom'){

			if (!empty($header_page_select)) {
				$header_page_select_id = intval($header_page_select);

				if ( did_action( 'elementor/loaded' ) ) {

					// Get the page settings manager
					$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

					// Get the settings model for header post
					$page_settings_model = $page_settings_manager->get_model( $header_page_select_id );

					$header_queries = $page_settings_model->get_settings( 'mobile_breakpoint' );
				}
			}
		}
		$mobile_over_content = assurena_Theme_Helper::get_option('mobile_over_content');
		$mobile_sticky = assurena_Theme_Helper::get_option('mobile_sticky');

		if ($mobile_header == '1') {
			$mobile_background = assurena_Theme_Helper::get_option('mobile_background');
			$mobile_color = assurena_Theme_Helper::get_option('mobile_color');

			$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
				.stl-theme-header{
					background-color: '.esc_attr( $mobile_background['rgba']).' !important;
					color: '.esc_attr( $mobile_color).' !important;
				}
				.hamburger-inner, .hamburger-inner:before, .hamburger-inner:after{
					background-color:'.esc_attr( $mobile_color).';
				}
			}';
		}

		$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
			.stl-theme-header .stl-mobile-header {
				display: block;
			}
			.stl-site-header,
			.stl-theme-header .primary-nav {
				display: none;
			}
			.elementor-editor-active .stl-theme-header .stl-site-header,
			.elementor-editor-active .stl-theme-header .primary-nav {
				display: block;
			}
			.stl-theme-header .mobile-hamburger-toggle {
				display: inline-block;
			}
			header.stl-theme-header .mobile_nav_wrapper .primary-nav {
				display: block;
			}
			.stl-theme-header .stl-sticky-header {
				display: none;
			}
		}';

		if ($mobile_over_content == '1') {
			$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
				.stl-theme-header{
					position: absolute;
					z-index: 99;
					width: 100%;
					left: 0;
					top: 0;
				}
			}';
			if ($mobile_sticky == '1') {
				$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
					body .stl-theme-header .stl-mobile-header{
						position: absolute;
						left: 0;
						width: 100%;
					}
				}';
			}
		} else {
			$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
				body .stl-theme-header.header_overlap{
					position: relative;
					z-index: 2;
				}
			}';
		}

		if ($mobile_sticky == '1') {
			$css .= '@media only screen and (max-width: '.(int)$header_queries.'px) {
				body .stl-theme-header, body .stl-theme-header.header_overlap{
					position: sticky;
				}
				.admin-bar .stl-theme-header{
					top: 32px;
				}
			}';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Mobile Header render
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Page Title Responsive
		/*-----------------------------------------------------------------------------------*/
		$page_title_resp = assurena_Theme_Helper::get_option('page_title_resp_switch');
		$mb_cond_logic = false;

		if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
			$mb_cond_logic = rwmb_meta('mb_page_title_switch') == 'on' && rwmb_meta('mb_page_title_resp_switch') == '1' ? '1' : '';

			if (rwmb_meta('mb_page_title_switch') == 'on') {
				if (rwmb_meta('mb_page_title_resp_switch') == '1') {
					$page_title_resp = '1';
				}
			}
		}
		if ($page_title_resp) {

			$page_title_height = assurena_Theme_Helper::get_option('page_title_resp_height')['height'];

			$page_title_queries = assurena_Theme_Helper::options_compare('page_title_resp_resolution', 'mb_page_title_resp_switch', $mb_cond_logic);

			$page_title_padding = assurena_Theme_Helper::options_compare('page_title_resp_padding', 'mb_page_title_resp_switch', $mb_cond_logic);

			if ($mb_cond_logic == '1') {
				$page_title_height = rwmb_meta('mb_page_title_resp_height');
			}

			$page_title_font = assurena_Theme_Helper::options_compare('page_title_resp_font', 'mb_page_title_resp_switch', $mb_cond_logic);
			$page_title_breadcrumbs_font = assurena_Theme_Helper::options_compare('page_title_resp_breadcrumbs_font', 'mb_page_title_resp_switch', $mb_cond_logic);
			$page_title_breadcrumbs_switch = assurena_Theme_Helper::options_compare('page_title_resp_breadcrumbs_switch', 'mb_page_title_resp_switch', $mb_cond_logic);

			// Title styles
			$page_title_font_color = !empty( $page_title_font['color']) ? 'color:'.esc_attr( $page_title_font['color'] ).' !important;' : '';
			$page_title_font_size = !empty( $page_title_font['font-size']) ? 'font-size:'.esc_attr( (int)$page_title_font['font-size'] ).'px !important;' : '';
			$page_title_font_height = !empty( $page_title_font['line-height']) ? 'line-height:'.esc_attr( (int)$page_title_font['line-height'] ).'px !important;' : '';
			$page_title_additional_style = !(bool)$page_title_breadcrumbs_switch ? 'margin-bottom: 0 !important;' : '';

			$title_style = $page_title_font_color . $page_title_font_size . $page_title_font_height . $page_title_additional_style;

			// Breadcrumbs Styles
			$page_title_breadcrumbs_font_color = !empty( $page_title_breadcrumbs_font['color']) ? 'color:'.esc_attr( $page_title_breadcrumbs_font['color'] ).' !important;' : '';
			$page_title_breadcrumbs_font_size = !empty( $page_title_breadcrumbs_font['font-size']) ? 'font-size:'.esc_attr( (int) $page_title_breadcrumbs_font['font-size']).'px !important;' : '';
			$page_title_breadcrumbs_font_height = !empty( $page_title_breadcrumbs_font['line-height']) ? 'line-height:'.esc_attr( (int) $page_title_breadcrumbs_font['line-height'] ).'px !important;' : '';

			$page_title_breadcrumbs_display = !(bool)$page_title_breadcrumbs_switch ? 'display: none !important;' : '';

			$breadcrumbs_style = $page_title_breadcrumbs_font_color . $page_title_breadcrumbs_font_size . $page_title_breadcrumbs_font_height . $page_title_breadcrumbs_display;

			$css .= '@media only screen and (max-width: '.(int)$page_title_queries.'px) {
				.page-header {
					'.( isset( $page_title_padding['padding-top']) && !empty( $page_title_padding['padding-top']) ? 'padding-top:'.esc_attr( (int) $page_title_padding['padding-top'] ).'px !important;' : '' ).'
					'.( isset( $page_title_padding['padding-bottom']) && !empty( $page_title_padding['padding-bottom']) ? 'padding-bottom:'.esc_attr( (int) $page_title_padding['padding-bottom'] ).'px !important;' : '' ).'
					'.( isset( $page_title_height) && !empty( $page_title_height) ? 'height:'.esc_attr( (int) $page_title_height ).'px !important;' : '' ).'
				}
				.page-header_content .page-header_title {
					'.(isset( $title_style) && !empty( $title_style) ? $title_style : '').'
				}

				.page-header_content .page-header_breadcrumbs {
					'.(isset( $breadcrumbs_style) && !empty( $breadcrumbs_style) ? $breadcrumbs_style : '').'
				}

			}';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Page Title Responsive
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Portfolio Single Responsive
		/*-----------------------------------------------------------------------------------*/
		$portfolio_resp = assurena_Theme_Helper::get_option('portfolio_single_resp');
		$mb_cond_logic_pf = false;

		if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {

			$mb_cond_logic_pf = rwmb_meta('mb_portfolio_post_conditional') == 'custom' && rwmb_meta('mb_portfolio_single_resp') == '1' ? '1' : '';

			if (rwmb_meta('mb_portfolio_post_conditional') == 'custom') {
				if (rwmb_meta('mb_portfolio_single_resp') == '1') {
					$portfolio_resp = '1';
				}
			}
		}

		if ($portfolio_resp == '1') {

			$pf_queries = assurena_Theme_Helper::options_compare('portfolio_single_resp_breakpoint', 'mb_portfolio_single_resp', $mb_cond_logic_pf);

			$pf_padding = assurena_Theme_Helper::options_compare('portfolio_single_resp_padding', 'mb_portfolio_single_resp', $mb_cond_logic_pf);

			$css .= '@media only screen and (max-width: '.esc_attr( (int)$pf_queries ).'px) {
				.stl-portfolio-single_wrapper.single_type-3 .stl-portfolio-item_bg .stl-portfolio-item_title_wrap,
				.stl-portfolio-single_wrapper.single_type-4 .stl-portfolio-item_bg .stl-portfolio-item_title_wrap{
					'.( isset( $pf_padding['padding-top']) && !empty( $pf_padding['padding-top']) ? 'padding-top:'.esc_attr( (int) $pf_padding['padding-top'] ).'px !important;' : '' ).'
					'.( isset( $pf_padding['padding-bottom']) && !empty( $pf_padding['padding-bottom']) ? 'padding-bottom:'. esc_attr( (int) $pf_padding['padding-bottom'] ).'px  !important;' : '' ).'
				}

			}';
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Portfolio Single Responsive
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Footer page css
		/*-----------------------------------------------------------------------------------*/
		$footer_switch = assurena_Theme_Helper::get_option('footer_switch');
		if ($footer_switch) {
			$footer_content_type = assurena_Theme_Helper::get_option('footer_content_type');
			if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
				$mb_footer_switch = rwmb_meta('mb_footer_switch');
				if ($mb_footer_switch == 'on') {
					$footer_content_type = rwmb_meta('mb_footer_content_type');
				}
			}

			if ($footer_content_type == 'pages') {
				$footer_page_id = assurena_Theme_Helper::options_compare('footer_page_select');
				if ($footer_page_id) {
					$footer_page_id = intval( $footer_page_id);
					$shortcodes_css = get_post_meta( $footer_page_id, '_wpb_shortcodes_custom_css', true );
					if (! empty( $shortcodes_css )) {
						$shortcodes_css = strip_tags( $shortcodes_css );
						$css .= $shortcodes_css;
					}
				}
			}
		}
		/*-----------------------------------------------------------------------------------*/
		/* \End Footer page css
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Gradient css
		/*-----------------------------------------------------------------------------------*/

		require_once( get_theme_file_path('/core/admin/css/dynamic/gradient.php') );

		/*-----------------------------------------------------------------------------------*/
		/* \End Gradient css
		/*-----------------------------------------------------------------------------------*/


		/*-----------------------------------------------------------------------------------*/
		/* Elementor Theme css
		/*-----------------------------------------------------------------------------------*/

		if (did_action( 'elementor/loaded' )) {
			
			if (defined('ELEMENTOR_VERSION')) {
                if (version_compare(ELEMENTOR_VERSION, '3.0', '<')) {
                    $container_width = get_option('elementor_container_width');
                    $container_width = !empty($container_width) ? $container_width : 1140;
                } else {
                    $kit_id = (new \Elementor\Core\Kits\Manager())->get_active_id();
                    $meta_key = \Elementor\Core\Settings\Page\Manager::META_KEY;
                    $kit_settings = get_post_meta($kit_id, $meta_key, true);
                    $container_width = $kit_settings['container_width']['size'] ?? 1140;
                }
            }

			$css .= 'body.elementor-page main .stl-container.stl-content-sidebar,
			body.elementor-editor-active main .stl-container.stl-content-sidebar,
			body.elementor-editor-preview main .stl-container.stl-content-sidebar{
				max-width: '.intval( $container_width).'px;
				margin-left: auto;
				margin-right: auto;
			}';

			$css .= 'body.single main .stl-container{
				max-width: '.intval( $container_width).'px;
				margin-left: auto;
				margin-right: auto;
			}';

		}


		/*-----------------------------------------------------------------------------------*/
		/* \End Elementor Theme css
		/*-----------------------------------------------------------------------------------*/

		/*-----------------------------------------------------------------------------------*/
		/* Add Inline css
		/*-----------------------------------------------------------------------------------*/

		$css = $this->minify_css( $css);
		wp_add_inline_style( 'assurena-main', $css );

		/*-----------------------------------------------------------------------------------*/
		/* \End Add Inline css
		/*-----------------------------------------------------------------------------------*/
	}
}

if (!function_exists('assurena_dynamic_styles')) {
	function assurena_dynamic_styles() {
		return assurena_dynamic_styles::instance();
	}
}

assurena_dynamic_styles()->register_script();
assurena_dynamic_styles()->init_style();



