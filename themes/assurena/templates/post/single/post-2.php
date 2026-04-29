<?php

$single = assurena_SinglePost::getInstance();
$single->set_data();

$show_share = assurena_Theme_Helper::get_option('single_share');
$show_views = assurena_Theme_Helper::get_option('single_views');
$show_tags = assurena_Theme_Helper::get_option('single_meta_tags');
$single_author_info = assurena_Theme_Helper::get_option('single_author_info');
$single_meta = assurena_Theme_Helper::get_option('single_meta');
$hide_featured = assurena_Theme_Helper::options_compare('post_hide_featured_image', 'mb_post_hide_featured_image', '1');
$single->set_post_views(get_the_ID());

$meta_args = [];

if ( ! $single_meta ) :
	$meta_args['category'] = ! (bool)assurena_Theme_Helper::get_option('single_meta_categories');	
	$meta_args['date'] = ! (bool)assurena_Theme_Helper::get_option('single_meta_date');
	$meta_args['author'] = ! (bool)assurena_Theme_Helper::get_option('single_meta_author');
	$meta_args['comments'] = ! (bool)assurena_Theme_Helper::get_option('single_meta_comments');
endif;

?>
<article class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
	<div <?php post_class("single_meta"); ?>>
		<div class="item_wrapper">
			<div class="blog-post_content"><?php

				// Featured Image
				if ( ! $hide_featured ) {
					$single->render_featured();
				}

				
				
				echo '<div class="post_meta-wrap">';

					// Date, cats, Author, Comments
					if ( ! $single_meta ) {
						$single->render_post_meta($meta_args);
					}

					// Views
					if ( $show_views ) {
						echo '<div class="blog-post_views-wrap">', $single->get_post_views(get_the_ID()), '</div>';
					}


				echo '</div>'; // meta-wrap

				// Title
				echo '<h2 class="blog-post_title">', get_the_title(), '</h2>';

				the_content();

				wp_link_pages(
					[
						'before' => '<div class="page-link"><span class="pagger_info_text">' .esc_html__( 'Pages', 'assurena' ). ': </span>',
						'after' => '</div>'
					]
				);

				if ( ! $show_tags && has_tag() || $show_share ) :

					echo '<div class="single_post_info">';

						// Shares
						if ( $show_share && function_exists('stl_theme_helper') ) {
							echo '<div class="single_info-share_social-wpapper">',
									 stl_theme_helper()->render_post_share('yes'),
								 '</div>';
						}
						
						
						// Tags
						if ( ! $show_tags && has_tag() ) {
							the_tags('<div class="tagcloud-wrapper"><div class="tagcloud">', ' ', '</div></div>');
						}

					echo '</div>'; // post_info

				else :

					echo '<div class="post_info-divider"></div>';

				endif;

				// Author Info
				if ( $single_author_info ) $single->render_author_info();

				?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</article>
