<?php

if (!class_exists('assurena_Theme_Helper')){
    return;
}
/**
 * Class Portfolio
 * @package PostType
 */
class Portfolio
{
    /**
     * @var string
     *
     * Set post type params
     */
    private $type = 'portfolio';
    private $slug;
    private $name;
    private $singular_name;
    private $plural_name;

    /**
     * Portfolio constructor.
     *
     * When class is instantiated
     */
    public function __construct() {
        // Register the post type
        $this->name = __( 'Portfolio', 'assurena-core' );
        $this->singular_name = __( 'Item', 'assurena-core' );
        $this->plural_name = __( 'Items', 'assurena-core' );

        $this->slug = assurena_Theme_Helper::get_option('portfolio_slug') != '' ? assurena_Theme_Helper::get_option('portfolio_slug') : 'portfolio';

        add_action('init', array($this, 'register'));
        add_action('init', array($this, 'register_taxonomy'));
        add_action('init', array($this, 'register_taxonomy_tag'));
        add_action('manage_portfolio_posts_custom_column', array($this, 'column_image_thumbnail'),10,2);
        /*$this->register();
        $this->register_taxonomy();
        $this->register_taxonomy_tag();*/
        add_filter('single_template', array($this, 'get_custom_pt_single_template'));
        add_filter('archive_template', array($this, 'get_custom_pt_archive_template'));
        add_filter('manage_portfolio_posts_columns',  array($this, 'column_image_name'));
        
        add_theme_support('post-thumbnails');
    }

    /**
     * Register post type
     */
    public function register() {
        $labels = array(
            'name'               => $this->name,
            'singular_name'      => $this->singular_name,
            'add_new'            => sprintf( __('Add New %s', 'assurena-core' ), $this->singular_name ),
            'add_new_item'       => sprintf( __('Add New %s', 'assurena-core' ), $this->singular_name ),
            'edit_item'          => sprintf( __('Edit %s', 'assurena-core'), $this->singular_name ),
            'new_item'           => sprintf( __('New %s', 'assurena-core'), $this->singular_name ),
            'all_items'          => sprintf( __('All %s', 'assurena-core'), $this->plural_name ),
            'view_item'          => sprintf( __('View %s', 'assurena-core'), $this->name ),
            'search_items'       => sprintf( __('Search %s', 'assurena-core'), $this->name ),
            'not_found'          => sprintf( __('No %s found' , 'assurena-core'), strtolower($this->name) ),
            'not_found_in_trash' => sprintf( __('No %s found in Trash', 'assurena-core'), strtolower($this->name) ),
            'parent_item_colon'  => '',
            'menu_name'          => $this->name
        );
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => $this->slug ),
            'has_archive'        => true,
            'menu_position'      => 12,
            'supports'           => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'page-attributes',
                'comments'
            ),
            'menu_icon'  =>  'dashicons-images-alt2',
        );
        register_post_type( $this->type, $args );
    }

    public function register_taxonomy() {
        $category = 'category'; // Second part of taxonomy name

        $labels = array(
            'name'              => sprintf( __( '%s Categories', 'assurena-core' ), $this->name ),
            'menu_name'         => sprintf( __( '%s Categories','assurena-core' ), $this->name ),
            'singular_name'     => sprintf( __( '%s Category', 'assurena-core' ), $this->name ),
            'search_items'      => sprintf( __( 'Search %s Categories', 'assurena-core' ), $this->name ),
            'all_items'         => sprintf( __( 'All %s Categories','assurena-core' ), $this->name ),
            'parent_item'       => sprintf( __( 'Parent %s Category','assurena-core' ), $this->name ),
            'parent_item_colon' => sprintf( __( 'Parent %s Category:','assurena-core' ), $this->name ),
            'new_item_name'     => sprintf( __( 'New %s Category Name','assurena-core' ), $this->name ),
            'add_new_item'      => sprintf( __( 'Add New %s Category','assurena-core' ), $this->name ),
            'edit_item'         => sprintf( __( 'Edit %s Category','assurena-core' ), $this->name ),
            'update_item'       => sprintf( __( 'Update %s Category','assurena-core' ), $this->name ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $this->slug.'-'.$category ),
        );
        register_taxonomy( $this->type.'-'.$category, array($this->type), $args );
    }

    public function register_taxonomy_tag() { // Second part of taxonomy name

        $labels = array(
            'name' => __( 'Tags', 'assurena-core' ),
            'menu_name' => __( 'Tags','assurena-core' ),
            'singular_name' => __( 'Tag', 'assurena-core' ),
            'popular_items' => __( 'Popular Tags', 'assurena-core' ),
            'search_items' =>  __( 'Search Tag', 'assurena-core' ),
            'all_items' => __( 'All Tags','assurena-core' ),
            'parent_item' => null,
            'parent_item_colon' => null,
            'new_item_name' => __( 'New Tag Name','assurena-core' ),
            'add_new_item' => __( 'Add New Tag','assurena-core' ),
            'edit_item' => __( 'Edit Tag','assurena-core' ),
            'update_item' => __( 'Update Tag','assurena-core' ),
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'update_count_callback' => '_update_post_term_count',
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => $this->slug.'-tag' ),
        );
        register_taxonomy( $this->type.'_tag', array($this->type), $args );
    }

    // Custom column with featured image
    function column_image_name ($columns) {
        
        $array1 = array_slice($columns, 0, 1);
        $array2 = array('image' => __( 'Featured Image', 'assurena-core' ));
        $array3 = array_slice($columns, 1);

        $output = array_merge($array1, $array2, $array3);

        return $output;
    }

    function column_image_thumbnail ($column, $post_id ) {
        if ( 'image' === $column ) {
            echo get_the_post_thumbnail( $post_id, array(80, 80) );
        }
    }

    // https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
    function get_custom_pt_single_template($single_template) {
        global $post;

        if ($post->post_type == $this->type) {
            if(file_exists(get_template_directory().'/single-portfolio.php')) return $single_template;
            
            $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'portfolio/templates/single-portfolio.php';
        }
        return $single_template;
    }

    // https://codex.wordpress.org/Plugin_API/Filter_Reference/archive_template
    function get_custom_pt_archive_template($archive_template) {
        global $post;

        if ( is_post_type_archive ($this->type) || is_archive() && $post->post_type == 'portfolio' ) {
            if (file_exists(get_template_directory().'/archive-portfolio.php')) return $archive_template;

            $archive_template = plugin_dir_path( dirname( __FILE__ ) ) .'portfolio/templates/archive-portfolio.php';
        }
        return $archive_template;
    }

}