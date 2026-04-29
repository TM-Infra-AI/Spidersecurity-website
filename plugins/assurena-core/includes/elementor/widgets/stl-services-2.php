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

class stl_Services_2 extends Widget_Base {
    
    public function get_name() {
        return 'stl-services-2';
    }

    public function get_title() {
        return esc_html__('stl Services 2', 'assurena-core');
    }

    public function get_icon() {
        return 'stl-services-2';
    }

    public function get_categories() {
        return [ 'stl-extensions' ];
    }
    
    
    protected function _register_controls() {
        $theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
        $second_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
        $header_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

       

        stl_Icons::init(
            $this,
            [
                'label' => esc_html__('Services 2 ', 'assurena-core'),
                'output' => '','section' => true,
                'prefix' => ''
            ]
        );
        
        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'stl_ib_content',
            [ 'label' => esc_html__('Service Content', 'assurena-core') ]
        );

        $this->add_control(
            'services_title',
            [
                'label' => esc_html__('Title', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'assurena-core'),

            ]
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__('Service Link', 'assurena-core'),
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add Button', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
            ]
        ); 
        
        $this->add_control(
            'add_whole_link',
            [
                'label' => esc_html__('Add Link on whole Item', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
                'condition' => [ 'add_read_more' => 'yes' ],
            ]
        ); 

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'assurena-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'condition' => [ 'add_read_more' => 'yes' ],
            ]
        );

        $this->end_controls_section(); 

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 
            'icon_colors',
            [ 'condition' => [ 'icon_type'  => 'font' ] ]
        );

        $this->start_controls_tab(
            'icon_colors_idle',
            [ 'label' => esc_html__('Idle', 'assurena-core') ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-services-2-icon_container .stl-icon' => 'color: {{VALUE}};',
                ],
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
                    '{{WRAPPER}}:hover .stl-services-2-icon_container .stl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


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
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-services-2-icon_container .stl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'font',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'assurena-core') . ' (%)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_type' => 'image',
                ]
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
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
                'description' => esc_html__('Choose your tag for service title', 'assurena-core'),
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹DIV›',
                    'span' => '‹SPAN›',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .stl-services_title',
            ]
        );


        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color_idle',
            [
                'label' => esc_html__('Idle' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border Bottom Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .stl-services-2-title_wrapper' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            [
                'label' => esc_html__('Hover' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-services_title' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .stl-services_title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'hover_border_color',
            [
                'label' => esc_html__('Border Bottom Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-services-2-title_wrapper' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        
        
        
        
        
        

        $this->end_controls_section();

 
        
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 
                    'add_read_more!' => '',
                ],
            ]
        );

       
        $this->start_controls_tabs( 'button_color_tab' );

        $this->start_controls_tab(
            'custom_button_color_idle',
            [
                'label' => esc_html__('Idle' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => [
                    '{{WRAPPER}} .stl-services_readmore .stl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            [
                'label' => esc_html__('Hover' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-services_readmore .stl-icon' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 
        
        $this->start_controls_section(
            'service_2_style_section',
            [
                'label' => esc_html__('Item', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'service_2_border_radius',
            [
                'label' => esc_html__('Border Radius', 'assurena-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .stl-services_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_2_color_tab' );

        $this->start_controls_tab(
            'custom_service_2_color_idle',
            [
                'label' => esc_html__('Idle' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color',
            [
                'label' => esc_html__('Background Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .stl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border',
                'label' => esc_html__('Border Type', 'assurena-core'),
                'selector' => '{{WRAPPER}} .stl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow',
                'selector' =>  '{{WRAPPER}} .stl-services_wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_2_color_hover',
            [
                'label' => esc_html__('Hover' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color_hover',
            [
                'label' => esc_html__('Background Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border_hover',
                'label' => esc_html__('Border Type', 'assurena-core'),
                'selector' => '{{WRAPPER}}:hover .stl-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow_hover',
                'selector' =>  '{{WRAPPER}}:hover .stl-services_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'services', [
			'class' => [
                'stl-services-2',
            ],
        ] );


        $this->add_render_attribute( 'serv_link', [
            'class' => [ 'stl-services_readmore' ],
            'href' => esc_url($settings[ 'link' ][ 'url' ] ),
            'target' => $settings[ 'link' ][ 'is_external' ] ? '_blank' : '_self',
            'rel' => $settings[ 'link' ][ 'nofollow' ] ? 'nofollow' : '',
        ] );
        
        $this->add_render_attribute( 'whole_link', [
            'class' => [ 'stl-services_whole_link' ],
            'href' => esc_url($settings[ 'link' ][ 'url' ] ),
            'target' => $settings[ 'link' ][ 'is_external' ] ? '_blank' : '_self',
            'rel' => $settings[ 'link' ][ 'nofollow' ] ? 'nofollow' : '',
        ] );

        // Icon/Image output
        ob_start();
        if (!empty($settings[ 'icon_type' ])) {
            $icons = new stl_Icons;
            echo $icons->build($this, $settings, []);
        }
        $services_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string( 'services' ); ?>>
                <div class="stl-services_wrap">
                    
                    <div class="stl-services-2-title_wrapper">
                        <<?php echo $settings[ 'title_tag' ]; ?> class="stl-services_title"><?php echo $settings[ 'services_title' ];?></<?php echo $settings[ 'title_tag' ]; ?>>
                    </div>
                    
                    <div class="stl-services-2-bottom">
                        
                        <?php
                            if ($settings[ 'icon_type' ] != '') {?>
                            <div class="stl-services-2-icon_container">
                                <?php 
                                if (!empty($services_media)) {
                                    echo $services_media;
                                }?>
                            </div>
                        <?php } ?>
                        
                        <?php    
                        if ((bool)$settings[ 'add_read_more' ]) {?>
                            <div class="stl-services-2-button_wrapper">
                                <a <?php echo $this->get_render_attribute_string( 'serv_link' ); ?>>
                                    <span class="stl-icon elementor-icon"><i class="icon flaticon-arrow"></i></span>
                               </a>
                            </div>
                        <?php }?>

                    </div>
                    <?php    
                    if ((bool)$settings[ 'add_whole_link' ]) {?>
                        <a <?php echo $this->get_render_attribute_string( 'whole_link' ); ?>></a>
                    <?php } ?>
                </div>
        </div>

        <?php     
    }
    
}