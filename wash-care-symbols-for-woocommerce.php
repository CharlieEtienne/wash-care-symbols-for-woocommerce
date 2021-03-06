<?php
/**
 * Plugin Name:             Wash Care Symbols for WooCommerce
 * Description:             Display wash/care symbols in WooCommerce products
 * Version:                 2.1.9
 * Requires at least:       5.2
 * Requires PHP:            7.2
 * WC requires at least:    4.0
 * WC tested up to:         5.0
 * Author:                  Charlie Etienne
 * Author URI:              https://web-nancy.fr
 * License:                 GPL v2 or later
 * License URI:             https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:             wash-care-symbols-for-woocommerce
 * Domain Path:             /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WashCareSymbolsForWooCommerce {
	public $values;

	public function __construct() {
		add_action( 'init', [ $this, 'load_plugin_textdomain' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_filter( 'woocommerce_product_tabs', [ $this, 'force_tab_to_display' ], 98 );
		add_filter( 'woocommerce_product_data_tabs', [ $this, 'wash_care_tab' ], 10, 1 );
		add_action( 'woocommerce_product_data_panels', [ $this, 'wash_care_tab_content' ] );
		add_action( 'woocommerce_process_product_meta', [ $this, 'save_fields' ] );
		add_action( 'woocommerce_product_additional_information', [ $this, 'additional_info_display' ] );

		/**
		 * Multidimensional array with all the choices, labels, and all necessary informations for the fields
		 */
		$this->values = [
			'wcsfw_washing'      => [
				'label'       => __( 'Washing', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Washing', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'wash_1'  => __( 'Machine wash, gentle / delicate', 'wash-care-symbols-for-woocommerce' ),
					'wash_2'  => __( 'Machine wash, permanent press / wrinkle resistant', 'wash-care-symbols-for-woocommerce' ),
					'wash_3'  => __( 'Machine wash, regular / normal', 'wash-care-symbols-for-woocommerce' ),
					'wash_4'  => __( 'Do not wash', 'wash-care-symbols-for-woocommerce' ),
					'wash_5'  => __( 'Hand wash only', 'wash-care-symbols-for-woocommerce' ),
					'wash_6'  => __( 'Machine wash, gentle / delicate, 30 degrees C (85 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_7'  => __( 'Machine wash, permanent press / wrinkle resistant, 30 degrees C (85 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_8'  => __( 'Machine wash, regular / normal, 30 degrees C (85 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_9'  => __( 'Machine wash, gentle / delicate, 40 degrees C (105 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_10' => __( 'Machine wash, permanent press, 40 degrees C (105 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_11' => __( 'Machine wash, regular / normal, 40 degrees C (105 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_12' => __( 'Machine wash, gentle / delicate, 50 degrees C (120 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_13' => __( 'Machine wash, permanent press, 50 degrees C (120 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_14' => __( 'Machine wash, regular / normal, 50 degrees C (120 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_15' => __( 'Machine wash, gentle / delicate, 60 degrees C (140 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_16' => __( 'Machine wash, permanent press, 60 degrees C (140 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_17' => __( 'Machine wash, regular / normal, 60 degrees C (140 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_18' => __( 'Machine wash, gentle / delicate, 70 degrees C (160 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_19' => __( 'Machine wash, permanent press, 70 degrees C (160 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_20' => __( 'Machine wash, regular / normal, 70 degrees C (160 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_21' => __( 'Machine wash, gentle / delicate, 95 degrees C (200 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_22' => __( 'Machine wash, permanent press, 95 degrees C (200 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_23' => __( 'Machine wash, regular / normal, 95 degrees C (200 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_24' => __( 'Hand wash, 30 degrees C (85 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_25' => __( 'Hand wash, 40 degrees C (105 degrees F)', 'wash-care-symbols-for-woocommerce' ),
					'wash_26' => __( 'Hand wash, 50 degrees C (120 degrees F)', 'wash-care-symbols-for-woocommerce' ),

				],
			],
			'wcsfw_drying'       => [
				'label'       => __( 'Drying', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Drying', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'drying_1'  => __( 'Tumble dry, normal', 'wash-care-symbols-for-woocommerce' ),
					'drying_2'  => __( 'Tumble dry, normal, low heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_3'  => __( 'Tumble dry, normal, medium heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_4'  => __( 'Tumble dry, normal, high heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_5'  => __( 'Tumble dry, normal, no heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_6'  => __( 'Tumble dry, permanent press', 'wash-care-symbols-for-woocommerce' ),
					'drying_7'  => __( 'Tumble dry, permanent press, low heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_8'  => __( 'Tumble dry, permanent press, medium heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_9'  => __( 'Tumble dry, permanent press, high heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_10' => __( 'Tumble dry, gentle', 'wash-care-symbols-for-woocommerce' ),
					'drying_11' => __( 'Tumble dry, gentle, low heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_12' => __( 'Tumble dry, gentle, medium heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_13' => __( 'Tumble dry, gentle, high heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_14' => __( 'Tumble dry, permanent press, no heat', 'wash-care-symbols-for-woocommerce' ),
					'drying_15' => __( 'Line dry', 'wash-care-symbols-for-woocommerce' ),
					'drying_16' => __( 'Drip dry', 'wash-care-symbols-for-woocommerce' ),
					'drying_17' => __( 'Dry flat', 'wash-care-symbols-for-woocommerce' ),
					'drying_18' => __( 'Dry in shade', 'wash-care-symbols-for-woocommerce' ),
					'drying_19' => __( 'Do not dry', 'wash-care-symbols-for-woocommerce' ),
					'drying_20' => __( 'Line dry in shade', 'wash-care-symbols-for-woocommerce' ),
					'drying_21' => __( 'Drip dry in shade', 'wash-care-symbols-for-woocommerce' ),
					'drying_22' => __( 'Dry flat in shade', 'wash-care-symbols-for-woocommerce' ),
				],
			],
			'wcsfw_ironing'      => [
				'label'       => __( 'Ironing', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Ironing', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'ironing_1' => __( 'Ironing required', 'wash-care-symbols-for-woocommerce' ),
					'ironing_2' => __( 'Iron, low temperature', 'wash-care-symbols-for-woocommerce' ),
					'ironing_3' => __( 'Iron, medium temperature', 'wash-care-symbols-for-woocommerce' ),
					'ironing_4' => __( 'Iron, high temperature', 'wash-care-symbols-for-woocommerce' ),
					'ironing_5' => __( 'Do not iron', 'wash-care-symbols-for-woocommerce' ),
					'ironing_6' => __( 'Iron, no steam', 'wash-care-symbols-for-woocommerce' ),
					'ironing_7' => __( 'Iron, no steam, low temperature', 'wash-care-symbols-for-woocommerce' ),
					'ironing_8' => __( 'Iron, no steam, medium temperature', 'wash-care-symbols-for-woocommerce' ),
					'ironing_9' => __( 'Iron, no steam, high temperature', 'wash-care-symbols-for-woocommerce' ),
				],
			],
			'wcsfw_dry_cleaning' => [
				'label'       => __( 'Dry cleaning', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Dry cleaning', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'dry_cleaning_1'  => __( 'Dry clean', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_2'  => __( 'Dry clean, any solvent', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_3'  => __( 'Dry clean, petroleum based solvent only', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_4'  => __( 'Dry clean, any solvent other than trichloroethylene', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_5'  => __( 'Do not dry clean', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_6'  => __( 'Dry clean, short cycle', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_7'  => __( 'Dry clean, low moisture', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_8'  => __( 'Dry clean, low heat', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_9'  => __( 'Dry clean, no steam', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_10' => __( 'Dry clean, any solvent, short cycle', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_11' => __( 'Dry clean, any solvent, low moisture', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_12' => __( 'Dry clean, any solvent, low heat', 'wash-care-symbols-for-woocommerce' ),
					'dry_cleaning_13' => __( 'Dry clean, any solvent, no steam', 'wash-care-symbols-for-woocommerce' ),
				],
			],
			'wcsfw_bleaching'    => [
				'label'       => __( 'Bleaching', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Bleaching', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'bleaching_1' => __( 'Use any bleach', 'wash-care-symbols-for-woocommerce' ),
					'bleaching_2' => __( 'Use only non-chlorine bleach', 'wash-care-symbols-for-woocommerce' ),
					'bleaching_3' => __( 'Do not bleach', 'wash-care-symbols-for-woocommerce' ),
				],
			],
		];
		$this->values = apply_filters( 'wcsfw-data', $this->values );
	}

	/**
	 * Loads plugin's translated strings.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wash-care-symbols-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'wcsfw-microtip', plugin_dir_url( __FILE__ ) . 'assets/css/vendor/microtip.css' );
		wp_enqueue_style( 'wcsfw-main', plugin_dir_url( __FILE__ ) . 'assets/css/wcsfw.css' );
	}

	/**
	 * Add a custom product data tab
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	public function wash_care_tab( $tabs ) {
		$tabs[ 'custom_tab' ] = array(
			'label'    => __( 'Wash / Care', 'wash-care-symbols-for-woocommerce' ),
			'target'   => 'wash_care_tab_content',
			'priority' => 60,
			'class'    => array()
		);

		return $tabs;
	}

	/**
	 * Content of Wash / Care tab in admin
	 */
	public function wash_care_tab_content() {
		?>
        <div id="wash_care_tab_content" class="panel woocommerce_options_panel">
			<?php $this->get_fields(); ?>
        </div>
		<?php
	}

	/**
	 * Return all multiselect fields
	 */
	public function get_fields() {
		foreach ( $this->values as $fieldkey => $field ) {
			$this->multiple_select(
				[
					'id'          => $fieldkey,
					'name'        => '_' . $fieldkey . '[]',
					'label'       => $field[ 'label' ],
					'class'       => 'wcsfw',
					'desc_tip'    => true,
					'description' => $field[ 'description' ],
					'options'     => $field[ 'choices' ],
				]
			);
		}
	}

	/**
	 * Called when we save the post
	 *
	 * @param $post_id
	 */
	public function save_fields( $post_id ) {
		foreach ( $this->values as $fieldkey => $field ) {
			if ( isset( $_POST[ '_' . $fieldkey ] ) && is_array( $_POST[ '_' . $fieldkey ] ) ) {
				$clean_values = [];
				foreach ( $_POST[ '_' . $fieldkey ] as $item ) {
					$clean_values[] = sanitize_key( $item );
				}
				update_post_meta( $post_id, '_' . $fieldkey, $clean_values ?? null );
			} else {
				delete_post_meta( $post_id, '_' . $fieldkey );
			}
		}
	}

	/**
	 * Display our icons in Additional Information tab
	 */
	public function additional_info_display() {
		echo '<table class="wcsfw"><tbody>';
		foreach ( $this->values as $fieldkey => $field ) {
			$choices = get_post_meta( get_the_ID(), '_' . $fieldkey, true );
			if ( $choices ) {
				echo '<tr>';
				echo '<th class="wcsfw-title">' . $field[ 'label' ] . '</th>';
				echo '<td class="wcsfw-symbols-container">';
				foreach ( $choices as $choice ) {
					echo '<button aria-label="' . $field[ 'choices' ][ $choice ] . '"data-microtip-size="medium" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
					echo '<img class="wcsfw-symbol-img" src="' . plugin_dir_url( __FILE__ ) . 'symbols/' . $choice . '.png">';
					echo '</button>';
				}
				echo '</td></tr>';
			}
		}
		echo '</tbody></table>';
	}

	/**
	 * Force Additionnal Information tab to display even if product has no attributes or dimensions
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	public function force_tab_to_display( $tabs ) {
		if ( ! isset( $tabs[ 'additional_information' ] ) ) {
			$tabs[ 'additional_information' ] = apply_filters( 'wcsfw-additional-information', [
				'title'    => __( 'Additional information', 'woocommerce' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab',
			] );
		}

		return $tabs;
	}

	/**
	 * Add ability to use mutiselect selectWoo field
	 *
	 * @param $field
	 */
	public function multiple_select( $field ) {
		global $thepostid, $post;

		$thepostid                = empty( $thepostid ) ? $post->ID : $thepostid;
		$field[ 'class' ]         = isset( $field[ 'class' ] ) ? $field[ 'class' ] : 'select short';
		$field[ 'wrapper_class' ] = isset( $field[ 'wrapper_class' ] ) ? $field[ 'wrapper_class' ] : '';
		$field[ 'name' ]          = isset( $field[ 'name' ] ) ? $field[ 'name' ] : $field[ 'id' ];
		$field[ 'value' ]         = isset( $field[ 'value' ] ) ? $field[ 'value' ] : ( get_post_meta( $thepostid, '_' . $field[ 'id' ], true ) ? get_post_meta( $thepostid, '_' . $field[ 'id' ], true ) : array() );

		printf( '<p class="form-field %s_field %s">',
		        esc_attr( $field[ 'id' ] ),
		        esc_attr( $field[ 'wrapper_class' ] )
		);
		printf( '<label for="%s">%s</label>',
		        esc_attr( $field[ 'id' ] ),
		        wp_kses_post( $field[ 'label' ] )
		);
		printf( '<select id="%s" name="%s" class="%s multiselect wc-enhanced-select" multiple="multiple" style="width:calc(100%% - 25px);">',
		        esc_attr( $field[ 'id' ] ),
		        esc_attr( $field[ 'name' ] ),
		        esc_attr( $field[ 'class' ] )
		);

		foreach ( $field[ 'options' ] as $key => $value ) {
			printf( '<option value="%s" %s>%s</option>',
			        esc_attr( $key ),
			        in_array( $key, $field[ 'value' ] ) ? 'selected="selected"' : '',
			        esc_html( $value )
			);
		}

		echo '</select> ';

		if ( ! empty( $field[ 'description' ] ) ) {
			if ( isset( $field[ 'desc_tip' ] ) && false !== $field[ 'desc_tip' ] ) {
				printf( '<img class="help_tip" data-tip="%s" src="%s/assets/images/help.png" height="16" width="16" />',
				        esc_attr( $field[ 'description' ] ),
				        esc_url( WC()->plugin_url() )
				);
			} else {
				echo '<span class="description">' . wp_kses_post( $field[ 'description' ] ) . '</span>';
			}
		}
		echo '</p>';
	}
}

new WashCareSymbolsForWooCommerce();