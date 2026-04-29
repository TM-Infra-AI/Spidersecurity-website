<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Elementor_Helper;
use stlAddons\Templates\stlToggleAccordion;
use Elementor\Frontend;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;


class stl_Tabs extends Widget_Base {
	
	public function get_name() {
		return 'stl-tabs';
	}

	public function get_title() {
		return esc_html__('stl Tabs', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-tabs';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}

	protected function _register_controls() {
		$primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_general',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);

		$this->add_responsive_control('tabs_tab_align',
			[
				'label' => esc_html__('Alignment', 'assurena-core'),
				'type' => Controls_Manager::CHOOSE,
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
				'default' => 'left',
			]
		);
		
		$this->add_responsive_control(
			'tabs_section_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_content',
			[ 'label' => esc_html__('Content', 'assurena-core') ]
		);

		$this->add_control(
			'tabs_tab',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[ 'tabs_tab_title' => esc_html__('Tab Title 1', 'assurena-core') ],
					[ 'tabs_tab_title' => esc_html__('Tab Title 2', 'assurena-core') ],
					[ 'tabs_tab_title' => esc_html__('Tab Title 3', 'assurena-core') ],
				],
				'fields' => [
					[
						'name' => 'tabs_tab_title',
						'label' => esc_html__('Tab Title', 'assurena-core'),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__('Tab Title', 'assurena-core'),
					],
					[
						'name' => 'tabs_tab_icon_type',
						'label' => esc_html__('Add Icon/Image', 'assurena-core'),
						'type' => Controls_Manager::CHOOSE,
						'label_block' => false,
						'options' => [
							'' => [
								'title' => esc_html__('None', 'assurena-core'), 
								'icon' => 'fa fa-ban',
							],
							'font' => [
								'title' => esc_html__('Icon', 'assurena-core'),
								'icon' => 'fa fa-smile-o',
							],
							'image' => [
								'title' => esc_html__('Image', 'assurena-core'),
								'icon' => 'fa fa-picture-o',
							]
						],
						'default' => '',
					],
					[
						'name' => 'tabs_tab_icon_pack',
						'label' => esc_html__('Icon Pack', 'assurena-core'),
						'type' => Controls_Manager::SELECT,
						'condition' => [ 'tabs_tab_icon_type' => 'font' ],
						'options' => [
							'fontawesome' => esc_html__('Fontawesome', 'assurena-core'), 
							'flaticon' => esc_html__('Flaticon', 'assurena-core'),
						],
						'default' => 'fontawesome',
					],
					[
						'name' => 'tabs_tab_icon_flaticon',
						'label' => esc_html__('Icon', 'assurena-core'),
						'type' => 'stl-icon',
						'label_block' => true,
						'condition' => [
							'tabs_tab_icon_pack'  => 'flaticon',
							'tabs_tab_icon_type'  => 'font',
						],
						'description' => esc_html__('Select icon from Flaticon library.', 'assurena-core'),
					],
					[
						'name' => 'tabs_tab_icon_fontawesome',
						'label' => esc_html__('Icon', 'assurena-core'),
						'type' => Controls_Manager::ICON,
						'label_block' => true,
						'condition' => [
							'tabs_tab_icon_pack'  => 'fontawesome',
							'tabs_tab_icon_type'  => 'font',
						],
						'description' => esc_html__('Select icon from Fontawesome library.', 'assurena-core'),
					],
					[
						'name' => 'tabs_tab_icon_thumbnail',
						'label' => esc_html__('Image', 'assurena-core'),
						'type' => Controls_Manager::MEDIA,
						'label_block' => true,
						'condition' => [ 'tabs_tab_icon_type' => 'image' ],
						'default' => [ 'url' => Utils::get_placeholder_image_src() ],
					],
					[
						'name' => 'tabs_content_type',
						'label' => esc_html__('Content Type', 'assurena-core'),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'content' => esc_html__('Content', 'assurena-core'),
							'template' => esc_html__('Saved Templates', 'assurena-core'),
						],
						'default' => 'content',
					],
					[
						'name' => 'tabs_content_templates',
						'label' => esc_html__('Choose Template', 'assurena-core'),
						'type' => Controls_Manager::SELECT,
						'condition' => [ 'tabs_content_type' => 'template' ],
						'options' => stl_Elementor_Helper::get_instance()->get_elementor_templates(),
					],
					[
						'name' => 'tabs_content',
						'label' => esc_html__('Tab Content', 'assurena-core'),
						'type' => Controls_Manager::WYSIWYG,
						'condition' => [ 'tabs_content_type' => 'content' ],
						'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'assurena-core'),
					],
				],
				'title_field' => '{{tabs_tab_title}}',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> TITLE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__('Title', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_title_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-tabs_title',
			]
		);

		$this->add_control(
			'tabs_title_tag',
			[
				'label' => esc_html__('Title HTML Tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h4',
			]
		);

		$this->add_responsive_control(
			'tabs_title_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
				    'top' => 18,
				    'right' => 0,
				    'bottom' => 18,
				    'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_title_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 64,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_title_line',
			[
				'label' => esc_html__('Add Title Bottom Line', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);

		
		$this->start_controls_tabs( 'tabs_header_tabs' );
	
		$this->start_controls_tab(
			'tabs_header_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			't_title_color_idle',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_idle',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_border_radius_idle',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tabs_title_border',
				'selector' => '{{WRAPPER}} .stl-tabs_header',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_header_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			't_title_color_hover',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_hover',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_line_color_hover',
			[
				'label' => esc_html__('Title Bottom Line Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'tabs_title_line' => 'yes' ],
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header:hover:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_border_radius_hover',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 't_title_border_hover',
				'selector' => '{{WRAPPER}} .stl-tabs_header:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			't_header_active',
			[ 'label' => esc_html__('Active', 'assurena-core') ]
		);

		$this->add_control(
			't_title_color_active',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_bg_color_active',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_line_color_active',
			[
				'label' => esc_html__('Title Bottom Line Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'tabs_title_line' => 'yes' ],
				'default' => $secondary_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header.active:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			't_title_border_radius_active',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 't_title_border_active',
				'selector' => '{{WRAPPER}} .stl-tabs_header.active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> ICON
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'tabs_icon_size',
			[
				'label' => esc_html__('Icon Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 26,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_icon:not(.stl-tabs_icon-image)' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tabs_icon_position',
			[
				'label' => esc_html__('Icon/Image Position', 'assurena-core'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => esc_html__('Top', 'assurena-core'), 
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__('Right', 'assurena-core'),
						'icon' => 'eicon-h-align-right',
					],
					'bottom' => [
						'title' => esc_html__('Bottom', 'assurena-core'),
						'icon' => 'eicon-v-align-bottom',
					],
					'left' => [
						'title' => esc_html__('Left', 'assurena-core'),
						'icon' => 'eicon-h-align-left',
					]
				],
				'default' => 'top',
			]
		);

		$this->add_responsive_control(
			'tabs_icon_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs( 'tabs_icon_tabs' );
	 
		$this->start_controls_tab(
			'tabs_icon_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'tabs_icon_color',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			'tabs_icon_color_hover',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header:hover .stl-tabs_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_icon_active',
			[ 'label' => esc_html__('Active', 'assurena-core') ]
		);

		$this->add_control(
			'tabs_icon_color_active',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_header.active .stl-tabs_icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__('Content', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tabs_content_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-tabs_content',
			]
		);

		$this->add_responsive_control(
			'tabs_content_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 29,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_content_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_color',
			[
				'label' => esc_html__('Content Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_bg_color',
			[
				'label' => esc_html__('Content Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tabs_content_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-tabs_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'tabs_content_border',
				'selector' => '{{WRAPPER}} .stl-tabs_content',
			]
		);

		$this->end_controls_section(); 

	}

	protected function render() {
		
		$_s = $this->get_settings_for_display();
		$id_int = substr( $this->get_id_int(), 0, 3 );

		$this->add_render_attribute(
			'tabs',
			[
				'class' => [
					'stl-tabs',
					'icon_position-'.$_s[ 'tabs_icon_position' ],
					'tabs_align-'.$_s[ 'tabs_tab_align' ],
				],
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>

			<div class="stl-tabs_headings"><?php
				foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

					$tab_count = $index + 1;
					$tab_title_key = $this->get_repeater_setting_key( 'tabs_tab_title', 'tabs_tab', $index );
					$this->add_render_attribute(
						$tab_title_key,
						[
							'data-tab-id' => 'stl-tab_' . $id_int . $tab_count,
							'class' => [ 'stl-tabs_header' ],
						]
					);

					?>
					<<?php echo $_s[ 'tabs_title_tag' ]; ?> <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>>
						<span class="stl-tabs_title"><?php echo $item[ 'tabs_tab_title' ] ?></span>

						<?php 
						// Tab Icon/image
						if ( $item[ 'tabs_tab_icon_type' ] != '' ) {
							if ( $item[ 'tabs_tab_icon_type' ] == 'font' && (!empty( $item[ 'tabs_tab_icon_flaticon' ] ) || !empty( $item[ 'tabs_tab_icon_fontawesome' ] )) ) {
								switch ( $item[ 'tabs_tab_icon_pack' ] ) {
									case 'fontawesome':
										wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
										$icon_font = $item[ 'tabs_tab_icon_fontawesome' ];
										break;
									case 'flaticon':
										wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
										$icon_font = $item[ 'tabs_tab_icon_flaticon' ];
										break;
								}
								?>
								<span class="stl-tabs_icon">
									<i class="icon <?php echo esc_attr( $icon_font) ?>"></i>
								</span>
								<?php
							 }
							if ( $item[ 'tabs_tab_icon_type' ] == 'image' && !empty( $item[ 'tabs_tab_icon_thumbnail' ] ) ) {
								if ( ! empty( $item[ 'tabs_tab_icon_thumbnail' ][ 'url' ] ) ) {
									$this->add_render_attribute( 'thumbnail', 'src', $item[ 'tabs_tab_icon_thumbnail' ][ 'url' ] );
									$this->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $item[ 'tabs_tab_icon_thumbnail' ] ) );
									$this->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $item[ 'tabs_tab_icon_thumbnail' ] ) );
									?>
									<span class="stl-tabs_icon stl-tabs_icon-image">
									<?php
										echo Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'tabs_tab_icon_thumbnail' );
									?>
									</span>
									<?php
								}
							}
						}
						// End Tab Icon/image
						?>

					</<?php echo $_s[ 'tabs_title_tag' ]; ?>>

				<?php endforeach;?>
			</div>

			<div class="stl-tabs_content-wrap"><?php 
				foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

					$tab_count = $index + 1;
					$tab_content_key = $this->get_repeater_setting_key( 'tab_content', 'tabs_tab', $index );
					$this->add_render_attribute(
						$tab_content_key,
						[
							'data-tab-id' => 'stl-tab_' . $id_int . $tab_count,
							'class' => [ 'stl-tabs_content' ],
						]
					);

					?>
					<div <?php echo $this->get_render_attribute_string( $tab_content_key ); ?>>
					<?php
						if ( $item[ 'tabs_content_type' ] == 'content' ) {
							echo do_shortcode( $item[ 'tabs_content' ] );
						} else if ( $item[ 'tabs_content_type' ] == 'template' ) {
							$id = $item[ 'tabs_content_templates' ];
							$stl_frontend = new Frontend;
							echo $stl_frontend->get_builder_content_for_display( $id, false );
						}
					?>
					</div>

				<?php endforeach; ?>
			</div>
			
		</div>
		<?php

	}
	
}