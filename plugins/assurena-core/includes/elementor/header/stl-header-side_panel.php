<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, If called directly.

use stlAddons\Includes\stl_Icons;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;


class stl_Header_Side_panel extends Widget_Base
{
	public function get_name() {
		return 'stl-header-side_panel';
	}

	public function get_title() {
		return esc_html__('stl Side Panel Button', 'assurena-core' );
	}

	public function get_icon() {
		return 'stl-header-side_panel';
	}

	public function get_categories() {
		return [ 'stl-header-modules' ];
	}

	public function get_script_depends() {
		return [ 'stl-elementor-extensions-widgets' ];
	}

	protected function _register_controls()
	{
		$primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


		$this->start_controls_section(
			'section_side_panel_settings',
			[
				'label' => esc_html__( 'Side Panel', 'assurena-core' ),
			]
		);

		$this->add_responsive_control(
			'sp_width',
			[
				'label' => esc_html__( 'Item Width', 'assurena-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [ 'min' => 30, 'max' => 200 ],
					'%' => [ 'min' => 5, 'max' => 100 ],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sp_height',
			[
				'label' => esc_html__( 'Item Height', 'assurena-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [ 'min' => 30, 'max' => 250 ],
					'%' => [ 'min' => 5, 'max' => 100 ],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'assurena-core' ),
				'type' => Controls_Manager::CHOOSE,
				'condition' => [ 'sp_width!' => 0 ],
				'options' => [
					'margin-right' => [
						'title' => esc_html__( 'Left', 'assurena-core' ),
						'icon' => 'fa fa-align-left',
					],
					'margin' => [
						'title' => esc_html__( 'Center', 'assurena-core' ),
						'icon' => 'fa fa-align-center',
					],
					'margin-left' => [
						'title' => esc_html__( 'Right', 'assurena-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}}' => '{{VALUE}}: auto;',
				],

			]
		);

		$this->start_controls_tabs(
			'sp_color_tabs',
			[
				'separator' => 'before',
			]
		);

		$this->start_controls_tab(
			'tab_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'icon_color_idle',
			[
				'label' => esc_html__( 'Icon Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .side_panel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_bg_idle',
			[ 
				'label' => esc_html__( 'Item Background', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .side_panel' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Icon Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}:hover .side_panel' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'item_bg_hover',
			[ 
				'label' => esc_html__( 'Item Background', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .side_panel' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}


	public function render()
	{
		echo '<div class="side_panel">',
			'<div class="side_panel_inner">',
				'<a href="#" class="side_panel-toggle">',
					'<span class="side_panel-toggle-inner">',
						'<span></span>',
						'<span></span>',
						'<span></span>',
					'</span>',
				'</a>',
			'</div>',
		'</div>';
	}
}