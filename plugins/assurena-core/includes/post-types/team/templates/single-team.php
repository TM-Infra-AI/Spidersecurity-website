<?php

use stlAddons\Templates\stlTeam;

$sb = assurena_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
$container_class = $sb['container_class'];

$defaults = [
	'title' => '',
	'posts_per_line' => '2',
	'grid_gap' => '',
	'info_align' => 'center',
	'single_link_wrapper' => false,
	'single_link_heading' => true,
	'hide_title' => false,
	'hide_meta' => false,
	'hide_soc_icons' => false,
	'grayscale_anim' => false,
	'info_anim' => false,
];
extract($defaults);

$team_image_dims = ['width' => '960', 'height' => '1000']; // ratio = 0.96


// Render
get_header();

echo '<div class="stl-container', apply_filters('assurena_container_class', $container_class),'">';
	echo '<div class="row', esc_attr($row_class), '">';
		echo '<div id="main-content" class="stl_col-', apply_filters('assurena_column_class', $column), '">';

			while ( have_posts() ) : the_post();
				$item = new stlTeam();

				echo '<div class="row single_team_page">',
					'<div class="stl_col-12">',
						$item->render_stl_team_item(true, $defaults, $team_image_dims, false),
					'</div>',
					'<div class="stl_col-12">',
						the_content( esc_html__('Read more!', 'assurena') ),
					'</div>',
				'</div>';
			endwhile;
			wp_reset_postdata();

		echo '</div>';

		// Sidebar
		echo ! empty($sb['content']) ? $sb['content'] : '';

	echo '</div>';
echo '</div>';

get_footer();
