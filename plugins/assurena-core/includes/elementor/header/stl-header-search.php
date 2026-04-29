<?php

namespace stlAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use stlAddons\Includes\stl_Icons;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;


class stl_Header_Search extends Widget_Base
{

    public function get_name() {
        return 'stl-header-search';
    }

    public function get_title() {
        return esc_html__('stl Search', 'assurena-core' );
    }

    public function get_icon() {
        return 'stl-header-search';
    }

    public function get_categories() {
        return [ 'stl-header-modules' ];
    }

    public function get_script_depends() {
        return [
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
        /*  CONTENT -> SEARCH SETTINGS
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_search_settings',
            [
                'label' => esc_html__( 'Search Settings', 'assurena-core' ),
            ]
        );

        $this->add_control(
            'search_height',
            [
                'label' => esc_html__( 'Search Height', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .header_search' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'search_align',
            [
                'label' => esc_html__( 'Alignment', 'assurena-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'assurena-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'assurena-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'assurena-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .stl-search' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'search_section',
            [
                'label' => esc_html__( 'Search Style', 'assurena-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'search_icon_color',
            [
                'label' => esc_html__( 'Icon Idle', 'assurena-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .header_search-button-wrapper' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $search_style = \assurena_Theme_Helper::get_option('search_style');
        $search_style =  !empty($search_style) ? $search_style : 'standard';

        $search_class = ' search_'.\assurena_Theme_Helper::get_option('search_style');

        $this->add_render_attribute( 'search', 'class', ['stl-search elementor-search header_search-button-wrapper'] );
        $this->add_render_attribute( 'search', 'role', 'button' );

        echo '<div class="header_search'.esc_attr($search_class).'">';

            echo '<div ', $this->get_render_attribute_string( 'search' ), '>',
                '<div class="header_search-button fa fa-search"></div>',
                '<div class="header_search-close"></div>',
                '</div>';

            echo '<div class="header_search-field">';
                if ($search_style === 'alt') {
                    echo '<div class="header_search-wrap">',
                        '<div class="header_search-close"></div>',
                        '</div>';
                }
                echo get_search_form(false);
            echo '</div>';

        echo '</div>';
    }

}