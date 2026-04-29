<?php

namespace stlAddons\Includes;

defined( 'ABSPATH' ) || exit;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;


/**
* stl Elementor Icons Settings
*
*
* @class        stl_Icons
* @version      1.0
* @category     Class
* @author       StylusThemes
*/

if (! class_exists('stl_Icons')) {

    class stl_Icons
    {
        private static $instance = null;

        public static function get_instance()
        {
            if ( null == self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }


        public function build($self, $atts, $pref)
        {
            $icon_builder = new stl_Icon_Builder();
            return $icon_builder->build( $self, $atts, $pref );
        }


        public static function init($self, $array = [])
        {
            if (! $self) return;

            $label = isset($array['label']) ? $array['label'] : '';
            $prefix = ! empty($array['prefix']) ? $array['prefix'] : '';

            if ($array['section']) {
                $self->start_controls_section(
                    $prefix.'add_icon_image_section',
                    [
                        'label' => sprintf( esc_html__('%s Icon/Image', 'assurena-core'), $label ),
                    ]
                );
            }

            $self->add_control(
                $prefix.'icon_type',
                [
                    'label' => esc_html__('Add Icon/Image', 'assurena-core'),
                    'type' => Controls_Manager::CHOOSE,
                    'label_block' => false,
                    'options' => [
                        '' => [
                            'title' => esc_html__('None', 'assurena-core'), 
                            'icon' => 'fa fa-ban',
                        ],
                        'font' => [
                            'title' => esc_html__('Icon', 'assurena-core'),
                            'icon' => 'fa fa-smile-o',
                        ],
                        'image' => [
                            'title' => esc_html__('Image', 'assurena-core'),
                            'icon' => 'fa fa-picture-o',
                        ]
                    ],
                    'default' => '',
                ]
            );

            $self->add_control(
                $prefix.'icon_pack',
                [
                    'label' => esc_html__('Icon Pack', 'assurena-core'),
                    'type' => Controls_Manager::SELECT,
                    'condition' => [
                        $prefix.'icon_type' => 'font',
                    ],
                    'options' => [
                        'fontawesome' => esc_html__('Fontawesome', 'assurena-core'), 
                        'flaticon' => esc_html__('Flaticon', 'assurena-core'),
                    ],
                    'default' => 'fontawesome',
                ]
            );

            $self->add_control(
                $prefix.'icon_flaticon',
                [
                    'label' => esc_html__( 'Icon', 'assurena-core' ),
                    'type' => 'stl-icon',
                    'label_block' => true,
                    'condition' => [
                        $prefix.'icon_pack' => 'flaticon',
                        $prefix.'icon_type' => 'font',
                    ],
                    'description' => esc_html__( 'Select icon from Flaticon library.', 'assurena-core' ),
                ]
            );

            $self->add_control(
                $prefix.'icon_fontawesome',
                [
                    'label' => esc_html__( 'Icon', 'assurena-core' ),
                    'type' => Controls_Manager::ICON,
                    'label_block' => true,
                    'condition' => [
                        $prefix.'icon_pack' => 'fontawesome',
                        $prefix.'icon_type' => 'font',
                    ],
                    'description' => esc_html__( 'Select icon from Fontawesome library.', 'assurena-core' ),
                ]
            );

            $self->add_control(
                $prefix.'icon_render_class',
                [
                    'label' => esc_html__( 'Icon Class', 'assurena-core' ),
                    'type' => Controls_Manager::HIDDEN,
                    'condition' => [
                        $prefix.'icon_type' => 'font',
                    ],
                    'prefix_class' => 'elementor-widget-icon-box ',
                    'default' => 'stl-icon-box',
                ]
            );

            $self->add_control(
                $prefix.'thumbnail',
                [
                    'label' => esc_html__( 'Image', 'assurena-core' ),
                    'type' => Controls_Manager::MEDIA,
                    'label_block' => true,
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ],
                    'default' => [
                        'url' => Utils::get_placeholder_image_src(),
                    ],
                ]
            );

            $self->add_control(
                $prefix.'image_render_class',
                [
                    'label' => esc_html__( 'Image Class', 'assurena-core' ),
                    'type' => Controls_Manager::HIDDEN,
                    'default' => 'stl-image-box',
                    'prefix_class' => 'elementor-widget-image-box ',
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ]
                ]
            );

            $self->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => $prefix.'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                    'default' => 'full',
                    'separator' => 'none',
                    'condition' => [
                        $prefix.'icon_type' => 'image',
                    ],
                ]
            );

            if (isset($array['output']) && ! empty($array['output'])){
                foreach ($array['output'] as $key => $value) {
                    $self->add_control(
                        $key,
                        $value
                    );
                }
            }
            if ($array['section']) {
	            $self->end_controls_section();       
            }
        }
        
    }
    new stl_Icons();
}

