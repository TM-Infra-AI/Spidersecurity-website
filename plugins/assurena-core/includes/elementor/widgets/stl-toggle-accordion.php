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


class stl_Toggle_Accordion extends Widget_Base {
	
	public function get_name() {
		return 'stl-toggle-accordion';
	}

	public function get_title() {
		return esc_html__('stl Toggle/Accordion', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-toggle-accordion';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}

	
	protected function _register_controls() {

		$theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$second_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$third_color = esc_attr(\assurena_Theme_Helper::get_option('theme-third-color'));
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_general',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);

		$this->add_control(
			'acc_type',
			[
				'label' => esc_html__('Type', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'accordion' => esc_html__('Accordion', 'assurena-core'),
					'toggle' => esc_html__('Toggle', 'assurena-core'),
				],
				'default' => 'accordion',
			]
		);

		$this->add_control(
			'enable_acc_icon',
			[
				'label' => esc_html__('Icon', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__('None', 'assurena-core'),
					'plus' => esc_html__('Plus', 'assurena-core'),
					'custom' => esc_html__('Custom', 'assurena-core'),
				],
				'default' => 'plus',
			]
		);

		$this->add_control(
			'acc_icon',
			[
				'label' => esc_html__('Choose Icon', 'assurena-core'),
				'type' => Controls_Manager::ICON,
				'condition' => [ 'enable_acc_icon' => 'custom' ],
				'include' => [
					'fa fa-plus',
					'fa fa-long-arrow-right',
					'fa fa-chevron-right',
					'fa fa-chevron-circle-right',
					'fa fa-arrow-right',
					'fa fa-arrow-circle-right',
					'fa fa-angle-right',
					'fa fa-angle-double-right',
				],
				'default' => 'fa fa-angle-right',
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

		$this->add_responsive_control(
			'acc_tab_panel_margin',
			[
				'label' => esc_html__('Tab Panel Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 20,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label' => 'Tab Panel Shadow',
				'name' => 'acc_tab_panel_shadow',
				'selector' =>  '{{WRAPPER}} .stl-accordion_panel',
			]
		);

		$this->add_control(
			'acc_tab',
			[
				'type' => Controls_Manager::REPEATER,
				'seperator' => 'before',
				'default' => [
					[
						'acc_tab_title' => esc_html__('Tab Title 1', 'assurena-core'),
						'acc_tab_def_active' => 'yes'
					],
					[ 'acc_tab_title' => esc_html__('Tab Title 2', 'assurena-core') ],
					[ 'acc_tab_title' => esc_html__('Tab Title 3', 'assurena-core') ],
				],
				'fields' => [
					[
						'name' => 'acc_tab_title',
						'label' => esc_html__('Tab Title', 'assurena-core'),
						'type' => Controls_Manager::TEXTAREA,
						'default' => esc_html__('Tab Title', 'assurena-core'),
					],
					[
						'name' => 'acc_tab_title_pref',
						'label' => esc_html__('Title Prefix', 'assurena-core'),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__('1.', 'assurena-core'),
					],
					[
						'name' => 'acc_tab_def_active',
						'label' => esc_html__('Active as Default', 'assurena-core'),
						'type' => Controls_Manager::SWITCHER,
						'default' => 'no',
						'return_value' => 'yes',
					],
					[
						'name' => 'acc_content_type',
						'label' => esc_html__('Content Type', 'assurena-core'),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'content' => esc_html__('Content', 'assurena-core'),
							'template' => esc_html__('Saved Templates', 'assurena-core'),
						],
						'default' => 'content',
					],
					[
						'name' => 'acc_content_templates',
						'label' => esc_html__('Choose Template', 'assurena-core'),
						'type' => Controls_Manager::SELECT,
						'condition' => [ 'acc_content_type' => 'template' ],
						'options' => stl_Elementor_Helper::get_instance()->get_elementor_templates(),
					],
					[
						'name' => 'acc_content',
						'label' => esc_html__('Tab Content', 'assurena-core'),
						'type' => Controls_Manager::WYSIWYG,
						'condition' => [ 'acc_content_type' => 'content' ],
						'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'assurena-core'),
					],
				],
				'title_field' => '{{acc_tab_title}}',
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
				'name' => 'acc_title_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-accordion_title',
			]
		);

		$this->add_control(
			'acc_title_tag',
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
			'acc_title_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 22,
					'right' => 20,
					'bottom' => 18,
					'left' => 19,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'acc_title_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->start_controls_tabs( 'acc_header_tabs' );
		
		$this->start_controls_tab(
			'acc_header_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'acc_title_color',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_bg_color_idle',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#f8f8f8',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border',
				'selector' => '{{WRAPPER}} .stl-accordion_header',
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'acc_header_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			'acc_title_color_hover',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_bg_color_hover',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_border_radius_hover',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border_hover',
				'selector' => '{{WRAPPER}} .stl-accordion_header:hover',
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'acc_header_active',
			[ 'label' => esc_html__('Active', 'assurena-core') ]
		);

		$this->add_control(
			'acc_title_color_active',
			[
				'label' => esc_html__('Title Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_bg_color_active',
			[
				'label' => esc_html__('Title Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_title_border_radius_active',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border_active',
				'selector' => '{{WRAPPER}} .stl-accordion_header.active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> TITLE PREFIX
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_title_pref',
			[
				'label' => esc_html__('Title Prefix', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'acc_title_pref_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-accordion_title .stl-accordion_title-prefix',
			]
		);

		
		$this->start_controls_tabs( 'acc_header_pref_tabs' );
		
		$this->start_controls_tab(
			'acc_header_pref_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'acc_title_pref_color_idle',
			[
				'label' => esc_html__('Title Prefix Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header .stl-accordion_title-prefix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'acc_header_pref_hover',
			[
				'label' => esc_html__('Hover', 'assurena-core')
			]
		);

		$this->add_control(
			'acc_title_pref_color_hover',
			[
				'label' => esc_html__('Title Prefix Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover .stl-accordion_title-prefix' => 'color: {{VALUE}};',
				],
			]
		); 

		$this->end_controls_tab();
	
		
		$this->start_controls_tab(
			'acc_header_pref_active',
			[ 'label' => esc_html__('Active', 'assurena-core') ]
		);

		$this->add_control(
			'acc_title_pref_color_active',
			[
				'label' => esc_html__('Title Prefix Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active .stl-accordion_title-prefix' => 'color: {{VALUE}};',
				],
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
			'acc_icon_size',
			[
				'label' => esc_html__('Icon Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'enable_acc_icon' => 'custom' ],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
				],
				'default' => [ 'size' => 24, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'acc_icon_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'acc_icon_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'acc_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		$this->start_controls_tabs( 'acc_icon_tabs' );
		
		$this->start_controls_tab(
			'acc_icon_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'acc_icon_color_idle',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .icon-plus .stl-accordion_icon:before,{{WRAPPER}} .icon-plus .stl-accordion_icon:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_icon_bg_color_idle',
			[
				'label' => esc_html__('Icon Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'acc_icon_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			'acc_icon_color_hover',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover .stl-accordion_icon:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .icon-plus .stl-accordion_header:hover .stl-accordion_icon:before, {{WRAPPER}} .icon-plus .stl-accordion_header:hover .stl-accordion_icon:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_icon_bg_color_hover',
			[
				'label' => esc_html__('Icon Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header:hover .stl-accordion_icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
	
		$this->start_controls_tab(
			'acc_icon_active',
			[ 'label' => esc_html__('Active', 'assurena-core') ]
		);

		$this->add_control(
			'acc_icon_color_active',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active .stl-accordion_icon:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .icon-plus .stl-accordion_header.active .stl-accordion_icon:before, {{WRAPPER}} .icon-plus .stl-accordion_header.active .stl-accordion_icon:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_icon_bg_color_active',
			[
				'label' => esc_html__('Icon Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_header.active .stl-accordion_icon' => 'background-color: {{VALUE}};',
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
				'name' => 'acc_content_typo',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-accordion_content',
			]
		);

		$this->add_responsive_control(
			'acc_content_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 24,
					'right' => 30,
					'bottom' => 5,
					'left' => 30,
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'acc_content_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'acc_content_color',
			[
				'label' => esc_html__('Content Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_content_bg_color',
			[
				'label' => esc_html__('Content Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'acc_content_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-accordion_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_content_border',
				'selector' => '{{WRAPPER}} .stl-accordion_content',
			]
		);

		$this->end_controls_section(); 

	}

	protected function render() {
		
		$_s = $this->get_settings_for_display();
		$id_int = substr($this->get_id_int(), 0, 3);

		$this->add_render_attribute(
			'accordion',
			[
				'class' => [
					'stl-accordion', 
					'icon-'.$_s['enable_acc_icon'],
				],
				'id' => 'stl-accordion-'.esc_attr( $this->get_id() ),
				'data-type' => $_s['acc_type'],
			]
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>><?php
			foreach ( $_s['acc_tab'] as $index => $item ) :

				$tab_count = $index + 1;

				$tab_title_key = $this->get_repeater_setting_key( 'acc_tab_title', 'acc_tab', $index ); 

				$this->add_render_attribute(
					$tab_title_key,
					[
						'id' => 'stl-accordion_header-' . $id_int . $tab_count,
						'class' => [ 'stl-accordion_header' ],
						'data-default' => $item[ 'acc_tab_def_active' ],
					]
				);
				
				?>
				<div class="stl-accordion_panel">
					<<?php echo $_s['acc_title_tag']; ?> <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>>
						<span class="stl-accordion_title"><?php
							if ( ! empty($item[ 'acc_tab_title_pref' ]) ) { ?>
								<span class="stl-accordion_title-prefix"><?php echo $item[ 'acc_tab_title_pref' ] ?></span><?php
							}
							echo $item[ 'acc_tab_title' ] ?></span>
						<?php if ( $_s['enable_acc_icon'] != 'none' ) : ?><i class="stl-accordion_icon <?php echo $_s['acc_icon'] ?>"></i><?php endif;?>
					</<?php echo $_s['acc_title_tag']; ?>>
					<div class="stl-accordion_content"><?php 
						if ( $item[ 'acc_content_type' ] == 'content' ) {
							echo do_shortcode($item[ 'acc_content' ]);
						} else if( $item[ 'acc_content_type' ] == 'template' ) {
							$id = $item[ 'acc_content_templates' ];
							$stl_frontend = new Frontend;
							echo $stl_frontend->get_builder_content_for_display( $id, true );
						}
					?></div>
				</div><?php
			endforeach; ?>

		</div><?php
	}
}