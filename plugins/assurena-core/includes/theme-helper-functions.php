<?php

// Add extra profile information
add_action( 'show_user_profile', 'stl_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'stl_extra_user_profile_fields' );

function stl_user_social_medias_arr() {
    return [ 'instagram', 'facebook', 'linkedin', 'twitter', 'telegram' ];
}

function stl_extra_user_profile_fields( $user )
{ 
    ?>
    <h3><?php esc_html_e( 'Social media accounts', 'assurena-core' ); ?></h3>

    <table class="form-table">
        <?php
        foreach ( stl_user_social_medias_arr() as $social) { ?>
            <tr>
                <th><label for="<?php echo esc_attr($social); ?>" style="text-transform: capitalize;"><?php esc_html_e( $social, 'assurena-core' ); ?></label></th>
                <td>
                    <input type="text" name="<?php echo esc_attr($social); ?>" id="<?php echo esc_attr($social); ?>" value="<?php echo esc_attr( get_the_author_meta( $social, $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php esc_html_e( 'Your '.$social.' url.', 'assurena-core' ); ?></span>
                </td>
            </tr>
            <?php
        } ?>
    </table>
    <?php
}

add_action( 'personal_options_update', 'stl_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'stl_save_extra_user_profile_fields' );

function stl_save_extra_user_profile_fields( $user_id )
{
    if (! current_user_can( 'edit_user', $user_id ) ) return false; 

    foreach ( stl_user_social_medias_arr() as $social) {
        update_user_meta( $user_id, $social, $_POST[ $social ] );
    }
}

// Adding functions for theme
add_action( 'init', 'stl_custom_fields' );
function stl_custom_fields()
{
    if (class_exists('Vc_Manager')) {
        $gtdu = get_template_directory_uri();
        vc_add_shortcode_param('assurena_radio_image', 'assurena_radio_image', $gtdu.'/wpb/addon_fields/js/stl_vc_extenstions.js');
        vc_add_shortcode_param('dropdown_multi','assurena_dropdown_field');
        vc_add_shortcode_param('stl_checkbox', 'assurena_checkbox_custom', $gtdu.'/wpb/addon_fields/js/stl_vc_extenstions.js');
        vc_add_shortcode_param('assurena_param_heading', 'assurena_heading_line');
    }
}
        
// admin icon tinymce shortcode
if (! function_exists('stl_admin_icon')) {
    function stl_admin_icon($atts)
    {
        if (! class_exists('stlAdminIcon')) return;

        extract(
            shortcode_atts(
                [
                    'name'             => '',
                    'class'            => '',
                    'unprefixed_class' => '',
                    'title'            => '', /* For compatibility with other plugins */
                    'size'             => '', /* For compatibility with other plugins */
                    'space'            => '',
                ],
                $atts
            )
        );

        $title = $title ? 'title="' . $title . '" ' : '';
        $space = 'true' == $space ? '&nbsp;' : '';
        $size = $size ? ' '. stlAdminIcon()->prefix . '-' . $size : '';

        $prefixes = [ 'icon-', 'fa-' ];
        foreach ( $prefixes as $prefix) {
            if ( substr( $name, 0, strlen( $prefix ) ) == $prefix) {
                $name = substr( $name, strlen( $prefix ) );
            }
        }

        $name = str_replace( 'fa-', '', $name );
        $icon_name = stlAdminIcon()->prefix ? stlAdminIcon()->prefix . '-' . $name : $name;

        $class = str_replace( 'icon-', '', $class );
        $class = str_replace( 'fa-', '', $class );

        $class = trim( $class );
        $class = preg_replace( '/\s{3,}/', ' ', $class );

        $class_array = explode( ' ', $class );
        foreach ( $class_array as $index => $class) {
            $class_array[ $index ] = $class;
        }
        $class = implode( ' ', $class_array );

        // Add unprefixed classes.
        $class .= $unprefixed_class ? ' ' . $unprefixed_class : '';

        $class = apply_filters( 'stl_icon_class', $class, $name );

        $es_2class = 'stl-icon';

        $tag = apply_filters( 'stl_icon_tag', 'i' );

        $output = sprintf( '<%s class="%s %s %s %s %s" %s>%s</%s>',
            $tag,
            $es_2class,
            stlAdminIcon()->prefix,
            $icon_name,
            $class,
            $size,
            $title,
            $space,
            $tag
        );

        return apply_filters( 'stl_icon', $output );
    }
    add_shortcode('stl_icon', 'stl_admin_icon');
}



add_action('wp_head','stl_wp_head_custom_code',1000);
function stl_wp_head_custom_code()
{
    // this code not only js or css / can insert any type of code
    
    if (class_exists('assurena_Theme_Helper')) {
        $header_custom_code = assurena_Theme_Helper::get_option('header_custom_js');
    }
    echo isset($header_custom_code) ? "<script>".$header_custom_code."</script>" : '';
}

add_action('wp_footer', 'stl_custom_footer_js', 1000);

function stl_custom_footer_js()
{
    if (class_exists('assurena_Theme_Helper')){
        $custom_js = assurena_Theme_Helper::get_option('custom_js');
    }
    echo isset($custom_js) ? '<script id="stl_custom_footer_js">'.$custom_js.'</script>' : '';
}

// If Redux is running as a plugin, this will remove the demo notice and links
add_action( 'redux/loaded', 'remove_demo' );


/**
 * Removes the demo link and the notice of integrated demo from the redux-framework plugin
 */
if (! function_exists( 'remove_demo' )) {
    function remove_demo() {
        // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
        if ( class_exists( 'ReduxFrameworkPlugin' )) {
            remove_filter( 'plugin_row_meta', array(
                ReduxFrameworkPlugin::instance(),
                'plugin_metalinks'
            ), null, 2 );

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
        }
    }
}

// Get User IP
if (! function_exists('stl_get_ip')) {
    function stl_get_ip()
    {
        if ( isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] )) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        }
        $ip = filter_var( $ip, FILTER_VALIDATE_IP );
        $ip = ( $ip === false ) ? '0.0.0.0' : $ip;
        return $ip;
    }
}

?>
