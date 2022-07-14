<?php

/** @var array $product_values */
/** @var array|mixed|void $values */
/** @var string $layout */

?>
<table class="wcsfw <?= $layout ?>">
	<tbody>
	<tr>
		<th class="wcsfw-title"><?= __('Wash / Care', 'wash-care-symbols-for-woocommerce') ?></th>
		<td class="wcsfw-symbols-container">
			<?php foreach( $product_values as $fieldkey => $options ) : ?>
				<?php foreach( $options as $option ) : ?>
					<button aria-label="<?= __($values[ $fieldkey ][ 'choices' ][ $option ], 'wash-care-symbols-for-woocommerce') ?>"
					        data-microtip-size="medium" data-microtip-position="top"
					        role="tooltip" class="wcsfw-symbol-btn">
						<img class="wcsfw-symbol-img"
						     src="<?= WCSFWC_PLUGIN_DIR_URL . 'symbols/' . $option . '.png' ?>">
					</button>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</td>
	</tr>
	</tbody>
</table>