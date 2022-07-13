<?php
/**
 * Plugin Name:             Wash Care Symbols for WooCommerce
 * Description:             Display wash/care symbols in WooCommerce products
 * Version:                 3.1.0
 * Requires at least:       5.2
 * Requires PHP:            7.2
 * WC requires at least:    4.0
 * WC tested up to:         6.2
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

	private static $instance;

	final public static function get_instance(): WashCareSymbolsForWooCommerce {
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    public function init() {
	    add_action( 'init', [ $this, 'load_plugin_textdomain' ] );
	    add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
	    add_action( 'admin_init', [ $this, 'register_settings' ] );
	    add_action( 'wcsfw_display', [ $this, 'display' ] );
	    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
	    add_filter( 'woocommerce_product_tabs', [ $this, 'force_tab_to_display' ], 98 );
	    add_filter( 'woocommerce_product_data_tabs', [ $this, 'wash_care_tab' ], 10, 1 );
	    add_action( 'woocommerce_product_data_panels', [ $this, 'wash_care_tab_content' ] );
	    add_action( 'woocommerce_process_product_meta', [ $this, 'save_fields' ] );
	    add_action( 'product_cat_add_form_fields', [ $this, 'product_cat_add_form_fields' ], 10 );
	    add_action( 'product_cat_edit_form_fields', [ $this, 'product_cat_edit_form_fields' ], 10, 2 );
	    add_action( 'created_product_cat', [ $this, 'save_term_fields' ] );
	    add_action( 'edited_product_cat', [ $this, 'save_term_fields' ] );
	    do_action( 'wcsfw_display' );
    }

	public function __construct() {
		/**
		 * Multidimensional array with all the choices, labels, and all necessary information for the fields
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
			'wcsfw_chemical_cleaning'    => [
				'label'       => __( 'Chemical cleaning', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Chemical cleaning', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'chemical_cleaning_1' => __( 'Dry clean, hydrocarbon solvent only (HCS)', 'wash-care-symbols-for-woocommerce' ),
					'chemical_cleaning_2' => __( 'Gentle cleaning with hydrocarbon sovents (HCS)', 'wash-care-symbols-for-woocommerce' ),
					'chemical_cleaning_3' => __( 'Very gentle cleaning with hydrocarbon sovents (HCS)', 'wash-care-symbols-for-woocommerce' ),
					'chemical_cleaning_4' => __( 'Dry clean, tetrachloroethylene only (PCE)', 'wash-care-symbols-for-woocommerce' ),
					'chemical_cleaning_5' => __( 'Gentle cleaning with tetrachloroethylene (PCE)', 'wash-care-symbols-for-woocommerce' ),
					'chemical_cleaning_6' => __( 'Very gentle cleaning with tetrachloroethylene (PCE)', 'wash-care-symbols-for-woocommerce' ),
				],
			],
			'wcsfw_wet_cleaning'    => [
				'label'       => __( 'Wet cleaning', 'wash-care-symbols-for-woocommerce' ),
				'description' => __( 'Wet cleaning', 'wash-care-symbols-for-woocommerce' ),
				'choices'     => [
					'wet_cleaning_1' => __( 'Wet clean', 'wash-care-symbols-for-woocommerce' ),
					'wet_cleaning_2' => __( 'Gentle wet cleaning', 'wash-care-symbols-for-woocommerce' ),
					'wet_cleaning_3' => __( 'Very gentle wet cleaning', 'wash-care-symbols-for-woocommerce' ),
					'wet_cleaning_4' => __( 'Professionnal wet cleaning is not allowed', 'wash-care-symbols-for-woocommerce' ),
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
		$css = ".wcsfw-symbol-img,.woocommerce img.wcsfw-symbol-img,.woocommerce-page img.wcsfw-symbol-img {";
		$css .= "height: {$this->get_icon_size_setting()}px;";
		$css .= "}";
        wp_add_inline_style( 'wcsfw-main', $css);
	}

	public function enqueue_admin_scripts($hook) {
        if( $this->is_product_edit_page( $hook ) || $this->is_product_cat_edit_page( $hook ) ) {
            
	        // Loads a modified copy of select2.js in order to add symbols in dropdowns and selected options,
	        // which is not possible with selectWoo since v1.07
	        // See https://github.com/woocommerce/selectWoo/issues/39
	        wp_enqueue_script( 'select-wcsfw', plugin_dir_url( __FILE__ ) . 'assets/js/vendor/select2-wcsfw.js', [ 'jquery' ] );
	        wp_enqueue_script( 'wcsfw-admin-script', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', [
		        'selectWoo',
		        'select-wcsfw'
	        ] );
	        wp_localize_script( 'wcsfw-admin-script', 'symbols_dir', [ plugin_dir_url( __FILE__ ) . 'symbols/' ] );

	        $page_type = $this->is_product_cat_edit_page( $hook ) ? 'product_cat_edit' : 'product_edit';
            wp_localize_script( 'wcsfw-admin-script', 'wcsfw_page_type', [ $page_type ] );
        }
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
        $values = $this->get_formatted_values();
		foreach ( $values as $field ) {
			$this->multiple_select($field);
		}
	}

	public function get_formatted_values(): array {
        $formatted = [];
		foreach ( $this->values as $fieldkey => $field ) {
			$formatted[] = [
				'id'          => $fieldkey,
				'name'        => '_' . $fieldkey . '[]',
				'label'       => $field[ 'label' ],
				'class'       => 'wcsfw',
				'desc_tip'    => true,
				'description' => $field[ 'description' ],
				'options'     => $field[ 'choices' ],
			];
		}

        return $formatted;
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

	public function display(  ) {
		$position = $this->get_position_setting();

		if ( $position === 'below_short_desc' ){
            $priority = apply_filters( 'wcsfw_below_short_desc_priority', 21 );
			add_action( 'woocommerce_single_product_summary', [ $this, 'below_short_desc_display' ], $priority );
		}
		elseif( $position === 'custom_tab' ){
			add_filter( 'woocommerce_product_tabs', [$this, 'add_custom_tab'] );
		}
        else {
	        add_action( 'woocommerce_product_additional_information', [ $this, 'additional_info_display' ] );
        }
    }

	/**
	 * Display instructions in a custom tab
	 *
	 * @param array $tabs
	 * @return array
	 *
	 * @since 3.1.0
	 */
	public function add_custom_tab( $tabs ): array {
		/**
		 * Hook wcsfw_custom_tab_priority
		 * Allows to change tab order when using custom tab layout
		 * Default to 21 to have it just after Additionnal Information tab
		 * @since 3.1.0
		 */
		$priority = apply_filters( 'wcsfw_custom_tab_priority', 21 );

		$tabs[ '_care_instructions_tab' ] = [
			'title'    => __( 'Wash / Care', 'wash-care-symbols-for-woocommerce' ),
			'priority' => $priority,
			'callback' => [$this, 'additional_info_display']
		];
		return $tabs;
	}

	/**
	 * Display our icons in Additional Information tab
	 */
	public function additional_info_display() {
		$layout = $this->get_layout_setting();

        $values = $this->get_product_values();

        if ( !$values ){return;}

		echo '<table class="wcsfw ' . $layout . '"><tbody>';
		if ($layout === 'minimal'){
            echo '<tr>';
            echo '<th class="wcsfw-title">' . __( 'Wash / Care', 'wash-care-symbols-for-woocommerce' ) . '</th>';
            echo '<td class="wcsfw-symbols-container">';
			foreach ( $values as $fieldkey => $options ) {
                foreach ( $options as $option ) {
                    echo '<button aria-label="' . __( $this->values[$fieldkey][ 'choices' ][ $option ], 'wash-care-symbols-for-woocommerce' ) . '"data-microtip-size="medium" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
                    echo '<img class="wcsfw-symbol-img" src="' . plugin_dir_url( __FILE__ ) . 'symbols/' . $option . '.png">';
                    echo '</button>';
                }
			}
            echo '</td></tr>';
		}
		elseif($layout === 'vertical') {
            echo '<tr>';
			foreach ( $values as $fieldkey => $options ) {
				if ( $options ) {
					echo '<th class="wcsfw-title">' . __( $this->values[$fieldkey][ 'label' ], 'wash-care-symbols-for-woocommerce' ) . '</th>';
				}
			}
            echo '</tr>';
			echo '<tr>';
			foreach ( $values as $fieldkey => $options ) {
				if ( $options ) {
					echo '<td class="wcsfw-symbols-container">';
					foreach ( $options as $option ) {
						echo '<button aria-label="' . __( $this->values[$fieldkey][ 'choices' ][ $option ], 'wash-care-symbols-for-woocommerce' ) . '"data-microtip-size="medium" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
						echo '<img class="wcsfw-symbol-img" src="' . plugin_dir_url( __FILE__ ) . 'symbols/' . $option . '.png">';
						echo '</button>';
					}
					echo '</td>';
				}
			}
			echo '</tr>';
		}
		else {
			foreach ( $values as $fieldkey => $options ) {
                echo '<tr>';
                echo '<th class="wcsfw-title">' . __( $this->values[$fieldkey][ 'label' ], 'wash-care-symbols-for-woocommerce' ) . '</th>';
                echo '<td class="wcsfw-symbols-container">';
                foreach ( $options as $option ) {
                    echo '<button aria-label="' . __( $this->values[$fieldkey][ 'choices' ][ $option ], 'wash-care-symbols-for-woocommerce' ) . '"data-microtip-size="medium" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
                    echo '<img class="wcsfw-symbol-img" src="' . plugin_dir_url( __FILE__ ) . 'symbols/' . $option . '.png">';
                    echo '</button>';
                }
                echo '</td></tr>';
			}
		}
		echo '</tbody></table>';
	}

	/**
	 * Display our icons below product short description
	 */
	public function below_short_desc_display() {
		$values = $this->get_product_values();
        if ($values) {
	        echo '<div class="wcsfw below-short-desc">';
	        echo '<ul>';
	        echo '<li class="wcsfw-symbols-container">';
	        foreach ( $values as $fieldkey => $options ) {
		        if ( $options ) {
		            foreach ( $options as $option ) {
				        echo '<button aria-label="' . __( $this->values[$fieldkey][ 'choices' ][ $option ], 'wash-care-symbols-for-woocommerce' ) . '"data-microtip-size="medium" data-microtip-position="top" role="tooltip" class="wcsfw-symbol-btn" >';
				        echo '<img class="wcsfw-symbol-img" src="' . plugin_dir_url( __FILE__ ) . 'symbols/' . $option . '.png">';
				        echo '</button>';
			        }
		        }
	        }
	        echo '</li></ul>';
	        echo '</div>';
        }
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

	public function product_cat_add_form_fields() {
		?>
        <div class="form-field">
            <h3><?= __('Wash Care Symbols for WooCommerce', 'wash-care-symbols-for-woocommerce') ?></h3>
        </div>
        <div class="form-field">
            <label for="wcsfw_use_at_cat_level"><?= __('Define wash/care symbols on category level?', 'wash-care-symbols-for-woocommerce') ?></label>
            <input name="wcsfw_use_at_cat_level" id="wcsfw_use_at_cat_level" type="checkbox" value="1" />
            <p class="description"><?= __('Check this to define wash/care symbols for whole product category. This settings can be overrided for each product.', 'wash-care-symbols-for-woocommerce') ?></p>
        </div>
		<?php
		foreach ( $this->get_formatted_values() as $field ) {
			$field[ 'name' ]  = $field[ 'name' ] ?? $field[ 'id' ];
			?>
            <div class="form-field wcsfw-cat-field <?= $field[ 'id' ] ?>">
                <?php
                printf( '<label for="%s">%s</label>', esc_attr( $field[ 'id' ] ), wp_kses_post( $field[ 'label' ] ) );
                ?>
                <?php
                printf( '<select id="%s" name="%s" class="%s multiselect" multiple="multiple" style="width:calc(100%% - 25px);">',
                        esc_attr( $field[ 'id' ] ), esc_attr( $field[ 'name' ] ), esc_attr( $field[ 'class' ] ) );

                foreach ( $field[ 'options' ] as $key => $value ) {
                    printf( '<option value="%s" >%s</option>',
                            esc_attr( $key ), esc_html( $value ) );
                }

                echo '</select> ';
                ?>
            </div>
			<?php
		}
	}

	public function product_cat_edit_form_fields( $term, $taxonomy ) {
		$use_at_cat_level = get_term_meta( $term->term_id, 'wcsfw_use_at_cat_level', true );
        ?>
        <tr class="form-field">
            <td colspan="2" style="padding: 0;">
                <h3><?= __('Wash Care Symbols for WooCommerce', 'wash-care-symbols-for-woocommerce') ?></h3>
            </td>
        </tr>
            <tr class="form-field">
                <th>
                    <label for="wcsfw_use_at_cat_level"><?= __('Define wash/care symbols on category level?', 'wash-care-symbols-for-woocommerce') ?></label>
                </th>
                <td>
                    <input name="wcsfw_use_at_cat_level" id="wcsfw_use_at_cat_level" type="checkbox" value="1" <?php checked( $use_at_cat_level, 1 ); ?> />
                    <p class="description"><?= __('Check this to define wash/care symbols for whole product category. This settings can be overrided for each product.', 'wash-care-symbols-for-woocommerce') ?></p>
                </td>
            </tr>
        <?php
		foreach ( $this->get_formatted_values() as $field ) {
			$field[ 'value' ] = $field[ 'value' ] ?? ( get_term_meta( $term->term_id, '_' . $field[ 'id' ], true ) ? get_term_meta( $term->term_id, '_' . $field[ 'id' ], true ) : array() );
			$field[ 'name' ]  = $field[ 'name' ] ?? $field[ 'id' ];
            ?>
                <tr class="form-field wcsfw-cat-field <?= $field[ 'id' ] ?>">
                    <th>
                        <?php
                        printf( '<label for="%s">%s</label>', esc_attr( $field[ 'id' ] ), wp_kses_post( $field[ 'label' ] ) );
                        ?>
                    </th>
                    <td>
                        <?php
                        printf( '<select id="%s" name="%s" class="%s multiselect" multiple="multiple" style="width:calc(100%% - 25px);">',
                                esc_attr( $field[ 'id' ] ), esc_attr( $field[ 'name' ] ), esc_attr( $field[ 'class' ] ) );

                        foreach ( $field[ 'options' ] as $key => $value ) {
	                        printf( '<option value="%s" %s>%s</option>',
	                                esc_attr( $key ), in_array( $key, $field[ 'value' ] ) ? 'selected="selected"' : '', esc_html( $value ) );
                        }

                        echo '</select> ';
                        ?>
                    </td>
                </tr>
            <?php
        }
    }

	public function is_product_category(  ): bool {
		global $taxnow;
        return isset( get_current_screen()->base) && get_current_screen()->base === 'term' && isset( $taxnow) && $taxnow === 'product_cat';
    }

	public function save_term_fields( $term_id ) {
		update_term_meta(
			$term_id,
			'wcsfw_use_at_cat_level',
			sanitize_key( $_POST[ 'wcsfw_use_at_cat_level' ] )
		);

		foreach ( $this->values as $fieldkey => $field ) {
			if ( isset( $_POST[ '_' . $fieldkey ] ) && is_array( $_POST[ '_' . $fieldkey ] ) ) {
				$clean_values = [];
				foreach ( $_POST[ '_' . $fieldkey ] as $item ) {
					$clean_values[] = sanitize_key( $item );
				}
				update_term_meta( $term_id, '_' . $fieldkey, $clean_values ?? null );
			} else {
				delete_term_meta( $term_id, '_' . $fieldkey );
			}
		}
    }

	/**
	 * Add ability to use mutiselect selectWoo field
	 *
	 * @param $field
	 */
	public function multiple_select( $field ) {
		global $thepostid, $post;

		$thepostid                = empty( $thepostid ) ? $post->ID : $thepostid;
		$field[ 'class' ]         = $field[ 'class' ] ?? 'select short';
		$field[ 'wrapper_class' ] = $field[ 'wrapper_class' ] ?? '';
		$field[ 'name' ]          = $field[ 'name' ] ?? $field[ 'id' ];
		if ($this->is_product_category()){
			$term_id = absint( $_GET['tag_ID'] );
			$field[ 'value' ] = $field[ 'value' ] ?? ( get_term_meta( $term_id, '_' . $field[ 'id' ], true ) ? get_term_meta( $term_id, '_' . $field[ 'id' ], true ) : array() );
		}
        else {
	        $field[ 'value' ] = $field[ 'value' ] ?? ( get_post_meta( $thepostid, '_' . $field[ 'id' ], true ) ? get_post_meta( $thepostid, '_' . $field[ 'id' ], true ) : array() );
        }

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

	public function add_settings_page() {
		add_options_page( 'Wash Care Symbols for WooCommerce', 'Wash Care Symbols for WooCommerce', 'manage_options', 'wash-care-symbols-for-woocommerce', [
			$this,
			'render_plugin_settings_page'
		] );
	}

	public function render_plugin_settings_page() {
		?>
        <!--suppress HtmlUnknownTarget -->
        <form action="options.php" method="POST">
			<?php
			settings_fields( 'wcsfw_options' );
			do_settings_sections( 'wcsfw' );
			submit_button();
			?>
        </form>
		<?php
	}

	public function register_settings() {
		register_setting( 'wcsfw_options', 'wcsfw_options', 'wcsfw_options_validate' );
		add_settings_section( 'settings', __( 'Wash Care Symbols for WooCommerce Settings', 'wash-care-symbols-for-woocommerce' ), [ $this, 'section_settings' ], 'wcsfw' );
		add_settings_field(
			'setting_position',
			__( 'Choose position', 'wash-care-symbols-for-woocommerce' ),
			[
				$this,
				'setting_position'
			],
			'wcsfw',
			'settings'
		);
        add_settings_field(
			'setting_layout',
			__( 'Choose layout (only for default position)', 'wash-care-symbols-for-woocommerce' ),
			[
				$this,
				'setting_layout'
			],
			'wcsfw',
			'settings'
		);
		add_settings_field(
			'setting_icon_size',
			__( 'Choose icons size', 'wash-care-symbols-for-woocommerce' ),
			[
				$this,
				'setting_icon_size'
			],
			'wcsfw',
			'settings'
		);
	}

	public function section_settings(): bool {
        return true;
	}

	public function setting_layout() {
		$layout = $this->get_layout_setting();
		?>
        <label for="horizontal"> <input type="radio"
                                        name="wcsfw_options[layout]"
                                        id="horizontal"
                                        value="horizontal" <?php checked( 'horizontal', $layout );
			echo empty( $layout ) ? 'checked' : ''; ?>>
			<?php _e( 'Horizontal (Default)', 'wash-care-symbols-for-woocommerce' ); ?>
        </label>
        <label for="vertical"> <input type="radio"
                                      name="wcsfw_options[layout]"
                                      id="vertical"
                                      value="vertical" <?php checked( 'vertical', $layout ); ?>>
			<?php _e( 'Vertical', 'wash-care-symbols-for-woocommerce' ); ?>
        </label>
        <label for="minimal"> <input type="radio"
                                      name="wcsfw_options[layout]"
                                      id="minimal"
                                      value="minimal" <?php checked( 'minimal', $layout ); ?>>
			<?php _e( 'Minimal', 'wash-care-symbols-for-woocommerce' ); ?>
        </label>
		<?php
	}

	public function setting_position() {
		$position = $this->get_position_setting();
		?>
        <label for="standard"> <input type="radio"
                                        name="wcsfw_options[position]"
                                        id="standard"
                                        value="standard" <?php checked( 'standard', $position );
			echo empty( $position ) ? 'checked' : ''; ?>>
			<?php _e( 'Additional Information (Default)', 'wash-care-symbols-for-woocommerce' ); ?>
        </label>
        <label for="below_short_desc"> <input type="radio"
                                      name="wcsfw_options[position]"
                                      id="below_short_desc"
                                      value="below_short_desc" <?php checked( 'below_short_desc', $position ); ?>>
			<?php _e( 'Below short description', 'wash-care-symbols-for-woocommerce' ); ?>
        </label>
		<label for="custom_tab"> <input type="radio"
		                                      name="wcsfw_options[position]"
		                                      id="custom_tab"
		                                      value="custom_tab" <?php checked( 'custom_tab', $position ); ?>>
			<?php _e( 'In custom tab', 'wash-care-symbols-for-woocommerce' ); ?>
		</label>
		<?php
	}

	public function setting_icon_size() {
		$icon_size = $this->get_icon_size_setting();
		?>
        <label for="icon_size">
            <input type="number" name="wcsfw_options[icon_size]" id="icon_size" value="<?php echo $icon_size ?>" style="width: 70px" >&nbsp;px
        </label>
		<?php
	}

	public function get_layout_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'layout' ] ) ) {
			return 'horizontal';
		}

		return $options[ 'layout' ];
	}

	public function get_position_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'position' ] ) ) {
			return 'standard';
		}

		return $options[ 'position' ];
	}

	public function get_icon_size_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'icon_size' ] ) ) {
			return '38';
		}

		return $options[ 'icon_size' ];
	}

	/**
	 * @param $hook
	 *
	 * @return bool
	 */
	public function is_product_edit_page( $hook ): bool {
        if (!isset( $hook ) || empty( get_current_screen()->post_type )){
            return false;
        }
		return 'post.php' === $hook && get_current_screen()->post_type === 'product';
	}

	/**
	 * @param $hook
	 *
	 * @return bool
	 */
	public function is_product_cat_edit_page( $hook ): bool {
		if (!isset( $hook ) || empty( get_current_screen()->taxonomy )){
			return false;
		}
		return ('term.php' === $hook || 'edit-tags.php' === $hook) && get_current_screen()->taxonomy === 'product_cat';
	}

	/**
     * Get product values or product category values if empty
     *
	 * @return array|false
	 */
	public function get_product_values() {
		$values = [];
		foreach ( $this->values as $fieldkey => $field ) {
            $option = get_post_meta( get_the_ID(), '_' . $fieldkey, true );
            if($option){
			    $values[$fieldkey] = get_post_meta( get_the_ID(), '_' . $fieldkey, true );
            }
		}
        if( !empty($values) ){
	        return $values;
        }
        // get product category values if empty
        else {
            $product_cat_ids = wc_get_product_term_ids(get_the_ID(), 'product_cat');
            $empty = true;
	        foreach ( $product_cat_ids as $product_cat_id ) {
                if (get_term_meta( $product_cat_id, 'wcsfw_use_at_cat_level', true ) == 1) {
	                foreach ( $this->values as $fieldkey => $field ) {
		                $option = get_term_meta( $product_cat_id, '_' . $fieldkey, true );
		                if ( $option ) {
			                $empty               = false;
			                $values[ $fieldkey ] = $option;
		                }
	                }
	                if ( ! $empty ) {
		                return $values;
	                }
                }
	        }
        }
        return false;
	}

}

WashCareSymbolsForWooCommerce::get_instance()->init();