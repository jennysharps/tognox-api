<?php
/**
 * Certifications Widget
 *
 * Adds certification icons list
 */

Class Custom_Certifications_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			strtolower( __CLASS__ ),
			'Certifications List',
			array( 'description' => __( 'Certification icons' ), )
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'init', array ( $this, 'init' ) );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_certifications', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Certifications') : $instance['title'], $instance, $this->id_base);
		$link_text = !empty($instance['link_text']) ? $instance['link_text'] : '';
		$link_page = !empty($instance['link_page']) ? $instance['link_page'] : '';
		$link_href = $link_page ? get_permalink($link_page) : '';

		echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<?php if ( $instance && is_array( $instance['images'] ) ) {?>
			<ul class="certification-container">
				<?php foreach ($instance['images'] as $image_id) { ?>
					<?php $img_src = wp_get_attachment_image_src($image_id, 'cert-logo')[0]; ?>
					<div class="certification-logo-container">
						<image class="certification-logo" src="<?php echo $img_src; ?>" />
					</div> <?php
				} ?>
			</ul><?php
			if ($link_page && $link_href) { ?>
				<div class="certification-logo-link-container">
					<a href="<?php echo $link_href; ?>"><?php echo $link_text; ?></a>
				</div><?php
			}
		}
		echo $after_widget;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_certifications', $cache, 'widget');
	}

	public function enqueue_scripts( $instance ) {
		wp_enqueue_style( 'custom-certifications-widget', get_template_directory_uri() . '/library/widgets/css/custom-certifications-widget.css' );
	}

	public function admin_enqueue_scripts( $instance ) {
		wp_enqueue_style( 'custom-certifications-widget', get_template_directory_uri() . '/library/widgets/css/custom-certifications-widget-admin.css' );
		wp_enqueue_script( 'custom-certifications-widget', get_template_directory_uri() . '/library/widgets/js/custom-certifications-widget-admin.js', array( 'jquery' ) );
	}

	private function get_image_selection_template( $cert_images, $selected_image_id = '' ) {
		$output = '<div class="certification-select-container">';
		$output .= '<select name="' . $this->get_field_name( 'images' ) . '[]">';
		$output .= '<option selected disabled value="">Choose Image</option>';
		
		while( $cert_images->have_posts() ) {
			$cert_images->the_post();
			$id = get_the_ID();
			$output .= '<option value="' . $id . '" ' . selected( $selected_image_id, $id, false ) . '>' . get_the_title() . '</option>';
		}

		$output .= '</select>';
		$output .= '<a class="button certification-delete-button">x</a>';
		$output .= '</div>';

		return $output;
	}

	public function form( $instance ) {
		$instance = wp_parse_args((array) $instance, array('title' => '', 'images' => array('')));
      	$title =  isset($instance[ 'title' ]) ? $instance['title'] : '';
      	$images = isset($instance['images']) ? $instance['images'] : array('');
		$cert_images = new WP_Query( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image' , 'posts_per_page' => -1, 'tag' => 'cert' ) );
		$link_text = isset($instance[ 'link_text' ]) ? $instance['link_text'] : '';
		$link_page = isset($instance[ 'link_page' ]) ? $instance['link_page'] : '';
		?>

		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<hr />

		<div>
			<h4>Logos</h4>
			<?php $template = $this->get_image_selection_template( $cert_images ); ?>

			<script class="certificationItemTemplate" type="text/html">
				<?php echo $template; ?>
			</script><?php
			if ( count( $images ) ) { ?>
				<div class="certification-logos-container"><?php
					foreach( $images as $key => $current_image ) {
						if( $cert_images->have_posts() ) {
							echo $this->get_image_selection_template( $cert_images, $current_image );
						} else {
						    echo 'There are no images tagged "cert" in the media library. Click <a href="' . admin_url('/media-new.php') . '" title="Add Images">here</a> to add some images';
						}
					} ?>
				</div><?php
			} else {
				echo $template;
			}?>
			<a class="button certification-add-button">Add Logo</a>
		</div>

		<hr />

		<div>
			<h4>Link (Optional)</h4>
			<p>
				<label for="<?php echo $this->get_field_name( 'link_text' ); ?>"><?php _e( 'Text:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_text' ); ?>" name="<?php echo $this->get_field_name( 'link_text' ); ?>" type="text" value="<?php echo esc_attr( $link_text ); ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_name( 'link_page' ); ?>"><?php _e( 'Page ID:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'link_page' ); ?>" name="<?php echo $this->get_field_name( 'link_page' ); ?>" type="text" value="<?php echo esc_attr( $link_page ); ?>" />
			</p>
		</div><?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['images'] = $new_instance['images'];
		$instance['link_text'] = ( !empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';
		$instance['link_page'] = ( !empty( $new_instance['link_page'] ) ) ? strip_tags( $new_instance['link_page'] ) : '';
		return $instance;
	}

	public function init() {
		add_image_size( 'cert-logo', 9999, 100 );
	}
}


add_action( 'widgets_init', function(){
	 register_widget( 'Custom_Certifications_Widget' );
});