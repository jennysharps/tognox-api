<?php
/**
 * Extend Recent Posts Widget
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

Class Custom_Recent_Projects_Widget extends WP_Widget {

        public $tweets, $twitterUsername;

	public function __construct() {
		parent::__construct(
			strtolower( __CLASS__ ),
			str_replace( '_', ' ', __CLASS__ ),
			array( 'description' => __( 'The most recent projects on your site' ), )
		);
	}

function widget($args, $instance) {
		$cache = wp_cache_get('widget_recent_posts', 'widget');

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

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Projects') : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 3;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

                $query_args = array(
                    'posts_per_page' => $number,
                    'post_type' => 'main_projects'
                );

                query_posts( $query_args );

                echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul>
		<?php while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>">
                                    <?php echo get_the_post_thumbnail( get_the_ID(), 'three-col' ); ?>
                                    <div class="ribbon">
                                        <h4><?php if ( get_the_title() ) the_title(); else the_ID(); ?></h4>
                                        <span class="ribbon-tail"></span>
                                    </div>
                                </a>
			</li>
		<?php endwhile; ?>
		</ul>

                <?php
                echo $after_widget;

		wp_reset_query();
                wp_reset_postdata();

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_recent_posts', $cache, 'widget');
	}


 	public function form( $instance ) {
                $title = isset( $instance[ 'title' ] ) ? $instance['title'] : '';
                $number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;
                $display = isset( $instance['display'] ) ? $instance['display'] : 'list';
                $display_opts = array( 'list', 'slides' );

		?>
		<p>
                    <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Projects to show:' ); ?></label>
                    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
                </p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                $instance['number'] = ( !empty( $new_instance['number'] ) ) ? intval( $new_instance['number'] ) : '3';
                $instance['display'] = ( !empty( $new_instance['display'] ) ) ? $new_instance['display'] : 'list';

		return $instance;
	}

}


add_action( 'widgets_init', function(){
     register_widget( 'Custom_Recent_Projects_Widget' );
});