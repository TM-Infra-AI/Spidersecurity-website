<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use stlAddons\Includes\stl_Loop_Settings;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Templates\stlPortfolio;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;


class stl_Portfolio extends Widget_Base
{
	public function get_name() {
		return 'stl-portfolio';
	}

	public function get_title() {
		return esc_html__('stl Portfolio', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-portfolio';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}

	public function get_script_depends()
	{
		return [
			'slick',
			'imagesloaded',
			'isotope',
			'stl-elementor-extensions-widgets',
		];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'stl_portfolio_section',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);

		$this->add_control(
			'portfolio_layout',
			[
				'label' => esc_html__('Layout', 'assurena-core'),
				'type' => 'stl-radio-image',
				'options' => [
					'grid' => [
						'title' => esc_html__('Grid', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_grid.png',
					],
					'carousel' => [
						'title' => esc_html__('Carousel', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_carousel.png',
					],
					'masonry' => [
						'title' => esc_html__('Masonry', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry2' => [
						'title' => esc_html__('Masonry 2', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry3' => [
						'title' => esc_html__('Masonry 3', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_masonry.png',
					],
					'masonry4' => [
						'title' => esc_html__('Masonry 4', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/layout_masonry.png',
					],
				],
				'default' => 'grid',
			]
		);

		$this->add_control(
			'posts_per_row',
			[
				'label' => esc_html__('Columns Amount', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('1', 'assurena-core'),
					'2' => esc_html__('2', 'assurena-core'),
					'3' => esc_html__('3', 'assurena-core'),
					'4' => esc_html__('4', 'assurena-core'),
					'5' => esc_html__('5', 'assurena-core'),
				],
				'default' => '3',
				'condition' => [
					'portfolio_layout' => [ 'grid', 'masonry', 'carousel' ]
				]
			]
		);

		$this->add_control(
			'grid_gap',
			[
				'label' => esc_html__('Grid Gap', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'0px' => esc_html__('0', 'assurena-core'),
					'1px' => esc_html__('1', 'assurena-core'),
					'2px' => esc_html__('2', 'assurena-core'),
					'3px' => esc_html__('3', 'assurena-core'),
					'4px' => esc_html__('4', 'assurena-core'),
					'5px' => esc_html__('5', 'assurena-core'),
					'10px' => esc_html__('10', 'assurena-core'),
					'15px' => esc_html__('15', 'assurena-core'),
					'20px' => esc_html__('20', 'assurena-core'),
					'25px' => esc_html__('25', 'assurena-core'),
					'30px' => esc_html__('30', 'assurena-core'),
					'35px' => esc_html__('35', 'assurena-core'),
				],
				'default' => '30px',
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label' => esc_html__('Show Filter', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'portfolio_layout!' => 'carousel' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'filter_align',
			[
				'label' => esc_html__('Filter Align', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'portfolio_layout!' => 'carousel',
					'show_filter' => 'yes',
				],
				'options' => [
					'left' => esc_html__('Left', 'assurena-core'),
					'right' => esc_html__('Right', 'assurena-core'),
					'center' => esc_html__('Сenter', 'assurena-core'),
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'crop_images',
			[
				'label' => esc_html__('Crop Images', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'portfolio_layout!' => 'masonry' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__('Navigation Type', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'portfolio_layout!' => 'carousel' ],
				'options' => [
					'none' => esc_html__('None', 'assurena-core'),
					'pagination' => esc_html__('Pagination', 'assurena-core'),
					'infinite' => esc_html__('Infinite Scroll', 'assurena-core'),
					'load_more' => esc_html__('Load More', 'assurena-core'),
					'custom_link' => esc_html__('Custom Link', 'assurena-core'),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'item_link',
			[
				'label' => esc_html__('Link', 'assurena-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'navigation' => 'custom_link' ],
				'placeholder' => esc_html__('https://your-link.com', 'assurena-core'),
				'default' => [ 'url' => '#' ],
			]
		);

		$this->add_control(
			'link_position',
			[
				'label' => esc_html__('Link Position', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'custom_link' ],
				'options' => [
					'below_items' => esc_html__('Below Items', 'assurena-core'),
					'after_items' => esc_html__('After Items', 'assurena-core'),
				],
				'default' => 'below_items',
			]
		);

		$this->add_control(
			'link_align',
			[
				'label' => esc_html__('Link Alignment', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'custom_link' ],
				'options' => [
					'center' => esc_html__('Сenter', 'assurena-core'),
					'left' => esc_html__('Left', 'assurena-core'),
					'right' => esc_html__('Right', 'assurena-core'),
				],
				'default' => 'left',
			]
		);

		$this->add_responsive_control(
			'link_margin',
			[
				'label' => esc_html__('Spacing', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'navigation' => 'custom_link' ],
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 60,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio_item_link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'nav_align',
			[
				'label' => esc_html__('Alignment', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'navigation' => 'pagination' ],
				'options' => [
					'center' => esc_html__('Сenter', 'assurena-core'),
					'left' => esc_html__('Left', 'assurena-core'),
					'right' => esc_html__('Right', 'assurena-core'),
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'items_load',
			[
				'label' => esc_html__('Items to be loaded', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'navigation' => [ 'load_more', 'infinite' ],
				],
				'default' => esc_html__('4', 'assurena-core'),
			]
		);

		$this->add_control(
			'name_load_more',
			[
				'label' => esc_html__('Button Text', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'navigation' => [ 'load_more', 'custom_link' ],
				],
				'default' => esc_html__('Load More', 'assurena-core'),
			]
		);

		$this->add_control(
			'add_animation',
			[
				'label' => esc_html__('Add Appear Animation', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'appear_animation',
			[
				'label' => esc_html__('Animation Style', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'add_animation' => 'yes' ],
				'options' => [
					'fade-in' => esc_html__('Fade In', 'assurena-core'),
					'slide-top' => esc_html__('Slide Top', 'assurena-core'),
					'slide-bottom' => esc_html__('Slide Bottom', 'assurena-core'),
					'slide-left' => esc_html__('Slide Left', 'assurena-core'),
					'slide-right' => esc_html__('Slide Right', 'assurena-core'),
					'zoom' => esc_html__('Zoom', 'assurena-core'),
				],
				'default' => 'fade-in',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> APPEARANCE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'display_section',
			[ 'label' => esc_html__('Appearance', 'assurena-core') ]
		);

		$this->add_control(
			'img_click_action',
			[
				'label' => esc_html__('Image Click Action', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'single' => esc_html__('Open Single Page', 'assurena-core'),
					'custom' => esc_html__('Open Custom Link', 'assurena-core'),
					'popup' => esc_html__('Popup the Image', 'assurena-core'),
					'none' => esc_html__('Do Nothing', 'assurena-core'),
				],
				'default' => 'single',
			]
		);

		$this->add_control(
			'img_click_action_notice',
			[
				'label' => esc_html__('Notice! You can specify custom link for each post in corresponding metabox options section.', 'assurena-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'img_click_action' => 'custom' ],
			]
		);

		$this->add_control(
			'single_link_title',
			[
				'label' => esc_html__('Add link on Heading', 'assurena-core'),
				'condition' => [ 'gallery_mode' => '' ],
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'info_position',
			[
				'label' => esc_html__('Position the Info ', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inside_image' => esc_html__('within image', 'assurena-core'),
					'under_image' => esc_html__('beneath image', 'assurena-core'),
				],
				'default' => 'inside_image',
			]
		);

		$this->add_control(
			'image_anim',
			[
				'label' => esc_html__('Description Animation', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'info_position' => 'inside_image' ],
				'options' => [
					'simple' => esc_html__('Simple', 'assurena-core'),
					'sub_layer' => esc_html__('On Sub-Layer', 'assurena-core'),
					'offset' => esc_html__('Side Offset', 'assurena-core'),
					'zoom_in' => esc_html__('Zoom In', 'assurena-core'),
					'outline' => esc_html__('Outline', 'assurena-core'),
					'always_info' => esc_html__('Visible Until Hover', 'assurena-core'),
				],
				'default' => 'simple',
			]
		);

		$this->add_control(
			'horizontal_align',
			[
				'label' => esc_html__('Description Alignment', 'assurena-core'),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [
					'gallery_mode' => '',
					'info_position' => 'under_image'
				],
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'assurena-core'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'assurena-core'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'assurena-core'),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => esc_html__('Justified', 'assurena-core'),
						'icon' => 'fa fa-align-justify',
					],
				],
				'default' => 'center',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'content_section',
			[ 'label' => esc_html__('Content', 'assurena-core') ]
		);

		$this->add_control(
			'gallery_mode',
			[
				'label' => esc_html__('Gallery Mode', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'show_portfolio_title',
			[
				'label' => esc_html__('Show Title?', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_meta_categories',
			[
				'label' => esc_html__('Show categories?', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_content',
			[
				'label' => esc_html__('Show Excerpt/Content?', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'gallery_mode' => '' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'content_letter_count',
			[
				'label' => esc_html__('Content Letter Count', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter content letter count.', 'assurena-core' ),
				'condition' => [
					'show_content' => 'yes',
					'gallery_mode' => '',
				],
				'min' => 1,
				'default' => '85',
			]
		);

		$this->add_control(
			'portfolio_icon_type',
			[
				'label' => esc_html__('Add Icon', 'assurena-core' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [ 'gallery_mode!' => '' ],
				'label_block' => false,
				'options' => [
					'' => [
						'title' => esc_html__('None', 'assurena-core' ),
						'icon' => 'fa fa-ban',
					],
					'font' => [
						'title' => esc_html__('Icon', 'assurena-core' ),
						'icon' => 'fa fa-smile-o',
					],
				],
				'default' => '',
			]
		);

		$this->add_control(
			'portfolio_icon_pack',
			[
				'label' => esc_html__('Icon Pack', 'assurena-core' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'gallery_mode!' => '',
					'portfolio_icon_type' => 'font'
				],
				'options' => [
					'fontawesome' => esc_html__('Fontawesome', 'assurena-core' ),
					'flaticon' => esc_html__('Flaticon', 'assurena-core' ),
				],
				'default' => 'fontawesome',
			]
		);

		$this->add_control(
			'portfolio_icon_flaticon',
			[
				'label' => esc_html__('Icon', 'assurena-core' ),
				'type' => 'stl-icon',
				'description' => esc_html__('Select icon from Flaticon library.', 'assurena-core' ),
				'label_block' => true,
				'condition' => [
					'gallery_mode!' => '',
					'portfolio_icon_pack' => 'flaticon',
					'portfolio_icon_type' => 'font',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'portfolio_icon_fontawesome',
			[
				'label' => esc_html__('Icon', 'assurena-core' ),
				'type' => Controls_Manager::ICON,
				'condition' => [
					'gallery_mode!' => '',
					'portfolio_icon_pack' => 'fontawesome',
					'portfolio_icon_type' => 'font',
				],
				'description' => esc_html__('Select icon from Fontawesome library.', 'assurena-core' ),
				'label_block' => true,
				'default' => '',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CAROUSEL OPTIONS
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'stl_carousel_section',
			[
				'label' => esc_html__('Carousel Options', 'assurena-core'),
				'condition' => [ 'portfolio_layout' => 'carousel' ],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__('Autoplay', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__('Autoplay Speed', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'autoplay' => 'yes' ],
				'min' => 1,
				'default' => '3000',
			]
		);

		$this->add_control(
			'c_infinite_loop',
			[
				'label' => esc_html__('Infinite Loop', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'c_slide_per_single',
			[
				'label' => esc_html__('Slide per single item', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label' => esc_html__('Center Mode', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'center_info',
			[
				'label' => esc_html__('Show Center Info', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'center_mode' => 'yes' ],
			]
		);

		$this->add_control(
			'variable_width',
			[
				'label' => esc_html__('Variable Width', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'use_pagination',
			[
				'label' => esc_html__('Add Pagination control', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'pag_type',
			[
				'label' => esc_html__('Pagination Type', 'assurena-core'),
				'type' => 'stl-radio-image',
				'condition' => [ 'use_pagination' => 'yes' ],
				'options' => [
					'circle' => [
						'title' => esc_html__('Circle', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_circle.png',
					],
					'circle_border' => [
						'title' => esc_html__('Empty Circle', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_circle_border.png',
					],
					'square' => [
						'title' => esc_html__('Square', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_square.png',
					],
					'square_border' => [
						'title' => esc_html__('Empty Square', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_square_border.png',
					],
					'line' => [
						'title' => esc_html__('Line', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_line.png',
					],
					'line_circle' => [
						'title' => esc_html__('Line - Circle', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/pag_line_circle.png',
					],
				],
				'default' => 'square_border',
			]
		);

		$this->add_control(
			'pag_offset',
			[
				'label' => esc_html__('Pagination Top Offset', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'use_pagination' => 'yes' ],
				'min' => -55,
				'max' => 55,
				'default' => 14,
				'selectors' => [
					'{{WRAPPER}} .stl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'custom_pag_color',
			[
				'label' => esc_html__('Customize Pagination Color', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_pagination!' => '' ],
			]
		);

		$this->add_control(
			'pag_color',
			[
				'label' => esc_html__('Pagination Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'condition' => [ 'custom_pag_color' => 'yes' ],
			]
		);

		$this->add_control(
			'use_prev_next',
			[
				'label' => esc_html__('Add Prev/Next buttons', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'arrows_center_mode',
			[
				'label' => esc_html__('Center Mode', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'use_prev_next' => 'yes' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);


		$this->add_control(
			'custom_resp',
			[
				'label' => esc_html__('Customize Responsive', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
			]
		);

		$this->add_control(
			'heading_desktop',
			[
				'label' => esc_html__('Desktop Settings', 'assurena-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'custom_resp' => 'yes' ],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'resp_medium',
			[
				'label' => esc_html__('Desktop Screen Breakpoint', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'default' => '1025',
			]
		);

		$this->add_control(
			'resp_medium_slides',
			[
				'label' => esc_html__('Columns amount', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
			]
		);

		$this->add_control(
			'heading_tablet',
			[
				'label' => esc_html__('Tablet Settings', 'assurena-core'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
				'condition' => [ 'custom_resp' => 'yes' ],
			]
		);

		$this->add_control(
			'resp_tablets',
			[
				'label' => esc_html__('Tablet Screen Breakpoint', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'default' => '800',
			]
		);

		$this->add_control(
			'resp_tablets_slides',
			[
				'label' => esc_html__('Columns amount', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'step' => 1,
			]
		);

		$this->add_control(
			'heading_mobile',
			[
				'label' => esc_html__('Mobile Settings', 'assurena-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'custom_resp' => 'yes' ],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'resp_mobile',
			[
				'label' => esc_html__('Mobile Screen Breakpoint', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
				'default' => '480',
			]
		);

		$this->add_control(
			'resp_mobile_slides',
			[
				'label' => esc_html__('Columns amount', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'custom_resp' => 'yes' ],
				'min' => 1,
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  SETTINGS -> QUERY
		/*-----------------------------------------------------------------------------------*/

		stl_Loop_Settings::init(
			$this,
			[
				'post_type' => 'portfolio',
				'hide_cats' => true,
				'hide_tags' => true
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'media_style_section',
			[
				'label' => esc_html__('General', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_padding',
			[
				'label' => esc_html__('Description Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 40,
					'right' => 40,
					'bottom' => 40,
					'left' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'description',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'info_position' => 'under_image' ],
				'selector' => '{{WRAPPER}} .stl-portfolio-item_description',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba('.\assurena_Theme_Helper::HexToRGB($h_font_color).', 0.7)' ],
				],
			]
		);

		$this->add_control(
			'custom_image_mask_heading',
			[
				'label' => esc_html__('Item Overlay', 'assurena-core'),
				'type' => Controls_Manager::HEADING,
				'condition' => [ 'info_position' => 'inside_image' ],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_image_mask_color',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [
					'info_position' => 'inside_image',
					'image_anim!' => 'sub_layer',
				],
				'selector' => '{{WRAPPER}} .overlay',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba('.\assurena_Theme_Helper::HexToRGB($primary_color).', 0.9)' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_desc_mask_color',
				'types' => [ 'classic', 'gradient' ],
				'condition' => [
					'info_position' => 'inside_image',
					'image_anim' => 'sub_layer',
				],
				'selector' => '{{WRAPPER}} .stl-portfolio-item_description',
				'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => 'rgba('.\assurena_Theme_Helper::HexToRGB($primary_color).', 0.8)' ],
				],
			]
		);

		$this->add_control(
			'sec_overlay_color',
			[
				'label' => esc_html__('Additional Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'info_position' => 'inside_image',
					'image_anim' => [ 'offset', 'outline', 'always_info' ],
				],
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .inside_image .overlay:before' => 'box-shadow: inset 0px 0px 0px 0px {{VALUE}}',
					'{{WRAPPER}} .inside_image:hover .overlay:before' => 'box-shadow: inset 0px 0px 0px 10px {{VALUE}}',
					'{{WRAPPER}} .inside_image.offset_animation:before' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> FILTER
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_filter',
			[
				'label' => esc_html__('Filter', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_filter' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'filter_cats_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_cats_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 23,
					'bottom' => 0,
					'left' => 23,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_filter_cats',
				'selector' => '{{WRAPPER}} .isotope-filter a',
			]
		);

		$this->start_controls_tabs( 'filter_cats_color_tabs' );

		$this->start_controls_tab(
			'filter_cats_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'filter_color_idle',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_idle',
			[
				'label' => esc_html__('Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_cats_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'filter_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .isotope-filter a:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_hover',
			[
				'label' => esc_html__('Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'filter_cats_color_active',
			[ 'label' => esc_html__('Active' , 'assurena-core') ]
		);

		$this->add_control(
			'filter_color_active',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'filter_bg_active',
			[
				'label' => esc_html__('Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'filter_cats_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .isotope-filter a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'filter_cats_shadow',
				'selector' => '{{WRAPPER}} .isotope-filter a',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> HEADINGS
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_headings',
			[
				'label' => esc_html__('Headings', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'headings_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 5,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio__item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_portfolio_headings',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .title',
			]
		);

		$this->start_controls_tabs( 'headings_color' );

		$this->start_controls_tab(
			'custom_headings_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_headings_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_headings_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_hover_headings_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .title:hover, {{WRAPPER}} .title:hover a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CATEGORIES
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'cats_style_section',
			[
				'label' => esc_html__('Categories', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_meta_categories!' => '' ],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_portfolio_cats',
				'selector' => '{{WRAPPER}} .post_cats',
			]
		);

		$this->start_controls_tabs( 'cats_color_tabs' );

		$this->start_controls_tab(
			'custom_cats_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'cats_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .portfolio-category, {{WRAPPER}} .post_cats > :first-child:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_cats_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'cat_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .portfolio-category:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> EXCERPT/CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Excerpt/Content', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_content!' => '' ],
			]
		);

		$this->add_control(
			'custom_content_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> LOAD MORE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'load_more_style_section',
			[
				'label' => esc_html__('Load More', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'navigation' => 'load_more' ],
			]
		);

		$this->add_responsive_control(
			'load_more_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'load_more_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 38,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_load_more',
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);


		$this->start_controls_tabs( 'load_more_color_tab' );

		$this->start_controls_tab(
			'custom_load_more_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'load_more_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_background',
			[
				'label' => esc_html__('Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_load_more_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'load_more_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_background_hover',
			[
				'label' => esc_html__('Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'load_more_border',
				'label' => esc_html__('Border Type', 'assurena-core'),
				'default' => '1px',
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);

		$this->add_control(
			'load_more_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .load_more_wrapper .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'load_more_shadow',
				'selector' => '{{WRAPPER}} .load_more_wrapper .load_more_item',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GALLERY ICON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_gallery',
			[
				'label' => esc_html__('Gallery Icon', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'portfolio_icon_type' => 'font' ],
			]
		);

		$this->add_responsive_control(
			'gallery_icon_size',
			[
				'label' => esc_html__('Icon Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 10, 'max' => 100 ],
				],
				'default' => [ 'size' => 20, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gallery_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stl-portfolio-item_icon > i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'gallery_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'gallery_icon_color',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stl-portfolio-item_icon a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_bg_color',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			'gallery_icon_hover_color',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .stl-portfolio-item_icon:hover a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_bg_hover_color',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'gallery_icon_border_hover_color',
			[
				'label' => esc_html__('Border Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon:hover' => 'border-color: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'gallery_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 30,
					'right' => 30,
					'bottom' => 30,
					'left' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-portfolio-item_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'gallery_icon_border',
				'selector' => '{{WRAPPER}} .stl-portfolio-item_icon',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width' => [
						'default' => [
							'top' => 1,
							'right' => 1,
							'bottom' => 1,
							'left' => 1,
						],
					],
					'color' => [ 'default' => '#ffffff' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$portfolio = new stlPortfolio();
		echo $portfolio->render($atts, $this);
	}

}