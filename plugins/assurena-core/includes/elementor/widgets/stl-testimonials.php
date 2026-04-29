<?php

namespace stlAddons\Widgets;

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Templates\stlTestimonials;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;


class stl_Testimonials extends Widget_Base {
	
	public function get_name() {
		return 'stl-testimonials';
	}

	public function get_title() {
		return esc_html__('stl Testimonials', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-testimonials';
	}

	public function get_script_depends() {
		return [ 'slick' ];
	}
 
	public function get_categories() {
		return [ 'stl-extensions' ];
	}


	protected function _register_controls() {
		$theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);
		$header_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

        
		$this->start_controls_section(
			'stl_testimonials_section',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);
        
        
		$this->add_control(
			'posts_per_line',
			[
				'label' => esc_html__('Columns Amount', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('One Column', 'assurena-core'),
					'2' => esc_html__('Two Columns', 'assurena-core'),
					'3' => esc_html__('Three Columns', 'assurena-core'),
					'4' => esc_html__('Four Columns', 'assurena-core'),
					'5' => esc_html__('Five Columns', 'assurena-core'),
				],
				'default' => '1',
			]
		);
        

        
		$repeater = new Repeater();

		$repeater->add_control(
			'thumbnail',
			[
				'label' => esc_html__('Image', 'assurena-core'),
				'type' => Controls_Manager::MEDIA,
				'label_block' => true,
				'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			]
		);

		$repeater->add_control(
			'author_name',
			[
				'label' => esc_html__('Author Name', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control('link_author',
			[
				'label' => esc_html__('Link Author', 'assurena-core'),
				'type' => Controls_Manager::URL,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'author_position',
			[
				'label' => esc_html__('Author Position', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$repeater->add_control(
			'quote',
			[
				'label' => esc_html__('Quote', 'assurena-core'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true
			]
		);
        
        $repeater->add_control(
			'star_rating',
			[
				'label' => esc_html__('Star Rating', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__('One Star', 'assurena-core'),
					'2' => esc_html__('Two Star', 'assurena-core'),
					'3' => esc_html__('Three Star', 'assurena-core'),
					'4' => esc_html__('Four Star', 'assurena-core'),
					'5' => esc_html__('Five Star', 'assurena-core'),
                    '6' => esc_html__('No Rating', 'assurena-core'),
                    
				],
				'default' => '6',
			]
		);

		$this->add_control(
			'list',
			[
				'label' => esc_html__('Items', 'assurena-core'),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'author_name' => esc_html__('- John doe', 'assurena-core'),
						'author_position' => '',
						'quote' => esc_html__('“Expertly trained team members who take the extra step and go the extra mile, all to fulfil our promise, deliver innovative and dynamic solutions to our customers!.”', 'assurena-core'),
						'thumbnail' => Utils::get_placeholder_image_src()
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ author_name }}}'
			]
		);
		
		$this->add_control(
			'item_type',
			[
				'label' => esc_html__('Overall Layout', 'assurena-core'),
				'type' => 'stl-radio-image',
				'options' => [
					'inline_top' => [
						'title'=> esc_html__('Top Inline', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/testimonials_2.png',
					],                    
					'inline_bottom' => [
						'title'=> esc_html__('Bottom Inline', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/testimonials_3.png',
					],

				],
				'default' => 'inline_bottom',
			]
		);

		$this->add_control(
			'item_align',
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
				'toggle' => true, 
			]
		);
        
        
        $this->add_control(
			'hover_animation',
			[
				'label' => esc_html__('Enable Hover Animation', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
			]
		);
        
        $this->add_control(
			'quote_icon',
			[
				'label' => esc_html__('Enable Quote Icon', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'assurena-core'),
				'label_off' => esc_html__('Off', 'assurena-core'),
				'return_value' => 'yes',
			]
		);


		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  Carousel options
		/*-----------------------------------------------------------------------------------*/ 

		stl_Carousel_Settings::options($this);


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> IMAGE
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'section_style_testimonials_image',
			[
				'label' => esc_html__('Image', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__('Image Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [ 'min' => 20, 'max' => 1000 ],
				],
				'default' => [ 'size' => 90, 'unit' => 'px' ],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'testimonials_image_shadow',
				'selector' =>  '{{WRAPPER}} .stl-testimonials_image img',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .stl-testimonials .stl-testimonials_image img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 90,
					'left' => 90,
					'right' => 90,
					'bottom' => 90,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> QUOTE
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'quote_style_section',
			[
				'label' => esc_html__('Quote', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'quote_tag',
			[
				'label' => esc_html__('Quote tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'quote_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'quote_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 77,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'quote_color' );

		$this->start_controls_tab(
			'custom_quote_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_quote_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($header_font_color),
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'custom_quote_color_bg',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_quote_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_hover_quote_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr($header_font_color),
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'custom_hover_quote_color_bg',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_quote:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_quote',
				'selector' => '{{WRAPPER}} .stl-testimonials .stl-testimonials_quote',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> NAME
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'author_name_style_section',
			[
				'label' => esc_html__('Name', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_tag',
			[
				'label' => esc_html__('HTML tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'name_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'name_color' );

		$this->start_controls_tab(
			'custom_name_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_name_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_name_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_hover_name_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials_item .stl-testimonials_name:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_name',
				'selector' => '{{WRAPPER}} .stl-testimonials .stl-testimonials_name',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> POSITION
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'author_position_style_section',
			[
				'label' => esc_html__('Position', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'position_tag',
			[
				'label' => esc_html__('HTML tag', 'assurena-core'),
				'type' => Controls_Manager::SELECT,
				'default' => 'span',
				'options' => [
					'div' => 'div',
					'span'  => 'span',
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
			]
		);

		$this->add_responsive_control(
			'position_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 10,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'position_color' );

		$this->start_controls_tab(
			'custom_position_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'custom_position_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#8d8d8d',
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_position' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_position_color_hover',
			[
				'label' => esc_html__('Hover' , 'assurena-core'),
			]
		);

		$this->add_control(
			'custom_hover_position_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '#8d8d8d',
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials .stl-testimonials_position:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_position',
				'selector' => '{{WRAPPER}} .stl-testimonials .stl-testimonials_position',
			]
		);

		$this->end_controls_section();


		/*-----------------------------------------------------------------------------------*/
		/*  STYLE -> CONTENT BOX
		/*-----------------------------------------------------------------------------------*/ 

		$this->start_controls_section(
			'secondary_style_section',
			[
				'label' => esc_html__('Content Box', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_item',
				'label' => esc_html__('Background', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .stl-testimonials_item',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'testimonials_shadow',
				'selector' =>  '{{WRAPPER}} .stl-testimonials_item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'testimonials_border',
				'label' => esc_html__('Border', 'assurena-core'),
				'selector' => '{{WRAPPER}} .stl-testimonials_item',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__('Content Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonials_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();   
        
        /*-----------------------------------------------------------------------------------*/
		/*  STYLE -> Star Rating
		/*-----------------------------------------------------------------------------------*/ 
        
        $this->start_controls_section(
			'rating_style_section',
			[
				'label' => esc_html__('Star Rating', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_control(
			'rating_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-testimonial_rating:before' => 'color: {{VALUE}};',
				],
			]
		);
        
        $this->add_responsive_control(
            'rating_size',
            [
                'label' => esc_html__('Size', 'assurena-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-testimonial_rating:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
			'rating_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonial_rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
        /*-----------------------------------------------------------------------------------*/
		/*  STYLE -> Quote Icon
		/*-----------------------------------------------------------------------------------*/ 
        
        $this->start_controls_section(
			'icon_style_section',
			[
				'label' => esc_html__('Quote Icon', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['quote_icon' => 'yes' ],
			]
		);
        
        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-testimonial-icon_wrapper.elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'assurena-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 16,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-testimonial-icon_wrapper.elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'left' => 0,
					'right' => 0,
					'bottom' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-testimonial-icon_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);        
        $this->end_controls_section();
	}

	protected function render() {
		$atts = $this->get_settings_for_display();
		
		$testimonials = new stlTestimonials();
		echo $testimonials->render($this, $atts);
	}
	
}