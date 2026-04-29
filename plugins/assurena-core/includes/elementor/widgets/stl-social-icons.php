<?php
namespace stlAddons\Widgets;

use stlAddons\Includes\stl_Icons;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class stl_Social_Icons extends Widget_Base {
    
    public function get_name() {
        return 'stl-social-icons';
    }

    public function get_title() {
        return esc_html__('stl Social Icons', 'assurena-core' );
    }

    public function get_icon() {
        return 'stl-social-icons';
    }
 
    public function get_categories() {
        return [ 'stl-extensions' ];
    }

    public function get_script_depends() {
        return ['appear'];
    }

	public function get_keywords() {
		return [ 'social', 'icon', 'link' ];
	}

    protected function _register_controls() {
        $theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-custom-color'));
        $second_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
        $header_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => esc_html__( 'Social Icons', 'assurena-core' ),
			]
		);

		$repeater = new Repeater();


		$repeater->add_control('icon_pack',
            array(
                'label' => esc_html__('Icon Pack', 'assurena-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fontawesome' => esc_html__('Fontawesome', 'assurena-core'), 
                    'flaticon' => esc_html__('Flaticon', 'assurena-core'),
                ],
                'default' => 'fontawesome',
            )
        );    

        $repeater->add_control('social_icon_flaticon',
            array(
                'label' => esc_html__( 'Icon', 'assurena-core' ),
                'type' => 'stl-icon',
                'label_block' => true,
                'condition' => [
                    'icon_pack'  => 'flaticon',
                ],
                'default' => '',
                'description' => esc_html__( 'Select icon from Flaticon library.', 'assurena-core' ),
            )
        );

		$repeater->add_control(
			'social_icon_fontawesome',
			array(
				'label' => esc_html__( 'Icon', 'assurena-core' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'social',
				'label_block' => true,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'condition' => [
                    'icon_pack'  => 'fontawesome',
                ],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'assurena-core',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'stumbleupon',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
			)
		);

		$repeater->add_control(
			'social_icon_title',
			[
				'label' => esc_html__( 'Title', 'assurena-core' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Title', 'assurena-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'assurena-core' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'default' => [
					'is_external' => 'true',
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'assurena-core' ),
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Color', 'assurena-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Inherit', 'assurena-core' ),
					'custom' => esc_html__( 'Custom', 'assurena-core' ),
				],
			]
		);

		$repeater->start_controls_tabs( 'item_icon_style_tab', [
		    'condition' => [
		        'item_icon_color' => 'custom',
		    ],
		] );

        $repeater->start_controls_tab(
            'item_icon_style_normal',
            array(
                'label' => esc_html__( 'Normal' , 'assurena-core' ),
            )
        );

		$repeater->add_control(
			'item_icon_primary_color',
			[
				'label' => esc_html__( 'Icon Idle', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon svg' => 'fill: {{VALUE}};',
				],
			]
		); 

		$repeater->add_control(
			'item_icon_secondary_color',
			[
				'label' => esc_html__( 'Background Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon' => 'background-color: {{VALUE}};',
				],
			]
		); 

		$repeater->add_control(
			'item_icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon' => 'border-color: {{VALUE}};',
				],
			]
		);	

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'item_icon_style_hover',
            array(
                'label' => esc_html__( 'Hover' , 'assurena-core' ),
            )
        );

		$repeater->add_control(
			'item_icon_primary_color_hover',
			[
				'label' => esc_html__( 'Icon Idle', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'item_icon_secondary_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);  

		$repeater->add_control(
			'item_icon_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();
        
        $this->add_control(
			'social_icon_list',
			[
				'label' => esc_html__( 'Social Icons', 'assurena-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'social_icon_title' => esc_html__( 'Twitter', 'assurena-core' ),
						'social_icon_fontawesome' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon_title' => esc_html__( 'Facebook', 'assurena-core' ),
						'social_icon_fontawesome' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social_icon_title' => esc_html__( 'Instagram', 'assurena-core' ),
						'social_icon_fontawesome' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
					],
				],
				'title_field' => '{{{ social_icon_title }}}',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => esc_html__( 'Shape', 'assurena-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => [
					'rounded' => esc_html__( 'Rounded', 'assurena-core' ),
					'square' => esc_html__( 'Square', 'assurena-core' ),
					'circle' => esc_html__( 'Circle', 'assurena-core' ),
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'assurena-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'assurena-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'assurena-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'assurena-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'assurena-core' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_social_style',
			[
				'label' => esc_html__( 'Icon', 'assurena-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'assurena-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Inherit', 'assurena-core' ),
					'custom' => esc_html__( 'Custom', 'assurena-core' ),
				],
			]
		);

		$this->start_controls_tabs( 'icon_style_tab', [
		    'condition' => [
		        'icon_color' => 'custom',
		    ],
		] );

        $this->start_controls_tab(
            'icon_style_normal',
            array(
                'label' => esc_html__( 'Normal' , 'assurena-core' ),
            )
        );

		$this->add_control(
			'icon_primary_color',
			[
				'label' => esc_html__( 'Icon Idle', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-social-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => esc_html__( 'Background Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'background-color: {{VALUE}};',
				],
			]
		);  		

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_style_hover',
            array(
                'label' => esc_html__( 'Hover' , 'assurena-core' ),
            )
        );

		$this->add_control(
			'icon_primary_color_hover',
			[
				'label' => esc_html__( 'Icon Idle', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);  

		$this->add_control(
			'icon_secondary_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'assurena-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);  


		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'assurena-core' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'section_social_divider',
            array(
                'type' => Controls_Manager::DIVIDER,
            )
        );

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'assurena-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__( 'Container Size', 'assurena-core' ),
                'type' => Controls_Manager::SLIDER,
				'range' => [
					'em' => [ 'min' => 0, 'max' => 5 ],
				],
                'selectors' => [
                    '{{WRAPPER}} .elementor-social-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Gap Items', 'assurena-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon:not(:last-child)' => $icon_spacing,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border', // We know this mistake - TODO: 'icon_border' (for hover control condition also)
				'selector' => '{{WRAPPER}} .elementor-social-icon',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'assurena-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
    }

    protected function render() {
		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-facebook',
			'fa fa-twitter',
			'fa fa-google-plus',
		];

		$class_animation = '';

		if ( ! empty( $settings['hover_animation'] ) ) {
			$class_animation = ' elementor-animation-' . $settings['hover_animation'];
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		?>
		<div class="stl-social-icons elementor-social-icons-wrapper">
			<?php
			foreach ( $settings['social_icon_list'] as $index => $item ) {
				$migrated = isset( $item['__fa4_migrated']['social_icon_fontawesome'] );
				$is_new = empty( $item['social'] ) && $migration_allowed;
				$social = '';

				// add old default
				if ( empty( $item['social'] ) && ! $migration_allowed ) {
					$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
				}

				if ( ! empty( $item['social'] ) ) {
					$social = str_replace( 'fa fa-', '', $item['social'] );
				}

				if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon_fontawesome']['library'] ) {
					$social = explode( ' ', $item['social_icon_fontawesome']['value'], 2 );
					if ( empty( $social[1] ) ) {
						$social = '';
					} else {
						$social = str_replace( 'fa-', '', $social[1] );
					}
				}
				if ( 'svg' === $item['social_icon_fontawesome']['library'] ) {
					$social = '';
				}

				$link_key = 'link_' . $index;

				$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

				$this->add_render_attribute( $link_key, 'class', [
					'elementor-icon',
					'elementor-social-icon',
					'elementor-social-icon-' . $social . $class_animation,
					'elementor-repeater-item-' . $item['_id'],
				] );

				if ( $item['link']['is_external'] ) {
					$this->add_render_attribute( $link_key, 'target', '_blank' );
				}

				if ( $item['link']['nofollow'] ) {
					$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
				}				
				
				if ( $item['social_icon_title'] ) {
					$this->add_render_attribute( $link_key, 'title', $item['social_icon_title'] );
				}

				$item_class = '';
	            switch ($item['icon_pack']) {
	                case 'fontawesome':
	                wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
	                break;
	                case 'flaticon':
	                wp_enqueue_style('flaticon', get_template_directory_uri() . '/fonts/flaticon/flaticon.css');
	                $item_class .= $item['social_icon_flaticon'];
	                break;
	            }

				?>
				<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
					<span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
					<?php
					if($item['icon_pack'] === 'fontawesome'){
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $item['social_icon_fontawesome'] );
						} else { ?>
							<i class="<?php echo esc_attr( $item['social'] ); ?>"></i>
						<?php } 
					}else{
						?>
						<i class="<?php echo esc_attr( $item_class ); ?>"></i>
						<?php
					}
					?>
				</a>
			<?php } ?>
		</div>
		<?php
    }
    
}