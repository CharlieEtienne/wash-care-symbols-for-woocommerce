<?php
/**
 * Plugin Name:       Wash Care Symbols for WooCommerce
 * Description:       Display wash/care symbols in WooCommerce products
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Charlie Etienne
 * Author URI:        https://web-nancy.fr
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wcsfw
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WashCareSymbolsForWooCommerce {
	public array $values;

	public function __construct() {
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
			'wcsfw_washing'   => [
				'label'       => __( 'Washing', 'wcsfw' ),
				'description' => __( 'Washing', 'wcsfw' ),
				'choices'     => [
					'wash_1'  => __( 'Machine wash, gentle / delicate', 'wcsfw' ),
					'wash_2'  => __( 'Machine wash, permanent press / wrinkle resistant', 'wcsfw' ),
					'wash_3'  => __( 'Machine wash, regular / normal', 'wcsfw' ),
					'wash_4'  => __( 'Do not wash', 'wcsfw' ),
					'wash_5'  => __( 'Hand wash only', 'wcsfw' ),
					'wash_6'  => __( 'Machine wash, gentle / delicate, 30 degrees C (85 degrees F)', 'wcsfw' ),
					'wash_7'  => __( 'Machine wash, permanent press / wrinkle resistant, 30 degrees C (85 degrees F)', 'wcsfw' ),
					'wash_8'  => __( 'Machine was h, regular / normal, 30 degrees C (85 degrees F)', 'wcsfw' ),
					'wash_9'  => __( 'Machine wash, gentle / delicate, 40 degrees C (105 degrees F)', 'wcsfw' ),
					'wash_10' => __( 'Machine wash, permanent press, 40 degrees C (105 degrees F)', 'wcsfw' ),
					'wash_11' => __( 'Machine wash, regular / normal, 40 degrees C (105 degrees F)', 'wcsfw' ),
					'wash_12' => __( 'Machine wash, gentle / delicate, 50 degrees C (120 degrees F)', 'wcsfw' ),
					'wash_13' => __( 'Machine wash, permanent press, 50 degrees C (120 degrees F)', 'wcsfw' ),
					'wash_14' => __( 'Machine wash, regular / normal, 50 degrees C (120 degrees F)', 'wcsfw' ),
					'wash_15' => __( 'Machine wash, gentle / delicate, 60 degrees C (140 degrees F)', 'wcsfw' ),
					'wash_16' => __( 'Machine wash, permanent press, 60 degrees C (140 degrees F)', 'wcsfw' ),
					'wash_17' => __( 'Machine wash, regular / normal, 60 degrees C (140 degrees F)', 'wcsfw' ),
					'wash_18' => __( 'Machine wash, gentle / delicate, 70 degrees C (160 degrees F)', 'wcsfw' ),
					'wash_19' => __( 'Machine wash, permanent press, 70 degrees C (160 degrees F)', 'wcsfw' ),
					'wash_20' => __( 'Machine wash, regular / normal, 70 degrees C (160 degrees F)', 'wcsfw' ),
					'wash_21' => __( 'Machine wash, gentle / delicate, 95 degrees C (200 degrees F)', 'wcsfw' ),
					'wash_22' => __( 'Machine wash, permanent press, 95 degrees C (200 degrees F)', 'wcsfw' ),
					'wash_23' => __( 'Machine wash, regular / normal, 95 degrees C (200 degrees F)', 'wcsfw' ),
					'wash_24' => __( 'Hand wash, 30 degrees C (85 degrees F)', 'wcsfw' ),
					'wash_25' => __( 'Hand wash, 40 degrees C (105 degrees F)', 'wcsfw' ),
					'wash_26' => __( 'Hand wash, 50 degrees C (120 degrees F)', 'wcsfw' ),

				],
			],
			'wcsfw_drying'    => [
				'label'       => __( 'Drying', 'wcsfw' ),
				'description' => __( 'Drying', 'wcsfw' ),
				'choices'     => [
					'drying_1'  => __( 'Tumble dry, normal', 'wcsfw' ),
					'drying_2'  => __( 'Tumble dry, normal, low heat', 'wcsfw' ),
					'drying_3'  => __( 'Tumble dry, normal, medium heat', 'wcsfw' ),
					'drying_4'  => __( 'Tumble dry, normal, high heat', 'wcsfw' ),
					'drying_5'  => __( 'Tumble dry, normal, no heat', 'wcsfw' ),
					'drying_6'  => __( 'Tumble dry, permanent press', 'wcsfw' ),
					'drying_7'  => __( 'Tumble dry, permanent press, low heat', 'wcsfw' ),
					'drying_8'  => __( 'Tumble dry, permanent press, medium heat', 'wcsfw' ),
					'drying_9'  => __( 'Tumble dry, permanent press, high heat', 'wcsfw' ),
					'drying_10' => __( 'Tumble dry, gentle', 'wcsfw' ),
					'drying_11' => __( 'Tumble dry, gentle, low heat', 'wcsfw' ),
					'drying_12' => __( 'Tumble dry, gentle, medium heat', 'wcsfw' ),
					'drying_13' => __( 'Tumble dry, gentle, high heat', 'wcsfw' ),
					'drying_14' => __( 'Tumble dry, permanent press, no heat', 'wcsfw' ),
					'drying_15' => __( 'Line dry', 'wcsfw' ),
					'drying_16' => __( 'Drip dry', 'wcsfw' ),
					'drying_17' => __( 'Dry flat', 'wcsfw' ),
					'drying_18' => __( 'Dry in shade', 'wcsfw' ),
					'drying_19' => __( 'Do not dry', 'wcsfw' ),
					'drying_20' => __( 'Line dry in shade', 'wcsfw' ),
					'drying_21' => __( 'Drip dry in shade', 'wcsfw' ),
					'drying_22' => __( 'Dry flat in shade', 'wcsfw' ),
				],
			],
			'wcsfw_ironing'   => [
				'label'       => __( 'Ironing', 'wcsfw' ),
				'description' => __( 'Ironing', 'wcsfw' ),
				'choices'     => [
					'ironing_1' => __( 'Ironing required', 'wcsfw' ),
					'ironing_2' => __( 'Iron, low temperature', 'wcsfw' ),
					'ironing_3' => __( 'Iron, medium temperature', 'wcsfw' ),
					'ironing_4' => __( 'Iron, high temperature', 'wcsfw' ),
					'ironing_5' => __( 'Do not iron', 'wcsfw' ),
					'ironing_6' => __( 'Iron, no steam', 'wcsfw' ),
					'ironing_7' => __( 'Iron, no steam, low temperature', 'wcsfw' ),
					'ironing_8' => __( 'Iron, no steam, medium temperature', 'wcsfw' ),
					'ironing_9' => __( 'Iron, no steam, high temperature', 'wcsfw' ),
				],
			],
			'wcsfw_dry_clean' => [
				'label'       => __( 'Dry clean', 'wcsfw' ),
				'description' => __( 'Dry clean', 'wcsfw' ),
				'choices'     => [
					'dry_cleaning_1'  => __( 'Dry clean', 'wcsfw' ),
					'dry_cleaning_2'  => __( 'Dry clean, any solvent', 'wcsfw' ),
					'dry_cleaning_3'  => __( 'Dry clean, petroleum based solvent only', 'wcsfw' ),
					'dry_cleaning_4'  => __( 'Dry clean, any solvent other than trichloroethylene', 'wcsfw' ),
					'dry_cleaning_5'  => __( 'Do not dry clean', 'wcsfw' ),
					'dry_cleaning_6'  => __( 'Dry clean, short cycle', 'wcsfw' ),
					'dry_cleaning_7'  => __( 'Dry clean, low moisture', 'wcsfw' ),
					'dry_cleaning_8'  => __( 'Dry clean, low heat', 'wcsfw' ),
					'dry_cleaning_9'  => __( 'Dry clean, no steam', 'wcsfw' ),
					'dry_cleaning_10' => __( 'Dry clean, any solvent, short cycle', 'wcsfw' ),
					'dry_cleaning_11' => __( 'Dry clean, any solvent, low moisture', 'wcsfw' ),
					'dry_cleaning_12' => __( 'Dry clean, any solvent, low heat', 'wcsfw' ),
					'dry_cleaning_13' => __( 'Dry clean, any solvent, no steam', 'wcsfw' ),
				],
			],
			'wcsfw_bleaching'    => [
				'label'       => __( 'Bleaching', 'wcsfw' ),
				'description' => __( 'Bleaching', 'wcsfw' ),
				'choices'     => [
					'bleaching_1' => __('Use any bleach', 'wcsfw'),
                    'bleaching_2' => __('Use only non-chlorine bleach', 'wcsfw'),
                    'bleaching_3' => __('Do not bleach', 'wcsfw'),
				],
			],
		];
		$this->values = apply_filters( 'wcsfw-data', $this->values );
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
			'label'    => __( 'Wash / Care', 'wcsfw' ),
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
			update_post_meta( $post_id, '_' . $fieldkey, $_POST[ '_' . $fieldkey ] ?? null );
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
					echo '<button aria-label="' . $field[ 'choices' ][ $choice ] . '" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
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