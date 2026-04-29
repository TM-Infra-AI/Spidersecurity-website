<?php
namespace stlAddons\Widgets;

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Loop_Settings;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Templates\stlCountDown;
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

defined( 'ABSPATH' ) || exit; // Abort, if called directly.

class stl_CountDown extends Widget_Base {
    
    public function get_name() {
        return 'stl-countdown';
    }

    public function get_title() {
        return esc_html__('stl Countdown Timer', 'assurena-core');
    }

    public function get_icon() {
        return 'stl-countdown';
    }

    public function get_categories() {
        return [ 'stl-extensions' ];
    }

    public function get_script_depends() {
        return [
            'coundown',
            'stl-elementor-extensions-widgets',
        ];
    }

    
    
    protected function _register_controls() {
        $theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
        $header_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);

        /* Start General Settings Section */
        $this->start_controls_section('stl_countdown_section',
            array(
                'label' => esc_html__('Countdown Timer Settings', 'assurena-core'),
            )
        );

        $this->add_control(
            'countdown_year',
            array(
                'label' => esc_html__('Year', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your title', 'assurena-core'),
                'default' => esc_html__('2021', 'assurena-core'),
                'label_block' => true,
                'description' => esc_html__('Example: 2021', 'assurena-core'),
            )
        ); 

        $this->add_control('countdown_month',
            array(
                'label' => esc_html__('Month', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('12', 'assurena-core'),
                'default' => esc_html__('12', 'assurena-core'),
                'label_block' => true,
                'description' => esc_html__('Example: 12', 'assurena-core'),
            )
        ); 

        $this->add_control('countdown_day',
            array(
                'label' => esc_html__('Day', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('31', 'assurena-core'),
                'default' => esc_html__('31', 'assurena-core'),
                'label_block' => true,
                'description' => esc_html__('Example: 31', 'assurena-core'),
            )
        ); 

        $this->add_control('countdown_hours',
            array(
                'label' => esc_html__('Hours', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('24', 'assurena-core'),
                'default' => esc_html__('24', 'assurena-core'),
                'label_block' => true,
                'description' => esc_html__('Example: 24', 'assurena-core'),
            )
        );

        $this->add_control('countdown_min',
            array(
                'label' => esc_html__('Minutes', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('59', 'assurena-core'),
				'default' => esc_html__('59', 'assurena-core'),
                'label_block' => true,
				'description' => esc_html__('Example: 59', 'assurena-core'),
            )
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Button Section 
        /*-----------------------------------------------------------------------------------*/  

        $this->start_controls_section('stl_countdown_content_section',
            array(
                'label' => esc_html__('Countdown Timer Content', 'assurena-core'),
            )
        );

        $this->add_control('hide_day',
            array(
                'label' => esc_html__('Hide Days?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
            )
        );

        $this->add_control('hide_hours',
            array(
                'label' => esc_html__('Hide Hours?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control('hide_minutes',
            array(
                'label' => esc_html__('Hide Minutes?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control('hide_seconds',
            array(
                'label' => esc_html__('Hide Seconds?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
            )
        );

        $this->add_control('show_value_names',
            array(
                'label' => esc_html__('Show Value Names?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control('show_separating',
            array(
                'label' => esc_html__('Show Separating?', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        /*End General Settings Section*/
        $this->end_controls_section(); 

        $this->start_controls_section(
            'countdown_style_section',
            array(
                'label' => esc_html__('Style', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('size',
            array(
                'label' => esc_html__('Countdown Size', 'assurena-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'large' => esc_html__('Large', 'assurena-core'),
                    'medium' => esc_html__('Medium', 'assurena-core'),
                    'small' => esc_html__('Small', 'assurena-core'),
                    'custom' => esc_html__('Custom', 'assurena-core'),
                ],
                'default' => 'medium'
            )
        ); 


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'label' => esc_html__('Number Typography', 'assurena-core'),
                'name' => 'custom_fonts_number',
                'selector' => '{{WRAPPER}} .stl-countdown .countdown-section .countdown-amount',
                'condition' => [
                    'size' => 'custom'
                ]
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'label' => esc_html__('Text Typography', 'assurena-core'),
                'name' => 'custom_fonts_text',
                'selector' => '{{WRAPPER}} .stl-countdown .countdown-section .countdown-period',
                'condition' => [
                    'size' => 'custom'
                ]
            )
        );

        $this->add_control(
            'number_text_color',
            array(
                'label' => esc_html__('Number Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .stl-countdown .countdown-section .countdown-amount' => 'color: {{VALUE}};',
                ],
            )
        );
          
        $this->add_control(
            'number_text_bg_color',
            array(
                'label' => esc_html__('Number Background Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1f242c',
                'selectors' => [
                    '{{WRAPPER}} .stl-countdown .countdown-section .countdown-amount span' => 'background-color: {{VALUE}};',
                ],
            )
        );

        $this->add_control(
            'period_text_color',
            array(
                'label' => esc_html__('Text Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1f242c',
                'selectors' => [
                    '{{WRAPPER}} .stl-countdown .countdown-section .countdown-period' => 'color: {{VALUE}};',
                ],
            )
        );

        $this->add_control(
            'separating_color',
            array(
                'label' => esc_html__('Separating Points Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1f242c',
                'selectors' => [
                    '{{WRAPPER}} .stl-countdown .countdown-section:not(:last-child) .countdown-amount:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .stl-countdown .countdown-section:not(:last-child) .countdown-amount:after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_separating' => 'yes'
                ]
            )
        );

        /*End Style Section*/
        $this->end_controls_section(); 
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        
       	$countdown = new stlCountDown();
        echo $countdown->render($this, $atts);

    }
    
}