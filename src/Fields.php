<?php

namespace WCSFWC;

class Fields {
	/**
	 * Called when we save the post
	 *
	 * @param $post_id
	 */
	public static function save( $post_id ) {
        $product = wc_get_product( $post_id );

		foreach ( Values::get() as $fieldkey => $field ) {
			if ( isset( $_POST[ '_' . $fieldkey ] ) && is_array( $_POST[ '_' . $fieldkey ] ) ) {
				$clean_values = [];
				foreach ( $_POST[ '_' . $fieldkey ] as $item ) {
					$clean_values[] = sanitize_key( $item );
				}
                $product->update_meta_data('_' . $fieldkey, $clean_values ?? null);
            } else {
                $product->delete_meta_data( '_' . $fieldkey );
            }
            $product->save();
        }
	}

	/**
	 * Return all multiselect fields
	 */
	public static function get() {
		$values = self::get_formatted_values();
		foreach ( $values as $field ) {
			Utils::multiple_select($field);
		}
	}

	/**
	 * Get formatted values
	 *
	 * @return array
	 */
	public static function get_formatted_values(): array {
		$formatted = [];
		foreach ( Values::get() as $fieldkey => $field ) {
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

	public static function product_cat_add_form() {
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
		foreach ( self::get_formatted_values() as $field ) {
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

	public static function product_cat_edit_form( $term, $taxonomy ) {
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
		foreach ( self::get_formatted_values() as $field ) {
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

	public static function save_term( $term_id ) {
		update_term_meta(
			$term_id,
			'wcsfw_use_at_cat_level',
			sanitize_key( $_POST[ 'wcsfw_use_at_cat_level' ] )
		);

		foreach ( Values::get() as $fieldkey => $field ) {
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
}