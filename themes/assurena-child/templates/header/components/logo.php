<?php


if (!class_exists('assurena_get_logo')) {
	class assurena_get_logo{

		public function __construct($location = 'bottom', $menu = false, $custom_logo = false, $custom_logo_height = false){
			return $this->init($location, $menu, $custom_logo, $custom_logo_height );
		}

		public function init($location, $menu, $custom_logo, $custom_logo_height){

			
			$id = !is_category() ? get_queried_object_id() : 0;
			$img_alt = '';
			
			// Get Default Logotype

			$header_logo_src =  empty($custom_logo) ? assurena_Theme_Helper::get_option('header_logo') : $custom_logo;
			$header_logo_id = !empty($header_logo_src) ? $header_logo_src['id'] : ''; 
			$header_logo_src = !empty($header_logo_src) ? $header_logo_src['url'] : ''; 
			

			// logo default image alt
			$def_img_alt = get_post_meta($header_logo_id, '_wp_attachment_image_alt', true);        

			// Get Mobile Logotype
			$menu = !empty($menu) ? '_menu' : '';

			$logo_mobile_src =  assurena_Theme_Helper::get_option('logo_mobile'.$menu);
			$logo_mobile_id = !empty($logo_mobile_src) ? $logo_mobile_src['id'] : ''; 
			$logo_mobile_src =  !empty($logo_mobile_src) ? $logo_mobile_src['url'] : '';
						// logo mobile image alt
			$mobile_img_alt = get_post_meta($logo_mobile_id, '_wp_attachment_image_alt', true); 

			$logo_height_custom = assurena_Theme_Helper::get_option('logo_height_custom');
			$logo_height = assurena_Theme_Helper::get_option('logo_height');
			$logo_height = $logo_height['height'];

			if(!empty($custom_logo_height)){
				$logo_height = $custom_logo_height;
				$logo_height_custom = '1';
			}

			$mobile_logo_height_custom = assurena_Theme_Helper::get_option('mobile_logo'.$menu.'_height_custom');
			$mobile_logo_height = assurena_Theme_Helper::get_option('mobile_logo'.$menu.'_height');
			$mobile_logo_height = $mobile_logo_height['height'];

			$logo_height_css = $mobile_height_style = '';

			if (!empty($logo_height) && $logo_height_custom == '1') {
				$logo_height_css .= 'height:'.(esc_attr((int) $logo_height)).'px;';
			}
			$logo_height_style = !empty($logo_height_css) ? ' style="'.$logo_height_css.'"' : '';           

			switch (true) {
				case !empty($mobile_logo_height) && $mobile_logo_height_custom == '1' && $location == 'mobile':
				$mobile_height_style .= 'height:'.(esc_attr((int) $mobile_logo_height)).'px;';
				break;						

				default:
				if(!empty($logo_height) && $logo_height_custom == '1'){
					$mobile_height_style = $logo_height_css;
				}
				break;
			}

			// Set Mobile Height Logotype
			$mobile_height_style = !empty($mobile_height_style) ? ' style="'.$mobile_height_style.'"' : '';
			$class = !empty($logo_mobile_src) ? " logo-mobile_enable" : '';

			?><div class='stl-logotype-container<?php echo esc_attr($class);?>'>
				<a href='<?php echo esc_url(home_url('/')) ?>'>
					<?php
					switch (true) {
						case $location == 'bottom':
						if (!empty($header_logo_src)) {
							?>
							<img class="default_logo" src="<?php echo esc_url($header_logo_src); ?>" alt="<?php echo esc_attr($def_img_alt); ?>" <?php echo assurena_Theme_Helper::render_html($logo_height_style);?>>
							<?php
						} else {
							?>
							<h1 class="logo-name">
								<?php echo get_bloginfo( 'name' ); ?>
							</h1>
							<?php
						}
						break;

						case !empty($logo_mobile_src) && $location == 'mobile':
						?>
						<img class="logo-mobile" src="<?php echo esc_url($logo_mobile_src);?>" alt="<?php echo esc_attr($mobile_img_alt); ?>" <?php echo assurena_Theme_Helper::render_html($mobile_height_style);?>>
						<?php
						break;

						default:
						if (!empty($header_logo_src)) {
							?>
							<img class="default_logo" src="<?php echo esc_url($header_logo_src); ?>" alt="<?php echo esc_attr($def_img_alt); ?>" <?php echo assurena_Theme_Helper::render_html($logo_height_style);?>>
							<?php
						} else {
							?>
							<h1 class="logo-name">
								<?php echo get_bloginfo( 'name' ); ?>
							</h1>
							<?php
						}
						break;
					}

					?>   
				</a>
			</div>
			<?php       
		}
	}
}
?>
