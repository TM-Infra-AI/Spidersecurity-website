<?php
namespace stlAddons\Widgets;

use stlAddons\Includes\stl_Icons;
use stlAddons\Includes\stl_Carousel_Settings;
use stlAddons\Includes\stl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
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

class stl_Services_3 extends Widget_Base {
    
    public function get_name() {
        return 'stl-services-3';
    }

    public function get_title() {
        return esc_html__('stl Services 3', 'assurena-core');
    }

    public function get_icon() {
        return 'stl-services-3';
    }

    public function get_categories() {
        return [ 'stl-extensions' ];
    }

    
    protected function _register_controls()
    {
        $theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
        $second_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section('stl_services_content',
            array(
                'label' => esc_html__('Service Content', 'assurena-core'),
            )
        );

        $this->add_control(
            'service_image',
            array(
                'label' => esc_html__('Thumbnail', 'assurena-core'),
                'type' => Controls_Manager::MEDIA,
            )
        );

        $this->add_control(
            'services_title',
            array(
                'label' => esc_html__('Title', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is heading​', 'assurena-core'),
            )
        );
        
        $this->add_control(
            'services_text',
            array(
                'label' => esc_html__('Text', 'assurena-core'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__('This is service text​', 'assurena-core'),
            )
        );

        $this->add_control(
            'alignment',
            array(
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
            )
        );
        

        
        /* Service Link */
        
        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Title', 'assurena-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'assurena-core'),
                'label_off' => esc_html__('Off', 'assurena-core'),
                'return_value' => 'yes',
                'condition' => [
                    'add_read_more!' => 'yes',
                ],  

            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'assurena-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'condition' => [ 
                    'add_item_link' => 'yes',
                ],
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
                'condition' => [ 'add_item_link!' => 'yes' ], 
            ]
        ); 

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'default' =>  esc_html__('Read More', 'assurena-core'),
				'label_block' => true,
                'condition' => [ 'add_read_more' => 'yes' ],
            ]
        );

        $this->add_control(
            'btn_link',
            [
                'label' => esc_html__('Button Link', 'assurena-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'condition' => [ 'add_read_more' => 'yes' ],
            ]
        );
        
        

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

        stl_Icons::init( $this, array( 'label' => esc_html__('Services 3 ', 'assurena-core'), 'output' => '','section' => true, 'prefix' => '' ) );

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    

        // Title Styles

        $this->start_controls_section(
            'title_style_section',
            array(
                'label' => esc_html__('Title', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .stl-services_title',
            )
        );

        $this->add_control(
            'title_tag',
            array(
                'label' => esc_html__('Title Tag', 'assurena-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'description' => esc_html__('Choose your tag for services title', 'assurena-core'),
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
            )
        );


        $this->add_control(
            'services_color',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-services_title' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section(); 
        
        
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(text Section)
        /*-----------------------------------------------------------------------------------*/    

        // Text Styles

        $this->start_controls_section(
            'text_style_section',
            array(
                'label' => esc_html__('Text', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_text',
                'selector' => '{{WRAPPER}} .stl-services_text',
            )
        );

        $this->add_control(
            'services_color_text',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-services_text' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section(); 
        
        
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Button Section)
        /*-----------------------------------------------------------------------------------*/    

        // Text Styles

        $this->start_controls_section(
            'button_style_section',
            array(
                'label' => esc_html__('Button', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .stl-services_readmore',
            )
        );

        $this->add_control(
            'services_color_button',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-services_readmore' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_control(
            'services_color_button_hover',
            array(
                'label' => esc_html__('Hover Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .stl-services-3:hover .stl-services_readmore' => 'color: {{VALUE}};'
                ),
            )
        );
       $this->add_control(
            'services_button_hover_backgorund',
            array(
                'label' => esc_html__('Hover Background-Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-services-3:hover .stl-services_readmore' => 'background-color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section(); 

        
        
        
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Icon)
        /*-----------------------------------------------------------------------------------*/    

        // Text Styles

        $this->start_controls_section(
            'icon_style_section',
            array(
                'label' => esc_html__('Icon', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );


        $this->add_control(
            'services_icon_color',
            array(
                'label' => esc_html__('Icon Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => "#fff",
                'selectors' => array(
                    '{{WRAPPER}} .stl-service-3_media-wrap i.icon' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_control(
            'services_icon_background',
            array(
                'label' => esc_html__('Icon backgroud Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-service-3_media-wrap .elementor-icon-box-icon' => 'background-color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section();        
    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'services', [
			'class' => [
                'stl-services-3',
                'a'.$settings[ 'alignment' ]
            ],
        ] );

        $this->add_render_attribute( 'image', [
			'class' => 'stl-services_image',
            'src' => esc_url($settings[ 'service_image' ][ 'url' ]),
            'alt' => Control_Media::get_image_alt( $settings[ 'service_image' ] ),
        ] );

        $this->add_render_attribute('item_link', 'class', 'stl-services_item-link');
        
        if (!empty($settings['item_link']['url'])) {
            $this->add_link_attributes('item_link', $settings['item_link']);
        }

        $this->add_render_attribute('btn_link', 'class', 'stl-services_readmore');
        
        if (!empty($settings['btn_link']['url'])) {
            $this->add_link_attributes('btn_link', $settings['btn_link']);
        }

        
        // Icon/Image output
        ob_start();
        if (!empty($settings[ 'icon_type' ])) {
            $icons = new stl_Icons;
            echo $icons->build($this, $settings, array());
        }
        $services_media = ob_get_clean();
        
        ?>
        <div <?php echo $this->get_render_attribute_string( 'services' ); ?>>
            <div class="stl-services_wrap"><?php
                if (!empty($settings[ 'service_image' ])) {?>
                    <div class="stl-services_image-wrap"><img <?php echo $this->get_render_attribute_string( 'image' ); ?> /></div><?php
                }
        
                if ($settings[ 'icon_type' ] != '') {?>
                    <div class="stl-service-3_media-wrap"><?php 
                        if (!empty($services_media)) {
                            echo $services_media;
                        }?>
                    </div><?php
                }
                if (!empty($settings[ 'services_title' ])) {?>
                    <div class="stl-services_title-wrap padding-10px-bottom"><?php
                        if ((bool)$settings[ 'add_item_link' ]) {?>
                            <a <?php echo $this->get_render_attribute_string( 'item_link' ); ?>><?php
                        }?>
                            <<?php echo $settings[ 'title_tag' ]; ?> class="stl-services_title"><?php echo $settings[ 'services_title' ];?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                        if ((bool)$settings[ 'add_item_link' ]) {?>
                            </a><?php
                        }?>
                    </div> <?php } ?>
                    <div class="stl-services_text-wrap">
                        <p class="stl-services_text"><?php echo $settings[ 'services_text' ];?></p>
                        </div>
                        <?php
                    if ((bool)$settings[ 'add_read_more' ]) {?>
                        <a <?php echo $this->get_render_attribute_string( 'btn_link' ); ?>><?php echo esc_html($settings[ 'read_more_text' ]);?> <i  class="fa fa-arrow-right"></i></a><?php
                    } ?>
            </div>
        </div>

        <?php     
    }
    
}