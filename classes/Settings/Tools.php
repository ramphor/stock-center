<?php
/**
 * ATUM tools and scripts for multiple purposes
 *
 * @package     Atum
 * @subpackage  Settings
 * @author      Be Rebel - https://berebel.io
 * @copyright   ©2021 Stock Management Labs™
 *
 * @since       1.4.5
 */

namespace Atum\Settings;

defined( 'ABSPATH' ) || die;


class Tools {

	/**
	 * The singleton instance holder
	 *
	 * @var Tools
	 */
	private static $instance;

	/**
	 * Tools singleton constructor
	 *
	 * @since 1.4.5
	 */
	private function __construct() {

		add_filter( 'atum/settings/tabs', array( $this, 'add_settings_tab' ), 999 );
		add_filter( 'atum/settings/defaults', array( $this, 'add_settings_defaults' ) );

	}

	/**
	 * Add a new tab to the ATUM settings page
	 *
	 * @since 1.4.5
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function add_settings_tab( $tabs ) {

		$tabs['tools'] = array(
			'label'     => __( 'Tools', ATUM_TEXT_DOMAIN ),
			'icon'      => 'atum-icon atmi-rocket',
			'sections'  => array(
				'tools' => __( 'ATUM Tools', ATUM_TEXT_DOMAIN ),
			),
			'no_submit' => TRUE,
		);

		return $tabs;
	}

	/**
	 * Add fields to the ATUM settings page
	 *
	 * @since 1.4.5
	 *
	 * @param array $defaults
	 *
	 * @return array
	 */
	public function add_settings_defaults( $defaults ) {

		$atum_label = '<br><span class="label label-secondary">ATUM</span>';

		$defaults['update_manage_stock'] = array(
			'group'   => 'tools',
			'section' => 'tools',
			'name'    => __( "Update WC's manage stock", ATUM_TEXT_DOMAIN ) . $atum_label,
			'desc'    => __( "Update the WooCommerce's manage stock at product level for all the products at once.", ATUM_TEXT_DOMAIN ),
			'type'    => 'script_runner',
			'options' => array(
				'select'        => array(
					'manage'   => __( 'Manage Stock', ATUM_TEXT_DOMAIN ),
					'unmanage' => __( 'Unmanage Stock', ATUM_TEXT_DOMAIN ),
				),
				'button_text'   => __( 'Update Now!', ATUM_TEXT_DOMAIN ),
				'script_action' => 'atum_tool_manage_stock',
				'confirm_msg'   => esc_attr( __( "This will change the WooCommerce's manage stock option for all your products", ATUM_TEXT_DOMAIN ) ),
			),
		);

		$defaults['update_control_stock'] = array(
			'group'   => 'tools',
			'section' => 'tools',
			'name'    => __( "Update ATUM's stock control", ATUM_TEXT_DOMAIN ) . $atum_label,
			'desc'    => __( "Update the ATUM's stock control option for all the products at once.", ATUM_TEXT_DOMAIN ),
			'type'    => 'script_runner',
			'options' => array(
				'select'        => array(
					'control'   => __( 'Control Stock', ATUM_TEXT_DOMAIN ),
					'uncontrol' => __( 'Uncontrol Stock', ATUM_TEXT_DOMAIN ),
				),
				'button_text'   => __( 'Update Now!', ATUM_TEXT_DOMAIN ),
				'script_action' => 'atum_tool_control_stock',
				'confirm_msg'   => esc_attr( __( "This will change the ATUM's stock control option for all your products", ATUM_TEXT_DOMAIN ) ),
			),
		);

		$defaults['clear_out_stock_threshold'] = array(
			'group'   => 'tools',
			'section' => 'tools',
			'name'    => __( 'Clear out stock threshold', ATUM_TEXT_DOMAIN ) . $atum_label,
			'desc'    => __( 'Clear all previously saved Out of Stock Threshold values.', ATUM_TEXT_DOMAIN ),
			'type'    => 'script_runner',
			'options' => array(
				'button_text'   => __( 'Clear Now!', ATUM_TEXT_DOMAIN ),
				'script_action' => 'atum_tool_clear_out_stock_threshold',
				'confirm_msg'   => esc_attr( __( 'This will clear all the Out Stock Threshold values that have been set in all products', ATUM_TEXT_DOMAIN ) ),
			),
		);

		$defaults['update_sales_calc_props'] = array(
			'group'   => 'tools',
			'section' => 'tools',
			'default' => 300,
			'name'    => __( "Update products' calculated properties", ATUM_TEXT_DOMAIN ) . $atum_label,
			'desc'    => __( 'Update the calculated product and sales properties for all the products.<br>The input field specifies the quantity of products to process per Ajax call, if it fails, try setting a lower value', ATUM_TEXT_DOMAIN ),
			'type'    => 'script_runner',
			'options' => array(
				'number'         => array(
					'default' => 400,
				),
				'is_recurrent'   => TRUE,
				'button_text'    => __( 'Update Now!', ATUM_TEXT_DOMAIN ),
				'script_action'  => 'atum_tool_update_calc_props',
				'confirm_msg'    => esc_attr( __( 'This will update all products\' calculated properties and it can take a lot of time', ATUM_TEXT_DOMAIN ) ),
				'processing_msg' => esc_attr( __( 'Processing {processed} from {total}', ATUM_TEXT_DOMAIN ) ),
				'processed_msg'  => esc_attr( __( 'Processed {processed} products', ATUM_TEXT_DOMAIN ) ),
			),
		);

		return $defaults;

	}


	/****************************
	 * Instance methods
	 ****************************/

	/**
	 * Cannot be cloned
	 */
	public function __clone() {

		_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', ATUM_TEXT_DOMAIN ), '1.0.0' );
	}

	/**
	 * Cannot be serialized
	 */
	public function __sleep() {

		_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', ATUM_TEXT_DOMAIN ), '1.0.0' );
	}

	/**
	 * Get Singleton instance
	 *
	 * @return Tools instance
	 */
	public static function get_instance() {

		if ( ! ( self::$instance && is_a( self::$instance, __CLASS__ ) ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
