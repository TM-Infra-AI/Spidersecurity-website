<?php

if (! class_exists('assurena_Theme_Helper')) {
	return;
}

use stlAddons\Templates\stlPortfolio;

get_header();


$term_id = isset(get_queried_object()->term_id) ? get_queried_object()->term_id : '';
$term_id = ! empty($term_id) ? $term_id : '';

//Show Filter Options
$show_filter = assurena_Theme_Helper::get_option('portfolio_list_show_filter');
$list_terms =  assurena_Theme_Helper::get_option('portfolio_list_filter_cats');

if (! empty($term_id)) {
	$show_filter = '';
}

if (! empty($show_filter) && ! empty($list_terms)) {
	$term_id = $list_terms;
}
$term_slug = [];
$cat_title = $cat_descr = '';
if (! empty($term_id)) {
	$return = '';
	if (is_array($term_id)) {
		$count = count($term_id);
		$i = 0;
		foreach ($term_id as $value) {
			$item = get_term_by( 'id', (int) $value, 'portfolio-category' ); 
			$i++;
			$return .= 'portfolio-category:'. $item->slug . ($i !== $count ? ', ' : '');
		}
	} else {
		$return = get_term_by( 'id', $term_id, 'portfolio-category' ); 
		$return = "portfolio-category:".$return->slug;
	}
	$term_slug[] = $return;
	$cat = get_term_by( 'id', (int) $term_id, 'portfolio-category' );
	$cat_title = $cat->name;
	$cat_descr = $cat->description;
}

$defaults = [
	'add_animation' => null,
	'navigation' => 'pagination',
	'nav_align' => 'center',
	'click_area' => 'single',
	'posts_per_row' => assurena_Theme_Helper::get_option('portfolio_list_columns'),
	'show_portfolio_title' => assurena_Theme_Helper::get_option('portfolio_list_show_title'),
	'show_content' => assurena_Theme_Helper::get_option('portfolio_list_show_content'),
	'show_meta_categories' => assurena_Theme_Helper::get_option('portfolio_list_show_cat'),
	'show_filter' => $show_filter,
	'crop_images' => 'yes',
	'items_load' => '4',
	'grid_gap' => '30px',
	'add_overlay' => 'true',
	'portfolio_layout' => 'masonry',
	'custom_overlay_color' => 'rgba(34,35,40,.7)',
	'number_of_posts' => '12',
	'order_by' => 'menu_order',
	'order' => 'DSC',
	'post_type' => 'portfolio',
	'taxonomies' => $term_slug,
	'info_position' => 'inside_image',
	'image_anim' => 'simple',
	'img_click_action' => 'single',
	'single_link_title' => 'yes',
	'gallery_mode' => false,
	'portfolio_icon_type' => '',
	'portfolio_icon_pack' => '',
];
extract($defaults);

$sb = assurena_Theme_Helper::render_sidebars('portfolio_list');
$row_class = $sb['row_class'];
$column = $sb['column'];
$container_class = $sb['container_class'];


?>
<div class="stl-container<?php echo apply_filters('assurena_container_class', $container_class); ?>">
	<div class="row<?php echo apply_filters('assurena_row_class', $row_class); ?>">
		<div id='main-content' class="stl_col-<?php echo apply_filters('assurena_column_class', $column); ?>">
			<?php
			if (! empty($term_id)) {
				echo '<div class="portfolio_archive-cat">',
					'<h4 class="portfolio_archive-cat_title">',
						esc_html__('Category:', 'assurena-core'),
						' ',
						esc_html($cat_title),
					'</h4>',
					'<div class="portfolio_archive-cat_descr">',
						esc_html($cat_descr),
					'</div>';
				'</div>';
			}
			$portfolio_render = new stlPortfolio();
			echo $portfolio_render->render($defaults);
			?>
		</div>
		<?php
			echo (isset($sb['content']) && ! empty($sb['content']) ) ? $sb['content'] : '';
		?>
	</div>
</div>
	
<?php get_footer(); ?>
