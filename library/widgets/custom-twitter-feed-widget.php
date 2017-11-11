<?php
/**
 * Output customizable feed of recent tweets in slides or list format
 *
 * Depends on https://github.com/stormuk/storm-twitter-for-wordpress
 */

class Custom_Twitter_Feed_Widget extends WP_Widget {

        public $tweets, $twitterUsername;

	public function __construct() {
		parent::__construct(
			strtolower( __CLASS__ ),
			str_replace( '_', ' ', __CLASS__ ),
			array( 'description' => __( 'Display a feed of latest tweets' ), )
		);
	}

        public function widget( $args, $instance ) {

             extract( $args );
             $title = apply_filters( 'widget_title', empty( $instance['title'] ) ?  '' : $instance['title'], $instance, $this->id_base );

             if ( empty( $instance['number'] ) || !$number = absint( $instance['number'] ) )
                 $number = 3;

             $this->tweets = getTweets( $number );

             $theme_options = get_option('theme_options');
             $this->twitterUsername = $theme_options['twitter_username'];
             $this->twitterUsername = $this->twitterUsername ? $this->twitterUsername : 'YOURUSERNAME';

             if ( is_array( $this->tweets ) ) {

                if( strpos($before_widget, 'class') === false ) {
                    $before_widget = str_replace('>', 'class="'. $instance['display'] . '-display"', $before_widget);
                }
                // there is 'class' attribute - append width value to it
                else {
                    $before_widget = str_replace('class="', 'class="'. $instance['display'] . '-display ', $before_widget);
                }

                echo $before_widget;

                if( $title ) {
                    echo $before_title . '<i class="fa-icon fa-icon-twitter"></i>' . $title . $after_title;
                }

                $this->enqueue_scripts( $instance );

                ?>

                <ul class="<?php echo $instance['display']; ?>">
                 <?php foreach ( $this->tweets as $tweet ) { ?>

                    <li>
                    <?php if ( $tweet['text'] ) {
                         $the_tweet = $tweet['text'];
                         /*
                           Twitter Developer Display Requirements
                           https://dev.twitter.com/terms/display-requirements

                           2.b. Tweet Entities within the Tweet text must be properly linked to their appropriate home on Twitter. For example:
                           i. User_mentions must link to the mentioned user's profile.
                           ii. Hashtags must link to a twitter.com search with the hashtag as the query.
                           iii. Links in Tweet text must be displayed using the display_url
                           field in the URL entities API response, and link to the original t.co url field.
                          */

                         // i. User_mentions must link to the mentioned user's profile.
                         if ( is_array( $tweet['entities']['user_mentions'] ) ) {
                             foreach ( $tweet['entities']['user_mentions'] as $key => $user_mention ) {
                                 $the_tweet = preg_replace(
                                         '/@' . $user_mention['screen_name'] . '/i', '<a class="user-mention" href="http://www.twitter.com/' . $user_mention['screen_name'] . '" target="_blank">@' . $user_mention['screen_name'] . '</a>', $the_tweet );
                             }
                         }

                         // ii. Hashtags must link to a twitter.com search with the hashtag as the query.
                         if ( is_array( $tweet['entities']['hashtags'] ) ) {
                             foreach ( $tweet['entities']['hashtags'] as $key => $hashtag ) {
                                 $the_tweet = preg_replace(
                                         '/#' . $hashtag['text'] . '/i', '<a class="hashtag" href="https://twitter.com/search?q=%23' . $hashtag['text'] . '&src=hash" target="_blank">#' . $hashtag['text'] . '</a>', $the_tweet );
                             }
                         }

                         // iii. Links in Tweet text must be displayed using the display_url
                         //      field in the URL entities API response, and link to the original t.co url field.
                         if ( is_array( $tweet['entities']['urls'] ) ) {
                             foreach ( $tweet['entities']['urls'] as $key => $link ) {
                                 $the_tweet = preg_replace(
                                         '`' . $link['url'] . '`', '<a class="link-url" href="' . $link['url'] . '" target="_blank">' . $link['url'] . '</a>', $the_tweet );
                             }
                         }

                         echo $the_tweet;


                         echo '<div class="tweet-meta">';
                         // 3. Tweet Actions
                         //    Reply, Retweet, and Favorite action icons must always be visible for the user to interact with the Tweet. These actions must be implemented using Web Intents or with the authenticated Twitter API.
                         //    No other social or 3rd party actions similar to Follow, Reply, Retweet and Favorite may be attached to a Tweet.
                         // get the sprite or images from twitter's developers resource and update your stylesheet
                         echo '
                        <div class="twitter-intents">
                            <a class="reply fa-icon fa-icon-reply" href="https://twitter.com/intent/tweet?in_reply_to=' . $tweet['id_str'] . '" title="Reply">Reply</a>
                            <a class="retweet fa-icon fa-icon-retweet" href="https://twitter.com/intent/retweet?tweet_id=' . $tweet['id_str'] . '" title="Retweet">Retweet</a>
                            <a class="favorite fa-icon fa-icon-small fa-icon-star" href="https://twitter.com/intent/favorite?tweet_id=' . $tweet['id_str'] . '" title="Favorite">Favorite</a>
                        </div>';


                         // 4. Tweet Timestamp
                         //    The Tweet timestamp must always be visible and include the time and date. e.g., “3:00 PM - 31 May 12”.
                         // 5. Tweet Permalink
                         //    The Tweet timestamp must always be linked to the Tweet permalink.
                         echo '
             <p class="timestamp">
                 <a href="https://twitter.com/' . $this->twitterUsername . '/status/' . $tweet['id_str'] . '" target="_blank">
                     ' . date( 'h:i A M d', strtotime( $tweet['created_at'] . '- 8 hours' ) ) . '
                 </a>
             </p>'; // -8 GMT for Pacific Standard Time

             echo '</div>';
             
                     } else {
                         echo '
             <br /><br />
             <a href="http://twitter.com/' . $this->twitterUsername . '" target="_blank">Click here to read ' . $this->twitterUsername . '\'S Twitter feed</a>';
                     }
                     ?>
                    </li>
                    <?php
                 }
                 ?>

                </ul>

                 <?php
                 echo $after_widget;
             }
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
                    <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Tweets to show:' ); ?></label>
                    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display Type:' ); ?></label>
                    <select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>">
                        <?php
                        foreach( $display_opts as $display_opt_val ) {
                        $selected = $display == $display_opt_val ? ' selected="selected"' : '';
                        ?>
                        <option <?php echo $selected; ?>value="<?php echo $display_opt_val; ?>"><?php echo ucfirst( $display_opt_val ); ?></option>
                        <?php } ?>
                    </select>
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

        public function enqueue_scripts( $instance ) {
                if( $instance['display'] == 'slides' ) {
                    wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/library/js/libs/jquery.flexslides.js', array( 'jquery' ) );
                    wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/library/css/flexslides.css' );
                    wp_enqueue_script( 'custom-twitter-widget', get_template_directory_uri() . '/library/widgets/js/custom-twitter-feed-widget.js', array( 'flexslider', 'jquery' ) );
                }

                wp_enqueue_script( 'twitter-widgets', '//platform.twitter.com/widgets.js' );

                return;
        }
}

add_action( 'widgets_init', function(){
     register_widget( 'Custom_Twitter_Feed_Widget' );
});