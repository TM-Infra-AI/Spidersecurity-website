<?php

if (!class_exists('assurena_Core')) {
    return;
}

if (!function_exists('stl_get_redux_icons')) {
    function stl_get_redux_icons()
    {
        return stlAdminIcon()->get_icons_name(true);
    }

    add_filter('redux/font-icons', 'stl_get_redux_icons');
}


// This is theme option name where all the Redux data is stored.
$theme_slug = 'assurena_set';

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme();

$args = [
    'opt_name' => $theme_slug, // This is where your data is stored in the database and also becomes your global variable name.
    'display_name' => $theme->get('Name'), // Name that appears at the top of your panel
    'display_version' => $theme->get('Version'), // Version that appears at the top of your panel
    'menu_type' => 'menu', // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu' => true, // Show the sections below the admin menu item or not
    'menu_title' => esc_html__('Theme Options', 'assurena'),
    'page_title' => esc_html__('Theme Options', 'assurena'),
    'google_api_key' => '', // You will need to generate a Google API key to use this feature. Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_update_weekly' => false, // Set it you want google fonts to update weekly. A google_api_key value is required.
    'async_typography' => true, // Must be defined to add google fonts to the typography module
    'admin_bar' => true, // Show the panel pages on the admin bar
    'admin_bar_icon' => 'dashicons-admin-generic', // Choose an icon for the admin bar menu
    'admin_bar_priority' => 50, // Choose an priority for the admin bar menu
    'global_variable' => '', // Set a different name for your global variable other than the opt_name
    'dev_mode' => false,
    'update_notice' => true, // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer' => true,
    'page_priority' => 3, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent' => 'stl-dashboard-panel', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions' => 'manage_options', // Permissions needed to access the options panel.
    'menu_icon' => 'dashicons-admin-generic', // Specify a custom URL to an icon
    'last_tab' => '', // Force your panel to always open to a specific tab (by id)
    'page_icon' => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
    'page_slug' => 'stl-theme-options-panel', // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults' => true, // On load save the defaults to DB before user clicks save or not
    'default_show' => false, // If true, shows the default value next to each field that is not the default value.
    'default_mark' => '', // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export' => true, // Shows the Import/Export panel when not used as a field.
    'transient_time' => 60 * MINUTE_IN_SECONDS, // Show the time the page took to load, etc
    'output' => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag' => true, // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database' => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn' => true,
];


Redux::setArgs($theme_slug, $args);

