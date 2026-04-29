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

class stl_Counter extends Widget_Base {
	
	public function get_name() {
		return 'stl-counter';
	}

	public function get_title() {
		return esc_html__('stl Counter', 'assurena-core');
	}

	public function get_icon() {
		return 'stl-counter';
	}

	public function get_categories() {
		return [ 'stl-extensions' ];
	}

	public function get_script_depends() {
		return [
			'appear',
		];
	}


	protected function _register_controls()
	{
		$theme_color = esc_attr(\assurena_Theme_Helper::get_option('theme-primary-color'));
		$second_color = esc_attr(\assurena_Theme_Helper::get_option('theme-secondary-color'));
		$third_color = esc_attr(\assurena_Theme_Helper::get_option('theme-third-color'));
		$header_font_color = esc_attr(\assurena_Theme_Helper::get_option('header-font')['color']);
		$main_font_color = esc_attr(\assurena_Theme_Helper::get_option('main-font')['color']);


		/*-----------------------------------------------------------------------------------*/
		/*  CONTENT -> GENERAL
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'stl_counter_content',
			[ 'label' => esc_html__('General', 'assurena-core') ]
		);

		stl_Icons::init(
			$this,
			[
				'label' => esc_html__('Counter ', 'assurena-core'),
				'output' => '',
				'section' => false,
			]
		);

		$this->add_control(
			'positiont',
			[
				'label' => esc_html__('Position', 'assurena-core'),
				'type' => 'stl-radio-image',
				'condition' => [ 'icon_type!' => '' ],
				'options' => [
					'top' => [
						'title'=> esc_html__('Top', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_def.png',
					],
					'left' => [
						'title'=> esc_html__('Left', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_left.png',
					],
					'right' => [
						'title'=> esc_html__('Right', 'assurena-core'),
						'image' => stl_ELEMENTOR_ADDONS_URL . 'assets/img/stl_elementor_addon/icons/style_right.png',
					],
				],
				'prefix_class' => 'elementor-position-',
				'default' => 'left',
			]
		);

		$this->add_control(
			'start_value',
			[
				'label' => esc_html__('Start Value', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'step' => 10,
				'default' => 0,
				'separator' => 'before'
			]
		); 

		$this->add_control(
			'end_value',
			[
				'label' => esc_html__('End Value', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'step' => 10,
				'default' => 120,
			]
		); 

		$this->add_control(
			'prefix',
			[
				'label' => esc_html__('Counter Prefix', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'suffix',
			[
				'label' => esc_html__('Counter Suffix', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__('+', 'assurena-core'),
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__('Animation Speed', 'assurena-core'),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'step' => 100,
				'default' => 2000,
			]
		); 

		$this->add_control(
			'counter_title',
			[
				'label' => esc_html__('Title', 'assurena-core'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('This is the heading​', 'assurena-core'),
			]
		);

		$this->add_control(
			'title_block',
			[
				'label' => esc_html__('Title Display Block', 'assurena-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'alignment',
			[
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
				'default' => 'left',
				'toggle' => true,
			]
		);

		$this->end_controls_section();


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

		$this->add_control(
			'primary_color',
			[
				'label' => esc_html__('Icon Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 'icon_type' => 'font' ],
				'default' => '#838383',
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Icon Size', 'assurena-core'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [ 'icon_type' => 'font' ],
				'range' => [
					'px' => [ 'min' => 16, 'max' => 100 ],
				],
				'default' => [ 'size' => 60, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .stl-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 22,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .stl-counter_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-counter_media-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'counter_icon_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-counter_media-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'media_background',
				'label' => esc_html__('Background', 'assurena-core'),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .stl-counter_media-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'counter_icon_border',
				'selector' => '{{WRAPPER}} .stl-counter_media-wrap'
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'counter_icon_shadow',
				'selector' => '{{WRAPPER}} .stl-counter_media-wrap',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Style Section(Headings Section)
		/*-----------------------------------------------------------------------------------*/    
		$this->start_controls_section(
			'value_style_section',
			[
				'label' => esc_html__('Value', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'value_offset',
			[
				'label' => esc_html__('Value Offset', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .stl-counter_value-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_value',
				'selector' => '{{WRAPPER}} .stl-counter_value-wrap',
			]
		);

		$this->add_control(
			'value_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} .stl-counter_value-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Title Styles
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
				'description' => esc_html__('Choose your tag for counter title', 'assurena-core'),
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
			]
		);

		$this->add_responsive_control(
			'title_offset',
			[
				'label' => esc_html__('Title Offset', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 12,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit'  => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .stl-counter_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_fonts_title',
				'selector' => '{{WRAPPER}} .stl-counter_title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .stl-counter_title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		
		// Item Styles

		$this->start_controls_section(
			'counter_style_section',
			[
				'label' => esc_html__('Item', 'assurena-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'counter_offset',
			[
				'label' => esc_html__('Margin', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'counter_padding',
			[
				'label' => esc_html__('Padding', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'counter_border_radius',
			[
				'label' => esc_html__('Border Radius', 'assurena-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .stl-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'counter_color_tab' );

		$this->start_controls_tab(
			'custom_counter_color_idle',
			[ 'label' => esc_html__('Idle' , 'assurena-core') ]
		);

		$this->add_control(
			'bg_counter_color',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .stl-counter' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'counter_border',
				'label' => esc_html__('Border Type', 'assurena-core'),
				'selector' => '{{WRAPPER}} .stl-counter',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'counter_shadow',
				'selector' =>  '{{WRAPPER}} .stl-counter',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'custom_counter_color_hover',
			[ 'label' => esc_html__('Hover' , 'assurena-core') ]
		);

		$this->add_control(
			'bg_counter_color_hover',
			[
				'label' => esc_html__('Background Color', 'assurena-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}:hover .stl-counter' => 'background-color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'counter_border_hover',
				'label' => esc_html__('Border Type', 'assurena-core'),
				'selector' => '{{WRAPPER}}:hover .stl-counter',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'counter_shadow_hover',
				'selector' =>  '{{WRAPPER}}:hover .stl-counter',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

	}

	public function render() {
		
		$_s = $this->get_settings_for_display();

		$this->add_render_attribute( 'counter', [
			'class' => [
				'stl-counter',
				'a'.$_s[ 'alignment' ],
				$_s[ 'title_block' ] ? 'title-block' : 'title-inline'
			],
		] );

		$this->add_render_attribute( 'counter_value', [
			'class' => [
				'stl-counter_value',
				'value-placeholder'
			],
			'data-start-value' => $_s[ 'start_value' ],
			'data-end-value' => $_s[ 'end_value' ],
			'data-speed' => $_s[ 'speed' ],
		] );

		// Icon/Image output
		ob_start();
		if (! empty($_s[ 'icon_type' ])) {
			$icons = new stl_Icons;
			echo $icons->build($this, $_s, []);
		}
		$counter_media = ob_get_clean();

		?>
		<div <?php echo $this->get_render_attribute_string( 'counter' ); ?>>
			<div class="stl-counter_wrap"><?php
				if ($_s[ 'icon_type' ] != '') {?>
					<div class="stl-counter_media-wrap"><?php 
						if (! empty($counter_media)) {
							echo $counter_media;
						}?>
					</div><?php
				}?>
				<div class="stl-counter_content-wrap">
					<div class="stl-counter_value-wrap"><?php
						if (! empty($_s[ 'prefix' ])) {?>
							<span class="stl-counter_prefix"><?php echo $_s[ 'prefix' ];?></span><?php
						}
						if (! empty($_s[ 'end_value' ])) {?>
							<div class="stl-counter_value-placeholder">
								<span <?php echo $this->get_render_attribute_string( 'counter_value' ); ?>><?php echo $_s[ 'start_value' ];?></span>
								<span class="stl-counter_value"><?php echo $_s[ 'end_value' ];?></span>
							</div><?php
						}
						if (! empty($_s[ 'suffix' ])) {?>
							<span class="stl-counter_suffix"><?php echo $_s[ 'suffix' ];?></span><?php
						}?>
					</div>
					<?php
					if (! empty($_s[ 'counter_title' ])) {?>
						<<?php echo $_s[ 'title_tag' ]; ?> class="stl-counter_title"><?php echo $_s[ 'counter_title' ];?></<?php echo $_s[ 'title_tag' ]; ?>><?php
					}?>
				</div>
			</div>
		</div>

		<?php
	}

}