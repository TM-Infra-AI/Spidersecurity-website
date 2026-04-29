<?php

/**
 * The template for displaying 404 page
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package    WordPress
 * @subpackage assurena
 * @since      1.0
 * @version    1.0.3
 */


get_header();

$main_bg_color = assurena_Theme_Helper::get_option('404_page_main_bg_image')['background-color'];
$bg_render = assurena_Theme_Helper::bg_render('404_page_main');

$styles = !empty($main_bg_color) ? 'background-color: ' . $main_bg_color . ';' : '';
$styles .= $bg_render ?: '';
$styles = $styles ? ' style="' . esc_attr($styles) . '"' : '';
?>
<div class="stl-container full-width">
  <div class="row">
    <div class="stl_col-12">
      <section class="page_404_wrapper" <?php echo \assurena_Theme_Helper::render_html($styles); ?>>
        <div class="page_404_wrapper-container">
          <div class="row">
            <div class="stl_col-12 stl_col-md-12">
              <div class="main_404-wrapper">
                <h2 class="banner_404_title"><span><?php echo esc_html__('Error! 404', 'assurena'); ?></span></h2>
                <p class="banner_404_text"><?php echo esc_html__('Sorry, we could not find the page you are looking for.', 'assurena'); ?></p>
                <div class="assurena_404_search">
                  <?php get_search_form(); ?>
                </div>
                <div class="assurena_404__button">
                  <a class="assurena_404__link stl-button" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php esc_html_e('Back to Homepage', 'assurena'); ?>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<?php get_footer();
