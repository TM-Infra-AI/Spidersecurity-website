<?php 

if ( ! class_exists('RWMB_Loader') ) return;


class assurena_Metaboxes
{
	public function __construct()
	{
		// Team Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'team_meta_boxes' ] );

		// Portfolio Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_meta_boxes' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_post_settings_meta_boxes' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'portfolio_related_meta_boxes' ] );

		// Blog Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'blog_settings_meta_boxes' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'blog_meta_boxes' ] );
		add_filter( 'rwmb_meta_boxes', [ $this, 'blog_related_meta_boxes' ]);
		
		// Page Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_layout_meta_boxes' ] );
		// Colors Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_color_meta_boxes' ] );			
		// Header Builder Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_header_meta_boxes' ] );
		// Title Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_title_meta_boxes' ] );
		// Side Panel Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_side_panel_meta_boxes' ] );		

		// Social Shares Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_soc_icons_meta_boxes' ] );	
		// Footer Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_footer_meta_boxes' ] );				
		// Copyright Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', [ $this, 'page_copyright_meta_boxes' ] );		
		
	}

	public function team_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Team Options', 'assurena'),
			'post_types' => [ 'team' ],
			'context' => 'advanced',
			'fields' => [      
				[
					'name' => esc_html__('Member Department', 'assurena'),
					'id' => 'department',
					'type' => 'text',
					'class' => 'field-inputs'
				],	        	
				[
					'name' => esc_html__('Member Info', 'assurena'),
					'id' => 'info_items',
					'type' => 'social',
					'clone' => true,
					'sort_clone' => true,
					'options' => [
						'name' => [
							'name' => esc_html__('Name', 'assurena'),
							'type_input' => 'text'
						],
						'description' => [
							'name' => esc_html__('Description', 'assurena'),
							'type_input' => 'text'
						],
						'link' => [
							'name' => esc_html__('Link', 'assurena'),
							'type_input' => 'text'
						],
					],
				],		
				[
					'name' => esc_html__('Social Icons', 'assurena'),
					'id' => 'soc_icon',
					'type' => 'select_icon',
					'options' => stlAdminIcon()->get_icons_name(),
					'clone' => true,
					'sort_clone' => true,
					'placeholder' => esc_html__('Select an icon', 'assurena'),
					'multiple' => false,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Info Background Image', 'assurena'),
					'id' => 'mb_info_bg',
					'type' => 'file_advanced',
					'max_file_uploads' => 1,
					'mime_type' => 'image',
				], 
			],
		];
		return $meta_boxes;
	}
	
	public function portfolio_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Portfolio Options', 'assurena'),
			'post_types' => [ 'portfolio' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Featured Image', 'assurena'),
					'id' => 'mb_portfolio_featured_image_conditional',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				], 
				[
					'name' => esc_html__('Featured Image Settings', 'assurena'),
					'id' => 'mb_portfolio_featured_image_type',
					'type' => 'button_group',
					'options' => [
						'off' => esc_html__('Off', 'assurena'),
						'replace' => esc_html__('Replace', 'assurena'),
					],
					'multiple' => false,
					'std' => 'off',
					'attributes' => [
						'data-conditional-logic' => [ [
								[ 'mb_portfolio_featured_image_conditional', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Featured Image Replace', 'assurena'),
					'id' => 'mb_portfolio_featured_image_replace',
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_featured_image_conditional', '=', 'custom' ],
							[ 'mb_portfolio_featured_image_type', '=', 'replace' ],
						] ],
					],
				],
				[
					'id' => 'mb_portfolio_title',
					'name' => esc_html__('Show Title on Single', 'assurena'),
					'type' => 'switch',
					'std' => 'true',
				],	
				[
					'id' => 'mb_portfolio_link',
					'name' => esc_html__('Add Custom Link for Portfolio Grid', 'assurena'),
					'type' => 'switch',
				],
				[
					'name' => esc_html__('Custom URL for Portfolio Grid', 'assurena'),
					'id' => 'portfolio_custom_url',
					'type' => 'text',
					'class' => 'field-inputs',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_link', '=', '1' ]
						], ],
					],
				],
				[
					'id' => 'portfolio_custom_url_target',
					'name' => esc_html__('Open Custom URL in New Window', 'assurena'),
					'type' => 'switch',
					'std' => 'true',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_link', '=', '1' ]
						], ],
					],
				],
				[
					'name' => esc_html__('Info', 'assurena'),
					'id' => 'mb_portfolio_info_items',
					'type' => 'social',
					'clone' => true,
					'sort_clone' => true,
					'desc' => esc_html__('Description', 'assurena'),
					'options' => [
						'name' => [
							'name' => esc_html__('Name', 'assurena'),
							'type_input' => 'text'
						],
						'description' => [
							'name' => esc_html__('Description', 'assurena'),
							'type_input' => 'text'
						],
						'link' => [
							'name' => esc_html__('URL', 'assurena'),
							'type_input' => 'text'
						],
					],
				],		
				[
					'name' => esc_html__('Info Description', 'assurena'),
					'id' => 'mb_portfolio_editor',
					'type' => 'wysiwyg',
					'multiple' => false,
					'desc' => esc_html__('Info description is shown in one row with a main info', 'assurena'),
				],			
				[
					'name' => esc_html__('Categories', 'assurena'),
					'id' => 'mb_portfolio_single_meta_categories',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'yes' => esc_html__('Use', 'assurena'),
						'no' => esc_html__('Hide', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],			
				[
					'name' => esc_html__('Date', 'assurena'),
					'id' => 'mb_portfolio_single_meta_date',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'yes' => esc_html__('Use', 'assurena'),
						'no' => esc_html__('Hide', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],			
				[
					'name' => esc_html__('Tags', 'assurena'),
					'id' => 'mb_portfolio_above_content_cats',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'yes' => esc_html__('Use', 'assurena'),
						'no' => esc_html__('Hide', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],		
				[
					'name' => esc_html__('Share Links', 'assurena'),
					'id' => 'mb_portfolio_above_content_share',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'yes' => esc_html__('Use', 'assurena'),
						'no' => esc_html__('Hide', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],	
			],
		];
		return $meta_boxes;
	}

	public function portfolio_post_settings_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Portfolio Post Settings', 'assurena'),
			'post_types' => [ 'portfolio' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Post Layout', 'assurena'),
					'id' => 'mb_portfolio_post_conditional',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],        
				[
					'name' => esc_html__('Post Layout Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_post_conditional', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Alignment', 'assurena'),
					'id' => 'mb_portfolio_single_align',
					'type' => 'button_group',
					'options' => [
						'left' => esc_html__('Left', 'assurena'),
						'center' => esc_html__('Center', 'assurena'),
						'right' => esc_html__('Right', 'assurena'),
					],
					'multiple' => false,
					'std' => 'left',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_post_conditional', '=', 'custom' ]
						], ],
					],
				], 
			],
		];
		return $meta_boxes;
	}

	public function portfolio_related_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Related Portfolio', 'assurena'),
			'post_types' => [ 'portfolio' ],
			'context' => 'advanced',
			'fields' => [
				[
					'id' => 'mb_portfolio_related_switch',
					'name' => esc_html__('Portfolio Related', 'assurena'),
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'on' => esc_html__('On', 'assurena'),
						'off' => esc_html__('Off', 'assurena'),
					],
					'inline' => true,
					'multiple' => false,
					'std' => 'default'
				],
				[
					'name' => esc_html__('Portfolio Related Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'id' => 'mb_pf_carousel_r',
					'name' => esc_html__('Display items carousel for this portfolio post', 'assurena'),
					'type' => 'switch',
					'std' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Title', 'assurena'),
					'id' => 'mb_pf_title_r',
					'type' => 'text',
					'std' => esc_html__('Related Portfolio', 'assurena'),
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				], 			
				[
					'name' => esc_html__('Categories', 'assurena'),
					'id' => 'mb_pf_cat_r',
					'multiple' => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'portfolio-category',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				],     
				[
					'name' => esc_html__('Columns', 'assurena'),
					'id' => 'mb_pf_column_r',
					'type' => 'button_group',
					'options' => [
						'2' => esc_html__('2', 'assurena'),
						'3' => esc_html__('3', 'assurena'),
						'4' => esc_html__('4', 'assurena'),
					],
					'multiple' => false,
					'std' => '3',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				],  
				[
					'name' => esc_html__('Number of Related Items', 'assurena'),
					'id' => 'mb_pf_number_r',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'std' => 3,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_portfolio_related_switch', '=', 'on' ]
						] ],
					],
				],
			],
		];
		return $meta_boxes;
	}

	public function blog_settings_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Post Settings', 'assurena'),
			'post_types' => [ 'post' ],
			'context' => 'advanced',
			'fields' => [       
				[
					'name' => esc_html__('Post Layout Settings', 'assurena'),
					'type' => 'stl_heading',
				],
				[
					'name' => esc_html__('Post Layout', 'assurena'),
					'id' => 'mb_post_layout_conditional',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],   	    
				[
					'name' => esc_html__('Post Layout Type', 'assurena'),
					'id' => 'mb_single_type_layout',
					'type' => 'button_group',
					'options' => [
						'1' => esc_html__('Title First', 'assurena'),
						'2' => esc_html__('Image First', 'assurena'),
						'3' => esc_html__('Overlay Image', 'assurena'),
					],
					'multiple' => false,
					'std' => '1',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_post_layout_conditional', '=', 'custom' ]
						] ],
					],
				], 
				[
					'name' => esc_html__('Padding Top', 'assurena'),
					'id' => 'mb_single_padding_layout_3',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => false,
						'bottom' => false,
						'left' => false,
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_post_layout_conditional', '=', 'custom' ],
							[ 'mb_single_type_layout', '=', '3' ],
						] ],
					],
					'std' => [
						'padding-top' => '160',
					]
				],
				[
					'id' => 'mb_single_apply_animation',
					'name' => esc_html__('Apply Animation', 'assurena'),
					'type' => 'switch',
					'std' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_post_layout_conditional', '=', 'custom' ],
							[ 'mb_single_type_layout', '=', '3' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Featured Image Settings', 'assurena'),
					'type' => 'stl_heading',
				],  
				[
					'name' => esc_html__('Featured Image', 'assurena'),
					'id' => 'mb_featured_image_conditional',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				], 
				[
					'name' => esc_html__('Featured Image Settings', 'assurena'),
					'id' => 'mb_featured_image_type',
					'type' => 'button_group',
					'options' => [
						'off' => esc_html__('Off', 'assurena'),
						'replace' => esc_html__('Replace', 'assurena'),
					],
					'multiple' => false,
					'std' => 'off',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_featured_image_conditional', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Featured Image Replace', 'assurena'),
					'id' => 'mb_featured_image_replace',
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_featured_image_conditional', '=', 'custom' ],
							[ 'mb_featured_image_type', '=', 'replace' ],
						] ],
					],
				],
			],
		];
		return $meta_boxes;
	}

	public function blog_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = [
			'title' => esc_html__('Post Format Layout', 'assurena'),
			'post_types' => [ 'post' ],
			'context' => 'advanced',
			'fields' => [
				// Standard Post Format
				[
					'name' => esc_html__('Standard Post( Enabled only Featured Image for this post format)', 'assurena'),
					'id' => 'post_format_standard',
					'type' => 'static-text',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'formatdiv', '=', '0' ]
						] ],
					],
				],
				// Gallery Post Format  
				[
					'name' => esc_html__('Gallery Settings', 'assurena'),
					'type' => 'stl_heading',
				],  
				[
					'name' => esc_html__('Add Images', 'assurena'),
					'id' => 'post_format_gallery',
					'type' => 'image_advanced',
					'max_file_uploads' => '',
				],
				// Video Post Format
				[
					'name' => esc_html__('Video Settings', 'assurena'),
					'type' => 'stl_heading',
				], 
				[
					'name' => esc_html__('Video Style', 'assurena'),
					'id' => 'post_format_video_style',
					'type' => 'select',
					'options' => [
						'bg_video' => esc_html__('Background Video', 'assurena'),
						'popup' => esc_html__('Popup', 'assurena'),
					],
					'multiple' => false,
					'std' => 'bg_video',
				],	
				[
					'name' => esc_html__('Start Video', 'assurena'),
					'id' => 'start_video',
					'type' => 'number',
					'std' => '0',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'post_format_video_style', '=', 'bg_video' ],
						] ],
					],
				],				
				[
					'name' => esc_html__('End Video', 'assurena'),
					'id' => 'end_video',
					'type' => 'number',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'post_format_video_style', '=', 'bg_video' ],
						] ],
					],
				],	
				[
					'name' => esc_html__('oEmbed URL', 'assurena'),
					'id' => 'post_format_video_url',
					'type' => 'oembed',
				],
				// Quote Post Format
				[
					'name' => esc_html__('Quote Settings', 'assurena'),
					'type' => 'stl_heading',
				], 
				[
					'name' => esc_html__('Quote Text', 'assurena'),
					'id' => 'post_format_qoute_text',
					'type' => 'textarea',
				],
				[
					'name' => esc_html__('Author Name', 'assurena'),
					'id' => 'post_format_qoute_name',
					'type' => 'text',
				],			
				[
					'name' => esc_html__('Author Position', 'assurena'),
					'id' => 'post_format_qoute_position',
					'type' => 'text',
				],
				[
					'name' => esc_html__('Author Avatar', 'assurena'),
					'id' => 'post_format_qoute_avatar',
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
				],
				// Audio Post Format
				[
					'name' => esc_html__('Audio Settings', 'assurena'),
					'type' => 'stl_heading',
				], 
				[
					'name' => esc_html__('oEmbed URL', 'assurena'),
					'id' => 'post_format_audio_url',
					'type' => 'oembed',
				],
				// Link Post Format
				[
					'name' => esc_html__('Link Settings', 'assurena'),
					'type' => 'stl_heading',
				], 
				[
					'name' => esc_html__('URL', 'assurena'),
					'id' => 'post_format_link_url',
					'type' => 'url',
				],
				[
					'name' => esc_html__('Text', 'assurena'),
					'id' => 'post_format_link_text',
					'type' => 'text',
				],
			]
		];
		return $meta_boxes;
	}

	public function blog_related_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Related Blog Post', 'assurena'),
			'post_types' => [ 'post' ],
			'context' => 'advanced',
			'fields' => [   

				[
					'name' => esc_html__('Related Options', 'assurena'),
					'id' => 'mb_blog_show_r',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
						'off'  	  => esc_html__('Off', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],        	
				[
					'name' => esc_html__('Related Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						] ],
					],
				], 
				[
					'name' => esc_html__('Title', 'assurena'),
					'id' => 'mb_blog_title_r',
					'type' => 'text',
					'std' => esc_html__('Related Posts', 'assurena'),
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						], ],
					],
				], 			
				[
					'name' => esc_html__('Categories', 'assurena'),
					'id' => 'mb_blog_cat_r',
					'multiple' => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'category',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						] ],
					],
				],     
				[
					'name' => esc_html__('Columns', 'assurena'),
					'id' => 'mb_blog_column_r',
					'type' => 'button_group',
					'options' => [
						'12' => esc_html__('1', 'assurena'),
						'6' => esc_html__('2', 'assurena'),
						'4' => esc_html__('3', 'assurena'),
						'3' => esc_html__('4', 'assurena'),
					],
					'multiple' => false,
					'std' => '6',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						] ],
					],
				],  
				[
					'name' => esc_html__('Number of Related Items', 'assurena'),
					'id' => 'mb_blog_number_r',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'std' => 2,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						] ],
					],
				],
				[
					'id' => 'mb_blog_carousel_r',
					'name' => esc_html__('Display items carousel for this blog post', 'assurena'),
					'type' => 'switch',
					'std' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_blog_show_r', '=', 'custom' ]
						] ],
					],
				],  
			],
		];
		return $meta_boxes;
	}

	public function page_layout_meta_boxes($meta_boxes)
	{

		$meta_boxes[] = [
			'title' => esc_html__('Page Layout', 'assurena'),
			'post_types' => [ 'page' , 'post', 'team', 'practice', 'portfolio', 'product' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Page Sidebar Layout', 'assurena'),
					'id' => 'mb_page_sidebar_layout',
					'type' => 'stl_image_select',
					'options' => [
						'default' => get_template_directory_uri() . '/core/admin/img/options/1c.png',
						'none' => get_template_directory_uri() . '/core/admin/img/options/none.png',
						'left' => get_template_directory_uri() . '/core/admin/img/options/2cl.png',
						'right' => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
					],
					'std' => 'default',
				],
				[
					'name' => esc_html__('Sidebar Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_sidebar_layout', '!=', 'default' ],
							[ 'mb_page_sidebar_layout', '!=', 'none' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Page Sidebar', 'assurena'),
					'id' => 'mb_page_sidebar_def',
					'type' => 'select',
					'placeholder' => 'Select a Sidebar',
					'options' => assurena_get_all_sidebar(),
					'multiple' => false,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_sidebar_layout', '!=', 'default' ],
							[ 'mb_page_sidebar_layout', '!=', 'none' ],
						] ],
					],
				],			
				[
					'name' => esc_html__('Page Sidebar Width', 'assurena'),
					'id' => 'mb_page_sidebar_def_width',
					'type' => 'button_group',
					'options' => [	
						'9' => esc_html( '25%' ),
						'8' => esc_html( '33%' ),
					],
					'std' => '9',
					'multiple' => false,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_sidebar_layout', '!=', 'default' ],
							[ 'mb_page_sidebar_layout', '!=', 'none' ],
						] ],
					],
				],
				[
					'id' => 'mb_sticky_sidebar',
					'name' => esc_html__('Sticky Sidebar On?', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_sidebar_layout', '!=', 'default' ],
							[ 'mb_page_sidebar_layout', '!=', 'none' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Sidebar Side Gap', 'assurena'),
					'id' => 'mb_sidebar_gap',
					'type' => 'select',
					'options' => [	
						'def' => 'Default',
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
					'std' => 'def',
					'multiple' => false,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_sidebar_layout', '!=', 'default' ],
							[ 'mb_page_sidebar_layout', '!=', 'none' ],
						] ],
					],
				],
			]
		];
		return $meta_boxes;
	}

	public function page_color_meta_boxes($meta_boxes)
	{

		$meta_boxes[] = [
			'title' => esc_html__('Page Colors', 'assurena'),
			'post_types' => [ 'page' , 'post', 'team', 'practice', 'portfolio' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Page Colors', 'assurena'),
					'id' => 'mb_page_colors_switch',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'inline' => true,
					'multiple' => false,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Colors Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('General Theme Color', 'assurena'),
					'id' => 'mb_page_theme_color',
					'type' => 'color',
					'std' => '#00aa55',
					'js_options' => [ 'defaultColor' => '#00aa55' ],
					'validate' => 'color',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ],
						] ],
					],
				],						
				[
					'name' => esc_html__('Body Background Color', 'assurena'),
					'id' => 'mb_body_background_color',
					'type' => 'color',
					'std' => '#ffffff',
					'js_options' => [ 'defaultColor' => '#ffffff' ],
					'validate' => 'color',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Scroll Up Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Button Background Color', 'assurena'),
					'id' => 'mb_scroll_up_bg_color',
					'type' => 'color',
					'std' => '#ff9e21',
					'js_options' => [ 'defaultColor' => '#ff9e21' ],
					'validate' => 'color',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ],
						] ],
					],
				],				
				[
					'name' => esc_html__('Button Arrow Color', 'assurena'),
					'id' => 'mb_scroll_up_arrow_color',
					'type' => 'color',
					'std' => '#ffffff',
					'js_options' => [ 'defaultColor' => '#ffffff' ],
					'validate' => 'color',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_colors_switch', '=', 'custom' ],
						] ],
					],
				],
			]
		];
		return $meta_boxes;
	}

	public function page_header_meta_boxes($meta_boxes) 
	{
	    $meta_boxes[] = [
	        'title'      => esc_html__( 'Header', 'assurena' ),
	        'post_types' => [ 'page', 'post', 'portfolio', 'product' ],
	        'context'    => 'advanced',
	        'fields'     => [
	        	[
					'name'     => esc_html__( 'Header Settings', 'assurena' ),
					'id'       => 'mb_customize_header_layout',
					'type'     => 'button_group',
					'options'  => [
						'default' => esc_html__( 'default', 'assurena' ),
						'custom'  => esc_html__( 'custom', 'assurena' ),
						'hide'    => esc_html__( 'hide', 'assurena' ),
					],
					'multiple' => false,
					'std'      => 'default',
				], 
				[
					'name'     => esc_html__( 'Header Template', 'assurena' ),
					'id'       => 'mb_header_content_type',
					'type'     => 'button_group',
					'options'  => [
						'default' => esc_html__( 'Default', 'assurena' ),
						'custom'   => esc_html__( 'Custom', 'assurena' )		
					],
					'multiple' => false,
					'std'      => 'default',
					'attributes' => [
					    'data-conditional-logic'  =>  [ [
							['mb_customize_header_layout', '=', 'custom']
						]],
					],
				],

	        	[
					'name'     => esc_html__( 'Template', 'assurena' ),
					'id'       => 'mb_customize_header',
					'type'        => 'post',
					'post_type'   => 'header',				
					'query_args'  => [
					    'post_status'    => 'publish',
					    'posts_per_page' => - 1,
					],
					'multiple' => false,
					'std'      => 'default',
					'attributes' => [
					    'data-conditional-logic'  =>  [ [
							['mb_customize_header_layout', '=', 'custom'],
							['mb_header_content_type', '=', 'custom'],
						]],
					],
				],
				[
					'id'   => 'mb_header_sticky',
					'name' => esc_html__( 'Sticky Header', 'assurena' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => [
					    'data-conditional-logic' => [ [
							['mb_customize_header_layout', '=', 'custom']
						]],
					],
				],
				[
					'name'     => esc_html__( 'Sticky Header Template', 'assurena' ),
					'id'       => 'mb_sticky_header_content_type',
					'type'     => 'button_group',
					'options'  => [
						'default' => esc_html__( 'Default', 'assurena' ),
						'custom'   => esc_html__( 'Custom', 'assurena' )		
					],
					'multiple' => false,
					'std'      => 'default',
					'attributes' => [
					    'data-conditional-logic'  =>  [ [
							['mb_customize_header_layout', '=', 'custom'],
							['mb_header_sticky','=','1'],
						]],
					],
				],
	        	[
					'name'     => esc_html__( 'Template', 'assurena' ),
					'id'       => 'mb_customize_sticky_header',
					'type'        => 'post',
					'post_type'   => 'header',				
					'query_args'  => [
					    'post_status'    => 'publish',
					    'posts_per_page' => - 1,
					],
					'multiple' => false,
					'std'      => 'default',
					'attributes' => [
					    'data-conditional-logic'  =>  [ [
							['mb_customize_header_layout', '=', 'custom'],
							['mb_sticky_header_content_type', '=', 'custom'],
							['mb_header_sticky','=','1'],
						]],
					],
				],
	        ]
		];
		return $meta_boxes;
	}

	public function page_title_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Page Title', 'assurena'),
			'post_types' => [ 'page', 'post', 'team', 'practice', 'portfolio', 'product' ],
			'context' => 'advanced',
			'fields' => [
				[
					'id' => 'mb_page_title_switch',
					'name' => esc_html__('Page Title', 'assurena'),
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'on' => esc_html__('On', 'assurena'),
						'off' => esc_html__('Off', 'assurena'),
					],
					'std' => 'default',
					'inline' => true,
					'multiple' => false
				],
				[
					'name' => esc_html__('Page Title Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[ 
					'id' => 'mb_page_title_bg_switch',
					'name' => esc_html__('Use Background?', 'assurena'),
					'type' => 'switch',
					'std' => true,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=' , 'on' ]
						] ],
					],
				],
				[
					'id' => 'mb_page_title_bg',
					'name' => esc_html__('Background', 'assurena'),
					'type' => 'stl_background',
					'image' => '',
					'position' => 'center bottom',
					'attachment' => 'scroll',
					'size' => 'cover',
					'repeat' => 'no-repeat',
					'color' => '#383838',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_bg_switch', '=', true ],
						] ],
					],
				],			
				[ 
					'name' => esc_html__('Height', 'assurena'),
					'id' => 'mb_page_title_height',
					'type' => 'number',
					'std' => 350,
					'min' => 0,
					'step' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_bg_switch', '=', true ],
						] ],
					],
				],
				[
					'name' => esc_html__('Title Alignment', 'assurena'),
					'id' => 'mb_page_title_align',
					'type' => 'button_group',
					'options' => [
						'left' => esc_html__('left', 'assurena'),
						'center' => esc_html__('center', 'assurena'),
						'right' => esc_html__('right', 'assurena'),
					],
					'std' => 'center',
					'multiple' => false,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=' , 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Paddings Top/Bottom', 'assurena'),
					'id' => 'mb_page_title_padding',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => false,
						'bottom' => true,
						'left' => false,
					],
					'std' => [
						'padding-top' => '80',
						'padding-bottom' => '80',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=' , 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Margin Bottom', 'assurena'),
					'id' => 'mb_page_title_margin',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'margin',
						'top' => false,
						'right' => false,
						'bottom' => true,
						'left' => false,
					],
					'std' => [ 'margin-bottom' => '40' ],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'id' => 'mb_page_title_border_switch',
					'name' => esc_html__('Border Top Switch', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Border Top Color', 'assurena'),
					'id' => 'mb_page_title_border_color',
					'type' => 'color',
					'std' => '#e5e5e5',
					'js_options' => [ 'defaultColor' => '#e5e5e5' ],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_border_switch', '=',true]
						] ],
					],
				],
				[
					'id' => 'mb_page_title_parallax',
					'name' => esc_html__('Parallax Switch', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Prallax Speed', 'assurena'),
					'id' => 'mb_page_title_parallax_speed',
					'type' => 'number',
					'std' => 0.3,
					'step' => 0.1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_parallax', '=',true ],
							[ 'mb_page_title_switch', '=', 'on' ],
						] ],
					],
				],
				[
					'id' => 'mb_page_change_tile_switch',
					'name' => esc_html__('Custom Page Title', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title', 'assurena'),
					'id' => 'mb_page_change_tile',
					'type' => 'text',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_change_tile_switch', '=', '1' ],
							[ 'mb_page_title_switch', '=', 'on' ],
						] ],
					],
				],
				[
					'id' => 'mb_page_title_breadcrumbs_switch',
					'name' => esc_html__('Show Breadcrumbs', 'assurena'),
					'type' => 'switch',
					'std' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Breadcrumbs Alignment', 'assurena'),
					'id' => 'mb_page_title_breadcrumbs_align',
					'type' => 'button_group',
					'options' => [
						'left' => esc_html__('left', 'assurena'),
						'center' => esc_html__('center', 'assurena'),
						'right' => esc_html__('right', 'assurena'),
					],
					'std' => 'center',
					'multiple' => false,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_breadcrumbs_switch', '=', '1' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Breadcrumbs Full Width', 'assurena'),
					'id' => 'mb_page_title_breadcrumbs_block_switch',
					'type' => 'switch',
					'std' => true,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_breadcrumbs_switch', '=', '1' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title Typography', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title Font', 'assurena'),
					'id' => 'mb_page_title_font',
					'type' => 'stl_font',
					'options' => [
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					],
					'std' => [
						'font-size' => '52',
						'line-height' => '52',
						'color' => '#fefefe',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title Breadcrumbs Font', 'assurena'),
					'id' => 'mb_page_title_breadcrumbs_font',
					'type' => 'stl_font',
					'options' => [
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					],
					'std' => [
						'font-size' => '16',
						'line-height' => '24',
						'color' => '#ffffff',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Responsive Layout', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'id' => 'mb_page_title_resp_switch',
					'name' => esc_html__('Responsive Layout On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Screen breakpoint', 'assurena'),
					'id' => 'mb_page_title_resp_resolution',
					'type' => 'number',
					'std' => 768,
					'min' => 1,
					'step' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Height', 'assurena'),
					'id' => 'mb_page_title_resp_height',
					'type' => 'number',
					'std' => 180,
					'min' => 0,
					'step' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Padding Top/Bottom', 'assurena'),
					'id' => 'mb_page_title_resp_padding',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => false,
						'bottom' => true,
						'left' => false,
					],
					'std' => [
						'padding-top' => '15',
						'padding-bottom' => '15',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title Font', 'assurena'),
					'id' => 'mb_page_title_resp_font',
					'type' => 'stl_font',
					'options' => [
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					],
					'std' => [
						'font-size' => '42',
						'line-height' => '48',
						'color' => '#ffffff',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
						] ],
					],
				],
				[
					'id' => 'mb_page_title_resp_breadcrumbs_switch',
					'name' => esc_html__('Show Breadcrumbs', 'assurena'),
					'type' => 'switch',
					'std' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
						] ],
					],
				],
				[
					'name' => esc_html__('Page Title Breadcrumbs Font', 'assurena'),
					'id' => 'mb_page_title_resp_breadcrumbs_font',
					'type' => 'stl_font',
					'options' => [
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					],
					'std' => [
						'font-size' => '16',
						'line-height' => '24',
						'color' => '#ffffff',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_page_title_switch', '=', 'on' ],
							[ 'mb_page_title_resp_switch', '=', '1' ],
							[ 'mb_page_title_resp_breadcrumbs_switch', '=', '1' ],
						] ],
					],
				],
			],
		];
		return $meta_boxes;
	}

	public function page_side_panel_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Side Panel', 'assurena'),
			'post_types' => [ 'page' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Side Panel', 'assurena'),
					'id' => 'mb_customize_side_panel',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'custom' => esc_html__('Custom', 'assurena'),
					],
					'multiple' => false,
					'inline' => true,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Side Panel Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Content Type', 'assurena'),
					'id' => 'mb_side_panel_content_type',
					'type' => 'button_group',
					'options' => [
						'widgets' => esc_html__('Widgets', 'assurena'),
						'pages' => esc_html__('Page', 'assurena')		
					],
					'multiple' => false,
					'std' => 'widgets',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Select a page', 'assurena'),
					'id' => 'mb_side_panel_page_select',
					'type' => 'post',
					'post_type' => 'side_panel',
					'field_type' => 'select_advanced',
					'placeholder' => 'Select a page',
					'query_args' => [
						'post_status' => 'publish',
						'posts_per_page' => - 1,
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ],
							[ 'mb_side_panel_content_type', '=', 'pages' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Paddings', 'assurena'),
					'id' => 'mb_side_panel_spacing',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => true,
						'bottom' => true,
						'left' => true,
					],
					'std' => [
						'padding-top' => '105',
						'padding-right' => '90',
						'padding-bottom' => '105',
						'padding-left' => '90'
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],	

				[
					'name' => esc_html__('Title Color', 'assurena'),
					'id' => 'mb_side_panel_title_color',
					'type' => 'color',
					'std' => '#ffffff',
					'js_options' => [ 'defaultColor' => '#ffffff' ],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],						
				[
					'name' => esc_html__('Text Color', 'assurena'),
					'id' => 'mb_side_panel_text_color',
					'type' => 'color',
					'std' => '#313538',
					'js_options' => [ 'defaultColor' => '#313538' ],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],				
				[
					'name' => esc_html__('Background Color', 'assurena'),
					'id' => 'mb_side_panel_bg',
					'type' => 'color',
					'std' => '#ffffff',
					'alpha_channel' => true,
					'js_options' => [ 'defaultColor' => '#ffffff' ],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Text Align', 'assurena'),
					'id' => 'mb_side_panel_text_alignment',
					'type' => 'button_group',
					'options' => [
						'left' => esc_html__('Left', 'assurena'),
						'center' => esc_html__('Center', 'assurena'),
						'right' => esc_html__('Right', 'assurena'),
					],
					'multiple' => false,
					'std' => 'center',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						], ],
					],
				],
				[
					'name' => esc_html__('Width', 'assurena'),
					'id' => 'mb_side_panel_width',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'std' => 480,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Position', 'assurena'),
					'id' => 'mb_side_panel_position',
					'type' => 'button_group',
					'options' => [
						'left' => esc_html__('Left', 'assurena'),
						'right' => esc_html__('Right', 'assurena'),
					],
					'multiple' => false,
					'std' => 'right',
					'attributes' => [
						'data-conditional-logic' => [ [
								[ 'mb_customize_side_panel', '=', 'custom' ]
						] ],
					],
				],
			]
		];
		return $meta_boxes;
	}	

	public function page_soc_icons_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Social Shares', 'assurena'),
			'post_types' => [ 'page' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Social Shares', 'assurena'),
					'id' => 'mb_customize_soc_shares',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'on' => esc_html__('On', 'assurena'),
						'off' => esc_html__('Off', 'assurena'),
					],
					'multiple' => false,
					'inline' => true,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Choose your share style.', 'assurena'),
					'id' => 'mb_soc_icon_style',
					'type' => 'button_group',
					'options' => [
						'standard' => esc_html__('Standard', 'assurena'),
						'hovered' => esc_html__('Hovered', 'assurena'),
					],
					'multiple' => false,
					'std' => 'standard',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],				
				[
					'id' => 'mb_soc_icon_position',
					'name' => esc_html__('Fixed Position On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],
				[ 
					'name' => esc_html__('Offset Top(in percentage)', 'assurena'),
					'id' => 'mb_soc_icon_offset',
					'type' => 'number',
					'std' => 50,
					'min' => 0,
					'step' => 1,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
					'desc' => esc_html__('Measurement units defined as "percents" while position fixed is enabled, and as "pixels" while position is off.', 'assurena'),
				],
				[
					'id' => 'mb_soc_icon_facebook',
					'name' => esc_html__('Facebook Share On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],				
				[
					'id' => 'mb_soc_icon_twitter',
					'name' => esc_html__('Twitter Share On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],				
				[
					'id' => 'mb_soc_icon_linkedin',
					'name' => esc_html__('Linkedin Share On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],						
				[
					'id' => 'mb_soc_icon_pinterest',
					'name' => esc_html__('Pinterest Share On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],				
				[
					'id' => 'mb_soc_icon_tumblr',
					'name' => esc_html__('Tumblr Share On/Off', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_customize_soc_shares', '=', 'on' ]
						] ],
					],
				],
				
			]
		];
		return $meta_boxes;
	}

	public function page_footer_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Footer', 'assurena'),
			'post_types' => [ 'page' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Footer', 'assurena'),
					'id' => 'mb_footer_switch',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'on' => esc_html__('On', 'assurena'),
						'off' => esc_html__('Off', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Footer Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ]
						] ],
					],
				], 
				[
					'id' => 'mb_footer_add_wave',
					'name' => esc_html__('Add Wave', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Set Wave Height', 'assurena'),
					'id' => 'mb_footer_wave_height',
					'type' => 'number',
					'min' => 0,
					'step' => 1,
					'std' => 158,
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_add_wave', '=', '1' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Content Type', 'assurena'),
					'id' => 'mb_footer_content_type',
					'type' => 'button_group',
					'options' => [
						'widgets' => esc_html__('Widgets', 'assurena'),
						'pages' => esc_html__('Page', 'assurena')		
					],
					'multiple' => false,
					'std' => 'pages',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Select a page', 'assurena'),
					'id' => 'mb_footer_page_select',
					'type' => 'post',
					'post_type' => 'footer',
					'field_type' => 'select_advanced',
					'placeholder' => 'Select a page',
					'query_args' => [
						'post_status' => 'publish',
						'posts_per_page' => - 1,
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_content_type', '=', 'pages' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Paddings', 'assurena'),
					'id' => 'mb_footer_spacing',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => true,
						'bottom' => true,
						'left' => true,
					],
					'std' => [
						'padding-top' => '0',
						'padding-right' => '0',
						'padding-bottom' => '0',
						'padding-left' => '0'
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_content_type', '=', 'widgets' ],
						] ],
					],
				],	
				[
					'name' => esc_html__('Background', 'assurena'),
					'id' => 'mb_footer_bg',
					'type' => 'stl_background',
					'image' => '',
					'position' => 'center center',
					'attachment' => 'scroll',
					'size' => 'cover',
					'repeat' => 'no-repeat',			
					'color' => '#ffffff',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_content_type', '=', 'widgets' ],
						] ],
					],
				],
				[
					'id' => 'mb_footer_add_border',
					'name' => esc_html__('Add Border Top', 'assurena'),
					'type' => 'switch',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_content_type', '=', 'widgets' ],
						] ],
					],
				],	
				[
					'name' => esc_html__('Border Color', 'assurena'),
					'id' => 'mb_footer_border_color',
					'type' => 'color',
					'std' => '#e5e5e5',
					'alpha_channel' => true,
					'js_options' => [
						'defaultColor' => '#e5e5e5',
					],
					'attributes' => [
						'data-conditional-logic' => [ [		
							[ 'mb_footer_switch', '=', 'on' ],
							[ 'mb_footer_add_border', '=', '1' ],
						] ],
					],
				],			
			],
		 ];
		return $meta_boxes;
	}	

	public function page_copyright_meta_boxes($meta_boxes)
	{
		$meta_boxes[] = [
			'title' => esc_html__('Copyright', 'assurena'),
			'post_types' => [ 'page' ],
			'context' => 'advanced',
			'fields' => [
				[
					'name' => esc_html__('Copyright', 'assurena'),
					'id' => 'mb_copyright_switch',
					'type' => 'button_group',
					'options' => [
						'default' => esc_html__('Default', 'assurena'),
						'on' => esc_html__('On', 'assurena'),
						'off' => esc_html__('Off', 'assurena'),
					],
					'multiple' => false,
					'std' => 'default',
				],
				[
					'name' => esc_html__('Copyright Settings', 'assurena'),
					'type' => 'stl_heading',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_copyright_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Editor', 'assurena'),
					'id' => 'mb_copyright_editor',
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 3,
					'std' => 'Copyright © 2020 assurena by StylusThemes. All Rights Reserved',
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_copyright_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Text Color', 'assurena'),
					'id' => 'mb_copyright_text_color',
					'type' => 'color',
					'std' => '#838383',
					'js_options' => [
						'defaultColor' => '#838383',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_copyright_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Background Color', 'assurena'),
					'id' => 'mb_copyright_bg_color',
					'type' => 'color',
					'std' => '#171a1e',
					'js_options' => [
						'defaultColor' => '#171a1e',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_copyright_switch', '=', 'on' ]
						] ],
					],
				],
				[
					'name' => esc_html__('Paddings', 'assurena'),
					'id' => 'mb_copyright_spacing',
					'type' => 'stl_offset',
					'options' => [
						'mode' => 'padding',
						'top' => true,
						'right' => false,
						'bottom' => true,
						'left' => false,
					],
					'std' => [
						'padding-top' => '10',
						'padding-bottom' => '10',
					],
					'attributes' => [
						'data-conditional-logic' => [ [
							[ 'mb_copyright_switch', '=', 'on' ]
						] ],
					],
				],
			],
		];
		return $meta_boxes;
	}
}

new assurena_Metaboxes();
