<?php

if (!class_exists('assurena_Theme_Helper')) {
    return;
}

/**
 * Class     Footer
 * @package  PostType
 */
class Footer
{
    /**
     * @var string
     *
     * Set post type params
     */
    private $type = 'footer';
    private $slug;
    private $name;
    private $plural_name;

    /**
     * Footer constructor.
     *
     * When class is instantiated
     */
    public function __construct()
    {
        $this->name = __('Footer', 'assurena-core');
        $this->slug = 'footer';
        $this->plural_name = __('Footers', 'assurena-core');

        add_action('init', [$this, 'register']);

        add_filter('single_template', [$this, 'get_custom_pt_single_template']);
    }

    /**
     * Register post type
     */
    public function register()
    {
        $labels = [
            'name' => $this->name,
            'singular_name' => $this->name,
            'add_new' => sprintf(__('Add New %s', 'assurena-core'), $this->name),
            'add_new_item' => sprintf(__('Add New %s', 'assurena-core'), $this->name),
            'edit_item' => sprintf(__('Edit %s', 'assurena-core'), $this->name),
            'new_item' => sprintf(__('New %s', 'assurena-core'), $this->name),
            'all_items' => sprintf(__('All %s', 'assurena-core'), $this->plural_name),
            'view_item' => sprintf(__('View %s', 'assurena-core'), $this->name),
            'search_items' => sprintf(__('Search %s', 'assurena-core'), $this->name),
            'not_found' => sprintf(__('No %s found', 'assurena-core'), strtolower($this->name)),
            'not_found_in_trash' => sprintf(__('No %s found in Trash', 'assurena-core'), strtolower($this->name)),
            'parent_item_colon' => '',
            'menu_name' => $this->name
        ];
        $args = [
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => ['slug' => $this->slug],
            'menu_position' =>  13,
            'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
            'menu_icon' => 'dashicons-admin-page',
        ];
        register_post_type($this->type, $args);
    }

    public function wrapper_footer_open()
    {
        global $post;

        if ($post->post_type == $this->type) {
            echo '<footer class="footer clearfix" id="footer">';
                echo '<div class="footer_top-area">';
                    echo '<div class="stl-container">';
                        echo '<div class="row-footer">';
        }
    }

    public function wrapper_footer_close()
    {
        global $post;

        if ($post->post_type == $this->type) {
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</footer>';
        }
    }

    // https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
    function get_custom_pt_single_template($single_template)
    {
        global $post;

        if ($post->post_type == $this->type) {

            if (defined('ELEMENTOR_PATH')) {
                $elementor_template = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

                if ( file_exists( $elementor_template ) ) {
                    add_action( 'elementor/page_templates/canvas/before_content', [$this, 'wrapper_footer_open']);
                    add_action( 'elementor/page_templates/canvas/after_content', [$this, 'wrapper_footer_close']);
                    return $elementor_template;
                }
            }

            if (file_exists(get_template_directory() . '/single-footer.php')) return $single_template;

            $single_template = plugin_dir_path(dirname(__FILE__)) . 'footer/templates/single-footer.php';

        }
        return $single_template;
    }
}
