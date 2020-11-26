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
	public array $images;

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
			'wcsfw_wash'         => [
				'label'       => __( 'Wash', 'wcsfw' ),
				'description' => __( 'Wash', 'wcsfw' ),
				'choices'     => [
					'machine_wash' => __( 'Machine wash', 'wcsfw' ),
					'hand_wash'    => __( 'Hand wash', 'wcsfw' ),
					'do_not_wash'  => __( 'Do not wash', 'wcsfw' ),
				],
			],
			'wcsfw_washing_temp' => [
				'label'       => __( 'Washing Temperature', 'wcsfw' ),
				'description' => __( 'Washing Temperature', 'wcsfw' ),
				'choices'     => [
					'washing_temperature_30' => __( 'Machine wash cold, 75F/30C', 'wcsfw' ),
					'washing_temperature_40' => __( 'Machine wash warm, 105F/40C', 'wcsfw' ),
					'washing_temperature_50' => __( 'Machine wash hot, 120F/50C', 'wcsfw' ),
					'washing_temperature_60' => __( 'Machine wash hot, 140F/60C', 'wcsfw' ),
					'washing_temperature_70' => __( 'Machine wash hot, 160F/70C', 'wcsfw' ),
					'washing_temperature_95' => __( 'Machine wash hot, 200F/95C', 'wcsfw' ),
				],
			],
			'wcsfw_wash_cycle'   => [
				'label'       => __( 'Wash Cycle', 'wcsfw' ),
				'description' => __( 'Wash Cycle', 'wcsfw' ),
				'choices'     => [
					'wash_cycle_delicate' => __( 'Delicate cycle', 'wcsfw' ),
				],
			],
			'wcsfw_bleach'       => [
				'label'       => __( 'Bleach', 'wcsfw' ),
				'description' => __( 'Bleach', 'wcsfw' ),
				'choices'     => [
					'bleach'                   => __( 'Bleach', 'wcsfw' ),
					'do_not_bleach'            => __( 'Do not bleach', 'wcsfw' ),
					'non_chlorine_bleach_only' => __( 'Non-chlorine bleach only', 'wcsfw' ),
				],
			],
			'wcsfw_dry'          => [
				'label'       => __( 'Dry', 'wcsfw' ),
				'description' => __( 'Dry', 'wcsfw' ),
				'choices'     => [
					'dry'                    => __( 'Dry', 'wcsfw' ),
					'tumble_dry_low_heat'    => __( 'Tumble dry, low heat', 'wcsfw' ),
					'tumble_dry_medium_heat' => __( 'Tumble dry, medium heat', 'wcsfw' ),
					'tumble_dry_high_heat'   => __( 'Tumble dry, high heat', 'wcsfw' ),
					'do_not_dry'             => __( 'Do not dry!', 'wcsfw' ),
					'do_not_tumble_dry'      => __( 'Do not tumble dry', 'wcsfw' ),
				],
			],
			'wcsfw_iron'         => [
				'label'       => __( 'Iron', 'wcsfw' ),
				'description' => __( 'Iron', 'wcsfw' ),
				'choices'     => [
					'iron'        => __( 'Iron', 'wcsfw' ),
					'do_not_iron' => __( 'Do not iron!', 'wcsfw' ),
				],
			],
			'wcsfw_dry_clean'    => [
				'label'       => __( 'Dry clean', 'wcsfw' ),
				'description' => __( 'Dry clean', 'wcsfw' ),
				'choices'     => [
					'dry_clean'        => __( 'Dry clean', 'wcsfw' ),
					'do_not_dry_clean' => __( 'Do not dry clean!', 'wcsfw' ),
				],
			],
		];
		$this->values = apply_filters( 'wcsfw-data', $this->values );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'wcsfw-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', [ 'wc-enhanced-select' ] );
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
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
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