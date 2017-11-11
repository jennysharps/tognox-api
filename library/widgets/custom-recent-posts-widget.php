<?php
/**
 * Extend Recent Posts Widget
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */

Class Custom_Recent_Posts_Widget extends WP_Widget_Recent_Posts {

	function widget($args, $instance) {

		extract( $args );

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);

		if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
			$number = 5;

                $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

                $args = array(
                    'posts_per_page' => $number,
                    'post_type' => 'post'
                );

                query_posts( $args );

                echo $before_widget;
                if( $title ) echo $before_title . $title . $after_title;
                ?>

                <ul>
                        <?php while ( have_posts() ) : the_post(); ?>
                        <li>
                            <?php if( $show_date ) { ?>
                                <span class="post-meta-date"><?php the_time( 'j' ); ?><span class="post-meta-month"><?php the_time( 'M' ); ?></span></span>
                            <?php } else { ?>
                                <div class="thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="Read <?php the_title(); ?>"><?php echo get_the_post_thumbnail(); ?></a>
                                </div>
                            <?php } ?>
                            <a href="<?php the_permalink(); ?>" title="Read <?php the_title(); ?>"><h4><?php the_title(); ?></h4></a>
                        </li>
                        <?php endwhile; ?>
                </ul>

                <?php
                echo $after_widget;

                wp_reset_query();
                wp_reset_postdata();
	}
}

function custom_widget_registration() {
    unregister_widget('WP_Widget_Recent_Posts');
    register_widget('Custom_Recent_Posts_Widget');
}
add_action('widgets_init', 'custom_widget_registration');