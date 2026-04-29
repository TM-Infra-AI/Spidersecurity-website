<?php

/**
 * Template Welcome
 *
 * @link       https://themeforest.net/user/stylusthemes
 * @since      1.0.0
 *
 * @package    assurena
 * @subpackage assurena/core/dashboard
 */

/**
 * @since      1.0.0
 * @package    assurena
 * @subpackage assurena/core/dashboard
 * @author     StylusThemes <stylusthemes@gmail.com>
 */

$theme = wp_get_theme();
$allowed_html = array(
	'a' => array(
		'href' => true,
		'target' => true,
	),
);
?>
<div class="stl-welcome_page">
	<div class="stl-welcome_title">
		<h1><?php esc_html_e('Welcome to', 'assurena');?>
			<?php echo esc_html(wp_get_theme()->get('Name')); ?> 
		</h1>		
	</div>
	<div class="stl-version_theme">
		<?php esc_html_e('Version - ', 'assurena');?>
		<?php echo esc_html(wp_get_theme()->get('Version')); ?>	
	</div>	
	<div class="stl-welcome_subtitle">
			<?php
				echo sprintf(esc_html__('%s is already installed and ready to use! Let\'s build something impressive.', 'assurena'), esc_html(wp_get_theme()->get('Name'))) ;
			?>
	</div>
	
	<div class="stl-welcome-step_wrap">
		<div class="stl-welcome_sidebar left_sidebar">
			<div class="theme-screenshot">
				<img src="<?php echo esc_url(get_template_directory_uri() . "/screenshot.png"); ?>">

			</div>
		</div>
		<div class="stl-welcome_content">
			<div class="step-subtitle">
				<?php
					echo sprintf(esc_html__('Just complete the steps below and you will be able to use all functionalities of %s theme by StylusThemes:', 'assurena'), esc_html(wp_get_theme()->get('Name')));
				?>
			</div>
			<ul>
			  <li>
			  	<span class="step">
			  		<?php esc_html_e('Step 1', 'assurena');?>		
			  	</span>
			  	<?php 
				echo sprintf( wp_kses( __( 'Check <a target="_blank" href="%s">requirements</a> to avoid errors with your WordPress.', 'assurena' ), $allowed_html), esc_url( admin_url( 'admin.php?page=stl-status-panel' ) ) );

			  	?>
			  </li>
			  <li>
			  	<span class="step">
			  		<?php esc_html_e('Step 2', 'assurena');?>
			  	</span>
			  	<?php esc_html_e('Install Required and recommended plugins.', 'assurena');?>
			  </li>
			  <li>
			  	<span class="step">
			  		<?php esc_html_e('Step 3', 'assurena');?>
			  	</span>
			  	<?php esc_html_e('Import demo content', 'assurena');?> 
			  	<span class="attention-title">
			  		<strong>
			  			<?php esc_html_e('Important:', 'assurena');?>
			  		</strong>
			  		<?php esc_html_e('one license  only for one website', 'assurena');?>
			  	</span>
			  </li>
			</ul>	
		</div>
	
	</div>


</div>
