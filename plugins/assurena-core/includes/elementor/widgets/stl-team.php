<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use stlAddons\Includes\stl_Loop_Settings;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Templates\stlTeam;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;


class stl_Team extends Widget_Base
{
	
	public function get_name() {
		return 'stl-team';
	}

	public function get_title() {
		return esc_html__('stl Team', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-team';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_general',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);

		$this->add_control(
			'posts_per_line',
			[
				'label' => esc_html__('Columns in Row', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('1', 'assurena-core'),
					'2' => esc_html__('2', 'assurena-core'),
					'3' => esc_html__('3', 'assurena-core'),
					'4' => esc_html__('4', 'assurena-core'),
					'5' => esc_html__('5', 'assurena-core'),
					'6' => esc_html__('6', 'assurena-core'),
				],
				'default' => '3',
			]
		);

		$this->add_control(
			'info_align',
			[
				'label' => esc_html__('Alignment', 'assurena-core'),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => true,
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
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'single_link_wrapper',
			[
				'label' => esc_html__('Add Link on Image', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'single_link_heading',
			[
				'label' => esc_html__('Add Link on Heading', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> APPEARANCE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_content_appearance',
			[ 'label' => esc_html__('Appearance', 'assurena-core') ]
		);

		$this->add_control(
			'hide_title',
			[
				'label' => esc_html__('Hide Title', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_meta',
			[
				'label' => esc_html__('Hide Meta', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_soc_icons',
			[
				'label' => esc_html__('Hide Social Icons', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'hide_content',
			[
				'label' => esc_html__('Hide Excerpt/Content', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'letter_count',
			[
				'label' => esc_html__('Limit the Excerpt/Content letters', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'condition' => [ 'hide_content!'  => 'yes' ],
				'min' => 1,
				'default' => '100',
			]
		);
		
		
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CAROUSEL OPTIONS
		/*-----------------------------------------------------------------------------------*/

		stl_Carousel_Settings::options($this);


		/*-----------------------------------------------------------------------------------*/
		/*  SETTINGS -> QUERY
		/*-----------------------------------------------------------------------------------*/

		stl_Loop_Settings::init(
			$this,
			[
				'post_type' => 'team',
				'hide_cats' => true,
				'hide_tags' => true
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_items',
			[
				'label' => esc_html__('General', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[
				'label' => esc_html__('Items Gap', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 20,
					'left' => 15,
					'right' => 15,
					'bottom' => 30,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl_module_team .team-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .stl_module_team .team-items_wrap' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'background_style_section',
			[
				'label' => esc_html__('Image', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 29,
					'right' => 44,
					'bottom' => 22,
					'left' => 44,
					'unit' => 'px',
				],
				'mobile_default' => [
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-item_media' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'unit'  => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .team-image, {{WRAPPER}} .team-image img, {{WRAPPER}} .team-image:before, {{WRAPPER}} .team-image:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bg_color_type',
			[
				'label' => esc_html__('Customize Overlays', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'background_color_tabs' );

		$this->start_controls_tab(
			'custom_background_color_idle',
			[
				'label' => esc_html__('Idle' , 'assurena-core'),
				'condition' => [ 'bg_color_type' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_color',
				'label' => esc_html__('Background Idle', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type' => 'yes' ],
				'selector' => '{{WRAPPER}} .team-image:before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_background_color_hover',
			[
				'label' => esc_html__('Hover' , 'assurena-core'),
				'condition' => [ 'bg_color_type' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_hover_color',
				'label' => esc_html__('Background Hover', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'bg_color_type' => 'yes' ],
				'selector' => '{{WRAPPER}} .team-image:after',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
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
				'name' => 'title_team_headings',
				'selector' => '{{WRAPPER}} .team-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 10,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_title_color',
			[
				'label' => esc_html__('Customize Colors', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->start_controls_tabs( 'title_color_tabs' );

		$this->start_controls_tab(
			'custom_title_color_idle',
			[
				'label' => esc_html__('Idle' , 'assurena-core'),
				'condition' => [ 'custom_title_color' => 'yes' ],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label' => esc_html__('Title Idle', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_title_color' => 'yes' ],
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .team-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_title_color_hover',
			[
				'label' => esc_html__('Hover' , 'assurena-core'),
				'condition' => [ 'custom_title_color' => 'yes' ],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Title Hover', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_title_color' => 'yes' ],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .team-title:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> META INFO
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => esc_html__('Meta Info', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 14,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-department' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_depart_color',
			[
				'label' => esc_html__('Customize Color', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'meta_color',
			[ 
				'label' => esc_html__('Meta Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_depart_color' => 'yes' ],
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .team-department' => 'color: {{VALUE}}',
				],
			]
		);

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

		$this->add_responsive_control(
			'content_padding',
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
					'{{WRAPPER}} .team-item_excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_content_color',
			[
				'label' => esc_html__('Customize Color', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'content_color',
			[ 
				'label' => esc_html__('Content Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_content_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-item_excerpt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();        
        

		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> SOCIALS
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'ssection_style_socials',
			[
				'label' => esc_html__('Socials', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'socials_margin',
			[
				'label' => esc_html__('Margins', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 4,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .team-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_soc_color',
			[
				'label' => esc_html__('Customize Colors', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'soc_color_tabs' );

		$this->start_controls_tab(
			'custom_soc_color_idle',
			[
				'label' => esc_html__('Idle' , 'assurena-core'),
				'condition' => [ 'custom_soc_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_color',
			[ 
				'label' => esc_html__('Icon Idle', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_color' => 'yes' ],
				'default' => '#adadad',
				'selectors' => [
					'{{WRAPPER}} .team-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_soc_color_hover',
			[
				'label' => esc_html__('Hover' , 'assurena-core'),
				'condition' => [ 'custom_soc_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_hover_color',
			[ 
				'label' => esc_html__('Icon Hover', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'custom_soc_bg_color',
			[
				'label' => esc_html__('Customize Backgrounds', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->start_controls_tabs( 'soc_background_tabs' );

		$this->start_controls_tab(
			'custom_soc_bg_idle',
			[
				'label' => esc_html__('Idle' , 'assurena-core'),
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_bg_color',
			[ 
				'label' => esc_html__('Icon Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_soc_bg_hover',
			[
				'label' => esc_html__('Hover' , 'assurena-core'),
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
			]
		);

		$this->add_control(
			'soc_bg_hover_color',
			[ 
				'label' => esc_html__('Icon Background', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'custom_soc_bg_color' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .team-icon:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$team = new stlTeam();
		echo $team->render($atts);
	}
	
}