<?php

global $stl_blog_atts;

// Default settings for blog item
$trim = true;
if (!$stl_blog_atts) {
	$opt_letter_count = assurena_Theme_Helper::get_option('blog_list_letter_count');
	$opt_blog_columns = assurena_Theme_Helper::get_option('blog_list_columns');

	global $wp_query;
	$stl_blog_atts = [
		'query' => $wp_query,
		// General
		'blog_layout' => 'grid',
		// Content
		'blog_columns' => empty($opt_blog_columns) ? '12' : $opt_blog_columns,
		'hide_media' => assurena_Theme_Helper::get_option('blog_list_hide_media'),
		'hide_content' => assurena_Theme_Helper::get_option('blog_list_hide_content'),
		'hide_blog_title' => assurena_Theme_Helper::get_option('blog_list_hide_title'),
		'hide_postmeta' => assurena_Theme_Helper::get_option('blog_list_meta'),
		'meta_author' => assurena_Theme_Helper::get_option('blog_list_meta_author'),
		'meta_comments' => assurena_Theme_Helper::get_option('blog_list_meta_comments'),
		'meta_categories' => assurena_Theme_Helper::get_option('blog_list_meta_categories'),
		'meta_date' => assurena_Theme_Helper::get_option('blog_list_meta_date'),
		'hide_share' => !assurena_Theme_Helper::get_option('blog_list_share'),
		'read_more_hide' => assurena_Theme_Helper::get_option('blog_list_read_more'),
		'content_letter_count' => empty($opt_letter_count) ? '85' : $opt_letter_count,
		'crop_square_img' => 'true',
		'heading_tag' => 'h3',
		'read_more_text' => esc_html__('Read More', 'assurena'),
		'items_load'  => 4,
		'heading_margin_bottom' => '16px',
	];
	$trim = false;
}

extract($stl_blog_atts);

$image_size = 'full';
if ($crop_square_img && $blog_columns !== '12') {
	$image_size = 'assurena-840-620';
}

global $stl_query_vars;
if (!empty($stl_query_vars)) {
	$query = $stl_query_vars;
}

// Allowed HTML render
$allowed_html = [
	'a' => [
		'href' => true,
		'title' => true,
	],
	'br' => [],
	'b' => [],
	'em' => [],
	'strong' => []
];

$heading_attr = isset($heading_margin_bottom) && $heading_margin_bottom != '' ? ' style="margin-bottom: ' . (int) $heading_margin_bottom . 'px"' : '';

while ($query->have_posts()) : $query->the_post();

	echo '<div class="stl_col-' . esc_attr($blog_columns) . ' item">';

	$single = assurena_SinglePost::getInstance();
	$single->set_data();

	$pf = $single->get_pf();
	$blog_item_classes = ' format-' . $pf;

	$blog_item_classes .= $hide_media ? ' hide_media' : '';
	$blog_item_classes .= is_sticky() ? ' sticky-post' : '';

	$single->set_data_image(true, $image_size, $aq_image = true);

	$has_media = $single->meta_info_render;
	if ($hide_media) $has_media = false;

	$blog_item_classes .= !$has_media ? ' format-no_featured' : '';
	$shares_condition = $pf == 'standard' && !$has_media;

	$meta_args['category'] = !$meta_categories;
	$meta_args['author'] = !$meta_author;
	$meta_args['comments'] = !$meta_comments;


	// Build the structure
	echo '<div class="blog-post', esc_attr($blog_item_classes), '">';
	echo '<div class="blog-post_wrapper">';
	

	if (!$meta_date) {
					echo '<span class="post_date post_date_grid">',
                        the_time('<\s\p\a\n>d</\s\p\a\n> M'),
					'</span>';
				}

	// Media
	if (!$hide_media) {
		$single->render_featured(true, $image_size, true, false);
	}


	// Shares (absoolute relative to wrapper)
	if ($shares_condition && !$hide_share && function_exists('stl_theme_helper')) {
		echo stl_theme_helper()->render_post_list_share();
	}

	echo '<div class="blog-post_content">';

	// Shares (absoolute relative to post_content)
	if (!$shares_condition && !$hide_share && function_exists('stl_theme_helper')) {
		echo stl_theme_helper()->render_post_list_share();
	}

	// Date, Author, Comments
	echo '<div class="post_meta-wrap">';
	if (!$hide_postmeta) {
		$single->render_post_meta($meta_args);
	}
	echo '</div>'; // meta-wrap

	// Blog Title
	if (!$hide_blog_title && !empty($title = get_the_title())) {
		printf('<%1$s class="blog-post_title"%2$s><a href="%3$s">%4$s</a></%1$s>', esc_html($heading_tag), $heading_attr, esc_url(get_permalink()), wp_kses($title, $allowed_html));
	}

	// Content Blog
	if (!$hide_content) {
		$single->render_excerpt($content_letter_count, $trim, !$read_more_hide, $read_more_text);
	}

	// Read more
	if (!$read_more_hide) {
		echo '<div class="read-more-wrap">',
			'<a href="', esc_url(get_permalink()), '" class="button-read-more">',
			esc_html($read_more_text),
            ' <i class="fa fa-arrow-right"></i>',
			'</a>',
			'</div>';
	}

	wp_link_pages(
		[
			'before' => '<div class="page-link">' . esc_html__('Pages', 'assurena') . ': ',
			'after' => '</div>'
		]
	);

	echo '</div>'; // post_content
	echo '</div>'; // post_wrapper
	echo '</div>'; // blog-post
	echo '</div>'; // item

endwhile;
wp_reset_postdata();
