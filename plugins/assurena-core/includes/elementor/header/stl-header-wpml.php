<?php
namespace stlAddons\Widgets;

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Includes\stl_Elementor_Helper;
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;


defined('ABSPATH') || exit; // Abort, If called directly.

class stl_Header_Wpml extends Widget_Base {
    
    public function get_name() {
        return 'stl-header-wpml';
    }

    public function get_title() {
        return esc_html__('WPML Selector', 'assurena-core' );
    }

    public function get_icon() {
        return 'stl-header-wpml';
    }

    public function get_categories() {
        return [ 'stl-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'perfect-scrollbar',
            'stl-elementor-extensions-widgets',
        ];
    }

    protected function _register_controls() {
        $primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']); 

        $this->start_controls_section(
            'section_navigation_settings',
            [
                'label' => esc_html__( 'WPML Settings', 'assurena-core' ),
            ]
        );

        $this->add_control(
            'wpml_height',
            array(
                'label' => esc_html__( 'WPML Height', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'assurena-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'wpml_align',
            array(
                'label' => esc_html__( 'Alignment', 'assurena-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'assurena-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'assurena-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'assurena-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();              
    }

    public function render(){
        if (class_exists('\SitePress')) {
            echo "<div class='sitepress_container'>";
                do_action('wpml_add_language_selector');
            echo "</div>";
        }
    }   
}