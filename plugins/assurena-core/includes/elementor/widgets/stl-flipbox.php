<?php
namespace stlAddons\Widgets;

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Includes\stl_Elementor_Helper;
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


defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class stl_Flipbox extends Widget_Base {
    
    public function get_name() {
        return 'stl-flipbox';
    }

    public function get_title() {
        return esc_html__('stl Flipbox', 'assurena-core');
    }

    public function get_icon() {
        return 'stl-flipbox';
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
            'section_flipbox_settings',
            [ 'label' => esc_html__('General', 'assurena-core') ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label' => esc_html__('Border Type', 'Border Control', 'assurena-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'flip_right' => esc_html__('Flip to Right', 'assurena-core'),
                    'flip_left' => esc_html__('Flip to Left', 'assurena-core'),
                    'flip_top' => esc_html__('Flip to Top', 'assurena-core'),
                    'flip_bottom' => esc_html__('Flip to Bottom', 'assurena-core'),
                ],
                'default' => 'flip_right',
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_height',
            [
                'label' => esc_html__('Custom Flipbox Height)', 'assurena-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 150,
                'step' => 10,
                'default' => 320,
                'description' => esc_html__('Enter value in pixels', 'assurena-core'),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_flipbox_icon',
            [ 'label' => esc_html__('Icon', 'assurena-core') ]
        );

        $this->start_controls_tabs( 'flipbox_icon' );

        $this->start_controls_tab(
            'flipbox_front_icon',
            [ 'label' => esc_html__('Front', 'assurena-core') ]
        );

        stl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'assurena-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'front_'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_icon',
            [
                'label' => esc_html__('Back', 'assurena-core'),
            ]
        );

        stl_Icons::init(
            $this,
            [
                'label' => esc_html__('Flipbox ', 'assurena-core'),
                'output' => '',
                'section' => false,
                'prefix' => 'back_'
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        //*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'stl_ib_content',
            [ 'label' => esc_html__('Content', 'assurena-core') ]
        );

        $this->start_controls_tabs( 'flipbox_content' );

        $this->start_controls_tab(
            'flipbox_front_content',
            [ 'label' => esc_html__('Front', 'assurena-core') ]
        );

        $this->add_control(
            'front_title',
            [
                'label' => esc_html__('Title', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'assurena-core'),
            ]
        );

        $this->add_control(
            'front_content',
            [
                'label' => esc_html__('Flipbox Text', 'assurena-core'),
                'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__('Description Text', 'assurena-core'),
				'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'assurena-core'),
            ]
        );
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_content',
            [
                'label' => esc_html__('Back', 'assurena-core'),
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label' => esc_html__('Title', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('This is the heading​', 'assurena-core'),
            ]
        );

        $this->add_control(
            'back_content',
            [
                'label' => esc_html__('Flipbox Text', 'assurena-core'),
                'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__('Description Text', 'assurena-core'),
                'label_block' => true,
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'assurena-core'),                
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /*End General Settings Section*/
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [ 'label' => esc_html__('Flipbox Link', 'assurena-core') ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_read_more!' => 'yes' ],  
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',

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
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
                'condition' => [
                    'add_item_link!' => 'yes',
                ], 
            ]
        ); 

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'default' =>  esc_html__('Read More', 'assurena-core'),
				'label_block' => true,
                'condition' => [ 
                    'add_read_more' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'assurena-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'condition' => [ 
                    'add_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section(); 


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('General', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'flipbox_style' );

        $this->start_controls_tab(
            'flipbox_front_style',
            [
                'label' => esc_html__('Front', 'assurena-core'),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'front_background',
				'label' => esc_html__('Front Background', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .stl-flipbox_front',
			]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'flipbox_back_style',
            [
                'label' => esc_html__('Back', 'assurena-core'),
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'back_background',
				'label' => esc_html__('Back Background', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .stl-flipbox_back',
			]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'flipbox_padding',
            [
                'label' => esc_html__('Padding', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'separator' => 'before',
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front, {{WRAPPER}} .stl-flipbox_back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'flipbox_margin',
            [
                'label' => esc_html__('Margin', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front, {{WRAPPER}} .stl-flipbox_back' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'flipbox_border_radius',
            [
                'label' => esc_html__('Border Radius', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front, {{WRAPPER}} .stl-flipbox_back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'flipbox_border',
				'selector' => '{{WRAPPER}} .stl-flipbox_front, {{WRAPPER}} .stl-flipbox_back',
				'separator' => 'before',
			]
        );
        
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'flipbox_shadow',
				'selector' => '{{WRAPPER}} .stl-flipbox_front, {{WRAPPER}} .stl-flipbox_back',
			]
		);

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> MEDIA
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'media_styles' );

        $this->start_controls_tab(
            'front_media_style',
            [ 'label' => esc_html__('Front', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'front_media_margin',
            [
                'label' => esc_html__('Margin', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'front_icon_color',
            [
                'label' => esc_html__('Icon Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'front_icon_type' => 'font',
                ]
            ]
        );

        $this->add_responsive_control(
            'front_icon_size',
            [
                'label' => esc_html__('Icon Size', 'assurena-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'front_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_media_style',
            [ 'label' => esc_html__('Back', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'back_media_margin',
            [
                'label' => esc_html__('Margin', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'back_icon_color',
            [
                'label' => esc_html__('Icon Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => [ 'back_icon_type' => 'font' ],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'back_icon_size',
            [
                'label' => esc_html__('Icon Size', 'assurena-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'back_icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 55, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
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
                'description' => esc_html__('Choose your tag for flipbox title', 'assurena-core'),
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                ],
            ]
        );

        $this->start_controls_tabs( 'title_styles' );

        $this->start_controls_tab(
            'front_title_style',
            [ 'label' => esc_html__('Front', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'front_title_offset',
            [
                'label' => esc_html__('Title Offset', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 8,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_title',
                'selector' => '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_title',
            ]
        );

        $this->add_control(
            'front_title_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_title_style',
            [ 'label' => esc_html__('Back', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'back_title_offset',
            [
                'label' => esc_html__('Title Offset', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 10,
                    'right' => 0,
                    'bottom' => 8,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_title',
                'selector' => '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_title',
            ]
        );

        $this->add_control(
            'back_title_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_title' => 'color: {{VALUE}};',
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
            ]
        );

        $this->start_controls_tabs( 'content_styles' );

        $this->start_controls_tab(
            'front_content_style',
            [ 'label' => esc_html__('Front', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'front_content_offset',
            [
                'label' => esc_html__('Content Offset', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_front_fonts_content',
                'selector' => '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_content',
            ]
        );

        $this->add_control(
            'front_content_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_front .stl-flipbox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'back_content_style',
            [ 'label' => esc_html__('Back', 'assurena-core') ]
        );

        $this->add_responsive_control(
            'back_content_offset',
            [
                'label' => esc_html__('Content Offset', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_back_fonts_content',
                'selector' => '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_content',
            ]
        );

        $this->add_control(
            'back_content_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_back .stl-flipbox_content' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .stl-flipbox_readmore',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 20,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_border',
            [
                'label' => esc_html__('Border Radius', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'assurena-core'),
                'selector' => '{{WRAPPER}} .stl-flipbox_readmore',
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .stl-flipbox_readmore.stl-button.elementor-button',
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
                'default' => $secondary_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore:hover' => 'background: {{VALUE}};'
                ],
            ]
        ); 

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .stl-flipbox_readmore:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'assurena-core'),
                'selector' => '{{WRAPPER}} .stl-flipbox_readmore:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .stl-flipbox_readmore:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        // HTML tags allowed for rendering
        $allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
            ],
            'br' => [],
            'em' => [],
            'strong' => [],
            'span' => [
                'class' => true,
                'style' => true,
            ],
            'p' => [
                'class' => true,
                'style' => true,
            ]
        ];

        $this->add_render_attribute(
            'flipbox',
            [
    			'class' => [
                    'stl-flipbox',
                    'type_'.$settings[ 'flip_direction' ],
                ],
            ]
        );

        $this->add_render_attribute(
            'flipbox_link',
            [
                'class' => [
                    'stl-flipbox_readmore',
                    'stl-button',
                    'elementor-button',
                    'elementor-size-xl',
                ],
                'href' => esc_url($settings[ 'link' ][ 'url' ] ),
                'target' => $settings[ 'link' ][ 'is_external' ] ? '_blank' : '_self',
                'rel' => $settings[ 'link' ][ 'nofollow' ] ? 'nofollow' : '',
            ]
        );

        $this->add_render_attribute(
            'item_link',
            [
                'class' => [ 'stl-flipbox_item-link' ],
                'href' => esc_url($settings[ 'item_link' ][ 'url' ] ),
                'target' => $settings[ 'item_link' ][ 'is_external' ] ? '_blank' : '_self',
                'rel' => $settings[ 'item_link' ][ 'nofollow' ] ? 'nofollow' : '',
            ]
        );

        // Icon/Image output
        ob_start();
        if (! empty($settings[ 'front_icon_type' ])) {
            $icons = new stl_Icons;
            echo $icons->build($this, $settings, 'front_' );
        }
        $front_media = ob_get_clean();
        // Icon/Image output
        ob_start();
        if (! empty($settings[ 'back_icon_type' ])) {
            $icons = new stl_Icons;
            echo $icons->build($this, $settings, 'back_' );
        }
        $back_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string( 'flipbox' ); ?>>
            <div class="stl-flipbox_wrap">
                <div class="stl-flipbox_front"><?php
                    if ($settings[ 'front_icon_type' ] != '') {?>
                    <div class="stl-flipbox_media-wrap"><?php 
                        if (! empty($front_media)) {
                            echo $front_media;
                        }?>
                    </div><?php
                    }
                    if (! empty($settings[ 'front_title' ])) {?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="stl-flipbox_title"><?php echo wp_kses( $settings[ 'front_title' ], $allowed_html );?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }
                    if (! empty($settings[ 'front_content' ])) {?>
                        <div class="stl-flipbox_content"><?php echo wp_kses( $settings[ 'front_content' ], $allowed_html );?></div><?php
                    }?>
                </div>
                <div class="stl-flipbox_back"><?php
                    if ($settings[ 'back_icon_type' ] != '') {?>
                    <div class="stl-flipbox_media-wrap"><?php 
                        if (! empty($back_media)) {
                            echo $back_media;
                        }?>
                    </div><?php
                    }
                    if (! empty($settings[ 'back_title' ])) {?>
                        <<?php echo $settings[ 'title_tag' ]; ?> class="stl-flipbox_title"><?php echo wp_kses( $settings[ 'back_title' ], $allowed_html );?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    }
                    if (! empty($settings[ 'back_content' ])) {?>
                        <div class="stl-flipbox_content"><?php echo wp_kses( $settings[ 'back_content' ], $allowed_html );?></div><?php
                    }
                    if ((bool)$settings[ 'add_read_more' ]) {?>
                        <div class="stl-flipbox_button-wrap"><a <?php echo $this->get_render_attribute_string( 'flipbox_link' ); ?>><?php echo esc_html($settings[ 'read_more_text' ]);?></a></div><?php
                    }?>
                </div>
            </div><?php
            if ((bool)$settings[ 'add_item_link' ]) {?>
                <a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>></a><?php
            }?>
        </div>

        <?php     
    }
    
}