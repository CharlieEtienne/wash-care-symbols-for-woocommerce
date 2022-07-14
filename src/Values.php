<?php

namespace WCSFWC;

class Values{
	/**
	 * Multidimensional array with all the choices, labels, and all necessary information for the fields
	 *
	 * @return array[]
	 */
	public static function get(): array {
		$values = [
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

		return apply_filters( 'wcsfw-data', $values );
	}
}