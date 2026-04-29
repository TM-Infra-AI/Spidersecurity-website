<?php

namespace stlAddons\Controls;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

defined( 'ABSPATH' ) || exit;

/**
* stl Elementor Custom Icon Control
*
*
* @class        stl_Icon
* @version      1.0
* @category Class
* @author       StylusThemes
*/

class stl_Icon extends Base_Data_Control{

	/**
	 * Get radio image control type.
	 *
	 * Retrieve the control type, in this case `radio-image`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'stl-icon';
	}

	public function enqueue() {
		// Scripts
		wp_enqueue_script( 'stl-elementor-extensions', stl_ELEMENTOR_ADDONS_URL . 'assets/js/stl_elementor_extenstions.js');

		// Style
		wp_enqueue_style( 'stl-elementor-extensions', stl_ELEMENTOR_ADDONS_URL . 'assets/css/stl_elementor_extenstions.css');
	}

	public static function get_flaticons() {
		return [
         
                'flaticon-policy' => 'policy',
                'flaticon-car-insurance' => 'car-insurance',
                'flaticon-car-insurance-1' => 'car-insurance-1',
                'flaticon-license' => 'license',
                'flaticon-car-insurance-2' => 'car-insurance-2',
                'flaticon-family-insurance' => 'family-insurance',
                'flaticon-transportation' => 'transportation',
                'flaticon-shield' => 'shield',
                'flaticon-car-insurance-3' => 'car-insurance-3',
                'flaticon-medical-insurance' => 'medical-insurance',
                'flaticon-medical-insurance-1' => 'medical-insurance-1',
                'flaticon-check-mark' => 'check-mark',
                'flaticon-insurance' => 'insurance',
                'flaticon-travel-insurance' => 'travel-insurance',
                'flaticon-prevention' => 'prevention',
                'flaticon-factory' => 'factory',
                'flaticon-family-insurance-1' => 'family-insurance-1',
                'flaticon-seller' => 'seller',
                'flaticon-medical-insurance-2' => 'medical-insurance-2',
                'flaticon-home-insurance' => 'home-insurance',
                'flaticon-umbrella' => 'umbrella',
                'flaticon-money' => 'money',
                'flaticon-dentist' => 'dentist',
                'flaticon-money-1' => 'money-1',
                'flaticon-medical-insurance-3' => 'medical-insurance-3',
                'flaticon-car-insurance-4' => 'car-insurance-4',
                'flaticon-savings' => 'savings',
                'flaticon-insurance-1' =>'insurance-1', 
                'flaticon-baggage-insurance' => 'baggage-insurance',
                'flaticon-student-hat' => 'student-hat',
                'flaticon-home-insurance-1' => 'home-insurance-1',
                'flaticon-medical-insurance-4' => 'medical-insurance-4',
                'flaticon-delivery-box' => 'delivery-box',
                'flaticon-home-insurance-2' => 'home-insurance-2', 
                'flaticon-home-insurance-3' => 'home-insurance-3',
                'flaticon-clipboard' => 'clipboard',
                'flaticon-car-insurance-5' => 'car-insurance-5',
                'flaticon-prevention-1' => 'prevention-1',
                'flaticon-contract' => 'contract',
                'flaticon-medical-report' => 'medical-report',
                'flaticon-home' => 'home',
                'flaticon-dollar' => 'Dollar',
                'flaticon-baggage-insurance-1' => 'baggage-insurance-1',
                'flaticon-money-2' => 'money-2',
                'flaticon-travel-insurance-1' => 'travel-insurance-1',
                'flaticon-insurance-2' => 'insurance-2',
                'flaticon-home-insurance-4' => 'home-insurance-4',
                'flaticon-tablet' => 'tablet',
                'flaticon-insurance-3' => 'insurance-3',
                'flaticon-chat' => 'chat',
                'flaticon-shipping-and-delivery' => 'shipping-and-delivery',
                'flaticon-umbrella-1' => 'umbrella-1',
                'flaticon-umbrella-2' => 'umbrella-2',
                'flaticon-business-and-finance' => 'business-and-finance',
                'flaticon-umbrella-3' => 'umbrella-3',
                'flaticon-insurance-4' => 'insurance-4',
                'flaticon-business-and-finance-1' => 'business-and-finance-1',
                'flaticon-architecture-and-city' => 'architecture-and-city',
                'flaticon-truck' => 'truck',
                'flaticon-clipboard-1' => 'clipboard-1',
                'flaticon-umbrella-4' => 'umbrella-4',
                'flaticon-girl' => 'girl',
                'flaticon-safe' => 'safe',
                'flaticon-files-and-folders' => 'files-and-folders',
                'flaticon-business-and-finance-2' => 'business-and-finance-2',
                'flaticon-list' => 'list',
                'flaticon-computer-insurance' => 'computer-insurance',
                'flaticon-safebox' => 'safebox',
                'flaticon-business-and-finance-3' => 'business-and-finance-3',
                'flaticon-business-and-finance-4' => 'business-and-finance-4',
                'flaticon-photograph' => 'photograph',
                'flaticon-files-and-folders-1' => 'files-and-folders-1',
                'flaticon-pound' => 'pound',
                'flaticon-smartwatch' => 'smartwatch',
                'flaticon-tv' => 'tv',
                'flaticon-business-and-finance-5' => 'business-and-finance-5',
                'flaticon-business-and-finance-6' => 'business-and-finance-6',
                'flaticon-tick' => 'tick',
                'flaticon-internet' => 'internet',
                'flaticon-calendar' => 'calender',
                'flaticon-close' => 'close',
                'flaticon-plus' => 'plus',
                'flaticon-pin' => 'pin',
                'flaticon-avatar' => 'avatar',
                'flaticon-gear' => 'gear',
                'flaticon-smartphone' => 'smartphone',
                'flaticon-pin-1' => 'pin-1',
                'flaticon-like' => 'like',
                'flaticon-calculator' => 'calculator',
                'flaticon-notebook' => 'notebook',
                'flaticon-message' => 'message',
                'flaticon-arrow' => 'arrow',
                'flaticon-arrow-1' => 'arrow-1',
                'flaticon-chat-1' => 'chat-1',
                'flaticon-global' => 'global',
                'flaticon-document' => 'document',
                'flaticon-clock' => 'clock',
                'flaticon-question' => 'question',
                'flaticon-right' => 'right',
                'flaticon-left' => 'left',
		];
	}

	/**
	 * Get radio image control default settings.
	 *
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'options' => self::get_flaticons(),
			'include' => '',
			'exclude' => '',
			'select2options' => [],
		];
	}

	/**
	 * Render radio image control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {

		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<# if ( data.label ) {#>
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper">
				<select id="<?php echo $control_uid; ?>" class="elementor-control-icon elementor-select2" type="select2"  data-setting="{{ data.name }}" data-placeholder="<?php echo __( 'Select Icon', 'assurena-core' ); ?>">
					<# _.each( data.options, function( option_title, option_value ) {
						var value = data.controlValue;
						if ( typeof value == 'string' ) {
							var selected = ( option_value === value ) ? 'selected' : '';
						} else if ( null !== value ) {
							var value = _.values( value );
							var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
						}
						#>
					<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
					<# } ); #>
				</select>
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}

?>