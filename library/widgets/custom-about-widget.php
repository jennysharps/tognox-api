<?php
/**
 * Widget to show resume links from about page
 */

Class Custom_About_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            strtolower( __CLASS__ ),
            str_replace( '_', ' ', __CLASS__ ),
            array( 'description' => __( 'Display resume links from an "About" page' ), )
        );
    }

	function widget($args, $instance) {

		extract( $args );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $page_id = empty($instance['page_id']) ? '' : $instance['page_id'];

        $meta = get_post_meta($page_id);
        $file_one_url = wp_get_attachment_url( $meta['file_1'][0]);
        $file_one_text = $meta['file_1_name'][0];
        $file_two_url = wp_get_attachment_url( $meta['file_2'][0]);
        $file_two_text = $meta['file_2_name'][0];

        ?>

        <?php echo $before_widget; ?>

        <?php if( $title ) echo $before_title . $title . $after_title; ?>

        <section class="entry-content">
            <div class="resume-section">
            <?php if( $file_one_url ) { ?>
                <a target="_blank" class="icon icon-large resume" href="<?php echo $file_one_url; ?>">
                    <div class="ribbon">
                        <h4><?php echo $file_one_text; ?></h4>
                    </div>
                </a>
            <?php } ?>
            
            <?php if( $file_two_url ) { ?>
                <a target="_blank" class="icon icon-large cv" href="<?php echo $file_two_url; ?>">
                    <div class="ribbon">
                        <h4><?php echo $file_two_text; ?></h4>
                    </div>
                </a>
            <?php } ?>
        </div>

        <?php echo $after_widget;
	}

    public function form( $instance ) {
        $title = isset( $instance[ 'title' ] ) ? $instance['title'] : '';
        $current_page_id = isset( $instance['page_id'] ) ? $instance['page_id'] : '';
        $about_pages = get_posts(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => 'page-template-about.php'
        ));
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <?php
                $count = count($about_pages);
                if($count > 0) {
                    ?>
                    <?php if($count === 1)  { ?>
                        <input type="hidden" id="<?php echo $this->get_field_id( 'page_id' ); ?>" name="<?php echo $this->get_field_name( 'page_id' ); ?>" value="<?php echo $about_pages[0]->ID; ?>">
                    <?php } else { ?>
                        <label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'About Page:' ); ?></label>
                    
                        <select id="<?php echo $this->get_field_id( 'page_id' ); ?>" name="<?php echo $this->get_field_name( 'page_id' ); ?>">
                            <?php
                            foreach( $about_pages as $about_page_item ) {
                                $selected = $current_page_id === $about_page_item->ID ? ' selected="selected"' : ''; ?>
                                <option <?php echo $selected; ?>value="<?php echo $about_page_item->ID; ?>"><?php echo $about_page_item->post_title ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?> 
                <?php } ?>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['page_id'] = ( !empty( $new_instance['page_id'] ) ) ? intval( $new_instance['page_id'] ) : '';

        return $instance;
    }
}

function custom_about_widget_registration() {
    register_widget('Custom_About_Widget');
}
add_action('widgets_init', 'custom_about_widget_registration');