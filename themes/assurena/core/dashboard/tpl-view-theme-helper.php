<?php

/**
 * Template Activate Theme
 *
 * @link       https://themeforest.net/user/StylusThemes
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

$allowed_html = array(
	'a' => array(
		'href' => true,
		'target' => true,
	),
);
?>
<div class="stl-theme-helper">
	<div class="container-form">
		<h1 class="stl-title">
			<?php echo esc_html__('Need Help? StylusThemes Help Center Here', 'assurena');?>
		</h1>
		<div class="stl-content">
			<p class="stl-content_subtitle">
				<?php
					echo wp_kses( __( 'Please read a <a target="_blank" href="https://themeforest.net/page/item_support_policy">Support Policy</a> before submitting a ticket and make sure that your question related to our product issues.', 'assurena' ), $allowed_html);
				?>
				<br/>
					<?php
					echo esc_html__('If you did not find an answer to your question, feel free to contact us.', 'assurena');
					?>
			</p>
		</div>
		<div class="stl-row">			
			<div class="stl-col stl-col-6">
				<div class="stl-col_inner">
					<div class="stl-info-box_wrapper">
						<div class="stl-info-box">
							<div class="stl-info-box_icon-wrapper">
								<div class="stl-info-box_icon">
									<img src="<?php echo esc_url(get_template_directory_uri()) . '/core/admin/img/dashboard/document_icon.png'?>">
								</div>
							</div>
							<div class="stl-info-box_content-wrapper">	
								<div class="stl-info-box_title">
									<h3 class="stl-info-box_icon-heading">
										<?php
											esc_html_e('Documentation', 'assurena');
										?>
									</h3>
								</div>					
								<div class="stl-info-box_content">
									<p>
										<?php
										esc_html_e('Before submitting a ticket, please read the documentation. Probably, your issue already described.', 'assurena');
										?>
									</p>
								</div>		
								<div class="stl-info-box_btn">
									<a target="_blank" href="https://assurena.stylusthemes.com/doc">
										<?php
											esc_html_e('Visit Documentation', 'assurena');
										?>	
									</a>
								</div>
							</div>
						</div>			
					</div>	
				</div>
			</div>
			<div class="stl-col stl-col-6">
				<div class="stl-col_inner">
					<div class="stl-info-box_wrapper">
						<div class="stl-info-box">
							<div class="stl-info-box_icon-wrapper">
								<div class="stl-info-box_icon">
									<img src="<?php echo esc_url(get_template_directory_uri()) . '/core/admin/img/dashboard/support_icon.png'?>">
								</div>
							</div>
							<div class="stl-info-box_content-wrapper">	
								<div class="stl-info-box_title">
									<h3 class="stl-info-box_icon-heading">
										<?php
											esc_html_e('Support forum', 'assurena');
										?>
									</h3>
								</div>					
								<div class="stl-info-box_content">
									<p>
										<?php
											esc_html_e('If you did not find an answer to your question, submit a ticket with well describe your issue.', 'assurena');
										?>
									</p>
								</div>		
								<div class="stl-info-box_btn">
									<a target="_blank" href="https://stylusthemes.ticksy.com">
										<?php
											esc_html_e('Create a ticket', 'assurena');
										?>	
									</a>
								</div>
							</div>
						</div>			
					</div>	
				</div>
			</div>					
	
		</div>
		<div class="theme-helper_desc">
			<?php
				echo wp_kses( __( 'Do You have some other questions? Need Customization? Pre-purchase questions? Ask it <a  target="_blank"  href="mailto:stylusthemes@gmail.com">there!</a>', 'assurena' ), $allowed_html);
			?>			
		</div>

	</div>
</div>

