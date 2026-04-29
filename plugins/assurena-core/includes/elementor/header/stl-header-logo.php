<?php

namespace stlAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

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



class stl_Header_Logo extends Widget_Base {
    
    public function get_name() {
        return 'stl-header-logo';
    }

    public function get_title() {
        return esc_html__('stl Logo', 'assurena-core' );
    }

    public function get_icon() {
        return 'stl-header-logo';
    }

    public function get_categories() {
        return [ 'stl-header-modules' ];
    }

    protected function _register_controls() {
        $primary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
        $third_color = esc_attr(\assurena_Theme_Helper::get_option('theme-third-color'));
        $h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_logo_settings',
            [
                'label' => esc_html__( 'Logo Settings', 'assurena-core' ),
            ]
        );

        $this->add_control(
            'use_custom_logo',
            array(
                'label' => esc_html__('Use Custom Logo?','assurena-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'assurena-core' ),
                'label_off' => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control(
            'custom_logo',
            array(
                'label' => esc_html__( 'Custom Logo', 'assurena-core' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [ 'use_custom_logo'  => 'yes' ],
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            )
        ); 

        $this->add_control(
            'enable_logo_height',
            array(
                'label' => esc_html__('Enable Logo Height?','assurena-core' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'use_custom_logo'  => 'yes' ],
            )
        );

        $this->add_control('logo_height',
            array(
                'label' => esc_html__('Logo Height', 'assurena-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'use_custom_logo' => 'yes',
                    'enable_logo_height'  => 'yes',
                ],
                'min' => 1,
                'default' => '',
            )
        ); 

        $this->add_control(
            'logo_align',
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
                    '{{WRAPPER}} .stl-logotype-container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();              

    }

    public function render() {
        
        $settings = $this->get_settings_for_display();
        extract($settings);
        
        $custom_size = $logo = false;


        if (! empty($use_custom_logo)) {
            $logo = $custom_logo;

            if (! empty($enable_logo_height)) {
                if (! empty($logo_height)) {
                    $custom_size = $logo_height;
                }
            }
        }

        $menu = false;

        require_once ( get_theme_file_path( '/templates/header/components/logo.php' ) );

        new \assurena_get_logo( 'bottom', false, $logo, $custom_size );   
    }
    
}