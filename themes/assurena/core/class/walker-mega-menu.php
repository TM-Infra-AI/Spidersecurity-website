<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* assurena Mega Menu Walker
*
*
* @class        assurena_Mega_Menu_Waker
* @version      1.1
* @category Class
* @author       StylusThemes
*/

if( ! class_exists( 'assurena_Mega_Menu_Waker' )){

    class assurena_Mega_Menu_Waker extends Walker_Nav_Menu {

        public function style_helper(){
            $style = '';

            if(!empty($this->stl_megamenu_background_image)){
                $style .= "background-image:url(".esc_attr($this->stl_megamenu_background_image).");";
                
                if(!empty($this->stl_megamenu_background_repeat)){
                    $style .= "background-repeat:".esc_attr($this->stl_megamenu_background_repeat).";";
                }
                if(!empty($this->stl_megamenu_background_pos_x)){
                    $style .= "background-position-x:".esc_attr($this->stl_megamenu_background_pos_x).";";
                }
                if(!empty($this->stl_megamenu_background_pos_y)){
                    $style .= "background-position-y:".esc_attr($this->stl_megamenu_background_pos_y).";";
                }            
            }

            if(!empty($this->stl_megamenu_min_height)){
                $style .= "min-height:".esc_attr((int) $this->stl_megamenu_min_height)."px;";
            }            

            if(!empty($this->stl_megamenu_width)){
                $style .= "max-width:".esc_attr((int) $this->stl_megamenu_width)."px;";
            }            

            if(!empty($this->stl_megamenu_padding_left)){
                $style .= "padding-left:".esc_attr((int) $this->stl_megamenu_padding_left)."px;";
            }            
            if(!empty($this->stl_megamenu_padding_right)){
                $style .= "padding-right:".esc_attr((int) $this->stl_megamenu_padding_right)."px;";
            }

            $style = !empty($style) ? " style='".$style."'" : "";
            return $style;
        }

        public function start_lvl( &$output, $depth = 0, $args = array() ){
            $indent = str_repeat("\t", $depth);

            switch (true) {
                case $depth === 0 && $this->stl_megamenu_enable == 'links':
                    $output .= "$indent<ul class=\"stl-mega-menu mega-menu sub-menu sub-menu-columns\"".$this->style_helper().">";
                    break;                
                case $depth === 1 && $this->stl_megamenu_enable == 'links' :
                    $output .= "$indent<ul class=\"stl-mega-menu mega-menu sub-menu sub-menu-columns_item\">";
                    break;                
                case $depth === 0 && ( $this->stl_megamenu_enable == 'sub-menu-vertical-cats' || $this->stl_megamenu_enable == 'sub-menu-horizontal-cats' ):
                    $output .= "$indent<ul class=\"stl-mega-menu mega-menu sub-menu\"".$this->style_helper().">";
                    break; 
                default:
                    $output .= "$indent<ul class=\"sub-menu\">";
                    break;
            }
        }


        /**
         * Ends the list of after the elements are added.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ){
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }

        /**
         * Check Active Mega Menu
         * @return void
         */
        public function check_mega_menu_activate($depth){
            return $depth === 0 && ! empty( $this->stl_megamenu_enable ) && $this->stl_megamenu_enable != 'disable';
        }        

        /**
        * Check Active Mega Menu Cat Filters
        * @return void
        */
        public function check_mega_menu_categories($item){
            return ( $this->stl_megamenu_enable == 'sub-menu-vertical-cats' || $this->stl_megamenu_enable == 'sub-menu-horizontal-cats' ) &&  $item->object == 'category';
        }
        /**
         * Start the element output.
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){  
            $indent    = ( $depth ) ? str_repeat( "\t", $depth ) : '';
            $class_names = $value = '';

            $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( " " , apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            $item_output = '';
            $data_attr = '';
            
            if( $depth === 0 ){ 
                //Check If Enabled
                $this->stl_megamenu_enable = get_post_meta( $item->ID, 'stl_megamenu_enable', true );
                
                if($this->stl_megamenu_enable !== ''){
                    $array = array('columns', 'ajax_loading', 'posts_count', 'min_height', 'width', 'padding_left', 'padding_right', 'hide_headings', 'background_image', 'background_repeat', 'background_pos_x', 'background_pos_y');
                    foreach ($array as $key => $value) {
                        $this->{'stl_megamenu_'.$value} = get_post_meta( $item->ID, 'stl_megamenu_'.$value, true );
                    }
                }
            }

            if( $this->check_mega_menu_activate($depth) ){
                $class_names .= ' mega-menu';

                if( $this->check_mega_menu_categories($item) ){

                    $class_names .= ' mega-cat ';
                    if( ! empty( $item->object_id ) ){
                        $data_attr = " data-id='".$item->object_id."'";
                        $this->stl_megamenu_posts_count = !empty($this->stl_megamenu_posts_count) ? $this->stl_megamenu_posts_count : 4;
                        $data_attr .= " data-posts-count='".$this->stl_megamenu_posts_count."'";
                    }
                    $columns     = ( ! empty( $this->stl_megamenu_columns ) ? $this->stl_megamenu_columns :  1 );
                    $class_names  .= ' mega-columns-'.$columns.'col ';

                }
                elseif( $this->stl_megamenu_enable == 'links' ){

                    $columns     = ( ! empty( $this->stl_megamenu_columns ) ? $this->stl_megamenu_columns :  1 );
                    $class_names  .= ' mega-menu-links mega-columns-'.$columns.'col ';
                }
            }

            if( $depth === 1 && $this->stl_megamenu_enable == 'links' ){
                if( ! empty( $this->stl_megamenu_hide_headings ) ){
                    $class_names .= ' hide-mega-headings';
                }
            }

            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent.'<li'. $id.$class_names.$data_attr.'>';

            $atts = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
            $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ){
                if ( ! empty( $value ) ){
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            if( ! empty( $args->before ) ){
                $item_output = $args->before;
            }

            $item_output .= '<a' . $attributes .'>';

            $menu_item = apply_filters( 'the_title', $item->title, $item->ID );

			$item_output .= $args->link_before . $menu_item . $args->link_after;
			$item_output .= '<i class="menu-item__plus"></i>';
			$item_output .= '</a>'; 
			$item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
        
        /**
         * @return array
         */
        public function get_term_link( $term, $tax = null ){
            if ( empty( $term ) ) {
                return;
            }

            return get_term_link( $term, $tax );

        }

        public function get_category_id($id){
            if(function_exists('icl_object_id')) {
                return icl_object_id( $id, 'category', true);
            } else {
                return $id;
            }
        }

        public function end_el( &$output, $item, $depth = 0, $args = array() ){

            if( $this->check_mega_menu_activate($depth) ){

                if( $this->check_mega_menu_categories($item) ){

                    $class = '';
                    $has_cat = true;

                    $query_args = array(
                        'child_of'  => $this->get_category_id($item->object_id),
                    );
                    
                    $sub_cat = get_categories( $query_args );

                    if( count($sub_cat) == 0){
                        $has_cat  = false ;
                    }
                    
                    $class .= $this->stl_megamenu_enable == 'sub-menu-horizontal-cats' ? ' horizontal-posts' : ' vertical-posts';
                    
                    $container_class = $this->stl_megamenu_enable == 'sub-menu-horizontal-cats' ? ' cats-horizontal-wrapper' : ' cats-vertical-wrapper';
                    $cat_type     = $this->stl_megamenu_enable == 'sub-menu-horizontal-cats' ? ' cats-horizontal' : ' cats-vertical';

                    $output .= "<div class='stl-mega-menu mega-menu-container".esc_attr($container_class)."'".$this->style_helper().">";

                    $cats = array();
                    if((bool) $has_cat ){
                        
                        $output .= "<ul class='mega-menu sub-menu mega-cat-sub-categories".esc_attr($cat_type)."'>";
                        
                        $this->stl_megamenu_posts_count = !empty($this->stl_megamenu_posts_count) ? $this->stl_megamenu_posts_count : "";
                        
                        $output .= "<li class='menu-item is-active is-uploaded' data-id='".esc_attr($item->object_id)."' data-posts-count='".esc_attr($this->stl_megamenu_posts_count)."'><a href='#' class='mega-sub-menu-cat'><span>". esc_html__( 'All', 'assurena' ) ."<span class='arrow'></span></span></a></li>";
                        
                        $cats[] = $this->get_category_id($item->object_id);
                        foreach( $sub_cat as $category ){
                            $cat_link = $this->get_term_link( $category->term_id, 'category' );
                            $output  .= "<li class='menu-item".(empty($this->stl_megamenu_ajax_loading) ? " is-uploaded" : '') ."' data-id='".$category->term_id."' data-posts-count='".esc_attr($this->stl_megamenu_posts_count)."'><a href='".esc_url($cat_link)."' class='mega-sub-menu-cat'><span>".$category->name."<span class='arrow'></span></span></a></li>";

                            $cats[] = $this->get_category_id($category->term_id);
                        }

                        $output .=  "</ul>";
                    }
                    $output .= "<div class='mega-cat-content".esc_attr($class)."'>";
                        $output .= "<div class='blog-style-standard'>";
                            
                            $output .= "<div class='mega-ajax-content'>";
                                
                                if(empty($this->stl_megamenu_ajax_loading)){
                                    foreach ($cats as $key => $value) {
                                        
                                        $query_args = array();
                                        $query_args['cat'] = $value;
                                        $query_args['order'] = 'DESC';
                                        $query_args['orderby'] = 'date';
                                        $query_args['post_status'] = 'publish';
                                        $query_args['posts_per_page'] = $this->stl_megamenu_posts_count;

                                        $query_args['no_found_rows'] = true;

                                        $query = assurena_Theme_Cache::cache_query($query_args); 
                                        $stl_def_atts = array(
                                            'query' => $query,
                                        );      

                                        global $stl_blog_atts;
                                        $stl_blog_atts = $stl_def_atts;
                                        
                                        ob_start();

                                            get_template_part('templates/post/post', 'mega_menu');
                                         
                                        $mega_menu_cat_items = ob_get_clean();
                                         
                                        $output .= '<div class="ajax_menu" style="display: none;" data-url="'.$value.'">';
                                            $output .= $mega_menu_cat_items;
                                        $output .= '</div>';
                                        unset($GLOBALS["stl_blog_atts"]);
                                        
                                    }
                                }

 
                            $output .= "</div>";

                        $output .= "</div>";
                    $output .= "</div>";
                }
                
                if( $this->stl_megamenu_enable != 'links' ){
                    $output .= "</div>";
                }
            }

            $output .= "</li>";
        }

    } // Walker_Nav_Menu

    /*-----------------------------------------------------------------------------------*/
    /* StylusThemes menu fields
    /*-----------------------------------------------------------------------------------*/
    add_action( 'wp_nav_menu_item_custom_fields', 'assurena_add_megamenu_fields', 10, 4 );
    function assurena_add_megamenu_fields( $item_id, $item, $depth, $args ){
        
        ?>
    
        <div class="clear"></div>
        <div style="margin-top: 20px;">
            <strong><?php esc_html_e( 'assurena Mega Menu Settings:', 'assurena' ); ?></strong> 
            <em><?php esc_html_e( '(Only for Main Menu)', 'assurena' ); ?></em>
        </div>
        <div class="clear"></div>
        
        <div class='stl_accordion_wrapper collapsible close widget_class'>
            <div class='stl_accordion_heading'>
                <span class='stl_accordion_title'><?php esc_html_e( 'stl Mega Menu Settings', 'assurena' ); ?></span>
                <span class='stl_accordion_button'></span>
            </div>
        <div class='stl_accordion_body' style='display: none'>
            <div class="stl-mega-menu_wrapper">
                <p class="description description-wide field-megamenu-enable">
                    <label for="edit-menu-item-megamenu-enable-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Enable The stl Mega Menu?', 'assurena' ); ?>
                        <select id="edit-menu-item-megamenu-enable-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-enable" name="menu-item-stl-megamenu-enable[<?php echo esc_attr( $item_id ) ?>]">
                            <option value=""><?php esc_attr_e( 'Disable', 'assurena' ); ?></option>
                            <?php  if( $item->object == 'category' ){  ?>
                            <option value="sub-menu-vertical-cats" <?php selected( $item->stl_megamenu_enable, 'sub-menu-vertical-cats' ); ?>><?php esc_html_e( ' Vertical Sub-Categories', 'assurena' ); ?></option>
                            <option value="sub-menu-horizontal-cats" <?php selected( $item->stl_megamenu_enable, 'sub-menu-horizontal-cats' ); ?>><?php esc_html_e( 'Horizontal Sub-Categories', 'assurena' ); ?></option>
                            <?php } ?>
                            <option value="links" <?php selected( $item->stl_megamenu_enable, 'links' ); ?>><?php esc_html_e( 'Mega Menu Columns', 'assurena' ); ?></option>
                        </select>
                    </label>
                </p>

                <?php if( $item->object == 'category' ){  ?>              
                    <p class="description description-wide field-megamenu-posts-count">
                        <label for="edit-menu-item-megamenu-posts-count-<?php echo esc_attr( $item_id ) ?>">
                            <?php esc_html_e( 'Posts Count', 'assurena' ); ?>
                            <input type="text" id="edit-menu-item-megamenu-posts-count-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-stl-megamenu-posts-count[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_html($item->stl_megamenu_posts_count); ?>">
                        </label>
                    </p>               
                <?php } ?>                

                <?php if( $item->object == 'category' ){  ?>              
                    <p class="description description-wide field-megamenu-ajax-loading">
                        <label for="edit-menu-item-megamenu-ajax-loading-<?php echo esc_attr( $item_id ) ?>">
                            <?php esc_html_e( 'Ajax Loading?', 'assurena' );?>
                            <input type="checkbox" id="edit-menu-item-megamenu-ajax-loading-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-ajax-loading" name="menu-item-stl-megamenu-ajax-loading[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->stl_megamenu_ajax_loading, 'true' ); ?>>
                        </label>
                    </p>             
                <?php } ?>

                <p class="description description-wide field-megamenu-columns">
                    <label for="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Number of Mega Menu Columns', 'assurena' ); ?>
                        <select id="edit-menu-item-megamenu-columns-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-columns" name="menu-item-stl-megamenu-columns[<?php echo esc_attr( $item_id ) ?>]">
                            <option value=""></option>
                            <option value="2" <?php selected( $item->stl_megamenu_columns, '2' ); ?>>2</option>
                            <option value="3" <?php selected( $item->stl_megamenu_columns, '3' ); ?>>3</option>
                            <option value="4" <?php selected( $item->stl_megamenu_columns, '4' ); ?>>4</option>
                            <option value="5" <?php selected( $item->stl_megamenu_columns, '5' ); ?>>5</option>
                        </select>
                    </label>
                </p>

                <p class="description description-wide field-megamenu-background-image col-6">
                    <label for="edit-menu-item-megamenu-background-image-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Image', 'assurena' );?>
                        <input type="text" class="assurena_media_url widefat code edit-menu-item-megamenu-background-image" name="menu-item-stl-megamenu-background-image[<?php echo esc_attr( $item_id ) ?>]" id="edit-menu-item-megamenu-background-image-<?php echo esc_attr( $item_id ) ?>" value="<?php echo esc_attr($item->stl_megamenu_background_image); ?>">    
                    </label>
                    <a href="#" class="button assurena_media_upload"><?php esc_html_e('Upload', 'assurena'); ?></a>
                </p>

                <p class="description description-wide field-megamenu-background-repeat col-6">
                    <label for="edit-menu-item-megamenu-background-repeat-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Repeat', 'assurena' ); ?>
                        <select id="edit-menu-item-megamenu-background-repeat-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-repeat" name="menu-item-stl-megamenu-background-repeat[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="no-repeat" <?php selected( $item->stl_megamenu_background_repeat, 'no-repeat' ); ?>><?php esc_html_e( 'No Repeat', 'assurena' ); ?></option>
                            <option value="repeat" <?php selected( $item->stl_megamenu_background_repeat, 'repeat' ); ?>><?php esc_html_e( 'Repeat', 'assurena' ); ?></option>
                            <option value="repeat-x" <?php selected( $item->stl_megamenu_background_repeat, 'repeat-x' ); ?>><?php esc_html_e( 'Repeat X', 'assurena' ); ?></option>
                            <option value="repeat-y" <?php selected( $item->stl_megamenu_background_repeat, 'repeat-y' ); ?>><?php esc_html_e( 'Repeat Y', 'assurena' ); ?></option>
                        </select>
                    </label>
                </p>     
                <div class="clear"></div>
                <p class="description description-wide field-megamenu-background-pos-x col-6">
                    <label for="edit-menu-item-megamenu-background-pos-x-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Position X', 'assurena' ); ?>
                        <select id="edit-menu-item-megamenu-background-pos-x-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-pos-x" name="menu-item-stl-megamenu-background-pos-x[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="right" <?php selected( $item->stl_megamenu_background_pos_x, 'right' ); ?>><?php esc_html_e( 'Right', 'assurena' ); ?></option>
                            <option value="center" <?php selected( $item->stl_megamenu_background_pos_x, 'center' ); ?>><?php esc_html_e( 'Center', 'assurena' ); ?></option>
                            <option value="left" <?php selected( $item->stl_megamenu_background_pos_x, 'left' ); ?>><?php esc_html_e( 'Left', 'assurena' ); ?></option>
                        </select>
                    </label>
                </p>            

                <p class="description description-wide field-megamenu-background-pos-y col-6">
                    <label for="edit-menu-item-megamenu-background-pos-y-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Background Position Y', 'assurena' ); ?>
                        <select id="edit-menu-item-megamenu-background-pos-y-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-background-pos-y" name="menu-item-stl-megamenu-background-pos-y[<?php echo esc_attr( $item_id ) ?>]">
                            <option value="top" <?php selected( $item->stl_megamenu_background_pos_y, 'top' ); ?>><?php esc_html_e( 'Top', 'assurena' ); ?></option>
                            <option value="center" <?php selected( $item->stl_megamenu_background_pos_y, 'center' ); ?>><?php esc_html_e( 'Center', 'assurena' ); ?></option>
                            <option value="bottom" <?php selected( $item->stl_megamenu_background_pos_y, 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'assurena' ); ?></option>
                        </select>
                    </label>
                </p>
                <div class="clear"></div>
                <p class="description description-wide field-megamenu-min-height col-6">
                    <label for="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Min Height', 'assurena' ); 
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-min-height-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-stl-megamenu-min-height[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->stl_megamenu_min_height); ?>">
                    </label>
                </p>            

                <p class="description description-wide field-megamenu-width col-6">
                    <label for="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Max Width', 'assurena' ); 
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-width-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-stl-megamenu-width[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->stl_megamenu_width); ?>">
                    </label>
                </p>           
                 <div class="clear"></div>
                 <p class="description description-wide field-megamenu-padding-left col-6">
                    <label for="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Padding Left', 'assurena' ); 
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-padding-left-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-stl-megamenu-padding-left[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->stl_megamenu_padding_left); ?>">
                    </label>
                </p>            
                <p class="description description-wide field-megamenu-padding-right col-6">
                    <label for="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>">
                        <?php esc_html_e( 'Padding Right', 'assurena' ); 
                        ?>
                        <input type="text" id="edit-menu-item-megamenu-padding-right-<?php echo esc_attr( $item_id ) ?>"  class="input-sortable widefat code edit-menu-item-custom" name="menu-item-stl-megamenu-padding-right[<?php echo esc_attr( $item_id ) ?>]" value="<?php echo esc_attr($item->stl_megamenu_padding_right); ?>">
                    </label>
                </p>
                <div class="clear"></div>
                <?php if( $item->object != 'category' ){  ?>  
                    <p class="description description-wide field-megamenu-hide-headings">
                        <label for="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>">
                            <?php esc_html_e( 'Hide Mega Menu Headings?', 'assurena' );?>
                            <input type="checkbox" id="edit-menu-item-megamenu-hide-headings-<?php echo esc_attr( $item_id ) ?>" class="widefat code edit-menu-item-megamenu-hide-headings" name="menu-item-stl-megamenu-hide-headings[<?php echo esc_attr( $item_id ) ?>]" value="true" <?php checked( $item->stl_megamenu_hide_headings, 'true' ); ?>>
                        </label>
                    </p>
                 <?php } ?>
            </div>
        </div>
        </div>
    <?php }

    add_action('wp_update_nav_menu_item', 'assurena_custom_nav_update', 10, 3);
    function assurena_custom_nav_update( $menu_id, $menu_item_db_id, $menu_item_data = array() ){

        $fields = assurena_mega_menu_fields();

        foreach( $fields as $field ){
            
            $save   = str_replace( 'menu-item-stl-megamenu-', 'stl_megamenu_', $field);
            $save   = str_replace( '-', '_', $save);

            // Sanitize.
            if ( ! empty( $_POST[ $field ][ $menu_item_db_id ] ) ) {
                $val = sanitize_text_field($_POST[ $field ][ $menu_item_db_id ]);
                update_post_meta( $menu_item_db_id, $save, $val );
            } else {
                delete_post_meta( $menu_item_db_id, $save );
            }

        }

    }

    if (!function_exists('assurena_mega_menu_fields')) {
        
        function assurena_mega_menu_fields(){
            
            return array(
                'menu-item-stl-megamenu-enable',
                'menu-item-stl-megamenu-columns',
                'menu-item-stl-megamenu-ajax-loading',
                'menu-item-stl-megamenu-posts-count',
                'menu-item-stl-megamenu-min-height',
                'menu-item-stl-megamenu-width',
                'menu-item-stl-megamenu-padding-left',
                'menu-item-stl-megamenu-padding-right',
                'menu-item-stl-megamenu-hide-headings',
                'menu-item-stl-megamenu-background-image',
                'menu-item-stl-megamenu-background-repeat',
                'menu-item-stl-megamenu-background-pos-x',
                'menu-item-stl-megamenu-background-pos-y',
            );
        }
    }

    add_filter( 'wp_edit_nav_menu_walker', 'assurena_custom_nav_edit_walker',10,2 );
    function assurena_custom_nav_edit_walker($walker,$menu_id){
        return 'assurena_Mega_Menu_Edit_Walker';
    }

    /**
     * Navigation Menu API: Walker_Nav_Menu_Edit class
     *
     * @package WordPress
     * @subpackage Administration
     * @since 4.4.0
     */

    /**
     * Create HTML list of nav menu input items.
     *
     * @since 3.0.0
     *
     * @see Walker_Nav_Menu
     */
    class assurena_Mega_Menu_Edit_Walker extends Walker_Nav_Menu {
        /**
         * Starts the list before the elements are added.
         *
         * @see Walker_Nav_Menu::start_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         */
        public function start_lvl( &$output, $depth = 0, $args = array() ) {}

        /**
         * Ends the list of after the elements are added.
         *
         * @see Walker_Nav_Menu::end_lvl()
         *
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         */
        public function end_lvl( &$output, $depth = 0, $args = array() ) {}

        /**
         * Start the element output.
         *
         * @see Walker_Nav_Menu::start_el()
         * @since 3.0.0
         *
         * @global int $_wp_nav_menu_max_depth
         *
         * @param string $output Used to append additional content (passed by reference).
         * @param object $item   Menu item data object.
         * @param int    $depth  Depth of menu item. Used for padding.
         * @param array  $args   Not used.
         * @param int    $id     Not used.
         */
        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            ob_start();
            $item_id = esc_attr( $item->ID );
            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = false;
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
                if ( is_wp_error( $original_title ) )
                    $original_title = false;
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = get_the_title( $original_object->ID );
            } elseif ( 'post_type_archive' == $item->type ) {
                $original_object = get_post_type_object( $item->object );
                if ( $original_object ) {
                    $original_title = $original_object->labels->archives;
                }
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            );

            $title = $item->title;

            if ( ! empty( $item->_invalid ) ) {
                $classes[] = 'menu-item-invalid';
                /* translators: %s: title of menu item which is invalid */
                $title = sprintf( esc_html__( '%s (Invalid)', 'assurena' ), $item->title );
            } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( esc_html__('%s (Pending)', 'assurena'), $item->title );
            }

            $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

            $submenu_text = '';
            if ( 0 == $depth )
                $submenu_text = 'style="display: none;"';

            ?>
            <li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
                <div class="menu-item-bar">
                    <div class="menu-item-handle">
                        <span class="item-title">
                            <span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo !empty($submenu_text) ? $submenu_text : ''; ?>><?php esc_html_e( 'sub item', 'assurena' ); ?></span></span>
                        <span class="item-controls">
                            <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                            <span class="item-order hide-if-js">
                                <a href="<?php
                                    echo esc_url(wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-up-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    ));
                                ?>" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up', 'assurena' ) ?>">&#8593;</a>
                                |
                                <a href="<?php
                                    echo esc_url(wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'action' => 'move-down-menu-item',
                                                'menu-item' => $item_id,
                                            ),
                                            remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                        ),
                                        'move-menu_item'
                                    ));
                                ?>" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down', 'assurena'  ) ?>">&#8595;</a>
                            </span>
                            <a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? esc_url(admin_url( 'nav-menus.php' )) : esc_url(add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) ) );
                            ?>" aria-label="<?php esc_attr_e( 'Edit menu item', 'assurena'  ); ?>"><span class="screen-reader-text"><?php esc_html_e( 'Edit', 'assurena' ); ?></span></a>
                        </span>
                    </div>
                </div>

                <div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
                    <?php if ( 'custom' == $item->type ) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
                                <?php esc_html_e( 'URL', 'assurena' ); ?><br />
                                <input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-wide">
                        <label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Navigation Label', 'assurena' ); ?><br />
                            <input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                        </label>
                    </p>
                    <p class="field-title-attribute field-attr-title description description-wide">
                        <label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Title Attribute', 'assurena' ); ?><br />
                            <input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                        </label>
                    </p>
                    <p class="field-link-target description">
                        <label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
                            <input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
                            <?php esc_html_e( 'Open link in a new tab', 'assurena' ); ?>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'CSS Classes (optional)', 'assurena' ); ?><br />
                            <input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Link Relationship (XFN)', 'assurena' ); ?><br />
                            <input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                        </label>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
                            <?php esc_html_e( 'Description', 'assurena' ); ?><br />
                            <textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                            <span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'assurena'); ?></span>
                        </label>
                    </p>
                    <?php
                        /*-----------------------------------------------------------------------------------*/
                        /* StylusThemes Mega Menu
                        /*-----------------------------------------------------------------------------------*/
                        do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
                    ?>

                    <fieldset class="field-move hide-if-no-js description description-wide">
                        <span class="field-move-visual-label" aria-hidden="true"><?php esc_html_e( 'Move', 'assurena' ); ?></span>
                        <button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one', 'assurena' ); ?></button>
                        <button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one', 'assurena' ); ?></button>
                        <button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
                        <button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
                        <button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top', 'assurena' ); ?></button>
                    </fieldset>

                    <div class="menu-item-actions description-wide submitbox">
                        <?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
                            <p class="link-to-original">
                                <?php
                                $allowed_html = array(
                                    'a' => array(
                                        'href' => true,
                                    ),
                                );
                                printf( wp_kses( __('Original: %s', 'assurena'), $allowed_html ), '<a href="' . esc_url( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
                        echo esc_url(wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                admin_url( 'nav-menus.php' )
                            ),
                            'delete-menu_item_' . $item_id
                        )); ?>"><?php esc_html_e( 'Remove', 'assurena' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
                            ?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e('Cancel', 'assurena'); ?></a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
                </div><!-- .menu-item-settings-->
                <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_clean();
        }

    } // Walker_Nav_Menu_Edit
}