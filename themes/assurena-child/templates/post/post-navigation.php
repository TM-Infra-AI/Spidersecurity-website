<?php

/**
 * Template for single posts navigation section.
 *
 *
 * @author      StylusThemes
 * @subpackage  assurena
 * @since       1.0
 * @version     1.0
 */

$prevPost = get_adjacent_post(false, '', true);
$nextPost  = get_adjacent_post(false, '', false);

// Allowed HTML render
$allowed_html = [
	'a' => [
		'href' => true, 'title' => true,
		'class' => true, 'style' => true,
	],
	'br' => [],
	'b' => [],
	'em' => [],
	'strong' => [],
];


if ($nextPost || $prevPost) :

	echo '<section class="assurena-post-navigation">';

		if (is_a($prevPost, 'WP_Post') ) :
			$image_prev_url = wp_get_attachment_image_src(get_post_thumbnail_id($prevPost->ID), 'thumbnail');

            $img_prev_html = '';
            if (! empty($image_prev_url[0])){
                $img_prev_html = "<span class='image_prev'>";
                        $img_prev_html .= "<img src='". esc_url( $image_prev_url[0] ) ."' alt='". esc_attr($prevPost->post_title) ."'/>";
                $img_prev_html .= '</span>';
            }

			echo '<div class="prev-link_wrapper">',
				'<div class="info_wrapper">',
					'<a href="', esc_url(get_permalink($prevPost->ID)), '" title="', esc_attr($prevPost->post_title), '">',
						$img_prev_html,
						'<div class="prev-link-info_wrapper">',
							'<span class="meta-wrapper">',
								'<span>', esc_html__( 'Next', 'assurena' ) , '</span>',
							'</span>',
							'<h4 class="prev_title">', wp_kses( $prevPost->post_title, $allowed_html ), '</h4>',
						'</div>',
					'</a>',
				'</div>',
			'</div>';
		endif;

		if (is_a($nextPost, 'WP_Post') ) :
			$image_next_url = wp_get_attachment_image_src(get_post_thumbnail_id($nextPost->ID), 'thumbnail');

			$img_next_html = "";
            if(! empty($image_next_url[0])){
                $img_next_html = "<span class='image_next'>";
                    if (! empty($image_next_url[0])) {
                        $img_next_html .= "<img src='" . esc_url( $image_next_url[0] ) . "' alt='". esc_attr( $nextPost->post_title ) ."'/>";
                    } else {
                        $img_next_html .= "<span class='no_image_post'></span>";
                    }
                $img_next_html .= "</span>";
            }
			echo '<div class="next-link_wrapper">',
				'<div class="info_wrapper">',
					'<a href="', esc_url(get_permalink($nextPost->ID)), '" title="', esc_attr( $nextPost->post_title ), '">',
						'<div class="next-link-info_wrapper">',
							'<span class="meta-wrapper">',
								'<span>', esc_html__( 'Prev', 'assurena' ) , '</span>',
							'</span>',
							'<h4 class="next_title">', wp_kses( $nextPost->post_title, $allowed_html ), '</h4>',
						'</div>',
						$img_next_html,
					'</a>',
				'</div>',
			'</div>';
		endif;

		if (is_a($prevPost, 'WP_Post') || is_a($nextPost, 'WP_Post') ) :
			echo '<a class="back-nav_page" title="', esc_attr__( 'Back to previous page', 'assurena' ), '" onclick="location.href = document.referrer; return false;">',
				'<span></span><span></span>',
				'<span></span><span></span>',
			'</a>';
		endif;

	echo '</section>';

endif;