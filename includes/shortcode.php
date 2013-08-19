<?php

function gcsew_results_cb( $atts ) {
	$cse_id = get_option( 'gcsew_cse_id' );

	gcsew_script_base( $cse_id );

	echo '<gcse:searchresults-only></gcse:searchresults-only>';
}
add_shortcode( 'gcsew-results', 'gcsew_results_cb' );
