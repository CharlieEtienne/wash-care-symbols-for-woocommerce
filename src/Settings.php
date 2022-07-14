<?php

namespace WCSFWC;

class Settings{
	public static function add_settings_page() {
		add_options_page( 'Wash Care Symbols for WooCommerce', 'Wash Care Symbols for WooCommerce', 'manage_options', 'wash-care-symbols-for-woocommerce', [
			self::class,
			'render_plugin_settings_page'
		] );
	}

	public static function render_plugin_settings_page() {
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

	public static function register_settings() {
		register_setting( 'wcsfw_options', 'wcsfw_options', 'wcsfw_options_validate' );
		add_settings_section( 'settings', __( 'Wash Care Symbols for WooCommerce Settings', 'wash-care-symbols-for-woocommerce' ), [ self::class, 'section_settings' ], 'wcsfw' );
		add_settings_field(
			'setting_position',
			__( 'Choose position', 'wash-care-symbols-for-woocommerce' ),
			[
				self::class,
				'setting_position'
			],
			'wcsfw',
			'settings'
		);
		add_settings_field(
			'setting_layout',
			__( 'Choose layout (only for default position)', 'wash-care-symbols-for-woocommerce' ),
			[
				self::class,
				'setting_layout'
			],
			'wcsfw',
			'settings'
		);
		add_settings_field(
			'setting_icon_size',
			__( 'Choose icons size', 'wash-care-symbols-for-woocommerce' ),
			[
				self::class,
				'setting_icon_size'
			],
			'wcsfw',
			'settings'
		);
	}

	public static function section_settings(): bool {
		return true;
	}

	public static function setting_layout() {
		$layout = self::get_layout_setting();
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

	public static function setting_position() {
		$position = self::get_position_setting();
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

	public static function setting_icon_size() {
		$icon_size = self::get_icon_size_setting();
		?>
		<label for="icon_size">
			<input type="number" name="wcsfw_options[icon_size]" id="icon_size" value="<?php echo $icon_size ?>" style="width: 70px" >&nbsp;px
		</label>
		<?php
	}

	public static function get_layout_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'layout' ] ) ) {
			return 'horizontal';
		}

		return $options[ 'layout' ];
	}

	public static function get_position_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'position' ] ) ) {
			return 'standard';
		}

		return $options[ 'position' ];
	}

	public static function get_icon_size_setting() {
		$options = get_option( 'wcsfw_options' );
		if ( empty( $options ) || empty( $options[ 'icon_size' ] ) ) {
			return '38';
		}

		return $options[ 'icon_size' ];
	}
}