<?php
/**
 * Template Name: Full Width Page
*/

get_header();
the_post();
$sb = assurena_Theme_Helper::render_sidebars();
$row_class = $sb['row_class'];
$column = $sb['column'];
$container_class = $sb['container_class'];
?>
    <div class="stl-container full-width">
        <div class="row<?php echo apply_filters('assurena_row_class', $row_class); ?>">
            <div id='main-content' class="stl_col-<?php echo apply_filters('assurena_column_class', $column); ?>">
            <?php
                the_content(esc_html__('Read more!', 'assurena'));
                wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'assurena') . ': ', 'after' => '</div>'));
                

                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif; ?>
            </div>
            <?php
                echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
            ?>           
        </div>
     
    </div>

	<?php

get_footer(); 

?>