/**
* stl Icon Build
*
*
* @class        stl_Icon_Builder
* @version      1.0
* @category Class
* @author       StylusThemes
*/
if (!class_exists('stl_Icon_Builder')){
    class stl_Icon_Builder{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }


        public function build($self, $atts, $pref ){

            $prefix = '';
            if (isset($pref) && ! empty($pref)) {
                $prefix = $pref;
            }

            $icon_type = $atts[$prefix.'icon_type'];
            $icon_pack = $atts[$prefix.'icon_pack'];
            $icon_flaticon = $atts[$prefix.'icon_flaticon'];
            $icon_fontawesome = $atts[$prefix.'icon_fontawesome'];
            $thumbnail = $atts[$prefix.'thumbnail'];

            $self->add_render_attribute( $prefix.'icon', 'class', [ 'stl-icon', 'elementor-icon' ] );
            if (isset($atts['hover_animation_icon'])){
                $self->add_render_attribute( $prefix.'icon', 'class', 'elementor-animation-' . $atts['hover_animation_icon'] );
            }
            $wrapper_class = isset($atts['wrapper_class']) ? $atts['wrapper_class'] : 'stl-widget_wrapper';

            if ($icon_type !== ''){
                if ($icon_type === 'image'){
                    $wrapper_class .= ' elementor-image-box-img';
                }else{
                    $wrapper_class .= ' elementor-icon-box-icon';
                }
            } 

            $container_class = isset($atts['container_class']) ? $atts['container_class'] : 'stl-widget_container';

            $self->add_render_attribute( $prefix.'wrapper', 'class', [ $wrapper_class ] );

            $self->add_render_attribute( $prefix.'container', 'class', [ $container_class ] );

            $output = '';
            $icon_tag = 'span';
            
            if ( isset($atts['link_t']['url']) && ! empty( $atts['link_t']['url'] ) ) {
                $self->add_render_attribute( $prefix.'link_t', 'href', $atts['link_t']['url'] );
                $icon_tag = 'a';

                if ( $atts['link_t']['is_external'] ) {
                    $self->add_render_attribute( $prefix.'link_t', 'target', '_blank' );
                }

                if ( $atts['link_t']['nofollow'] ) {
                    $self->add_render_attribute( $prefix.'link_t', 'rel', 'nofollow' );
                }
            }

            $icon_attributes = $self->get_render_attribute_string( $prefix.'icon' );        
            $link_attributes = $self->get_render_attribute_string( $prefix.'link_t' );

            $wrapper = $self->get_render_attribute_string( $prefix.'wrapper' );
            $container = $self->get_render_attribute_string( $prefix.'container' );

            if ($icon_type == 'font' && (! empty($icon_fontawesome) || ! empty($icon_flaticon)) ||  $icon_type == 'image' && ! empty($thumbnail)){

                $output .= '<div '.implode( ' ', [ $wrapper ] ).'>'; 
                    $output .= '<div '.implode( ' ', [ $container ] ).'>'; 
                    
                        if ($icon_type == 'font' && (! empty($icon_fontawesome) || ! empty($icon_flaticon))) {
                            switch ($icon_pack) {
                                case 'fontawesome':
                                    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
                                    $icon_font = $icon_fontawesome;
                                    break;
                                case 'flaticon':
                                    wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
                                    $icon_font = $icon_flaticon;
                                    break;
                            }

                            $output .= '<'; 
                                $output .= implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] );
                            $output .= '>'; 
                                $output .= '<i class="icon '.esc_attr($icon_font).'"></i>';
                            
                            $output .= '</'.$icon_tag.'>';
                        }
                        if ($icon_type == 'image' && ! empty($thumbnail)) {

                            // var_dump($thumbnail);
                            if ( ! empty( $thumbnail['url'] ) ) {
                                $self->add_render_attribute( 'thumbnail', 'src', $thumbnail['url'] );
                                $self->add_render_attribute( 'thumbnail', 'alt', Control_Media::get_image_alt( $thumbnail ) );
                                $self->add_render_attribute( 'thumbnail', 'title', Control_Media::get_image_title( $thumbnail ) );

                                if ( isset($atts['hover_animation_image']) ) {
                                    $atts['hover_animation'] = $atts['hover_animation_image'];
                                }

                                $output .= '<figure class="stl-image-box_img">';

                                $output .= '<'; 
                                    $output .= implode( ' ', [ $icon_tag,  $link_attributes ] );
                                $output .= '>'; 
                                    $output .= Group_Control_Image_Size::get_attachment_image_html( $atts, 'thumbnail', $prefix.'thumbnail' );

                                $output .= '</'.$icon_tag.'>';

                                $output .= '</figure>';
                            }

                        }

                    $output .= '</div>';
                $output .= '</div>';
            }
            return $output;

        }

        public function template_build(){

        }       
    }
}
?>