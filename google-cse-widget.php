<?php
/*
Plugin Name: Google CSE Widget
Version: 1.0
Description: Put the Google CSE search box in a widget, display results with a shortcode
Author: Boone B Gorges
Author URI: http://boone.gorg.es
*/

function gcsew_init() {
	include( __DIR__ . '/includes/widget.php' );
	include( __DIR__ . '/includes/shortcode.php' );
}
add_action( 'plugins_loaded', 'gcsew_init' );

function gcsew_script_base( $cse_id ) {
	static $run;

	if ( ! empty( $run ) ) {
		return;
	}

	?>
<script>
  (function() {
    var cx = '<?php echo esc_attr( $cse_id ) ?>';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
	<?php

	$run = 1;
}
