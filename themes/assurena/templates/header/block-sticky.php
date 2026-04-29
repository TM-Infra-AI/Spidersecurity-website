<?php

defined( 'ABSPATH' ) || exit;

if (!class_exists('assurena_header_sticky')) {
	class assurena_header_sticky extends assurena_get_header{

		public function __construct(){
			$this->header_vars();  
			$this->html_render = 'sticky';

	   		if (assurena_Theme_Helper::options_compare('header_sticky','mb_customize_header_layout','custom') == '1') {
	   			$header_sticky_style = assurena_Theme_Helper::get_option('header_sticky_style');
	   			
	   			echo "<div class='stl-sticky-header stl-sticky-element".($this->header_type === 'default' ? ' header_sticky_shadow' : '')."'".(!empty($header_sticky_style) ? ' data-style="'.esc_attr($header_sticky_style).'"' : '').">";

	   				echo "<div class='container-wrapper'>";
	   				
	   					$this->build_header_layout('sticky');
	   				echo "</div>";

	   			echo "</div>";
	   		}
		}
	}

    new assurena_header_sticky();
}
