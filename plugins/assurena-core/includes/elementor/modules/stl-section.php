<?php
namespace stlAddons\Modules;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Frontend;
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Shapes;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* stl Elementor Section
*
*
* @class        stl_Section
* @version      1.0
* @category Class
* @author       StylusThemes
*/

class stl_Section{


    public $sections = array();

    public function __construct(){

        add_action( 'elementor/init', [ $this, 'add_hooks' ] );
    }

    public function add_hooks() {
        
        // Add stl extension control section to Section panel
        add_action( 'elementor/element/section/section_typo/after_section_end', [ $this, 'extened_animation' ], 10, 2 );
        
        //add_action( 'elementor/element/section/section_layout/after_section_end', [ $this, 'extends_header_params' ], 10, 2 );
        add_action( 'elementor/element/column/layout/after_section_end', [ $this, 'extends_column_params' ], 10, 2 );
        
        add_action( 'elementor/frontend/section/before_render', [ $this, 'extened_row_render' ], 10, 1 );  
        
        add_action( 'elementor/frontend/column/before_render', [ $this, 'extened_column_render' ], 10, 1 );  

        add_action('elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_scripts' ]);     

        add_action('elementor/element/wp-post/document_settings/after_section_end', [ $this, 'post_metaboxes' ] , 10 , 1 );
    }


    function post_metaboxes( $page ) {

        $page->start_controls_section(
            'header_options',
            array(
                'label'     => esc_html__( 'stl Header Options', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_SETTINGS
            )
        );

        $page->add_control(
            'mobile_breakpoint',
            array(
                'label' => esc_html__( 'Mobile Header resolution breakpoint', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 1,
                'min' => 5,
                'max' => 4000,
                'default' => 1200,
            )
        );

        $page->add_control(
            'header_on_bg',
            array(
                'label'        => esc_html__('Over content?','assurena-core' ),
                'description' => esc_html__( 'Set Header to display over content.', 'assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'yes',
            )
        );

        $page->end_controls_section();  


    }

    public function extened_row_render( \Elementor\Element_Base $element ){

        if( 'section' !== $element->get_name() ) {
            return;
        }

        $settings = $element->get_settings();
        $data     = $element->get_data();

        if(isset($settings['add_background_text']) && !empty($settings['add_background_text'])){

            wp_enqueue_script('appear', esc_url( get_template_directory_uri() . '/js/jquery.appear.js' ), array(), false, false);
            wp_enqueue_script('anime', esc_url( get_template_directory_uri() . '/js/anime.min.js' ), array(), false, false);
        }
      
        if(isset($settings['add_background_animation']) && !empty($settings['add_background_animation'])){
            if(!(bool) Plugin::$instance->editor->is_edit_mode()){
                wp_enqueue_script('parallax', esc_url( get_template_directory_uri() . '/js/parallax.min.js' ), array(), false, false);
                wp_enqueue_script('paroller', esc_url( get_template_directory_uri() . '/js/jquery.paroller.min.js' ), array(), false, false); 
                wp_enqueue_style('animate', esc_url( get_template_directory_uri() . '/css/animate.css' ) );                 
            }
        }

        $this->sections[ $data['id'] ] = $settings;

    }    

    public function extened_column_render( \Elementor\Element_Base $element ){

        if( 'column' !== $element->get_name() ) {
            return;
        }

        $settings = $element->get_settings();
        $data     = $element->get_data();

        if(isset($settings['apply_sticky_column']) && !empty($settings['apply_sticky_column'])){

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array(), false, false);

        }
    }

    public function enqueue_scripts(){

        if((bool) Plugin::$instance->preview->is_preview_mode()){
            wp_enqueue_style('animate', esc_url( get_template_directory_uri() . '/css/animate.css' ));

            wp_enqueue_script('parallax', esc_url( get_template_directory_uri() . '/js/parallax.min.js' ), array(), false, false);
            wp_enqueue_script('paroller', esc_url( get_template_directory_uri() . '/js/jquery.paroller.min.js' ), array(), false, false);  

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array(), false, false);    
        }  

        //Add options in the section
        wp_enqueue_script( 'stl-parallax', esc_url( stl_ELEMENTOR_ADDONS_URL . 'assets/js/stl_elementor_sections.js' ), array('jquery'), false, true );
        
        //Add options in the column
        wp_enqueue_script( 'stl-column', esc_url( stl_ELEMENTOR_ADDONS_URL . 'assets/js/stl_elementor_column.js' ), array('jquery'), false, true );

        wp_localize_script(
            'stl-parallax',
            'stl_parallax_settings',
            array( 
                $this->sections,
                'ajaxurl' => admin_url( 'admin-ajax.php' ), 
                'svgURL'  => esc_url( stl_ELEMENTOR_ADDONS_URL . 'assets/shapes/' ), 
            )
        );
    }

    public function extened_animation( $widget, $args ){
        $widget->start_controls_section(
            'extened_animation',
            array(
                'label'     => esc_html__( 'stl Background Text', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );
        
        $widget->add_control(
            'add_background_text',
            array(
                'label'        => esc_html__('Add Background Text?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'add-background-text',
                'prefix_class' => 'stl-',
            )
        );

        $widget->add_control('background_text',
            array(
                'label'             => esc_html__('Background Text', 'assurena-core'),
                'type'              => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' =>  esc_html__('Text', 'assurena-core'),
                'selectors' => array(
                    '{{WRAPPER}}.stl-add-background-text:before' => 'content:"{{VALUE}}"',
                    '{{WRAPPER}} .stl-background-text' => 'content:"{{VALUE}}"',
                ),
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            )
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'background_text_typo',
                'selector' => '{{WRAPPER}}.stl-add-background-text:before, {{WRAPPER}} .stl-background-text',
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            )
        );

        $widget->add_responsive_control(
            'background_text_indent',
            [
                'label' => esc_html__( 'Text Indent', 'assurena-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vw' ],
                'selectors' => [
                    '{{WRAPPER}}.stl-add-background-text:before' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .stl-background-text .letter:last-child' => 'margin-right: -{{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                    ],                    
                    'vw' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'unit' => 'vw',
                    'size' => 8.9,
                ],
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            ]
        );

        $widget->add_control(
            'background_text_color',
            array(
                'label' => esc_html__( 'Color', 'assurena-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f1f1f1',
                'selectors' => array(
                    '{{WRAPPER}}.stl-add-background-text:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .stl-background-text' => 'color: {{VALUE}};',
                ),
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            )
        );

        $widget->add_responsive_control(
            'background_text_spacing',
            [
                'label' => esc_html__( 'Top Spacing', 'assurena-core' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}.stl-add-background-text:before' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .stl-background-text' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 400,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            ]
        );

        $widget->add_control(
            'apply_animation_background_text',
            array(
                'label'        => esc_html__('Apply Animation?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'animation-background-text',
                'default'      => 'animation-background-text',
                'prefix_class' => 'stl-',
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
            )
        );

        $widget->end_controls_section();        

        $widget->start_controls_section(
            'extened_parallax',
            array(
                'label'     => esc_html__( 'stl Parallax', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );
        
        $widget->add_control(
            'add_background_animation',
            array(
                'label'        => esc_html__('Add Extended Background Animation?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'yes',
            )
        );

        $repeater = new Repeater();

        $repeater->add_control('image_effect',
            array(
                'label'             => esc_html__('Parallax Effect', 'assurena-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'scroll'        => esc_html__('Scroll', 'assurena-core'),
                    'mouse'         => esc_html__('Mouse', 'assurena-core'),  
                    'css_animation' => esc_html__('CSS Animation', 'assurena-core'),  
                ],
                'default' => 'scroll',
            )
        ); 
        
        $repeater->add_responsive_control(
            'animation_name',
            array(
                'label' => esc_html__( 'Animation', 'assurena-core' ),
                'type' => Controls_Manager::SELECT2,
                'default' => 'fadeIn',
                'options' => [
                    'bounce' => 'bounce',
                    'flash' => 'flash',
                    'pulse' => 'pulse',
                    'rubberBand' => 'rubberBand',
                    'shake' => 'shake',
                    'swing' => 'swing',
                    'tada' => 'tada',
                    'wobble' => 'wobble',
                    'jello' => 'jello',
                    'bounceIn' => 'bounceIn',
                    'bounceInDown' => 'bounceInDown',
                    'bounceInUp' => 'bounceInUp',
                    'bounceOut' => 'bounceOut',
                    'bounceOutDown' => 'bounceOutDown',
                    'bounceOutLeft' => 'bounceOutLeft',
                    'bounceOutRight' => 'bounceOutRight',
                    'bounceOutUp' => 'bounceOutUp',
                    'fadeIn' => 'fadeIn',
                    'fadeInDown' => 'fadeInDown',
                    'fadeInDownBig' => 'fadeInDownBig',
                    'fadeInLeft' => 'fadeInLeft',
                    'fadeInLeftBig' => 'fadeInLeftBig',
                    'fadeInRightBig' => 'fadeInRightBig',
                    'fadeInUp' => 'fadeInUp',
                    'fadeInUpBig' => 'fadeInUpBig',
                    'fadeOut' => 'fadeOut',
                    'fadeOutDown' => 'fadeOutDown',
                    'fadeOutDownBig' => 'fadeOutDownBig',
                    'fadeOutLeft' => 'fadeOutLeft',
                    'fadeOutLeftBig' => 'fadeOutLeftBig',
                    'fadeOutRightBig' => 'fadeOutRightBig',
                    'fadeOutUp' => 'fadeOutUp',
                    'fadeOutUpBig' => 'fadeOutUpBig',
                    'flip' => 'flip',
                    'flipInX' => 'flipInX',
                    'flipInY' => 'flipInY',
                    'flipOutX' => 'flipOutX',
                    'flipOutY' => 'flipOutY',
                    'fadeOutDown' => 'fadeOutDown',
                    'lightSpeedIn' => 'lightSpeedIn',
                    'lightSpeedOut' => 'lightSpeedOut',
                    'rotateIn' => 'rotateIn',
                    'rotateInDownLeft' => 'rotateInDownLeft',
                    'rotateInDownRight' => 'rotateInDownRight',
                    'rotateInUpLeft' => 'rotateInUpLeft',
                    'rotateInUpRight' => 'rotateInUpRight',
                    'rotateOut' => 'rotateOut',
                    'rotateOutDownLeft' => 'rotateOutDownLeft',
                    'rotateOutDownRight' => 'rotateOutDownRight',
                    'rotateOutUpLeft' => 'rotateOutUpLeft',
                    'rotateOutUpRight' => 'rotateOutUpRight',
                    'slideInUp' => 'slideInUp',
                    'slideInDown' => 'slideInDown',
                    'slideInLeft' => 'slideInLeft',
                    'slideInRight' => 'slideInRight',
                    'slideOutUp' => 'slideOutUp',
                    'slideOutDown' => 'slideOutDown',
                    'slideOutLeft' => 'slideOutLeft',
                    'slideOutRight' => 'slideOutRight',
                    'zoomIn' => 'zoomIn',
                    'zoomInDown' => 'zoomInDown',
                    'zoomInLeft' => 'zoomInLeft',
                    'zoomInRight' => 'zoomInRight',
                    'zoomInUp' => 'zoomInUp',
                    'zoomOut' => 'zoomOut',
                    'zoomOutDown' => 'zoomOutDown',
                    'zoomOutLeft' => 'zoomOutLeft',
                    'zoomOutUp' => 'zoomOutUp',
                    'hinge' => 'hinge',
                    'rollIn' => 'rollIn',
                    'rollOut' => 'rollOut'
                ],
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
            )
        );
        $repeater->add_control(
            'animation_name_iteration_count',
            [
                'label' => esc_html__( 'Animation Iteration Count', 'assurena-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    'infinite' => esc_html__( 'Infinite', 'assurena-core' ),
                    '1' => esc_html__( '1', 'assurena-core' ),
                ],
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-iteration-count:{{UNIT}}'
                ],
            ]
        );
        $repeater->add_control(
            'animation_name_speed',
            array(
                'label' => esc_html__( 'Animation speed', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,         
                'min' => 1,
                'step' => 100,
                'default' => '1',
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-duration:{{UNIT}}s'
                ],
            )
        );
        $repeater->add_control(
            'animation_name_direction',
            [
                'label' => esc_html__( 'Animation Direction', 'assurena-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => esc_html__( 'Normal', 'assurena-core' ),
                    'reverse' => esc_html__( 'Reverse', 'assurena-core' ),
                    'alternate' => esc_html__( 'Alternate', 'assurena-core' ),
                ],
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => 'animation-direction:{{UNIT}}'
                ],
            ]
        );
        $repeater->add_control(
            'image_bg',
            array(
                'label' => esc_html__( 'Parallax Image', 'assurena-core' ),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => '',
                ],
            )
        );  


        $repeater->add_control('parallax_dir',
            array(
                'label'             => esc_html__('Parallax Direction', 'assurena-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'vertical'    => esc_html__('Vertical', 'assurena-core'),
                    'horizontal'     => esc_html__('Horizontal', 'assurena-core'), 
                ],
                'condition' => [
                    'image_effect' => 'scroll',
                ],
                'default' => 'vertical',
            )
        );        

        $repeater->add_control(
            'parallax_factor',
            array(
                'label' => esc_html__( 'Parallax Factor', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => -3,
                'max' => 3,
                'step' => 0.01,
                'default' => 0.03,
                'description' => esc_html__( 'Set elements offset and speed. It can be positive (0.3) or negative (-0.3). Less means slower.', 'assurena-core' ),
            )
        );    

        $repeater->add_responsive_control(
            'position_top',
            [
                'label' => esc_html__( 'Top Offset', 'assurena-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -200,
                        'max' => 1000,
                        'step' => 5,
                    ],
                ],
                'default'   => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'description' => esc_html__( 'Set figure vertical offset from top border.', 'assurena-core' ),
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => 'top: {{SIZE}}{{UNIT}}',

                ],
            ]
        );        

        $repeater->add_responsive_control(
            'position_left',
            [
                'label' => esc_html__( 'Left Offset', 'assurena-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px'  ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -200,
                        'max' => 1000,
                        'step' => 5,
                    ],
                ],
                'default'   => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'description' => esc_html__( 'Set figure horizontal offset from left border.', 'assurena-core' ),
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => 'left: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        $repeater->add_control(
            'image_index',
            array(
                'label' => esc_html__( 'Image z-index', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 1,
                'default' => -1,
                'selectors' => [
                    "{{WRAPPER}} {{CURRENT_ITEM}}" => 'z-index: {{UNIT}}',
                ],
            )
        );

        $repeater->add_control(
            'hide_on_mobile',
            array(
                'label'        => esc_html__('Hide On Mobile?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'yes',
            )
        );
        $repeater->add_control(
            'hide_mobile_resolution',
            array(
                'label' => esc_html__( 'Screen Resolution', 'assurena-core' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 1,
                'default' => 768,
                'condition' => [
                    'hide_on_mobile' => 'yes',
                ],
            )
        );

        $widget->add_control(
            'items_parallax',
            array(
                'label' => esc_html__( 'Layers', 'assurena-core' ),
                'type' => Controls_Manager::REPEATER,
                'condition' => [
                    'add_background_animation' => 'yes',
                ],
                'fields' => $repeater->get_controls(),
            )
        );

        $widget->end_controls_section();        

        $widget->start_controls_section(
            'extened_shape',
            array(
                'label'     => esc_html__( 'stl Shape Divider', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            )
        );

        $widget->start_controls_tabs( 'tabs_stl_shape_dividers' );

        $shapes_options = [
            '' => esc_html__( 'None', 'assurena-core' ),
            'torn_line' => esc_html__( 'Torn Line', 'assurena-core' ),
        ];

        foreach ( [
            'top' => esc_html__( 'Top', 'assurena-core' ),
            'bottom' => esc_html__( 'Bottom', 'assurena-core' ),
        ] as $side => $side_label ) {
            $base_control_key = "stl_shape_divider_$side";

            $widget->start_controls_tab(
                "tab_$base_control_key",
                [
                    'label' => $side_label,
                ]
            );
            
            $widget->add_control(
                $base_control_key,
                [
                    'label' => esc_html__( 'Type', 'assurena-core' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $shapes_options,
                ]
            );


            $widget->add_control(
                $base_control_key . '_color',
                [
                    'label' => esc_html__( 'Color', 'assurena-core' ),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [
                        "stl_shape_divider_$side!" => '',
                    ],
                    'selectors' => [
                        "{{WRAPPER}} > .stl-elementor-shape-$side path" => 'fill: {{UNIT}};',
                    ],
                ]
            );

            $widget->add_responsive_control(
                $base_control_key . '_height',
                [
                    'label' => esc_html__( 'Height', 'assurena-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 500,
                        ],
                    ],
                    'condition' => [
                        "stl_shape_divider_$side!" => '',
                    ],
                    'selectors' => [
                        "{{WRAPPER}} > .stl-elementor-shape-$side svg" => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_flip',
                [
                    'label' => __( 'Flip', 'assurena-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        "{{WRAPPER}} > .stl-elementor-shape-$side svg" => 'transform: translateX(-50%) rotateY(180deg)',
                    ],
                    'condition' => [
                        "stl_shape_divider_$side!" => '',
                    ],
                ]
            );            

            $widget->add_control(
                $base_control_key . '_invert',
                [
                    'label' => __( 'Invert', 'assurena-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        "{{WRAPPER}} > .stl-elementor-shape-$side" => 'transform: rotate(180deg)',
                    ],
                    'condition' => [
                        "stl_shape_divider_$side!" => '',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_above_content',
                array(
                    'label' => esc_html__( 'Z-index', 'assurena-core' ),
                    'type' => Controls_Manager::NUMBER,
                    'step' => 1,
                    'default' => 0,
                    'selectors' => [
                        "{{WRAPPER}} > .stl-elementor-shape-$side" => 'z-index: {{UNIT}}',
                    ],
                    'condition' => [
                        "stl_shape_divider_$side!" => '',
                    ],
                )
            );

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }    

    public function extends_header_params($widget, $args) {

        $widget->start_controls_section(
            'extened_header',
            array(
                'label'     => esc_html__( 'stl Header Layout', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_LAYOUT
            )
        );

        $widget->add_control(
            'apply_sticky_row',
            array(
                'label'        => esc_html__('Apply Sticky?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'sticky-on',
                'prefix_class' => 'stl-',
            )
        );

        $widget->end_controls_section();  
    
    }    

    public function extends_column_params($widget, $args) {

        $widget->start_controls_section(
            'extened_header',
            array(
                'label'     => esc_html__( 'stl Column Options', 'assurena-core' ),
                'tab'       => Controls_Manager::TAB_LAYOUT
            )
        );

        $widget->add_control(
            'apply_sticky_column',
            array(
                'label'        => esc_html__('Enable Sticky?','assurena-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'assurena-core' ),
                'label_off'    => esc_html__( 'Off', 'assurena-core' ),
                'return_value' => 'sidebar',
                'prefix_class' => 'sticky-',
            )
        );

        $widget->end_controls_section();  
    
    }
}

?>