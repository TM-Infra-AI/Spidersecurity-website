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

class stl_Process_Box extends Widget_Base {
    
    public function get_name() {
        return 'stl-process-box';
    }

    public function get_title() {
        return esc_html__('stl Process Box', 'assurena-core');
    }

    public function get_icon() {
        return 'stl-process-box';
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

        stl_Icons::init( $this, array( 'label' => esc_html__(' ', 'assurena-core'), 'output' => '','section' => true, 'prefix' => '' ) );

        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section('stl_process_content',
            array(
                'label' => esc_html__('Process Content', 'assurena-core'),
            )
        );

        $this->add_control(
            'process_title',
            array(
                'label' => esc_html__('Title', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is heading​', 'assurena-core'),
            )
        );
        
        $this->add_control(
            'process_text',
            array(
                'label' => esc_html__('Text', 'assurena-core'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__('This is service text​', 'assurena-core'),
            )
        );
        
        $this->add_control(
            'processs_number',
            array(
                'label' => esc_html__('Number', 'assurena-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('1​', 'assurena-core'),
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
            'title_link',
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
                'selector' => '{{WRAPPER}} .stl-process_title',
            )
        );

        $this->add_control(
            'title_tag',
            array(
                'label' => esc_html__('Title Tag', 'assurena-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h3',
                'description' => esc_html__('Choose your tag for Process title', 'assurena-core'),
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
            'title_color',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process_title' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_control(
            'hover_title_color',
            array(
                'label' => esc_html__('Hover Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process_title:hover' => 'color: {{VALUE}};'
                ),
                'condition' => [ 
                    'add_item_link' => 'yes',
                ],
            )
        );

		$this->add_responsive_control(
			'title_padding',
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
					'{{WRAPPER}} .stl-process-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
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
					'{{WRAPPER}} .stl-process-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
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
                'selector' => '{{WRAPPER}} .stl-process_text',
            )
        );

        $this->add_control(
            'process_color_text',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process_text' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_responsive_control(
			'text_padding',
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
					'{{WRAPPER}} .stl-process-text-wrapp' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
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
					'{{WRAPPER}} .stl-process-text-wrapp' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
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
                'selector' => '{{WRAPPER}} .stl-process_readmore',
            )
        );

        $this->add_control(
            'process_color_button',
            array(
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process_readmore' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_control(
            'process_color_button_hover',
            array(
                'label' => esc_html__('Hover Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .stl-process-box:hover .stl-process_readmore' => 'color: {{VALUE}};'
                ),
            )
        );
       $this->add_control(
            'process_button_hover_backgorund',
            array(
                'label' => esc_html__('Hover Background-Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process-box:hover .stl-process_readmore' => 'background-color: {{VALUE}};'
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

        $this->add_responsive_control(
            'icon_size',
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
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-process-icon_wrap .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'process_icon_color',
            array(
                'label' => esc_html__('Icon Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .stl-process-icon_wrap i.icon' => 'color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_control(
            'process_icon_background',
            array(
                'label' => esc_html__('Icon backgroud Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => array(
                    '{{WRAPPER}} .stl-process_wrap .stl-process-media_wrap' => 'background-color: {{VALUE}};'
                ),
            )
        );
        
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .stl-process_wrap .stl-process-media_wrap',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_border_radius',
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
					'{{WRAPPER}} .stl-process_wrap .stl-process-media_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section(); 
        
        
        
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Number)
        /*-----------------------------------------------------------------------------------*/    

        // Text Styles

        $this->start_controls_section(
            'number_style_section',
            array(
                'label' => esc_html__('Number', 'assurena-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        
        $this->add_responsive_control(
            'number_size',
            [
                'label' => esc_html__('Font Size', 'assurena-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .stl-process-media_wrap .stl-process-number' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 

        $this->start_controls_tabs( 'number_color_tab' );

        $this->start_controls_tab(
            'custom_number_color_idle',
            [
                'label' => esc_html__('Idle' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .stl-process-media_wrap .stl-process-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'number_bgcolor',
            [
                'label' => esc_html__('Background Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => [
                    '{{WRAPPER}} .stl-process-media_wrap .stl-process-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_number_color_hover',
            [
                'label' => esc_html__('Hover' , 'assurena-core'),
            ]
        );

        $this->add_control(
            'number_color_hover',
            [
                'label' => esc_html__('Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-process-media_wrap .stl-process-number' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'number_bgcolor_hover',
            [
                'label' => esc_html__('Background Color', 'assurena-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $second_color,
                'selectors' => [
                    '{{WRAPPER}}:hover .stl-process-media_wrap .stl-process-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();         
    }

    public function render() {
        
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'process', [
			'class' => ['stl-process-box','acenter'],
        ] );

        $this->add_render_attribute('title_link', 'class', 'stl-process_item-link');
        
        if (!empty($settings['title_link']['url'])) {
            $this->add_link_attributes('title_link', $settings['title_link']);
        }
        
        $this->add_render_attribute('btn_link', 'class', 'stl-process_readmore');
        
        if (!empty($settings['btn_link']['url'])) {
            $this->add_link_attributes('btn_link', $settings['btn_link']);
        }
        
        // Icon/Image output
        ob_start();
        if (!empty($settings[ 'icon_type' ])) {
            $icons = new stl_Icons;
            echo $icons->build($this, $settings, array());
        }
        $process_media = ob_get_clean();
        
        ?>
        <div <?php echo $this->get_render_attribute_string( 'process' ); ?>>
            <div class="stl-process_wrap">
                <div class="stl-process-media_wrap">
                   <?php if ($settings[ 'icon_type' ] != '') {?>
                        <div class="stl-process-icon_wrap"><?php 
                            if (!empty($process_media)) {
                                echo $process_media;
                            }?>
                        </div><?php
                    } ?>
                    <div class="stl-process-number"><?php echo $settings[ 'processs_number' ];?></div>
                </div>
                <div class="stl-process-content_wrap">
                    <?php if (!empty($settings[ 'process_title' ])) {?>
                    <div class="stl-process-title"><?php
                    if ((bool)$settings[ 'add_item_link' ]) {?>
                        <a <?php echo $this->get_render_attribute_string( 'title_link' ); ?>><?php
                    }?>
                    <<?php echo $settings[ 'title_tag' ]; ?> class="stl-process_title"><?php echo $settings[ 'process_title' ];?></<?php echo $settings[ 'title_tag' ]; ?>><?php
                    if ((bool)$settings[ 'add_item_link' ]) {?>
                        </a><?php
                    }?>
                    </div><?php } ?>
                    <div class="stl-process-text-wrapp">
                        <p class="stl-process_text"><?php echo $settings[ 'process_text' ];?></p>
                    </div>
                </div>
                <?php if ((bool)$settings[ 'add_read_more' ]) {?>
                    <a <?php echo $this->get_render_attribute_string( 'btn_link' ); ?>><?php echo esc_html($settings[ 'read_more_text' ]);?> <i  class="fa fa-arrow-right"></i></a><?php
                } ?>
            </div>
        </div>

        <?php     
    }
    
}