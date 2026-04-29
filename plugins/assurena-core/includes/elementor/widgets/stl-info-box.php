<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Templates\stlInfoBoxes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;


class stl_Info_Box extends Widget_Base
{

	public function get_name() {
		return 'stl-info-box';
	}

	public function get_title() {
		return esc_html__('stl Info Box', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-info-box';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}


	protected function _register_controls()
	{
		$primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);
		$h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> ICON/IMAGE
		/*-----------------------------------------------------------------------------------*/

		$output = [];
		$output[ 'view' ] = [
			'label' => esc_html__('View', 'assurena-core'),
			'type' => Controls_Manager::SELECT,
			'condition' => [ 'icon_type'  => 'font' ],
			'options' => [
				'default' => esc_html__('Default', 'assurena-core'),
				'stacked' => esc_html__('Stacked', 'assurena-core'),
				'framed' => esc_html__('Framed', 'assurena-core'),
			],
			'default' => 'default',
			'prefix_class' => 'elementor-view-',
		];

		$output[ 'shape' ] = [
			'label' => esc_html__('Shape', 'assurena-core'),
			'type' => Controls_Manager::SELECT,
			'options' => [
				'circle' => esc_html__('Circle', 'assurena-core'),
				'square' => esc_html__('Square', 'assurena-core'),
			],
			'default' => 'circle',
			'condition' => [
				'icon_type'  => 'font',
				'view!' => 'default',
			],
			'prefix_class' => 'elementor-shape-',
		];

		$output[ 'link_t' ] = [
			'label' => esc_html__('Link', 'assurena-core'),
			'type' => Controls_Manager::URL,
			'placeholder' => esc_html__('https://your-link.com', 'assurena-core'),
			'separator' => 'before',
			'condition' => [ 'icon_type!' => '' ],
		];

		$output[ 'position' ] = [
			'label' => esc_html__('Position', 'assurena-core'),
			'type' => 'stl-radio-image',
			'condition' => [ 'icon_type!' => '' ],     
			'options' => [
				'top' => [
					'title'=> esc_html__('Top', 'assurena-core'),
					'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_def.png',
				],
				'left' => [
					'title'=> esc_html__('Left', 'assurena-core'),
					'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_left.png',
				],                    
				'right' => [
					'title'=> esc_html__('Right', 'assurena-core'),
					'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_right.png',
				],                                   
			],
			'prefix_class' => 'elementor-position-',
			'default' => 'top',     
		];

		stl_Icons::init(
			$this,
			[
				'output' => $output,
				'section' => true,
			]
		);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> CONTENT
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'stl_ib_content',
			[ 'label' => esc_html__('Content', 'assurena-core') ]
		);

		$this->add_control(
			'ib_title',
			[
				'label' => esc_html__('Title', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('This is the heading​', 'assurena-core'),
			]
		);

		$this->add_control(
			'ib_content',
			[
				'label' => esc_html__('Content', 'assurena-core'),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__('Description Text', 'assurena-core'),
				'label_block' => true,
				'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'assurena-core'),
			]
		);

		$this->add_control(
			'alignment',
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
				],
				'default' => 'left',
				'prefix_class' => 'a',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__('Enable hover animation', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
				'description' => esc_html__('Lift up the item on hover.', 'assurena-core'),
				'prefix_class' => 'stl-hover_shift-',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> BUTTON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_link',
			[ 'label' => esc_html__('Link', 'assurena-core') ]
		);

		$this->add_control(
			'add_item_link',
			[
				'label' => esc_html__('Add Link On Whole Item', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
				'condition' => [ 'add_read_more!' => 'yes' ],  
			]
		);

		$this->add_control(
			'item_link',
			[
				'label' => esc_html__('Link', 'assurena-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'add_item_link' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'add_read_more',
			[
				'label' => esc_html__('Add \'Read More\' Button', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'add_item_link!' => 'yes' ], 
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
			]
		); 
        
        $this->add_control(
			'add_button_divider',
			[
				'label' => esc_html__('Add Divider before button', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_read_more' => 'yes' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
				'prefix_class' => 'divider_',
			]
		); 

		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__('Button Text', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'add_read_more' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__('Button Link', 'assurena-core'),
				'type' => Controls_Manager::URL,
				'condition' => [ 'add_read_more' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'hr_link',
			[ 'type' => Controls_Manager::DIVIDER ]
		); 

		$this->add_control(
			'read_more_icon_sticky',
			[
				'label' => esc_html__('Stick the button', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [ 'add_read_more' => 'yes' ],
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
				'description' => esc_html__('Attach to the bottom right or left corner.', 'assurena' ),
			]
		); 

		$this->add_control(
			'read_more_icon_sticky_pos',
			[
				'label' => esc_html__('Read More Position', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 
					'add_read_more' => 'yes',
					'read_more_icon_sticky' => 'yes',
				],
				'options' => [
					'right' => esc_html__('Right', 'assurena-core'),
					'left' => esc_html__('Left', 'assurena-core'),
				],
				'default' => 'right',
			]
		); 

		$this->add_control(
			'icon_read_more_pack',
			[
				'label' => esc_html__('Icon Pack', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'add_read_more' => 'yes' ],
				'options' => [
					'fontawesome' => esc_html__('Fontawesome', 'assurena-core'), 
					'flaticon' => esc_html__('Flaticon', 'assurena-core'),
				],
				'default' => 'fontawesome',
			]
		);

		$this->add_control(
			'read_more_icon_flaticon',
			[
				'label' => esc_html__('Icon', 'assurena-core'),
				'type' => 'stl-icon',
				'condition' => [ 
					'add_read_more' => 'yes',
					'icon_read_more_pack' => 'flaticon',
				],
				'label_block' => true,
				'description' => esc_html__('Select icon from Flaticon library.', 'assurena-core'),
			]
		);

		$this->add_control(
			'read_more_icon_fontawesome',
			[
				'label' => esc_html__('Icon', 'assurena-core'),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'condition' => [ 
					'add_read_more' => 'yes',
					'icon_read_more_pack' => 'fontawesome',
				],
				'description' => esc_html__('Select icon from Fontawesome library.', 'assurena-core'),
			]
		);

		$this->add_control(
			'read_more_icon_align',
			[
				'label' => esc_html__('Icon Position', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'condition' => [ 'add_read_more' => 'yes' ],
				'options' => [
					'left' => esc_html__('Before', 'assurena-core'),
					'right' => esc_html__('After', 'assurena-core'),
				],
				'default' => 'right',
			]
		);

		$this->add_control(
			'read_more_icon_spacing',
			[
				'label' => esc_html__('Icon Spacing', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'add_read_more' => 'yes' ],
				'range' => [
					'px' => [ 'min' => 0, 'max' => 100 ],
				],
				'default' => [ 'size' => 10, 'unix' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button.icon-position-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .stl-infobox_button.icon-position-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> ICON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type'  => 'font' ],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .stl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .stl-icon, {{WRAPPER}}.elementor-view-default .stl-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => esc_html__('Additional Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .stl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .stl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_shadow',
				'selector' =>  '{{WRAPPER}} .stl-icon',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked:hover .stl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed:hover .stl-icon, {{WRAPPER}}.elementor-view-default:hover .stl-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => esc_html__('Additional Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'view!' => 'default' ],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed:hover .stl-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked:hover .stl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_hover_shadow',
				'selector' =>  '{{WRAPPER}}:hover .stl-icon',
			]
		);

		$this->add_control(
			'hover_animation_icon',
			[
				'label' => esc_html__('Hover Animation', 'assurena-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		); 

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'hr_icon_style',
			[ 'type' => Controls_Manager::DIVIDER ]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 6, 'max' => 300 ],
				],
				'default' => [ 'size' => 40, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'view!' => 'default' ],
				'range' => [
					'em' => [ 'min' => 0, 'max' => 5 ],
				],
				'default' => [ 'size' => 18, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rotate',
			[
				'label' => esc_html__('Rotate', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 0, 'unit' => 'deg' ],
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__('Border Width', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view' => 'framed' ],
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [ 'view!' => 'default' ],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__('Image', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'icon_type' => 'image' ],
			]
		);

		$this->add_responsive_control(
			'image_space',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__('Width', 'assurena-core') . ' (%)',
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [ 'min' => 5, 'max' => 100 ],
				],
				'default' => [ 'size' => 100, 'unit' => '%' ],
				'tablet_default' => [ 'unit' => '%' ],
				'mobile_default' => [ 'unit' => '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_animation_image',
			[
				'label' => esc_html__('Hover Animation', 'assurena-core'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'Idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .stl-image-box_img img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__('Opacity', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0.10, 'max' => 1, 'step' => 0.01 ],
				],
				'selectors' => [
					'{{WRAPPER}} .stl-image-box_img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__('Transition Duration', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 'size' => 0.3 ],
				'range' => [
					'px' => [ 'max' => 3, 'step' => 0.1 ],
				],
				'selectors' => [
					'{{WRAPPER}} .stl-image-box_img img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[ 'label' => esc_html__('Hover', 'assurena-core') ]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover .stl-image-box_img img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => esc_html__('Opacity', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [ 'min' => 0.10, 'max' => 1, 'step' => 0.01 ],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .stl-image-box_img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> TITLE
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => esc_html__('Title', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__('Title Tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => '‹h1›',
					'h2' => '‹h2›',
					'h3' => '‹h3›',
					'h4' => '‹h4›',
					'h5' => '‹h5›',
					'h6' => '‹h6›',
					'div' => '‹div›',
					'span' => '‹span›',
				],
			]
		);

		$this->add_responsive_control(
			'title_offset',
			[
				'label' => esc_html__('Title Offset', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => '',
					'right' => '',
					'bottom' => 10,
					'left' => '',
					'unit'  => 'px',
					'isLinked'  => false,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_title',
				'selector' => '{{WRAPPER}} .stl-infobox_title',
			]
		);

		$this->start_controls_tabs( 'title_color_tab' );

		$this->start_controls_tab(
			'custom_title_color_idle',
			[ 'label' => esc_html__('Idle', 'assurena-core') ]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#232323',
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_title_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}}:hover .stl-infobox_title' => 'color: {{VALUE}};',
					'{{WRAPPER}}:hover .stl-infobox_title a' => 'color: {{VALUE}};',
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
			'content_style_section',
			[
				'label' => esc_html__('Content', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'ib_content!' => '' ],
			]
		);

		$this->add_control(
			'content_tag',
			[
				'label' => esc_html__('Content Tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => '‹h1›',
					'h2' => '‹h2›',
					'h3' => '‹h3›',
					'h4' => '‹h4›',
					'h5' => '‹h5›',
					'h6' => '‹h5›',
					'div' => '‹div›',
					'span' => '‹span›',
				],
				'default' => 'div',
			]
		);

		$this->add_responsive_control(
			'content_offset',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom'=> 15,
					'left'  => 0,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'custom_content_mask_color',
				'label' => esc_html__('Background', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [ 'custom_bg' => 'custom' ],
				'selector' => '{{WRAPPER}} .stl-infobox_content',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_content',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_3['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_3['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-infobox_content',
			]
		); 

		$this->start_controls_tabs( 'content_color_tab' );

		$this->start_controls_tab(
			'custom_content_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'content_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $main_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_content_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'content_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .stl-infobox_content' => 'color: {{VALUE}};'
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> BUTTON
		/*-----------------------------------------------------------------------------------*/    

		$this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__('Button', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'add_read_more!' => '' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_button',
				'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \stl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \stl_Addons_Elementor::$typography_1['font_weight']],
                ],
				'selector' => '{{WRAPPER}} .stl-infobox_button',
			]
		);

		$this->add_responsive_control(
			'custom_button_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'custom_button_border',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->start_controls_tabs( 'button_color_tab' );

		$this->start_controls_tab(
			'custom_button_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'button_background',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $primary_color,
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stl-infobox_button.read-more-icon:empty:after, {{WRAPPER}} .stl-infobox_button.read-more-icon:empty:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => esc_html__('Border Type', 'assurena-core'),
				'selector' => '{{WRAPPER}} .stl-infobox_button',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow',
				'selector' =>  '{{WRAPPER}} .stl-infobox_button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_button_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'button_background_hover',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button:hover' => 'background: {{VALUE}};'
				],
			]
		); 

		$this->add_control(
			'button_color_hover',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $h_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-infobox_button:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .stl-infobox_button.read-more-icon:empty:hover:after, {{WRAPPER}} .stl-infobox_button.read-more-icon:empty:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover',
				'label' => esc_html__('Border Type', 'assurena-core'),
				'default' => '',
				'selector' => '{{WRAPPER}} .stl-infobox_button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_shadow_hover',
				'selector' => '{{WRAPPER}} .stl-infobox_button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section(); 

	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$info_box = new stlInfoBoxes();
		echo $info_box->render($this, $atts);
	}
	
}
