<?php

class GCSEW_Widget extends WP_Widget {
	protected $default_title;

	public function __construct() {
		parent::__construct(
			'gcsew_widget',
			'Google Custom Search',
			array(
				'description' => 'Let your visitors search your site using your Google Custom Search',
			)
		);

		$this->default_title = 'Search';
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$results_url = ! empty( $instance['results_url'] ) ? esc_url( $instance['results_url'] ) : '';

		echo $args['before_widget'];

		echo $args['before_title'] . $title . $args['after_title'];

		echo gcsew_script_base( $instance['cse_id'] );

		$searchbox_atts = array();
		if ( $results_url ) {
			$searchbox_atts['resultsUrl'] = $results_url;
		}

		$searchbox_atts_string = '';
		foreach ( $searchbox_atts as $sba_k => $sba_v ) {
			$searchbox_atts_string .= ' ' . $sba_k . '="' . $sba_v . '"';
		}

		echo '<gcse:searchbox-only' . $searchbox_atts_string . '></gcse:searchbox-only>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : $this->default_title;
		$cse_id = isset( $instance['cse_id'] ) ? $instance['cse_id'] : '';
		$results_url = isset( $instance['results_url'] ) ? $instance['results_url'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" type="text" value="<?php echo esc_attr( $title ) ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'cse_id' ) ?>"><?php _e( 'Search Engine ID:' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'cse_id' ) ?>" name="<?php echo $this->get_field_name( 'cse_id' ) ?>" type="text" value="<?php echo esc_attr( $cse_id ) ?>" />
			<p class="description">From your Custom Search screen, find the "Search engine ID" button to get this value.</p>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'results_url' ) ?>"><?php _e( 'Results URL:' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'results_url' ) ?>" name="<?php echo $this->get_field_name( 'results_url' ) ?>" type="text" value="<?php echo esc_attr( $results_url ) ?>" />
			<p class="description">URL of the page where you want results shown. Make sure that page has the [gcsew-results] shortcode. Defaults to the Google-hosted results page.</p>
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : $this->default_title;
		$instance['cse_id'] = ! empty( $new_instance['cse_id'] ) ? strip_tags( $new_instance['cse_id'] ) : '';
		$instance['results_url'] = ! empty( $new_instance['results_url'] ) ? strip_tags( $new_instance['results_url'] ) : '';

		// Hack - we stash this in options for use outside widget
		// don't try to use more than one CSE id ;)
		update_option( 'gcsew_cse_id', $instance['cse_id'] );
		update_option( 'gcsew_results_url', $instance['results_url'] );

		return $instance;
	}
}

function gcsew_widget_init() {
	register_widget( 'GCSEW_Widget' );
}
add_action( 'widgets_init', 'gcsew_widget_init' );
