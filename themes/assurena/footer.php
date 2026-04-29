<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #main div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage assurena
 * @since 1.0
 * @version 1.0
 */
global $assurena_dynamic_css;

$scroll_up = assurena_Theme_Helper::get_option('scroll_up');
$scroll_up_as_text = assurena_Theme_Helper::get_option('scroll_up_appearance');
$scroll_up_text = assurena_Theme_Helper::get_option('scroll_up_text');


?>
	</main>
	<?php
		get_template_part('templates/section', 'footer');

		if ($scroll_up) {
			echo '<a href="#" id="scroll_up">',
				$scroll_up_as_text ? $scroll_up_text : '',
			'</a>';
		}

		if (isset($assurena_dynamic_css['style']) && ! empty($assurena_dynamic_css['style'])) {
			echo '<span id="assurena-footer-inline-css" class="dynamic_styles-footer" style="display: none;">',
				assurena_Theme_Helper::render_html($assurena_dynamic_css['style']),
			'</span>';
		}

		wp_footer();
  ?>    
</body>
</html>