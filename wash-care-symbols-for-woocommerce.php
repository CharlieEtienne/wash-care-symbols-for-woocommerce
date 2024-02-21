<?php
/**
 * Plugin Name:             Wash Care Symbols for WooCommerce
 * Description:             Display wash/care symbols in WooCommerce products
 * Version:                 4.2.0
 * Requires at least:       5.2
 * Requires PHP:            7.2
 * WC requires at least:    4.0
 * WC tested up to:         8.6
 * Author:                  Charlie Etienne
 * Author URI:              https://web-nancy.fr
 * License:                 GPL v2 or later
 * License URI:             https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:             wash-care-symbols-for-woocommerce
 * Domain Path:             /languages
 */

namespace WCSFWC;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define('WCSFWC_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('WCSFWC_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));

require_once WCSFWC_PLUGIN_DIR_PATH . 'src/Settings.php';
require_once WCSFWC_PLUGIN_DIR_PATH . 'src/Values.php';
require_once WCSFWC_PLUGIN_DIR_PATH . 'src/Utils.php';
require_once WCSFWC_PLUGIN_DIR_PATH . 'src/Fields.php';

class WashCareSymbolsForWooCommerce {
	/** @var array|mixed|void $values */
	public $values;

	/** @var \WCSFWC\WashCareSymbolsForWooCommerce $instance */
	private static $instance;

	final public static function get_instance(): WashCareSymbolsForWooCommerce {
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

    public function init() {
	    add_action( 'init', [ $this, 'load_plugin_textdomain' ] );
	    add_action( 'admin_menu', [ Settings::class, 'add_settings_page' ] );
	    add_action( 'admin_init', [ Settings::class, 'register_settings' ] );
	    add_action( 'wcsfw_display', [ $this, 'display' ] );
	    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
	    add_filter( 'woocommerce_product_tabs', [ $this, 'force_tab_to_display' ], 98 );
	    add_filter( 'woocommerce_product_data_tabs', [ $this, 'wash_care_tab' ], 10, 1 );
	    add_action( 'woocommerce_product_data_panels', [ $this, 'wash_care_tab_content' ] );
	    add_action( 'woocommerce_process_product_meta', [ Fields::class, 'save' ] );
	    add_action( 'product_cat_add_form_fields', [ Fields::class, 'product_cat_add_form' ], 10 );
	    add_action( 'product_cat_edit_form_fields', [ Fields::class, 'product_cat_edit_form' ], 10, 2 );
	    add_action( 'created_product_cat', [ Fields::class, 'save_term' ] );
	    add_action( 'edited_product_cat', [ Fields::class, 'save_term' ] );
	    add_shortcode( 'wcsfwc', [ $this, 'shortcode_content' ] );
	    do_action( 'wcsfw_display' );
    }

	public function __construct() {
		/**
		 * Multidimensional array with all the choices, labels, and all necessary information for the fields
		 */
		$this->values = Values::get();
	}

	/**
	 * Loads plugin's translated strings.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wash-care-symbols-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'wcsfw-microtip', WCSFWC_PLUGIN_DIR_URL . 'assets/css/vendor/microtip.css' );
		wp_enqueue_style( 'wcsfw-main', WCSFWC_PLUGIN_DIR_URL . 'assets/css/wcsfw.css' );
		$css = ".wcsfw-symbol-img,.woocommerce img.wcsfw-symbol-img,.woocommerce-page img.wcsfw-symbol-img {";
		$css .= "height: " . Settings::get_icon_size_setting() . "px;";
		$css .= "}";
        wp_add_inline_style( 'wcsfw-main', $css);
	}

	public function enqueue_admin_scripts($hook) {
        if( Utils::is_product_edit_page( $hook ) || Utils::is_product_cat_edit_page( $hook ) ) {

	        // Loads a modified copy of select2.js in order to add symbols in dropdowns and selected options,
	        // which is not possible with selectWoo since v1.07
	        // See https://github.com/woocommerce/selectWoo/issues/39
	        wp_enqueue_script( 'select-wcsfw', WCSFWC_PLUGIN_DIR_URL . 'assets/js/vendor/select2-wcsfw.js', [ 'jquery' ] );
	        wp_enqueue_script( 'wcsfw-admin-script', WCSFWC_PLUGIN_DIR_URL . 'assets/js/admin.js', [
		        'selectWoo',
		        'select-wcsfw'
	        ] );
	        wp_localize_script( 'wcsfw-admin-script', 'symbols_dir', [ WCSFWC_PLUGIN_DIR_URL . 'symbols/' ] );

	        $page_type = Utils::is_product_cat_edit_page( $hook ) ? 'product_cat_edit' : 'product_edit';
            wp_localize_script( 'wcsfw-admin-script', 'wcsfw_page_type', [ $page_type ] );
        }
	}

	public function shortcode_content($atts){
		extract(shortcode_atts([ 'product' => null, 'layout' => null ], $atts));

		$values         = $this->values;
		$layout         = ( empty($layout) ) ? Settings::get_layout_setting() : sanitize_text_field($layout);
		$product_values = ( empty($product) || is_nan($product) ) ? $this->get_product_values() : $this->get_product_values((int) $product);

		if( !$product_values ) {return;}
		if(!is_file(WCSFWC_PLUGIN_DIR_PATH . 'templates/'. $layout .'.php')){return;}

		include WCSFWC_PLUGIN_DIR_PATH . 'templates/'. $layout .'.php';
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
			<?php Fields::get(); ?>
        </div>
		<?php
	}

	public function display() {
		$position = Settings::get_position_setting();

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
	 * @param array    $tabs
	 *
	 * @return array
	 *
	 * @since 3.1.0
	 */
	public function add_custom_tab( array $tabs ): array {
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
		$layout         = Settings::get_layout_setting();
		$values         = $this->values;
		$product_values = $this->get_product_values();

		if( !$product_values ) {return;}

		if( $layout === 'minimal' ) {
			include WCSFWC_PLUGIN_DIR_PATH . 'templates/minimal.php';
		} elseif( $layout === 'vertical' ) {
			include WCSFWC_PLUGIN_DIR_PATH . 'templates/vertical.php';
		} else {
			include WCSFWC_PLUGIN_DIR_PATH . 'templates/horizontal.php';
		}
	}

	/**
	 * Display our icons below product short description
	 */
	public function below_short_desc_display() {
		$product_values = $this->get_product_values();
		$values = $this->values;
        if ($product_values) {
	        include WCSFWC_PLUGIN_DIR_PATH . 'templates/below-short-desc.php';
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

	/**
	 * Get product values or product category values if empty
	 *
	 * @param int|null    $product
	 *
	 * @return array|false
	 */
	public function get_product_values( int $product = null) {
		if( empty($product) ) {$product = get_the_ID();}
        $product_obj = wc_get_product($product);
		$values = [];
		foreach ( $this->values as $fieldkey => $field ) {
            $option = $product_obj->get_meta('_' . $fieldkey);
            if($option){
			    $values[$fieldkey] = $product_obj->get_meta('_' . $fieldkey);
            }
		}
        if( !empty($values) ){
	        return $values;
        }
        // get product category values if empty
        else {
            $product_cat_ids = wc_get_product_term_ids($product, 'product_cat');
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

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );