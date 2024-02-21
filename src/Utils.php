<?php

namespace WCSFWC;

class Utils {
	/**
	 * Add ability to use mutiselect selectWoo field
	 *
	 * @param $field
	 */
	public static function multiple_select( $field ) {
		global $thepostid, $post;

        $thepostid                = empty( $thepostid ) ? $post->ID : $thepostid;
        $product                  = wc_get_product( $thepostid );
        $field[ 'class' ]         = $field[ 'class' ] ?? 'select short';
		$field[ 'wrapper_class' ] = $field[ 'wrapper_class' ] ?? '';
		$field[ 'name' ]          = $field[ 'name' ] ?? $field[ 'id' ];
		if (self::is_product_category()){
			$term_id = absint( $_GET['tag_ID'] );
			$field[ 'value' ] = $field[ 'value' ] ?? ( get_term_meta( $term_id, '_' . $field[ 'id' ], true ) ? get_term_meta( $term_id, '_' . $field[ 'id' ], true ) : array() );
		}
		else {
            $product_meta = $product->get_meta('_' . $field['id']);
            $field[ 'value' ] = $field[ 'value' ] ?? ( $product_meta ? $product_meta : array() );
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

	public static function is_product_category(): bool {
		global $taxnow;
		return isset(get_current_screen()->base)
		       && get_current_screen()->base === 'term'
		       && isset($taxnow)
		       && $taxnow === 'product_cat';
	}

	/**
	 * @param $hook
	 *
	 * @return bool
	 */
	public static function is_product_edit_page( $hook ): bool {
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
	public static function is_product_cat_edit_page( $hook ): bool {
		if (!isset( $hook ) || empty( get_current_screen()->taxonomy )){
			return false;
		}
		return ('term.php' === $hook || 'edit-tags.php' === $hook) && get_current_screen()->taxonomy === 'product_cat';
	}
}