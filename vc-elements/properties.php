<?php
/*
Element Description: Property Listing
*/

// Element Class
class Inspry_VC_Lead extends WPBakeryShortCode {

	// Element Init
	function __construct() {
		add_action( 'init', array( $this, 'element_mapping' ) );
		add_shortcode( 'inspry_properties', array( $this, 'element_output' ) );
	}

	// Element Mapping
	public function element_mapping() {

		// Stop all if VC is not enabled
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		// Map the block with vc_map()
		vc_map(

			array(
				'name'        => esc_html__( 'Properties', 'inspiry-real-estate' ),
				'base'        => 'inspry_properties',
				'description' => esc_html__( 'Display property listing.', 'inspiry-real-estate' ),
				'category'    => esc_html__( 'Real Places Theme', 'inspiry-real-estate' ),
				'params'      => array(

					array(
						'type'       => 'textarea',
						'holder'     => 'p',
						'class'      => 'heading',
						'heading'    => esc_html__( 'Text To Test', 'inspiry-real-estate' ),
						'param_name' => 'param_key',
					)
				)
			)
		);
	}

	// Element HTML
	public function element_output( $attr ) {

		// Params extraction
		extract(
			shortcode_atts(
				array(
					'param_key' => '',
				),
				$attr
			)
		);

		ob_start();

		if ( ! empty( $param_key ) ) {
			?>
			<p><?php echo $param_key; ?></p>
			<?php
		}

		return ob_get_clean();

	}

} // End Element Class

// Element Class Init
new Inspry_VC_Lead();