// -> START Basic Fields
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('General', 'assurena'),
        'id' => 'general',
        'icon' => 'el el-cog',
        'fields' => [
            [
                'id' => 'use_minify',
                'type' => 'switch',
                'title' => esc_html__('Use minify css/js files', 'assurena'),
                'desc' => esc_html__('Recommended for site load speed.', 'assurena'),
            ],
            [
                'id' => 'preloder_settings',
                'type' => 'section',
                'title' => esc_html__('Preloader Settings', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'preloader',
                'type' => 'switch',
                'title' => esc_html__('Preloader On/Off', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'preloader_background',
                'type' => 'color',
                'title' => esc_html__('Preloader Background', 'assurena'),
                'subtitle' => esc_html__('Set Preloader Background', 'assurena'),
                'default' => '#ffffff',
                'transparent' => false,
                'required' => ['preloader', '=', '1'],
            ],
            [
                'id' => 'preloader_color_1',
                'type' => 'color',
                'title' => esc_html__('Preloader Color', 'assurena'),
                'default' => '#2462D2',
                'transparent' => false,
                'required' => ['preloader', '=', '1'],
            ],
            [
                'id' => 'preloader_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'search_settings',
                'type' => 'section',
                'title' => esc_html__('Search Settings', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'search_style',
                'type' => 'button_set',
                'title' => esc_html__('Choose search style', 'assurena'),
                'options' => [
                    'standard' => esc_html__('Standard', 'assurena'),
                    'alt' => esc_html__('Full Page Width', 'assurena'),
                ],
                'default' => 'alt',
            ],
            [
                'id' => 'search_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'scroll_up_settings',
                'type' => 'section',
                'title' => esc_html__('Scroll Up Button Settings', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'scroll_up',
                'type' => 'switch',
                'title' => esc_html__('Button', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Disable', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'scroll_up_appearance',
                'type' => 'switch',
                'title' => esc_html__('Appearance', 'assurena'),
                'on' => esc_html__('Text', 'assurena'),
                'off' => esc_html__('Icon', 'assurena'),
                'default' => true,
                'required' => ['scroll_up', '=', true],
            ],
            [
                'id' => 'scroll_up_text',
                'type' => 'text',
                'title' => esc_html__('Button Text', 'assurena'),
                'default' => esc_html__('Top', 'assurena'),
                'required' => ['scroll_up_appearance', '=', true],
            ],
            [
                'id' => 'scroll_up_arrow_color',
                'type' => 'color',
                'title' => esc_html__('Button Color', 'assurena'),
                'default' => '#ffffff',
                'transparent' => false,
                'required' => ['scroll_up', '=', true],
            ],
            [
                'id' => 'scroll_up_bg_color',
                'type' => 'color',
                'title' => esc_html__('Button Background', 'assurena'),
                'default' => '#2462D2',
                'transparent' => false,
                'required' => ['scroll_up', '=', true],
            ],
            [
                'id' => 'scroll_up_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
        ],
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Custom JS', 'assurena'),
        'id' => 'editors-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'custom_js',
                'type' => 'ace_editor',
                'title' => esc_html__('Custom JS', 'assurena'),
                'subtitle' => esc_html__('Paste your JS code here.', 'assurena'),
                'mode' => 'javascript',
                'theme' => 'chrome',
                'default' => ''
            ],
            [
                'id' => 'header_custom_js',
                'type' => 'ace_editor',
                'title' => esc_html__('Custom JS', 'assurena'),
                'subtitle' => esc_html__('Code to be added inside HEAD tag', 'assurena'),
                'mode' => 'html',
                'theme' => 'chrome',
                'default' => ''
            ],
        ],
    ]
);

// -> START Basic Fields
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header', 'assurena'),
        'id' => 'header_section',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Logo', 'assurena'),
        'id' => 'logo',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'header_logo',
                'type' => 'media',
                'title' => esc_html__('Header Logo', 'assurena'),
            ],
            [
                'id' => 'logo_height_custom',
                'type' => 'switch',
                'title' => esc_html__('Enable Logo Height', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'logo_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Set Logo Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['logo_height_custom', '=', '1'],
            ],
            [
                'id' => 'logo_sticky',
                'type' => 'media',
                'title' => esc_html__('Sticky Logo', 'assurena'),
            ],
            [
                'id' => 'sticky_logo_height_custom',
                'type' => 'switch',
                'title' => esc_html__('Enable Sticky Logo Height', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'sticky_logo_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Set Sticky Logo Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => ''],
                'required' => [
                    ['sticky_logo_height_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'logo_mobile',
                'type' => 'media',
                'title' => esc_html__('Mobile Logo', 'assurena'),
            ],
            [
                'id' => 'mobile_logo_height_custom',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Logo Height', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'mobile_logo_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Set Mobile Logo Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => ''],
                'required' => [
                    ['mobile_logo_height_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'logo_mobile_menu',
                'type' => 'media',
                'title' => esc_html__('Mobile Menu Logo', 'assurena'),
            ],
            [
                'id' => 'mobile_logo_menu_height_custom',
                'type' => 'switch',
                'title' => esc_html__('Enable Mobile Menu Logo Height', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'mobile_logo_menu_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Set Mobile Menu Logo Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => ''],
                'required' => [
                    ['mobile_logo_menu_height_custom', '=', '1'],
                ],
            ],
        ]
    ]
);

$header_builder_items = [
    'default' => [
        'html1' => ['title' => esc_html__('HTML 1', 'assurena'), 'settings' => true],
        'html2' => ['title' => esc_html__('HTML 2', 'assurena'), 'settings' => true],
        'html3' => ['title' => esc_html__('HTML 3', 'assurena'), 'settings' => true],
        'html4' => ['title' => esc_html__('HTML 4', 'assurena'), 'settings' => true],
        'html5' => ['title' => esc_html__('HTML 5', 'assurena'), 'settings' => true],
        'html6' => ['title' => esc_html__('HTML 6', 'assurena'), 'settings' => true],
        'html7' => ['title' => esc_html__('HTML 7', 'assurena'), 'settings' => true],
        'html8' => ['title' => esc_html__('HTML 8', 'assurena'), 'settings' => true],
        'delimiter1' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'delimiter2' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'delimiter3' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'delimiter4' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'delimiter5' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'delimiter6' => ['title' => esc_html__('|', 'assurena'), 'settings' => true],
        'spacer1' => ['title' => esc_html__('Spacer 1', 'assurena'), 'settings' => true],
        'spacer2' => ['title' => esc_html__('Spacer 2', 'assurena'), 'settings' => true],
        'spacer3' => ['title' => esc_html__('Spacer 3', 'assurena'), 'settings' => true],
        'spacer4' => ['title' => esc_html__('Spacer 4', 'assurena'), 'settings' => true],
        'spacer5' => ['title' => esc_html__('Spacer 5', 'assurena'), 'settings' => true],
        'spacer6' => ['title' => esc_html__('Spacer 6', 'assurena'), 'settings' => true],
        'spacer7' => ['title' => esc_html__('Spacer 7', 'assurena'), 'settings' => true],
        'spacer8' => ['title' => esc_html__('Spacer 8', 'assurena'), 'settings' => true],
        'button1' => ['title' => esc_html__('Button', 'assurena'), 'settings' => true],
        'button2' => ['title' => esc_html__('Button', 'assurena'), 'settings' => true],
        'wpml' => ['title' => esc_html__('WPML', 'assurena'), 'settings' => false],
        'cart' => ['title' => esc_html__('Cart', 'assurena'), 'settings' => true],
        'login' => ['title' => esc_html__('Login', 'assurena'), 'settings' => false],
        'side_panel' => ['title' => esc_html__('Side Panel', 'assurena'), 'settings' => true],
    ],
    'mobile' => [
        'html1' => esc_html__('HTML 1', 'assurena'),
        'html2' => esc_html__('HTML 2', 'assurena'),
        'html3' => esc_html__('HTML 3', 'assurena'),
        'html4' => esc_html__('HTML 4', 'assurena'),
        'html5' => esc_html__('HTML 5', 'assurena'),
        'html6' => esc_html__('HTML 6', 'assurena'),
        'spacer1' => esc_html__('Spacer 1', 'assurena'),
        'spacer2' => esc_html__('Spacer 2', 'assurena'),
        'spacer3' => esc_html__('Spacer 3', 'assurena'),
        'spacer4' => esc_html__('Spacer 4', 'assurena'),
        'spacer5' => esc_html__('Spacer 5', 'assurena'),
        'spacer6' => esc_html__('Spacer 6', 'assurena'),
        'side_panel' => esc_html__('Side Panel', 'assurena'),
        'wpml' => esc_html__('WPML', 'assurena'),
        'cart' => esc_html__('Cart', 'assurena'),
        'login' => esc_html__('Login', 'assurena'),
    ],
    'mobile_drawer' => [
        'html1' => esc_html__('HTML 1', 'assurena'),
        'html2' => esc_html__('HTML 2', 'assurena'),
        'html3' => esc_html__('HTML 3', 'assurena'),
        'html4' => esc_html__('HTML 4', 'assurena'),
        'html5' => esc_html__('HTML 5', 'assurena'),
        'html6' => esc_html__('HTML 6', 'assurena'),
        'wpml' => esc_html__('WPML', 'assurena'),
        'spacer1' => esc_html__('Spacer 1', 'assurena'),
        'spacer2' => esc_html__('Spacer 2', 'assurena'),
        'spacer3' => esc_html__('Spacer 3', 'assurena'),
        'spacer4' => esc_html__('Spacer 4', 'assurena'),
        'spacer5' => esc_html__('Spacer 5', 'assurena'),
        'spacer6' => esc_html__('Spacer 6', 'assurena'),
    ],
];

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Builder', 'assurena'),
        'id' => 'header-customize',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'header_type',
                'type' => 'select',
                'title' => esc_html__('Layout Building Tool', 'assurena'),
                'options' => [
                    'default' => esc_html__('Default Builder', 'assurena'),
                    'custom' => esc_html__('Custom Builder ( Recommended )', 'assurena')
                ],
                'default' => 'default',
                'desc' => esc_html__('Custom Builder allows use Elementor environment for template building.', 'assurena'),
            ],
            [
                'id' => 'header_page_select',
                'type' => 'select',
                'title' => esc_html__('Header Template', 'assurena'),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'header',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
                'required' => ['header_type', '=', 'custom'],
                'desc' => sprintf(
                    '%s <a href="%s" target="_blank">%s</a> %s',
                    esc_html__('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'assurena'),
                    admin_url('edit.php?post_type=header'),
                    esc_html__('Header Templates', 'assurena'),
                    esc_html__('dashboard tab.', 'assurena')
                ),
            ],
            [
                'id' => 'bottom_header_layout',
                'type' => 'custom_header_builder',
                'title' => esc_html__('Header Builder', 'assurena'),
                'compiler' => 'true',
                'full_width' => true,
                'options' => [
                    'items' => $header_builder_items['default'],
                    'Top Left area' => [],
                    'Top Center area' => [],
                    'Top Right area' => [],
                    'Middle Left area' => [
                        'spacer1' => ['title' => esc_html__('Spacer 1', 'assurena'), 'settings' => true],
                        'logo' => ['title' => esc_html__('Logo', 'assurena'), 'settings' => false],
                    ],
                    'Middle Center area' => [
                        'menu' => ['title' => esc_html__('Menu', 'assurena'), 'settings' => false],
                    ],
                    'Middle Right area' => [
                        'item_search' => ['title' => esc_html__('Search', 'assurena'), 'settings' => true],
                        'spacer2' => ['title' => esc_html__('Spacer 2', 'assurena'), 'settings' => true],
                    ],
                    'Bottom Left area' => [],
                    'Bottom Center area' => [],
                    'Bottom Right area' => [],
                ],
                'default' => [
                    'items' => $header_builder_items['default'],
                    'Top Left area' => [],
                    'Top Center area' => [],
                    'Top Right area' => [],
                    'Middle Left area' => [
                        'logo' => ['title' => esc_html__('Logo', 'assurena'), 'settings' => false],
                    ],
                    'Middle Center area' => [
                        'menu' => ['title' => esc_html__('Menu', 'assurena'), 'settings' => false],
                    ],
                    'Middle Right area' => [
                        'item_search' => ['title' => esc_html__('Search', 'assurena'), 'settings' => true],
                    ],
                    'Bottom Left area' => [],
                    'Bottom Center area' => [],
                    'Bottom Right area' => [],
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer1',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 1 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 41],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer2',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 2 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 30],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer3',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 3 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer4',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 4 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer5',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 5 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer6',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 6 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer7',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 7 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_spacer8',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Spacer 8 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_item_search_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Search', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_item_search_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_item_search_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_item_search_hover_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_item_search_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_item_search_custom_sticky',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Search', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_item_search_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_item_search_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_item_search_hover_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_item_search_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_cart_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize cart', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_cart_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_cart_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_cart_hover_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_cart_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_cart_custom_sticky',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky cart', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_cart_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_cart_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_cart_hover_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Icon Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(33,33,33, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_cart_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_delimiter1_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 20],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter1_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter1_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#cdcdcd',
                    'alpha' => '1',
                    'rgba' => 'rgba(205,205,205,1)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter1_margin',
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '20',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter1_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter1_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_delimiter1_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter1_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => [
                    ['bottom_header_delimiter1_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter2_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter2_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter2_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter2_margin',
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter2_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter2_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_delimiter2_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter2_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => [
                    ['bottom_header_delimiter2_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter3_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter3_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter3_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter3_margin',
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter3_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter3_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_delimiter3_sticky_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_delimiter3_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => [
                    ['bottom_header_delimiter3_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter4_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter4_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter4_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter4_margin',
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter4_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter4_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_delimiter4_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter4_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => [
                    ['bottom_header_delimiter4_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter5_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter5_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter5_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter5_margin',
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter5_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter5_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_delimiter5_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter5_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => [
                    ['bottom_header_delimiter5_sticky_custom', '=', '1'],
                ],
            ],
            [
                'id' => 'bottom_header_delimiter6_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter6_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter6_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter6_margin',
                'type' => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode' => 'margin',
                'all' => false,
                'bottom' => false,
                'top' => false,
                'left' => true,
                'right' => true,
                'title' => esc_html__('Delimiter Spacing', 'assurena'),
                'default' => [
                    'margin-left' => '30',
                    'margin-right' => '30',
                ],
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter6_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Delimiter', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_delimiter6_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Delimiter Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_delimiter6_sticky_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_delimiter6_sticky_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Delimiter Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
                'required' => ['bottom_header_delimiter6_sticky_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_title',
                'type' => 'text',
                'title' => esc_html__('Button Text', 'assurena'),
                'default' => esc_html__('Get Ticket', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_link',
                'type' => 'text',
                'title' => esc_html__('Link', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_target',
                'type' => 'switch',
                'title' => esc_html__('Open link in a new tab', 'assurena'),
                'default' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_size',
                'type' => 'select',
                'title' => esc_html__('Button Size', 'assurena'),
                'options' => [
                    's' => esc_html__('Small', 'assurena'),
                    'm' => esc_html__('Medium', 'assurena'),
                    'l' => esc_html__('Large', 'assurena'),
                    'xl' => esc_html__('Extra Large', 'assurena'),
                ],
                'default' => 's',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_radius',
                'type' => 'text',
                'title' => esc_html__('Button Border Radius', 'assurena'),
                'default' => '0',
                'desc' => esc_html__('Value in pixels.', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Button', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Text Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Text Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Background Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_border',
                'type' => 'color_rgba',
                'title' => esc_html__('Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_border',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_custom_sticky',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Button', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button1_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Text Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Text Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_bg_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Background Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_bg_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Background Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_border_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button1_hover_border_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button1_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_title',
                'type' => 'text',
                'title' => esc_html__('Button Text', 'assurena'),
                'default' => esc_html__('Get Ticket', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_link',
                'type' => 'text',
                'title' => esc_html__('Link', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_target',
                'type' => 'switch',
                'title' => esc_html__('Open link in a new tab', 'assurena'),
                'default' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_size',
                'type' => 'select',
                'title' => esc_html__('Button Size', 'assurena'),
                'options' => [
                    's' => esc_html__('Small', 'assurena'),
                    'm' => esc_html__('Medium', 'assurena'),
                    'l' => esc_html__('Large', 'assurena'),
                    'xl' => esc_html__('Extra Large', 'assurena'),
                ],
                'default' => 'm',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_radius',
                'type' => 'text',
                'title' => esc_html__('Button Border Radius', 'assurena'),
                'default' => '0',
                'desc' => esc_html__('Value in pixels.', 'assurena'),
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Button', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Text Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_color_txt',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Text Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Background Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_border',
                'type' => 'color_rgba',
                'title' => esc_html__('Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_border',
                'type' => 'color_rgba',
                'title' => esc_html__('Hover Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_custom_sticky',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Button', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_button2_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Text Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_color_txt_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Text Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_bg_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Background Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_bg_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Background Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_border_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_button2_hover_border_sticky',
                'type' => 'color_rgba',
                'title' => esc_html__('Sticky Hover Border Color', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['bottom_header_button2_custom_sticky', '=', '1'],
            ],
            [
                'id' => 'bottom_header_bar_html1_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 1 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html2_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 2 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html3_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 3 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html4_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 4 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html5_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 5 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html6_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 6 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html7_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 7 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_bar_html8_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 8 Editor', 'assurena'),
                'default' => '',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_side_panel_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Icon Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_side_panel_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Icon', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_side_panel_sticky_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Sticky Icon', 'assurena'),
                'default' => false,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'bottom_header_side_panel_sticky_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Icon Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_side_panel_sticky_custom', '=', '1']
                ],
            ],
            [
                'id' => 'bottom_header_side_panel_sticky_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Background Icon', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['bottom_header_side_panel_sticky_custom', '=', '1']
                ],
            ],
            [
                'id' => 'header_top-start',
                'type' => 'section',
                'title' => esc_html__('Header Top Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_top_full_width',
                'type' => 'switch',
                'title' => esc_html__('Full Width Header', 'assurena'),
                'subtitle' => esc_html__('Set header content in full width', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_top_max_width_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Max Width Container', 'assurena'),
                'subtitle' => esc_html__('Set max width container', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_top_max_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Max Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => [
                    'width' => 1290,
                ],
                'required' => ['header_top_max_width_custom', '=', '1'],
            ],
            [
                'id' => 'header_top_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Top Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 40]
            ],
            [
                'id' => 'header_top_background_image',
                'type' => 'media',
                'title' => esc_html__('Header Top Background Image', 'assurena'),
            ],
            [
                'id' => 'header_top_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Top Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_top_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Top Text Color', 'assurena'),
                'subtitle' => esc_html__('Set Top header text color', 'assurena'),
                'default' => [
                    'color' => '#fefefe',
                    'alpha' => '.5',
                    'rgba' => 'rgba(254,254,254,0.5)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_top_bottom_border',
                'type' => 'switch',
                'title' => esc_html__('Set Header Top Bottom Border', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'header_top_border_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Top Border Width', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => [
                    'height' => '1',
                ],
                'required' => [
                    ['header_top_bottom_border', '=', '1']
                ],
            ],
            [
                'id' => 'header_top_bottom_border_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Top Border Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,0.2)'
                ],
                'mode' => 'background',
                'required' => [
                    ['header_top_bottom_border', '=', '1'],
                ],
            ],
            [
                'id' => 'header_top-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_middle-start',
                'type' => 'section',
                'title' => esc_html__('Header Middle Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_middle_full_width',
                'type' => 'switch',
                'title' => esc_html__('Full Width Middle Header', 'assurena'),
                'subtitle' => esc_html__('Set header content in full width', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_middle_max_width_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Max Width Container', 'assurena'),
                'subtitle' => esc_html__('Set max width container', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_middle_max_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Max Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1290],
                'required' => ['header_middle_max_width_custom', '=', '1'],
            ],
            [
                'id' => 'header_middle_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Middle Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 80]
            ],
            [
                'id' => 'header_middle_background_image',
                'type' => 'media',
                'title' => esc_html__('Header Middle Background Image', 'assurena'),
            ],
            [
                'id' => 'header_middle_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Middle Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_middle_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Middle Text Color', 'assurena'),
                'subtitle' => esc_html__('Set Middle header text color', 'assurena'),
                'default' => [
                    'color' => '#323232',
                    'alpha' => '1',
                    'rgba' => 'rgba(50,50,50,1)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_middle_bottom_border',
                'type' => 'switch',
                'title' => esc_html__('Set Header Middle Bottom Border', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_middle_border_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Middle Border Width', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => '1'],
                'required' => [
                    ['header_middle_bottom_border', '=', '1']
                ],
            ],
            [
                'id' => 'header_middle_bottom_border_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Middle Border Color', 'assurena'),
                'default' => [
                    'color' => '#f5f5f5',
                    'alpha' => '1',
                    'rgba' => 'rgba(245,245,245,1)'
                ],
                'mode' => 'background',
                'required' => [
                    ['header_middle_bottom_border', '=', '1'],
                ],
            ],
            [
                'id' => 'header_middle-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_bottom-start',
                'type' => 'section',
                'title' => esc_html__('Header Bottom Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_bottom_full_width',
                'type' => 'switch',
                'title' => esc_html__('Full Width Bottom Header', 'assurena'),
                'subtitle' => esc_html__('Set header content in full width', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_bottom_max_width_custom',
                'type' => 'switch',
                'title' => esc_html__('Customize Max Width Container', 'assurena'),
                'subtitle' => esc_html__('Set max width container', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_bottom_max_width',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Max Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 1290],
                'required' => ['header_bottom_max_width_custom', '=', '1'],
            ],
            [
                'id' => 'header_bottom_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Bottom Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 100],
            ],
            [
                'id' => 'header_bottom_background_image',
                'type' => 'media',
                'title' => esc_html__('Header Bottom Background Image', 'assurena'),
            ],
            [
                'id' => 'header_bottom_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Bottom Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba' => 'rgba(255,255,255,0.9)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_bottom_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Bottom Text Color', 'assurena'),
                'subtitle' => esc_html__('Set Bottom header text color', 'assurena'),
                'default' => [
                    'color' => '#fefefe',
                    'alpha' => '.5',
                    'rgba' => 'rgba(254,254,254,0.5)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'header_bottom_bottom_border',
                'type' => 'switch',
                'title' => esc_html__('Set Header Bottom Border', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'header_bottom_border_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Header Bottom Border Width', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => '1'],
                'required' => [
                    ['header_bottom_bottom_border', '=', '1']
                ],
            ],
            [
                'id' => 'header_bottom_bottom_border_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Header Bottom Border Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,0.2)'
                ],
                'mode' => 'background',
                'required' => [
                    ['header_bottom_bottom_border', '=', '1'],
                ],
            ],
            [
                'id' => 'header_bottom-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-left-start',
                'type' => 'section',
                'title' => esc_html__('Top Left Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_top_left_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_left_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_left_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-center-start',
                'type' => 'section',
                'title' => esc_html__('Top Center Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_top_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-center-start',
                'type' => 'section',
                'title' => esc_html__('Top Center Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_top_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_top_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-top-right-start',
                'type' => 'section',
                'title' => esc_html__('Top Right Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_top_right_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'header_column_top_right_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_top_right_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-top-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-left-start',
                'type' => 'section',
                'title' => esc_html__('Middle Left Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_middle_left_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_middle_left_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_left_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-center-start',
                'type' => 'section',
                'title' => esc_html__('Middle Center Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_middle_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_middle_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-center-start',
                'type' => 'section',
                'title' => esc_html__('Middle Center Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_middle_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_middle_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-middle-right-start',
                'type' => 'section',
                'title' => esc_html__('Middle Right Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_middle_right_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'header_column_middle_right_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_middle_right_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-middle-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-left-start',
                'type' => 'section',
                'title' => esc_html__('Bottom Left Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_bottom_left_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_bottom_left_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_left_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-left-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-center-start',
                'type' => 'section',
                'title' => esc_html__('Bottom Center Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_bottom_center_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'header_column_bottom_center_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_center_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-center-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_column-bottom-right-start',
                'type' => 'section',
                'title' => esc_html__('Bottom Right Column Options', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_column_bottom_right_horz',
                'type' => 'button_set',
                'title' => esc_html__('Horizontal Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'header_column_bottom_right_vert',
                'type' => 'button_set',
                'title' => esc_html__('Vertical Align', 'assurena'),
                'options' => [
                    'top' => esc_html__('Top', 'assurena'),
                    'middle' => esc_html__('Middle', 'assurena'),
                    'bottom' => esc_html__('Bottom', 'assurena'),
                ],
                'default' => 'middle'
            ],
            [
                'id' => 'header_column_bottom_right_display',
                'type' => 'button_set',
                'title' => esc_html__('Display', 'assurena'),
                'options' => [
                    'normal' => esc_html__('Normal', 'assurena'),
                    'grow' => esc_html__('Grow', 'assurena'),
                ],
                'default' => 'normal'
            ],
            [
                'id' => 'header_column-bottom-right-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'header_row_settings-start',
                'type' => 'section',
                'title' => esc_html__('Header Settings', 'assurena'),
                'indent' => true,
                'required' => ['header_type', '=', 'default'],
            ],
            [
                'id' => 'header_shadow',
                'type' => 'switch',
                'title' => esc_html__('Header Bottom Shadow', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_on_bg',
                'type' => 'switch',
                'title' => esc_html__('Over content', 'assurena'),
                'subtitle' => esc_html__('Set Header preset to display over content.', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'lavalamp_active',
                'type' => 'switch',
                'title' => esc_html__('Enable Lavalamp Marker', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'sub_menu_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Sub Menu Background', 'assurena'),
                'subtitle' => esc_html__('Set sub menu background color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'sub_menu_color',
                'type' => 'color',
                'title' => esc_html__('Sub Menu Text Color', 'assurena'),
                'subtitle' => esc_html__('Set sub menu header text color', 'assurena'),
                'default' => '#313131',
                'transparent' => false,
            ],
            [
                'id' => 'header_sub_menu_bottom_border',
                'type' => 'switch',
                'title' => esc_html__('Sub Menu Bottom Border', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'header_sub_menu_border_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Sub Menu Border Width', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => '1'],
                'required' => ['header_sub_menu_bottom_border', '=', '1']
            ],
            [
                'id' => 'header_sub_menu_bottom_border_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Sub Menu Border Color', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(0, 0, 0, 0.08)'
                ],
                'mode' => 'background',
                'required' => ['header_sub_menu_bottom_border', '=', '1'],
            ],
            [
                'id' => 'header_mobile_queris',
                'type' => 'slider',
                'title' => esc_html__('Mobile Header resolution breakpoint', 'assurena'),
                'default' => 1200,
                'min' => 1,
                'step' => 1,
                'max' => 1700,
                'display_value' => 'text',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'header_row_settings-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Sticky', 'assurena'),
        'id' => 'header_builder_sticky',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'header_sticky',
                'type' => 'switch',
                'title' => esc_html__('Header Sticky', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'header_sticky-start',
                'type' => 'section',
                'title' => esc_html__('Sticky Settings', 'assurena'),
                'indent' => true,
                'required' => ['header_sticky', '=', '1'],
            ],
            [
                'id' => 'header_sticky_page_select',
                'type' => 'select',
                'title' => esc_html__('Header Sticky Template', 'assurena'),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'header',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
                'required' => ['header_sticky', '=', '1'],
                'desc' => sprintf(
                    '%s <a href="%s" target="_blank">%s</a> %s',
                    esc_html__('Selected Template will be used for all pages by default. You can edit/create Header Template in the', 'assurena'),
                    admin_url('edit.php?post_type=header'),
                    esc_html__('Header Templates', 'assurena'),
                    esc_html__('dashboard tab.', 'assurena')
                ),
            ],
            [
                'id' => 'header_sticky_style',
                'type' => 'select',
                'title' => esc_html__('Appearance', 'assurena'),
                'options' => [
                    'standard' => esc_html__('Always Visible', 'assurena'),
                    'scroll_up' => esc_html__('Visible while scrolling upwards', 'assurena'),
                ],
                'default' => 'standard'
            ],
            [
                'id' => 'header_sticky-end',
                'type' => 'section',
                'indent' => false,
                'required' => ['header_sticky', '=', '1'],
            ],
        ]
    ]
);
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Header Mobile', 'assurena'),
        'id' => 'header_builder_mobile',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'mobile_header',
                'type' => 'switch',
                'title' => esc_html__('Custom Mobile Header ', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'mobile_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Mobile Header Background', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49,49,49, 1)'
                ],
                'mode' => 'background',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_color',
                'type' => 'color',
                'title' => esc_html__('Mobile Header Text Color', 'assurena'),
                'default' => '#ffffff',
                'transparent' => false,
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_sub_menu_background',
                'type' => 'color_rgba',
                'title' => esc_html__('Mobile Sub Menu Background', 'assurena'),
                'default' => [
                    'color' => '#2d2d2d',
                    'alpha' => '1',
                    'rgba' => 'rgba(45,45,45,1)'
                ],
                'mode' => 'background',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_sub_menu_overlay',
                'type' => 'color_rgba',
                'title' => esc_html__('Mobile Sub Menu Overlay', 'assurena'),
                'default' => [
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba' => 'rgba(49, 49, 49, 0.8)'
                ],
                'mode' => 'background',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_sub_menu_color',
                'type' => 'color',
                'title' => esc_html__('Mobile Sub Menu Text Color', 'assurena'),
                'default' => '#ffffff',
                'transparent' => false,
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'header_mobile_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Mobile Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => [
                    'height' => '100',
                ],
                'required' => [
                    ['mobile_header', '=', '1']
                ],
            ],
            [
                'id' => 'mobile_over_content',
                'type' => 'switch',
                'title' => esc_html__('Mobile Over Content', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'mobile_sticky',
                'type' => 'switch',
                'title' => esc_html__('Mobile Sticky', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'mobile_position',
                'type' => 'button_set',
                'title' => esc_html__('Mobile Sub Menu Position', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'mobile_header_layout',
                'type' => 'sorter',
                'title' => esc_html__('Mobile Header Order', 'assurena'),
                'desc' => esc_html__('Organize the layout of the mobile header', 'assurena'),
                'compiler' => 'true',
                'full_width' => true,
                'options' => [
                    'items' => $header_builder_items['mobile'],
                    'Left align side' => [
                        'menu' => esc_html__('Menu', 'assurena'),
                    ],
                    'Center align side' => [
                        'logo' => esc_html__('Logo', 'assurena'),
                    ],
                    'Right align side' => [
                        'item_search' => esc_html__('Search', 'assurena'),
                    ],
                ],
                'default' => [
                    'items' => $header_builder_items['mobile'],
                    'Left align side' => [
                        'menu' => esc_html__('Menu', 'assurena'),
                    ],
                    'Center align side' => [
                        'logo' => esc_html__('Logo', 'assurena'),
                    ],
                    'Right align side' => [
                        'item_search' => esc_html__('Search', 'assurena'),
                    ],
                ],
                'required' => [
                    ['mobile_header', '=', '1']
                ],
            ],
            [
                'id' => 'mobile_content_header_layout',
                'type' => 'sorter',
                'title' => esc_html__('Mobile Drawer Content', 'assurena'),
                'desc' => esc_html__('Organize the layout of the mobile header', 'assurena'),
                'compiler' => 'true',
                'full_width' => true,
                'options' => [
                    'items' => $header_builder_items['mobile_drawer'],
                    'Left align side' => [
                        'logo' => esc_html__('Logo', 'assurena'),
                        'menu' => esc_html__('Menu', 'assurena'),
                        'item_search' => esc_html__('Search', 'assurena'),
                    ],
                ],
                'default' => [
                    'items' => $header_builder_items['mobile_drawer'],
                    'Left align side' => [
                        'logo' => esc_html__('Logo', 'assurena'),
                        'menu' => esc_html__('Menu', 'assurena'),
                        'item_search' => esc_html__('Search', 'assurena'),
                    ],
                ],
                'required' => [
                    ['mobile_header', '=', '1']
                ],
            ],
            [
                'id' => 'mobile_header_bar_html1_editor',
                'type' => 'ace_editor',
                'mode' => 'html',
                'title' => esc_html__('HTML Element 1 Editor', 'assurena'),
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_bar_html2_editor',
                'type' => 'ace_editor',
                'title' => esc_html__('HTML Element 2 Editor', 'assurena'),
                'mode' => 'html',
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_bar_html3_editor',
                'type' => 'ace_editor',
                'title' => esc_html__('HTML Element 3 Editor', 'assurena'),
                'mode' => 'html',
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_bar_html4_editor',
                'type' => 'ace_editor',
                'title' => esc_html__('HTML Element 4 Editor', 'assurena'),
                'mode' => 'html',
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_bar_html5_editor',
                'type' => 'ace_editor',
                'title' => esc_html__('HTML Element 5 Editor', 'assurena'),
                'mode' => 'html',
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_bar_html6_editor',
                'type' => 'ace_editor',
                'title' => esc_html__('HTML Element 6 Editor', 'assurena'),
                'mode' => 'html',
                'default' => '',
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer1',
                'type' => 'dimensions',
                'title' => esc_html__('Spacer 1 Width', 'assurena'),
                'units' => 'px',
                'units_extended' => false,
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer2',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Spacer 2 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer3',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Spacer 3 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer4',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Spacer 4 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer5',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Spacer 5 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
            [
                'id' => 'mobile_header_spacer6',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Spacer 6 Width', 'assurena'),
                'height' => false,
                'width' => true,
                'default' => ['width' => 25],
                'required' => ['mobile_header', '=', '1'],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Page Title', 'assurena'),
        'id' => 'page_title',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Settings', 'assurena'),
        'id' => 'page_title_settings',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_switch',
                'type' => 'switch',
                'title' => esc_html__('Use Page Title?', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'page_title-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'assurena'),
                'indent' => true,
                'required' => ['page_title_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_bg_switch',
                'type' => 'switch',
                'title' => esc_html__('Use Background Image/Color?', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'page_title_bg_image',
                'type' => 'background',
                'title' => esc_html__('Background Image/Color', 'assurena'),
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-image' => '',
                    'background-repeat' => 'no-repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center bottom',
                    'background-color' => '#383838',
                ],
                'required' => ['page_title_bg_switch', '=', true],
            ],
            [
                'id' => 'page_title_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 350],
                'required' => ['page_title_bg_switch', '=', true],
            ],
            [
                'id' => 'page_title_padding',
                'type' => 'spacing',
                'title' => esc_html__('Paddings Top/Bottom', 'assurena'),
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'default' => [
                    'padding-top' => '80',
                    'padding-bottom' => '80',
                ],
            ],
            [
                'id' => 'page_title_margin',
                'type' => 'spacing',
                'title' => esc_html__('Margin Bottom', 'assurena'),
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
                'default' => ['margin-bottom' => '67'],
            ],
            [
                'id' => 'page_title_align',
                'type' => 'button_set',
                'title' => esc_html__('Title Alignment', 'assurena'),
                'options' => [
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right'
                ],
                'default' => 'center',
            ],
            [
                'id' => 'page_title_breadcrumbs_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'page_title_breadcrumbs_block_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs Full Width', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => true,
                'required' => ['page_title_breadcrumbs_switch', '=', true],
            ],
            [
                'id' => 'page_title_breadcrumbs_align',
                'type' => 'button_set',
                'title' => esc_html__('Breadcrumbs Alignment', 'assurena'),
                'options' => [
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right'
                ],
                'default' => 'center',
                'required' => ['page_title_breadcrumbs_block_switch', '=', true],
            ],
            [
                'id' => 'page_title_parallax',
                'type' => 'switch',
                'title' => esc_html__('Parallax Effect', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'page_title_parallax_speed',
                'type' => 'spinner',
                'title' => esc_html__('Parallax Speed', 'assurena'),
                'default' => '0.3',
                'min' => '-5',
                'step' => '0.1',
                'max' => '5',
                'required' => ['page_title_parallax', '=', '1'],
            ],
            [
                'id' => 'page_title-end',
                'type' => 'section',
                'indent' => false,
                'required' => ['page_title_switch', '=', '1'],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Typography', 'assurena'),
        'id' => 'page_title_typography',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_font',
                'type' => 'custom_typography',
                'title' => esc_html__('Page Title Font', 'assurena'),
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '48px',
                    'line-height' => '52px',
                    'color' => '#ffffff',
                ],
            ],
            [
                'id' => 'page_title_breadcrumbs_font',
                'type' => 'custom_typography',
                'title' => esc_html__('Page Title Breadcrumbs Font', 'assurena'),
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '16px',
                    'color' => '#e2e2e2',
                    'line-height' => '24px',
                ],
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Responsive', 'assurena'),
        'id' => 'page_title_responsive',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'page_title_resp_switch',
                'type' => 'switch',
                'title' => esc_html__('Responsive Layout On/Off', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'page_title_resp_resolution',
                'type' => 'slider',
                'title' => esc_html__('Screen breakpoint', 'assurena'),
                'default' => 768,
                'min' => 1,
                'step' => 1,
                'max' => 1700,
                'display_value' => 'text',
                'required' => ['page_title_resp_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_resp_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => [ 'height' => 180 ],
                'required' => ['page_title_resp_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_resp_padding',
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'title' => esc_html__('Paddings Top/Bottom', 'assurena'),
                'default' => [
                    'padding-top' => '15',
                    'padding-bottom' => '15',
                ],
                'required' => ['page_title_resp_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_resp_font',
                'type' => 'custom_typography',
                'title' => esc_html__('Page Title Font', 'assurena'),
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '42px',
                    'line-height' => '48px',
                    'color' => '#ffffff',
                ],
                'required' => ['page_title_resp_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_resp_breadcrumbs_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs On/Off', 'assurena'),
                'default' => true,
                'required' => ['page_title_resp_switch', '=', '1'],
            ],
            [
                'id' => 'page_title_resp_breadcrumbs_font',
                'type' => 'custom_typography',
                'title' => esc_html__('Page Title Breadcrumbs Font', 'assurena'),
                'font-size' => true,
                'google' => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style' => false,
                'color' => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align' => false,
                'all_styles' => false,
                'default' => [
                    'font-size' => '16px',
                    'color' => '#e2e2e2',
                    'line-height' => '24px',
                ],
                'required' => ['page_title_resp_breadcrumbs_switch', '=', '1'],
            ],

        ]
    ]
);

// -> START Footer Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Footer', 'assurena'),
        'id' => 'footer',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Settings', 'assurena'),
        'id' => 'footer_settings',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'footer_switch',
                'type' => 'switch',
                'title' => esc_html__('Footer', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Disable', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'footer-start',
                'type' => 'section',
                'title' => esc_html__('Footer Settings', 'assurena'),
                'indent' => true,
                'required' => ['footer_switch', '=', '1'],
            ],
            [
                'id' => 'footer_add_wave',
                'type' => 'switch',
                'title' => esc_html__('Add Wave', 'assurena'),
                'default' => false,
                'required' => ['footer_switch', '=', '1'],
            ],
            [
                'id' => 'footer_wave_height',
                'type' => 'dimensions',
                'units' => 'px',
                'units_extended' => false,
                'title' => esc_html__('Set Wave Height', 'assurena'),
                'height' => true,
                'width' => false,
                'default' => ['height' => 158],
                'required' => ['footer_add_wave', '=', '1'],
            ],
            [
                'id' => 'footer_content_type',
                'type' => 'select',
                'title' => esc_html__('Content Type', 'assurena'),
                'options' => [
                    'widgets' => 'Get Widgets',
                    'pages' => 'Get Pages'
                ],
                'default' => 'widgets'
            ],
            [
                'id' => 'footer_page_select',
                'type' => 'select',
                'title' => esc_html__('Page Select', 'assurena'),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'footer',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
                'required' => ['footer_content_type', '=', 'pages'],
            ],
            [
                'id' => 'widget_columns',
                'type' => 'button_set',
                'title' => esc_html__('Columns', 'assurena'),
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'default' => '4',
                'required' => ['footer_content_type', '=', 'widgets'],
            ],
            [
                'id' => 'widget_columns_2',
                'type' => 'image_select',
                'title' => esc_html__('Columns Layout', 'assurena'),
                'options' => [
                    '6-6' => [
                        'alt' => '50-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-50.png'
                    ],
                    '3-9' => [
                        'alt' => '25-75',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-75.png'
                    ],
                    '9-3' => [
                        'alt' => '75-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/75-25.png'
                    ],
                    '4-8' => [
                        'alt' => '33-66',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-66.png'
                    ],
                    '8-4' => [
                        'alt' => '66-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/66-33.png'
                    ]
                ],
                'default' => '6-6',
                'required' => ['widget_columns', '=', '2'],
            ],
            [
                'id' => 'widget_columns_3',
                'type' => 'image_select',
                'title' => esc_html__('Columns Layout', 'assurena'),
                'options' => [
                    '4-4-4' => [
                        'alt' => '33-33-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-33-33.png'
                    ],
                    '3-3-6' => [
                        'alt' => '25-25-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-25-50.png'
                    ],
                    '3-6-3' => [
                        'alt' => '25-50-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-50-25.png'
                    ],
                    '6-3-3' => [
                        'alt' => '50-25-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-25-25.png'
                    ],
                ],
                'default' => '4-4-4',
                'required' => ['widget_columns', '=', '3'],
            ],
            [
                'id' => 'footer_spacing',
                'type' => 'spacing',
                'output' => ['.stl-footer'],
                'mode' => 'padding',
                'units' => 'px',
                'all' => false,
                'title' => esc_html__('Paddings', 'assurena'),
                'default' => [
                    'padding-top' => '50px',
                    'padding-right' => '0px',
                    'padding-bottom' => '0px',
                    'padding-left' => '0px'
                ],
                'required' => ['footer_content_type', '=', 'widgets'],
            ],
            [
                'id' => 'footer_full_width',
                'type' => 'switch',
                'title' => esc_html__('Full Width On/Off', 'assurena'),
                'default' => false,
                'required' => ['footer_content_type', '=', 'widgets'],
            ],
            [
                'id' => 'footer-end',
                'type' => 'section',
                'indent' => false,
                'required' => ['footer_switch', '=', '1'],
            ],
            [
                'id' => 'footer-start-styles',
                'type' => 'section',
                'title' => esc_html__('Footer Styling', 'assurena'),
                'indent' => true,
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_bg_image',
                'type' => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'title' => esc_html__('Background Image', 'assurena'),
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                ],
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_align',
                'type' => 'button_set',
                'title' => esc_html__('Content Align', 'assurena'),
                'options' => [
                    'left' => 'Left',
                    'center' => 'Center',
                    'right' => 'Right'
                ],
                'default' => 'center',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_bg_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'assurena'),
                'default' => '#1f242c',
                'transparent' => false,
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_heading_color',
                'type' => 'color',
                'title' => esc_html__('Headings color', 'assurena'),
                'transparent' => false,
                'default' => '#ffffff',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_text_color',
                'type' => 'color',
                'title' => esc_html__('Content color', 'assurena'),
                'transparent' => false,
                'default' => '#ffffff',
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_add_border',
                'type' => 'switch',
                'title' => esc_html__('Add Border Top', 'assurena'),
                'default' => false,
                'required' => [
                    ['footer_switch', '=', '1'],
                    ['footer_content_type', '=', 'widgets'],
                ],
            ],
            [
                'id' => 'footer_border_color',
                'type' => 'color',
                'title' => esc_html__('Border color', 'assurena'),
                'default' => '#e5e5e5',
                'transparent' => false,
                'required' => ['footer_add_border', '=', '1'],
            ],
            [
                'id' => 'footer-end-styles',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

// -> START Copyright Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Copyright', 'assurena'),
        'id' => 'copyright',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Settings', 'assurena'),
        'id' => 'copyright-settings',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'copyright_switch',
                'type' => 'switch',
                'title' => esc_html__('Copyright', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Disable', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'copyright-start',
                'type' => 'section',
                'title' => esc_html__('Copyright Settings', 'assurena'),
                'indent' => true,
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright_editor',
                'type' => 'editor',
                'title' => esc_html__('Editor', 'assurena'),
                'default' => '<p>Copyright © 2020 assurena by StylusThemes. All Rights Reserved</p>',
                'args' => [
                    'wpautop' => false,
                    'media_buttons' => false,
                    'textarea_rows' => 2,
                    'teeny' => false,
                    'quicktags' => true,
                ],
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright_text_color',
                'type' => 'color',
                'title' => esc_html__('Text Color', 'assurena'),
                'default' => '#9f9f9f',
                'transparent' => false,
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright_bg_color',
                'type' => 'color',
                'title' => esc_html__('Background Color', 'assurena'),
                'default' => '#1f242c',
                'transparent' => false,
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright_spacing',
                'type' => 'spacing',
                'title' => esc_html__('Paddings', 'assurena'),
                'mode' => 'padding',
                'left' => false,
                'right' => false,
                'all' => false,
                'default' => [
                    'padding-top' => '20',
                    'padding-bottom' => '20',
                ],
                'required' => ['copyright_switch', '=', '1'],
            ],
            [
                'id' => 'copyright-end',
                'type' => 'section',
                'indent' => false,
                'required' => ['footer_switch', '=', '1'],
            ],
        ]
    ]
);

// -> START Blog Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Blog', 'assurena'),
        'id' => 'blog-option',
        'icon' => 'el-icon-th',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Archive', 'assurena'),
        'id' => 'blog-list-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'blog_list_page_title-start',
                'type' => 'section',
                'title' => esc_html__('Page Title', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'post_archive_page_title_bg_image',
                'type' => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'title' => esc_html__('Background Image', 'assurena'),
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#1e73be',
                ],
            ],
            [
                'id' => 'blog_list_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_list_sidebar-start',
                'type' => 'section',
                'title' => esc_html__('Sidebar', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'blog_list_sidebar_layout',
                'type' => 'image_select',
                'title' => esc_html__('Sidebar Layout', 'assurena'),
                'options' => [
                    'none' => [
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'blog_list_sidebar_def',
                'type' => 'select',
                'title' => esc_html__('Sidebar Template', 'assurena'),
                'data' => 'sidebars',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'blog_list_sidebar_def_width',
                'type' => 'button_set',
                'title' => esc_html__('Sidebar Width', 'assurena'),
                'options' => [
                    '9' => '25%',
                    '8' => '33%',
                ],
                'default' => '8',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'blog_list_sidebar_sticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Sidebar', 'assurena'),
                'default' => false,
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'blog_list_sidebar_gap',
                'type' => 'select',
                'title' => esc_html__('Sidebar Side Gap', 'assurena'),
                'options' => [
                    'def' => esc_html__('Default', 'assurena'),
                    '0' => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ],
                'default' => 'def',
                'required' => ['blog_list_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'blog_list_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_list_appearance-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'blog_list_columns',
                'type' => 'button_set',
                'title' => esc_html__('Columns in Archive', 'assurena'),
                'options' => [
                    '12' => 'One',
                    '6' => 'Two',
                    '4' => 'Three',
                    '3' => 'Four'
                ],
                'default' => '12'
            ],
            [
                'id' => 'blog_list_share',
                'type' => 'switch',
                'title' => esc_html__('Shares', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_media',
                'type' => 'switch',
                'title' => esc_html__('Hide Media?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_title',
                'type' => 'switch',
                'title' => esc_html__('Hide Title?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_hide_content',
                'type' => 'switch',
                'title' => esc_html__('Hide Content?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_post_listing_content',
                'type' => 'switch',
                'title' => esc_html__('Cut Off Text in Blog Listing', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_letter_count',
                'type' => 'text',
                'title' => esc_html__('Limit amount of characters to be displayed.', 'assurena'),
                'default' => '85',
                'required' => ['blog_post_listing_content', '=', true],
            ],
            [
                'id' => 'blog_list_read_more',
                'type' => 'switch',
                'title' => esc_html__('Hide Read More Button?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_meta',
                'type' => 'switch',
                'title' => esc_html__('Hide all post-meta?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_list_meta_author',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta author?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['blog_list_meta', '=', false],
            ],
            [
                'id' => 'blog_list_meta_comments',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta comments?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['blog_list_meta', '=', false],
            ],
            [
                'id' => 'blog_list_meta_categories',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta categories?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['blog_list_meta', '=', false],
            ],
            [
                'id' => 'blog_list_meta_date',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta date?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['blog_list_meta', '=', false],
            ],
            [
                'id' => 'blog_list_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Single', 'assurena'),
        'id' => 'blog-single-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'single_type_layout',
                'type' => 'button_set',
                'title' => esc_html__('Default Post Layout', 'assurena'),
                'desc' => esc_html__('Note: each Post can be additionally customized within its Meta boxes section.', 'assurena'),
                'options' => [
                    '1' => esc_html__('Title First', 'assurena'),
                    '2' => esc_html__('Image First', 'assurena'),
                    '3' => esc_html__('Overlay Image', 'assurena')
                ],
                'default' => '3'
            ],
            [
                'id' => 'blog_single_page_title-start',
                'type' => 'section',
                'title' => esc_html__('Page Title', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'blog_title_conditional',
                'type' => 'switch',
                'title' => esc_html__('Page Title Text', 'assurena'),
                'on' => esc_html__('Custom', 'assurena'),
                'off' => esc_html__('Default', 'assurena'),
                'default' => 'off',
            ],
            [
                'id' => 'post_single_page_title_text',
                'type' => 'text',
                'title' => esc_html__('Custom Page Title Text', 'assurena'),
                'default' => esc_html__('Blog Post', 'assurena'),
                'required' => ['blog_title_conditional', '=', true],
            ],
            [
                'id' => 'blog_single_page_title_breadcrumbs_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'post_single_page_title_bg_image',
                'type' => 'background',
                'title' => esc_html__('Background Image', 'assurena'),
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#383838',
                ],
            ],
            [
                'id' => 'single_padding_layout_3',
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'title' => esc_html__('Padding Top/Bottom', 'assurena'),
                'desc' => esc_html__('Note: this setting affects only the "Overlay Image" post layout.', 'assurena'),
                'default' => [
                    'padding-top' => '120px',
                    'padding-bottom' => '90px',
                ],
            ],
            [
                'id' => 'blog_single_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_single_sidebar-start',
                'type' => 'section',
                'title' => esc_html__('Sidebar', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'single_sidebar_layout',
                'type' => 'image_select',
                'title' => esc_html__('Blog Single Sidebar Layout', 'assurena'),
                'options' => [
                    'none' => [
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'right'
            ],
            [
                'id' => 'single_sidebar_def',
                'type' => 'select',
                'title' => esc_html__('Blog Single Sidebar', 'assurena'),
                'data' => 'sidebars',
                'default' => 'sidebar_main-sidebar',
                'required' => ['single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'single_sidebar_def_width',
                'type' => 'button_set',
                'title' => esc_html__('Blog Single Sidebar Width', 'assurena'),
                'options' => [
                    '9' => '25%',
                    '8' => '33%',
                ],
                'default' => '8',
                'required' => ['single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'single_sidebar_sticky',
                'type' => 'switch',
                'title' => esc_html__('Blog Single Sticky Sidebar On?', 'assurena'),
                'default' => true,
                'required' => ['single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'single_sidebar_gap',
                'type' => 'select',
                'title' => esc_html__('Sidebar Side Gap', 'assurena'),
                'options' => [
                    'def' => esc_html__('Default', 'assurena'),
                    '0' => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ],
                'default' => 'def',
                'required' => ['single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'blog_single_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'blog_single_appearance-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'featured_image_type',
                'type' => 'button_set',
                'title' => esc_html__('Featured Image', 'assurena'),
                'options' => [
                    'default' => esc_html__('Default', 'assurena'),
                    'off' => esc_html__('Off', 'assurena'),
                    'replace' => esc_html__('Replace', 'assurena')
                ],
                'default' => 'default'
            ],
            [
                'id' => 'featured_image_replace',
                'type' => 'media',
                'title' => esc_html__('Image To Replace On', 'assurena'),
                'required' => ['featured_image_type', '=', 'replace'],
            ],
            [
                'id' => 'single_apply_animation',
                'type' => 'switch',
                'title' => esc_html__('Apply Animation?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => true,
                'required' => ['single_type_layout', '=', '3'],
            ],
            [
                'id' => 'single_views',
                'type' => 'switch',
                'title' => esc_html__('Views', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'single_share',
                'type' => 'switch',
                'title' => esc_html__('Shares', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'single_author_info',
                'type' => 'switch',
                'title' => esc_html__('Author Info', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'single_meta',
                'type' => 'switch',
                'title' => esc_html__('Hide all post-meta?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'single_meta_author',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta author?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['single_meta', '=', false],
            ],
            [
                'id' => 'single_meta_comments',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta comments?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => true,
                'required' => ['single_meta', '=', false],
            ],
            [
                'id' => 'single_meta_categories',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta categories?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['single_meta', '=', false],
            ],
            [
                'id' => 'single_meta_date',
                'type' => 'switch',
                'title' => esc_html__('Hide post-meta date?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
                'required' => ['single_meta', '=', false],
            ],
            [
                'id' => 'single_meta_tags',
                'type' => 'switch',
                'title' => esc_html__('Hide tags?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'blog_single_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Related', 'assurena'),
        'id' => 'blog-single-related-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'single_related_posts',
                'type' => 'switch',
                'title' => esc_html__('Related Posts', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'blog_title_r',
                'type' => 'text',
                'title' => esc_html__('Title', 'assurena'),
                'default' => esc_html__('Related Posts', 'assurena'),
                'required' => ['single_related_posts', '=', '1'],
            ],
            [
                'id' => 'blog_cat_r',
                'type' => 'select',
                'multi' => true,
                'title' => esc_html__('Select Categories', 'assurena'),
                'data' => 'categories',
                'width' => '20%',
                'required' => ['single_related_posts', '=', '1'],
            ],
            [
                'id' => 'blog_column_r',
                'type' => 'button_set',
                'title' => esc_html__('Columns', 'assurena'),
                'options' => [
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4'
                ],
                'default' => '6',
                'required' => ['single_related_posts', '=', '1'],
            ],
            [
                'id' => 'blog_number_r',
                'type' => 'text',
                'title' => esc_html__('Number of Related Items', 'assurena'),
                'default' => '2',
                'required' => ['single_related_posts', '=', '1'],
            ],
            [
                'id' => 'blog_carousel_r',
                'type' => 'switch',
                'title' => esc_html__('Display items in the carousel', 'assurena'),
                'default' => true,
                'required' => ['single_related_posts', '=', '1'],
            ],
        ]
    ]
);

// -> START Portfolio Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Portfolio', 'assurena'),
        'id' => 'portfolio-option',
        'icon' => 'el-icon-th',
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Archive', 'assurena'),
        'id' => 'portfolio-list-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_slug',
                'type' => 'text',
                'title' => esc_html__('Portfolio Slug', 'assurena'),
                'default' => 'portfolio',
            ],
            [
                'id' => 'portfolio_archive_page_title_bg_image',
                'type' => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview' => false,
                'title' => esc_html__('Archive Page Title Background Image', 'assurena'),
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#383838',
                ],
            ],
            [
                'id' => 'portfolio_list_sidebar_layout',
                'type' => 'image_select',
                'title' => esc_html__('Sidebar Layout', 'assurena'),
                'options' => [
                    'none' => [
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'portfolio_list_sidebar_def',
                'type' => 'select',
                'title' => esc_html__('Sidebar Template', 'assurena'),
                'data' => 'sidebars',
                'required' => ['portfolio_list_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'portfolio_list_appearance-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'portfolio_list_columns',
                'type' => 'button_set',
                'title' => esc_html__('Columns in Archive', 'assurena'),
                'options' => [
                    '1' => 'One',
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four'
                ],
                'default' => '3'
            ],
            [
                'id' => 'portfolio_list_show_filter',
                'type' => 'switch',
                'title' => esc_html__('Filter', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_list_filter_cats',
                'type' => 'select',
                'multi' => true,
                'title' => esc_html__('Select Categories', 'assurena'),
                'data' => 'terms',
                'args' => ['taxonomies' => 'portfolio-category'],
                'required' => ['portfolio_list_show_filter', '=', '1'],
            ],
            [
                'id' => 'portfolio_list_show_title',
                'type' => 'switch',
                'title' => esc_html__('Title', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_list_show_content',
                'type' => 'switch',
                'title' => esc_html__('Content', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_list_show_cat',
                'type' => 'switch',
                'title' => esc_html__('Categories', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_list_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Single', 'assurena'),
        'id' => 'portfolio-single-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_single_post_title-start',
                'type' => 'section',
                'title' => esc_html__('Post Title Settings', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'portfolio_title_conditional',
                'type' => 'switch',
                'title' => esc_html__('Post Title Text', 'assurena'),
                'on' => esc_html__('Custom', 'assurena'),
                'off' => esc_html__('Default', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_page_title_text',
                'type' => 'text',
                'title' => esc_html__('Custom Post Title Text', 'assurena'),
                'required' => ['portfolio_title_conditional', '=', true],
            ],
            [
                'id' => 'portfolio_single_title_align',
                'type' => 'button_set',
                'title' => esc_html__('Title Alignment', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'portfolio_single_breadcrumbs_align',
                'type' => 'button_set',
                'title' => esc_html__('Breadcrumbs Alignment', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'center',
            ],
            [
                'id' => 'portfolio_single_breadcrumbs_block_switch',
                'type' => 'switch',
                'title' => esc_html__('Breadcrumbs Full Width', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_title_bg_switch',
                'type' => 'switch',
                'title' => esc_html__('Use Background Image/Color?', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_page_title_bg_image',
                'type' => 'background',
                'title' => esc_html__('Background Image/Color', 'assurena'),
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '',
                ],
                'required' => ['portfolio_single_title_bg_switch', '=', true],
            ],
            [
                'id' => 'portfolio_single_page_title_padding',
                'type' => 'spacing',
                'title' => esc_html__('Paddings Top/Bottom', 'assurena'),
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
            ],
            [
                'id' => 'portfolio_single_page_title_margin',
                'type' => 'spacing',
                'title' => esc_html__('Margin Bottom', 'assurena'),
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
                'default' => ['margin-bottom' => '32'],
            ],
            [
                'id' => 'portfolio_single_post_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_single_sidebar-start',
                'type' => 'section',
                'title' => esc_html__('Sidebar', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'portfolio_single_sidebar_layout',
                'type' => 'image_select',
                'title' => esc_html__('Sidebar Layout', 'assurena'),
                'options' => [
                    'none' => [
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'none'
            ],
            [
                'id' => 'portfolio_single_sidebar_def',
                'type' => 'select',
                'title' => esc_html__('Sidebar Template', 'assurena'),
                'data' => 'sidebars',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'portfolio_single_sidebar_def_width',
                'type' => 'button_set',
                'title' => esc_html__('Sidebar Width', 'assurena'),
                'options' => [
                    '9' => '25%',
                    '8' => '33%',
                ],
                'default' => '8',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'portfolio_single_sidebar_sticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Sidebar', 'assurena'),
                'default' => false,
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'portfolio_single_sidebar_gap',
                'type' => 'select',
                'title' => esc_html__('Sidebar Side Gap', 'assurena'),
                'options' => [
                    'def' => esc_html__('Default', 'assurena'),
                    '0' => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ],
                'default' => 'def',
                'required' => ['portfolio_single_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'portfolio_single_sidebar-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => 'portfolio_single_appearance-start',
                'type' => 'section',
                'title' => esc_html__('Appearance', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'portfolio_single_align',
                'type' => 'button_set',
                'title' => esc_html__('Content Alignment', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left',
            ],
            [
                'id' => 'portfolio_above_content_cats',
                'type' => 'switch',
                'title' => esc_html__('Tags', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_above_content_share',
                'type' => 'switch',
                'title' => esc_html__('Shares', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'portfolio_single_meta',
                'type' => 'switch',
                'title' => esc_html__('Hide all post-meta?', 'assurena'),
                'on' => esc_html__('Yes', 'assurena'),
                'off' => esc_html__('No', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'portfolio_single_meta_author',
                'type' => 'switch',
                'title' => esc_html__('Post-meta author', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
                'required' => ['portfolio_single_meta', '=', false],
            ],
            [
                'id' => 'portfolio_single_meta_comments',
                'type' => 'switch',
                'title' => esc_html__('Post-meta comments', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => false,
                'required' => ['portfolio_single_meta', '=', false],
            ],
            [
                'id' => 'portfolio_single_meta_categories',
                'type' => 'switch',
                'title' => esc_html__('Post-meta categories', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
                'required' => ['portfolio_single_meta', '=', false],
            ],
            [
                'id' => 'portfolio_single_meta_date',
                'type' => 'switch',
                'title' => esc_html__('Post-meta date', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
                'required' => ['portfolio_single_meta', '=', false],
            ],
            [
                'id' => 'portfolio_single_appearance-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Related Posts', 'assurena'),
        'id' => 'portfolio-related-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'portfolio_related_switch',
                'type' => 'switch',
                'title' => esc_html__('Related Posts', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'pf_title_r',
                'type' => 'text',
                'title' => esc_html__('Title', 'assurena'),
                'default' => esc_html__('Related Projects', 'assurena'),
                'required' => ['portfolio_related_switch', '=', '1'],
            ],
            [
                'id' => 'pf_carousel_r',
                'type' => 'switch',
                'title' => esc_html__('Display items carousel for this portfolio post', 'assurena'),
                'default' => true,
                'required' => ['portfolio_related_switch', '=', '1'],
            ],
            [
                'id' => 'pf_column_r',
                'type' => 'button_set',
                'title' => esc_html__('Related Columns', 'assurena'),
                'options' => [
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four'
                ],
                'default' => '3',
                'required' => ['portfolio_related_switch', '=', '1'],
            ],
            [
                'id' => 'pf_number_r',
                'type' => 'text',
                'title' => esc_html__('Number of Related Items', 'assurena'),
                'default' => '3',
                'required' => ['portfolio_related_switch', '=', '1'],
            ],
        ]
    ]
);

// -> START Team Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Team', 'assurena'),
        'id' => 'team-option',
        'icon' => 'el-icon-th',
        'fields' => [
            [
                'id' => 'team_slug',
                'title' => esc_html__('Team Slug', 'assurena'),
                'type' => 'text',
                'default' => 'team',
            ],
        ]
    ]
);

Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Single', 'assurena'),
        'id' => 'team-single-option',
        'subsection' => true,
        'fields' => [
            [
                'id' => 'team_title_conditional',
                'title' => esc_html__('Page Title Text', 'assurena'),
                'type' => 'switch',
                'on' => esc_html__('Custom', 'assurena'),
                'off' => esc_html__('Default', 'assurena'),
                'default' => true,
            ],
            [
                'id' => 'team_single_page_title_text',
                'title' => esc_html__('Custom Page Title Text', 'assurena'),
                'type' => 'text',
                'required' => ['team_title_conditional', '=', true],
                'default' => esc_html__('Team', 'assurena'),
            ],
            [
                'id' => 'team_single_page_title_bg_image',
                'title' => esc_html__('Single Page Title Background Image', 'assurena'),
                'type' => 'background',
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '#383838',
                ],
            ],
        ]
    ]
);

// -> START Page 404 Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Page 404', 'assurena'),
        'id' => '404-option',
        'icon' => 'el-icon-th',
        'fields' => [
            [
                'id' => '404_page_main_bg_image',
                'title' => esc_html__('Main Background', 'assurena'),
                'type' => 'background',
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'no-repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'right top',
                    'background-color' => '#ffffff',
                ],
            ],
            [
                'id' => '404_page_title_switcher',
                'title' => esc_html__('Page Title Section', 'assurena'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => '404_post_title-start',
                'type' => 'section',
                'indent' => true,
                'required' => ['404_page_title_switcher', '=', true],
            ],
            [
                'id' => '404_custom_title_switch',
                'title' => esc_html__('Page Title Text', 'assurena'),
                'type' => 'switch',
                'on' => esc_html__('Custom', 'assurena'),
                'off' => esc_html__('Default', 'assurena'),
                'default' => false,
                'required' => ['404_page_title_switcher', '=', true],
            ],
            [
                'id' => '404_page_title_text',
                'title' => esc_html__('Custom Page Title Text', 'assurena'),
                'type' => 'text',
                'default' => esc_html__('', 'assurena'),
                'required' => ['404_custom_title_switch', '=', true],
            ],
            [
                'id' => '404_title_bg_switch',
                'title' => esc_html__('Background Image/Color', 'assurena'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
                'required' => ['404_page_title_switcher', '=', true],
            ],
            [
                'id' => '404_page_title_bg_image',
                'title' => esc_html__('Background Image/Color', 'assurena'),
                'type' => 'background',
                'required' => ['404_title_bg_switch', '=', true],
                'preview' => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'default' => [
                    'background-repeat' => 'repeat',
                    'background-size' => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position' => 'center center',
                    'background-color' => '',
                ],
            ],
            [
                'id' => '404_page_title_padding',
                'title' => esc_html__('Paddings Top/Bottom', 'assurena'),
                'type' => 'spacing',
                'mode' => 'padding',
                'all' => false,
                'bottom' => true,
                'top' => true,
                'left' => false,
                'right' => false,
                'required' => ['404_title_bg_switch', '=', true],
            ],
            [
                'id' => '404_page_title_margin',
                'title' => esc_html__('Margin Bottom', 'assurena'),
                'type' => 'spacing',
                'mode' => 'margin',
                'all' => false,
                'bottom' => true,
                'top' => false,
                'left' => false,
                'right' => false,
                'required' => ['404_title_bg_switch', '=', true],
            ],
            [
                'id' => '404_page_title-end',
                'type' => 'section',
                'indent' => false,
            ],
            [
                'id' => '404_show_header',
                'type' => 'switch',
                'title' => esc_html__('Header Section', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
            [
                'id' => '404_show_footer',
                'type' => 'switch',
                'title' => esc_html__('Footer Section', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Hide', 'assurena'),
                'default' => true,
            ],
        ]
    ]
);

// -> START Side Panel Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Side Panel', 'assurena'),
        'id' => 'side_panel',
        'icon' => 'el-icon-th',
        'fields' => [
            [
                'id' => 'side_panel_enable',
                'type' => 'switch',
                'title' => esc_html__('Side Panel', 'assurena'),
                'on' => esc_html__('Use', 'assurena'),
                'off' => esc_html__('Disable', 'assurena'),
                'default' => false,
            ],
            [
                'id' => 'side_panel-start',
                'type' => 'section',
                'title' => esc_html__('Side Panel Settings', 'assurena'),
                'indent' => true,
                'required' => ['side_panel_enable', '=', '1'],
            ],
            [
                'id' => 'side_panel_content_type',
                'type' => 'select',
                'title' => esc_html__('Content Type', 'assurena'),
                'options' => [
                    'widgets' => esc_html__('Get Widgets', 'assurena'),
                    'pages' => esc_html__('Get Pages', 'assurena')
                ],
                'default' => 'pages'
            ],
            [
                'id' => 'side_panel_page_select',
                'type' => 'select',
                'title' => esc_html__('Page Select', 'assurena'),
                'data' => 'posts',
                'args' => [
                    'post_type' => 'side_panel',
                    'posts_per_page' => -1,
                    'orderby' => 'title',
                    'order' => 'ASC',
                ],
                'required' => ['side_panel_content_type', '=', 'pages']
            ],
            [
                'id' => 'side_panel_spacing',
                'type' => 'spacing',
                'title' => esc_html__('Paddings', 'assurena'),
                'output' => ['#side-panel .side-panel_sidebar'],
                'mode' => 'padding',
                'units' => 'px',
                'all' => false,
                'default' => [
                    'padding-top' => '40px',
                    'padding-right' => '50px',
                    'padding-bottom' => '40px',
                    'padding-left' => '50px',
                ],
            ],
            [
                'id' => 'side_panel_title_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Title Color', 'assurena'),
                'default' => [
                    'color' => '#232323',
                    'alpha' => '1',
                    'rgba' => 'rgba(35,35,35,1)'
                ],
                'mode' => 'background',
                'required' => ['side_panel_content_type', '=', 'widgets'],
            ],
            [
                'id' => 'side_panel_text_color',
                'type' => 'color_rgba',
                'title' => esc_html__('Text Color', 'assurena'),
                'default' => [
                    'color' => '#cccccc',
                    'alpha' => '1',
                    'rgba' => 'rgba(204,204,204,1)'
                ],
                'mode' => 'background',
                'required' => ['side_panel_content_type', '=', 'widgets'],
            ],
            [
                'id' => 'side_panel_bg',
                'type' => 'color_rgba',
                'title' => esc_html__('Background', 'assurena'),
                'default' => [
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba' => 'rgba(255,255,255,1)'
                ],
                'mode' => 'background',
            ],
            [
                'id' => 'side_panel_text_alignment',
                'type' => 'button_set',
                'title' => esc_html__('Text Align', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'center' => esc_html__('Center', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'left'
            ],
            [
                'id' => 'side_panel_width',
                'type' => 'dimensions',
                'title' => esc_html__('Width', 'assurena'),
                'units' => 'px',
                'units_extended' => false,
                'height' => false,
                'width' => true,
                'default' => ['width' => 375],
            ],
            [
                'id' => 'side_panel_position',
                'type' => 'button_set',
                'title' => esc_html__('Position', 'assurena'),
                'options' => [
                    'left' => esc_html__('Left', 'assurena'),
                    'right' => esc_html__('Right', 'assurena'),
                ],
                'default' => 'right'
            ],
            [
                'id' => 'side_panel-end',
                'type' => 'section',
                'indent' => false,
                'required' => ['side_panel_enable', '=', '1'],
            ],
        ]
    ]
);

// -> START Layout Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Sidebars', 'assurena'),
        'id' => 'layout_options',
        'icon' => 'el el-braille',
        'fields' => [
            [
                'id' => 'sidebars',
                'type' => 'multi_text',
                'validate' => 'no_html',
                'add_text' => esc_html__('Add Sidebar', 'assurena'),
                'title' => esc_html__('Register Sidebars', 'assurena'),
                'default' => ['Main Sidebar'],
            ],
            [
                'id' => 'sidebars-start',
                'type' => 'section',
                'title' => esc_html__('Sidebar Page Settings', 'assurena'),
                'indent' => true,
            ],
            [
                'id' => 'page_sidebar_layout',
                'type' => 'image_select',
                'title' => esc_html__('Page Sidebar Layout', 'assurena'),
                'options' => [
                    'none' => [
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ],
                    'left' => [
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ],
                    'right' => [
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    ]
                ],
                'default' => 'right'
            ],
            [
                'id' => 'page_sidebar_def',
                'type' => 'select',
                'title' => esc_html__('Page Sidebar', 'assurena'),
                'data' => 'sidebars',
                'required' => ['page_sidebar_layout', '!=', 'none'],
                'default' => 'sidebar_main-sidebar'
            ],
            [
                'id' => 'page_sidebar_def_width',
                'type' => 'button_set',
                'title' => esc_html__('Page Sidebar Width', 'assurena'),
                'options' => [
                    '9' => '25%',
                    '8' => '33%',
                ],
                'default' => '8',
                'required' => ['page_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'page_sidebar_sticky',
                'type' => 'switch',
                'title' => esc_html__('Sticky Sidebar On?', 'assurena'),
                'default' => false,
                'required' => ['page_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'page_sidebar_gap',
                'type' => 'select',
                'title' => esc_html__('Sidebar Side Gap', 'assurena'),
                'options' => [
                    'def' => esc_html__('Default', 'assurena'),
                    '0' => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ],
                'default' => 'def',
                'required' => ['page_sidebar_layout', '!=', 'none'],
            ],
            [
                'id' => 'sidebars-end',
                'type' => 'section',
                'indent' => false,
            ],
        ]
    ]
);

// -> START Styling Options
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Color Options', 'assurena'),
        'id' => 'color_options_color',
        'icon' => 'el-icon-tint',
        'fields' => [
            [
                'id' => 'theme-primary-color',
                'type' => 'color',
                'title' => esc_html__('Primary Theme Color', 'assurena'),
                'transparent' => false,
                'validate' => 'color',
                'default' => '#2462D2',
            ],
            [
                'id' => 'theme-secondary-color',
                'type' => 'color',
                'title' => esc_html__('Secondary Theme Color', 'assurena'),
                'transparent' => false,
                'validate' => 'color',
                'default' => '#2F3D48',
            ],
            [
                'id' => 'body-background-color',
                'type' => 'color',
                'title' => esc_html__('Body Background Color', 'assurena'),
                'transparent' => false,
                'validate' => 'color',
                'default' => '#ffffff',
            ],
        ]
    ]
);

// Start Typography config
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Typography', 'assurena'),
        'id' => 'Typography',
        'icon' => 'el-icon-font',
    ]
);

$typography = [];
$main_typography = [
    [
        'id' => 'main-font',
        'title' => esc_html__('Content Font', 'assurena'),
        'color' => true,
        'line-height' => true,
        'font-size' => true,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'font-size' => '16px',
            'line-height' => '30px',
            'color' => '#616161',
            'font-family' => 'Fira Sans',
            'font-weight' => '400',
            'font-weight-multi' => '300,500',
        ],
    ],
    [
        'id' => 'header-font',
        'title' => esc_html__('Headings Font', 'assurena'),
        'font-size' => false,
        'line-height' => false,
        'color' => true,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'google' => true,
            'color' => '#232323',
            'font-family' => 'Fira Sans',
            'font-weight' => '700',
            'font-weight-multi' => '600,800,900',
        ],
    ],
    [
        'id' => 'additional-font',
        'title' => esc_html__('Additional Font', 'assurena'),
        'font-size' => false,
        'line-height' => false,
        'color' => false,
        'subsets' => false,
        'all_styles' => true,
        'font-weight-multi' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Poppins',
            'font-weight' => '700',
            'font-weight-multi' => '700',
        ],
    ],
];
foreach ($main_typography as $key => $value) {
    array_push(
        $typography,
        [
            'id' => $value['id'],
            'type' => 'custom_typography',
            'title' => $value['title'],
            'color' => $value['color'],
            'line-height' => $value['line-height'],
            'font-size' => $value['font-size'],
            'subsets' => $value['subsets'],
            'all_styles' => $value['all_styles'],
            'font-weight-multi' => isset($value['font-weight-multi']) ? $value['font-weight-multi'] : '',
            'subtitle' => isset($value['subtitle']) ? $value['subtitle'] : '',
            'google' => true,
            'font-style' => true,
            'font-backup' => false,
            'text-align' => false,
            'default' => $value['defs'],
        ]
    );
}
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Main Content', 'assurena'),
        'id' => 'main_typography',
        'subsection' => true,
        'fields' => $typography
    ]
);

// Start menu typography
$menu_typography = [
    [
        'id' => 'menu-font',
        'title' => esc_html__('Menu Font', 'assurena'),
        'color' => false,
        'line-height' => true,
        'font-size' => true,
        'subsets' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Fira Sans',
            'font-size' => '17px',
            'font-weight' => '700',
            'line-height' => '30px'
        ],
    ],
    [
        'id' => 'sub-menu-font',
        'title' => esc_html__('Submenu Font', 'assurena'),
        'color' => false,
        'line-height' => true,
        'font-size' => true,
        'subsets' => true,
        'defs' => [
            'google' => true,
            'font-family' => 'Fira Sans',
            'font-size' => '16px',
            'font-weight' => '700',
            'line-height' => '30px'
        ],
    ],
];
$menu_typography_array = [];
foreach ($menu_typography as $key => $value) {
    array_push($menu_typography_array, [
        'id' => $value['id'],
        'type' => 'custom_typography',
        'title' => $value['title'],
        'color' => $value['color'],
        'line-height' => $value['line-height'],
        'font-size' => $value['font-size'],
        'subsets' => $value['subsets'],
        'google' => true,
        'font-style' => true,
        'font-backup' => false,
        'text-align' => false,
        'all_styles' => false,
        'default' => $value['defs'],
    ]);
}
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Menu', 'assurena'),
        'id' => 'main_menu_typography',
        'subsection' => true,
        'fields' => $menu_typography_array
    ]
);
// End menu Typography

// Start headings typography
$headings = [
    [
        'id' => 'header-h1',
        'title' => esc_html__('H1', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '48px',
            'line-height' => '72px',
            'font-weight' => '700',
        ],
    ],
    [
        'id' => 'header-h2',
        'title' => esc_html__('H2', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '42px',
            'line-height' => '60px',
            'font-weight' => '700',
        ],
    ],
    [
        'id' => 'header-h3',
        'title' => esc_html__('H3', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '36px',
            'line-height' => '50px',
            'font-weight' => '700',
        ],
    ],
    [
        'id' => 'header-h4',
        'title' => esc_html__('H4', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '30px',
            'line-height' => '40px',
            'font-weight' => '600',
        ],
    ],
    [
        'id' => 'header-h5',
        'title' => esc_html__('H5', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '24px',
            'line-height' => '38px',
            'font-weight' => '600'
        ],
    ],
    [
        'id' => 'header-h6',
        'title' => esc_html__('H6', 'assurena'),
        'defs' => [
            'font-family' => 'Fira Sans',
            'font-size' => '20px',
            'line-height' => '32px',
            'font-weight' => '600',
        ],
    ],
];
$headings_array = [];
foreach ($headings as $key => $heading) {
    array_push($headings_array, [
        'id' => $heading['id'],
        'type' => 'custom_typography',
        'title' => $heading['title'],
        'google' => true,
        'font-backup' => false,
        'font-size' => true,
        'line-height' => true,
        'color' => false,
        'word-spacing' => false,
        'letter-spacing' => true,
        'text-align' => false,
        'text-transform' => true,
        'default' => $heading['defs'],
    ]);
}

// Typogrophy section
Redux::setSection(
    $theme_slug,
    [
        'title' => esc_html__('Headings', 'assurena'),
        'id' => 'main_headings_typography',
        'subsection' => true,
        'fields' => $headings_array
    ]
);
// End Typography config

if (class_exists('WooCommerce')) {
    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Shop', 'assurena'),
            'id' => 'shop-option',
            'icon' => 'el-icon-shopping-cart',
            'fields' => []
        ]
    );

    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Catalog', 'assurena'),
            'id' => 'shop-catalog-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_catalog_page_title_bg_image',
                    'type' => 'background',
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'title' => esc_html__('Catalog Page Title Background Image', 'assurena'),
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '#1e73be',
                    ]
                ],
                [
                    'id' => 'shop_catalog_sidebar-start',
                    'type' => 'section',
                    'title' => esc_html__('Sidebar Settings', 'assurena'),
                    'indent' => true,
                ],
                [
                    'id' => 'shop_catalog_sidebar_layout',
                    'type' => 'image_select',
                    'title' => esc_html__('Sidebar Layout', 'assurena'),
                    'options' => [
                        'none' => [
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => 'Left',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => 'Right',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ],
                    ],
                    'default' => 'left'
                ],
                [
                    'id' => 'shop_catalog_sidebar_def',
                    'type' => 'select',
                    'title' => esc_html__('Shop Catalog Sidebar', 'assurena'),
                    'data' => 'sidebars',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_catalog_sidebar_def_width',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Sidebar Width', 'assurena'),
                    'options' => [
                        '9' => '25%',
                        '8' => '33%',
                    ],
                    'default' => '8',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_catalog_sidebar_sticky',
                    'type' => 'switch',
                    'title' => esc_html__('Sticky Sidebar On?', 'assurena'),
                    'default' => false,
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_catalog_sidebar_gap',
                    'type' => 'select',
                    'title' => esc_html__('Sidebar Side Gap', 'assurena'),
                    'options' => [
                        'def' => esc_html__('Default', 'assurena'),
                        '0' => '0',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                    ],
                    'default' => 'def',
                    'required' => ['shop_catalog_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_catalog_sidebar-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'shop_column',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Column', 'assurena'),
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4'
                    ],
                    'default' => '3',
                ],
                [
                    'id' => 'shop_products_per_page',
                    'type' => 'spinner',
                    'title' => esc_html__('Products per page', 'assurena'),
                    'default' => '12',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                ],
                [
                    'id' => 'use_animation_shop',
                    'type' => 'switch',
                    'title' => esc_html__('Use Animation Shop?', 'assurena'),
                    'default' => true,
                ],
                [
                    'id' => 'shop_catalog_animation_style',
                    'type' => 'select',
                    'select2' => ['allowClear' => false],
                    'title' => esc_html__('Animation Style', 'assurena'),
                    'options' => [
                        'fade-in' => esc_html__('Fade In', 'assurena'),
                        'slide-top' => esc_html__('Slide Top', 'assurena'),
                        'slide-bottom' => esc_html__('Slide Bottom', 'assurena'),
                        'slide-left' => esc_html__('Slide Left', 'assurena'),
                        'slide-right' => esc_html__('Slide Right', 'assurena'),
                        'zoom' => esc_html__('Zoom', 'assurena'),
                    ],
                    'default' => 'slide-left',
                    'required' => ['use_animation_shop', '=', true],
                ],
            ]
        ]
    );
    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Single', 'assurena'),
            'id' => 'shop-single-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_single_post_title-start',
                    'type' => 'section',
                    'title' => esc_html__('Post Title Settings', 'assurena'),
                    'indent' => true,
                ],
                [
                    'id' => 'shop_title_conditional',
                    'type' => 'switch',
                    'title' => esc_html__('Post Title Text', 'assurena'),
                    'on' => esc_html__('Custom', 'assurena'),
                    'off' => esc_html__('Default', 'assurena'),
                    'default' => false,
                ],
                [
                    'id' => 'shop_single_page_title_text',
                    'type' => 'text',
                    'title' => esc_html__('Custom Post Title Text', 'assurena'),
                    'required' => ['shop_title_conditional', '=', true],
                ],
                [
                    'id' => 'shop_single_title_align',
                    'type' => 'button_set',
                    'title' => esc_html__('Title Alignment', 'assurena'),
                    'options' => [
                        'left' => esc_html__('Left', 'assurena'),
                        'center' => esc_html__('Center', 'assurena'),
                        'right' => esc_html__('Right', 'assurena'),
                    ],
                    'default' => 'center',
                ],
                [
                    'id' => 'shop_single_breadcrumbs_block_switch',
                    'type' => 'switch',
                    'title' => esc_html__('Breadcrumbs Display', 'assurena'),
                    'on' => 'Block',
                    'off' => 'Inline',
                    'default' => true,
                    'required' => ['page_title_breadcrumbs_switch', '=', true],
                ],
                [
                    'id' => 'shop_single_breadcrumbs_align',
                    'type' => 'button_set',
                    'title' => esc_html__('Title Breadcrumbs Alignment', 'assurena'),
                    'options' => [
                        'left' => esc_html__('Left', 'assurena'),
                        'center' => esc_html__('Center', 'assurena'),
                        'right' => esc_html__('Right', 'assurena'),
                    ],
                    'default' => 'center',
                    'required' => [
                        ['page_title_breadcrumbs_switch', '=', true],
                        ['shop_single_breadcrumbs_block_switch', '=', true]
                    ],
                ],
                [
                    'id' => 'shop_single_title_bg_switch',
                    'type' => 'switch',
                    'title' => esc_html__('Use Background Image/Color?', 'assurena'),
                    'default' => true,
                ],
                [
                    'id' => 'shop_single_page_title_bg_image',
                    'type' => 'background',
                    'title' => esc_html__('Background Image/Color', 'assurena'),
                    'preview' => false,
                    'preview_media' => true,
                    'background-color' => true,
                    'transparent' => false,
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '',
                    ],
                    'required' => ['shop_single_title_bg_switch', '=', true],
                ],
                [
                    'id' => 'shop_single_page_title_padding',
                    'type' => 'spacing',
                    'title' => esc_html__('Paddings Top/Bottom', 'assurena'),
                    'mode' => 'padding',
                    'all' => false,
                    'bottom' => true,
                    'top' => true,
                    'left' => false,
                    'right' => false,
                ],
                [
                    'id' => 'shop_single_page_title_margin',
                    'type' => 'spacing',
                    'title' => esc_html__('Margin Bottom', 'assurena'),
                    'mode' => 'margin',
                    'all' => false,
                    'bottom' => true,
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'default' => ['margin-bottom' => '47'],
                ],
                [
                    'id' => 'shop_single_page_title_border_switch',
                    'type' => 'switch',
                    'title' => esc_html__('Enable Border Top?', 'assurena'),
                    'default' => false,
                ],
                [
                    'id' => 'shop_single_page_title_border_color',
                    'type' => 'color_rgba',
                    'title' => esc_html__('Border Top Color', 'assurena'),
                    'default' => [
                        'color' => '#e5e5e5',
                        'alpha' => '1',
                        'rgba' => 'rgba(229,229,229,1)'
                    ],
                    'required' => ['shop_single_page_title_border_switch', '=', true],
                ],
                [
                    'id' => 'shop_single_post_title-end',
                    'type' => 'section',
                    'indent' => false,
                ],
                [
                    'id' => 'shop_single_sidebar_layout',
                    'type' => 'image_select',
                    'title' => esc_html__('Shop Single Sidebar Layout', 'assurena'),
                    'options' => [
                        'none' => [
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ],
                        'left' => [
                            'alt' => 'Left',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ],
                        'right' => [
                            'alt' => 'Right',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ],
                    ],
                    'default' => 'none',
                ],
                [
                    'id' => 'shop_single_sidebar_def',
                    'type' => 'select',
                    'title' => esc_html__('Shop Single Sidebar', 'assurena'),
                    'data' => 'sidebars',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_single_sidebar_def_width',
                    'type' => 'button_set',
                    'title' => esc_html__('Shop Single Sidebar Width', 'assurena'),
                    'options' => [
                        '9' => '25%',
                        '8' => '33%',
                    ],
                    'default' => '8',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_single_sidebar_sticky',
                    'type' => 'switch',
                    'title' => esc_html__('Shop Single Sticky Sidebar On?', 'assurena'),
                    'default' => false,
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_single_sidebar_gap',
                    'type' => 'select',
                    'title' => esc_html__('Shop Single Sidebar Side Gap', 'assurena'),
                    'options' => [
                        'def' => esc_html__('Default', 'assurena'),
                        '0' => '0',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                    ],
                    'default' => 'def',
                    'required' => ['shop_single_sidebar_layout', '!=', 'none'],
                ],
                [
                    'id' => 'shop_single_share',
                    'type' => 'switch',
                    'title' => esc_html__('Share On/Off', 'assurena'),
                    'default' => false,
                ],
            ]
        ]
    );
    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Related', 'assurena'),
            'id' => 'shop-related-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_related_columns',
                    'type' => 'button_set',
                    'title' => esc_html__('Related products column', 'assurena'),
                    'options' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4'
                    ],
                    'default' => '4',
                ],
                [
                    'id' => 'shop_r_products_per_page',
                    'type' => 'spinner',
                    'title' => esc_html__('Related products per page', 'assurena'),
                    'default' => '4',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                ],
            ]
        ]
    );
    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Cart', 'assurena'),
            'id' => 'shop-cart-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_cart_page_title_bg_image',
                    'type' => 'background',
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'title' => esc_html__('Cart Page Title Background Image', 'assurena'),
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '#383838',
                    ],
                ],
            ]
        ]
    );
    Redux::setSection(
        $theme_slug,
        [
            'title' => esc_html__('Checkout', 'assurena'),
            'id' => 'shop-checkout-option',
            'subsection' => true,
            'fields' => [
                [
                    'id' => 'shop_checkout_page_title_bg_image',
                    'type' => 'background',
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'title' => esc_html__('Checkout Page Title Background Image', 'assurena'),
                    'default' => [
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '#383838',
                    ],
                ],
            ]
        ]
    );
}
