<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
    - head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
    - custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break
/*
2. library/custom-post-type.php
    - an example custom post type
    - example custom taxonomy (like categories)
    - example custom taxonomy (like tags)
*/
require_once('library/theme-options/theme-options.php');
require_once('library/multi-post-thumbnails.php');
require_once('library/custom-post-main-projects.php');
require_once('library/custom-post-resources.php');
require_once('library/post-type-archive-menu-links/post-type-archive-menu-links.php');
require_once('library/register-acf-fields.php');
require_once('library/citation-extensions.php');
require_once('library/widgets/custom-certifications-widget.php');
require_once('library/widgets/custom-recent-posts-widget.php');
require_once('library/widgets/custom-recent-projects-widget.php');
require_once('library/widgets/custom-twitter-feed-widget.php');
require_once('library/widgets/custom-about-widget.php');

/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'homepage-carousel', 1140, 400, true );
add_image_size( 'three-col', 720, 253, true );
add_image_size( 'wide-thumb', 340, 120, true );
add_image_size( '16x9', 445, 250, true );
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 300, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {

    register_sidebar( array(
            'id' => 'home_right',
            'name' => 'Home Right Sidebar',
            'description' => 'The right part of the homepage.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>',
    ) );

    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'General Sidebar',
    	'description' => 'The primary sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h2 class="widgettitle">',
    	'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'id' => 'sidebar_about',
        'name' => 'About Template Sidebar',
        'description' => 'The sidebar used when the "About" page template is chosen.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

    register_sidebar( array(
            'id' => 'footer_middle',
            'name' => 'Footer Middle',
            'description' => 'The center section of the footer.',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widgettitle">',
            'after_title' => '</h2>',
    ) );

    /*
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call
    your new sidebar just use the following code:

    Just change the name to whatever your new
    sidebar's id is, for example:

    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => 'Sidebar 2',
    	'description' => 'The second (secondary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));

    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php

    */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
			    <?php
			    /*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */
			    ?>
			    <!-- custom gravatar call -->
			    <?php
			    	// create variable
			    	$bgauthemail = get_comment_author_email();
			    ?>
			    <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
			    <!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="alert info">
          			<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </form>';
    return $form;
} // don't remove this bracket!

function home_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'home_page_menu_args' );


// Disable Admin Bar for everyone
if (!function_exists('df_disable_admin_bar')) {

	function df_disable_admin_bar() {

		// for the admin page
		remove_action('admin_footer', 'wp_admin_bar_render', 1000);
		// for the front-end
		remove_action('wp_footer', 'wp_admin_bar_render', 1000);

		// css override for the admin page
		function remove_admin_bar_style_backend() {
			echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
		}
		add_filter('admin_head','remove_admin_bar_style_backend');

		// css override for the frontend
		function remove_admin_bar_style_frontend() {
			echo '<style type="text/css" media="screen">
			html { margin-top: 0px !important; }
			* html body { margin-top: 0px !important; }
			</style>';
		}
		add_filter('wp_head','remove_admin_bar_style_frontend', 99);
  	}
}
// add_action('init','df_disable_admin_bar');


add_action( 'init', 'register_tognox_scripts' );
function register_tognox_scripts() {
    wp_register_style( 'flexslider', get_template_directory_uri() . '/library/css/flexslider.css' );
    wp_register_script( 'flexslider', get_template_directory_uri() . '/library/js/libs/jquery.flexslider.js', array( 'jquery' ) );
}


add_action( 'wp_enqueue_scripts', 'enqueue_tognox_scripts' );
function enqueue_tognox_scripts() {
    if( is_front_page() ) {
        wp_enqueue_style( 'flexslider' );
        wp_enqueue_script( 'flexslider' );
    }
}

add_action( 'admin_enqueue_scripts', 'enqueue_tognox_admin_scripts' );
function enqueue_tognox_admin_scripts() {
	wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/library/css/admin.css' );
	wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/library/js/admin.js', array( 'jquery' ) );
}

function custom_excerpt_length( $length ) {
	if( is_front_page() ) {
            return 30;
        }
        return $length;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


function custom_excerpt_more( $more ) {
        if( is_front_page() || is_post_type_archive( 'main_projects' ) ) {
            return '...';
        } else {
            return $more;
        }
}
add_filter( 'excerpt_more', 'custom_excerpt_more', 999 );

register_nav_menu( 'social_buttons_header', 'Social Buttons in Header' );
register_nav_menu( 'social_buttons_footer', 'Social Buttons in Footer' );


function social_header_scripts() { ?>

<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
          appId      : '382397598528811', // App ID
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          oauth      : true, // enable OAuth 2.0
          xfbml      : true  // parse XFBML
        });
    };

    (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>

<?php }
 add_action( 'wp_head', 'social_header_scripts' );

function add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );

function post_thumbnail_placeholder( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( empty( $html ) ) {
        $meta = get_post_meta(get_the_ID());
        if(isset($meta['resource_type'])) {
            $placeholder_url = null;

            switch($meta['resource_type'][0]) {
                case "gist":
                case "github":
                    $type = "code";
                    $placeholder_url = get_stylesheet_directory_uri() . '/library/images/placeholder-' . $type . '_' . $size . '.jpg';
                    break;
                case "video":
                    $type = "video";
                    $placeholder_url = "http://img.youtube.com/vi/{$meta['video-id'][0]}/mqdefault.jpg";
                    break;
                case "file":
                    $type = "poster";
                    $placeholder_url = get_stylesheet_directory_uri() . '/library/images/placeholder-' . $type . '_' . $size . '.jpg';
                    break;
            }
            return "<img src='{$placeholder_url}' rel='placeholder'/>";

        } else {
            return;
        }
    }
    return $html;
}
add_filter( 'post_thumbnail_html', 'post_thumbnail_placeholder', 20, 5 );

function tognox_embed_gist($atts) {
    $return = '';

    $atts = shortcode_atts(array(
        'id' => null,
        'filename' => 'remove-firefox-button-padding.css'
    ), $atts, 'gist');

    if(false && $atts['id'] != null) {
        $return .= "<script src='http://gist.github.com/{$atts['id']}.js'></script>";

        $result = get_gist_data($atts['id']);
        $json = json_decode($result['body'], true);

        echo 'https://api.github.com/gists/' . $atts['id'];
        //var_dump($json);

        if(false && isset($json['description'])) {
            $description = $json['description'];

            if($atts['filename']) {

                /*echo '<br>------------------<br>';
                var_dump($json['files'][$atts['filename']]['content']);
                echo '<br>------------------<br>';*/
                if(isset($json['files'][$atts['filename']])) {
                    $return .= '<h2>'.$description.'</h2>';
                    $return .= '<pre><code>';
                    $return .= $json['files'][$atts['filename']]['content'];
                    $return .= '</code></pre>';
                }
            } else {
                /*foreach($json['files'] as $key => $fileData) {
                    $content .= $fileData['content'];

                    $return .= '<h2>'.$description.'</h2>';
                    $return .= '<pre><code>';
                    $return .= $fileData[]['content']
                    $return .= '</code></pre>';
                }*/
            }
        }
    }

    return $return;
}
add_action( 'init', 'register_shortcodes', 99);
function register_shortcodes() {
    add_shortcode('gist', 'tognox_embed_gist');
}

function get_gist_data($gist_id) {
    $result = wp_remote_get('https://api.github.com/gists/' . $gist_id, array('sslverify' => false));
    return json_decode($result['body'], true);
}

function tognox_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'tognox_add_tags_to_attachments' );

function tognox_get_citations_data($citation_ids = []) {
    $citations = [];
    if(function_exists('get_citation')) {
        foreach($citation_ids as $citation_id) {
            $citations[] = [
                id => $citation_id,
                rendered => get_citation($citation_id)
            ];
        }
    }
    return $citations;
}

function tognox_get_yoast_title($post_id) {
    $yoast_title = get_post_meta($post_id, '_yoast_wpseo_title', true);
    $title = strstr($yoast_title, '%%', true);

    if (empty($title)) {
        $title = get_the_title($post_id);
    }

    $wpseo_titles = get_option('wpseo_titles');
    $sep_options = WPSEO_Option_Titles::get_instance()->get_separator_options();

    if (isset($wpseo_titles['separator']) && isset($sep_options[$wpseo_titles['separator']])) {
        $sep = $sep_options[$wpseo_titles['separator']];
    } else {
        $sep = '-'; //setting default separator if Admin didn't set it from backed
    }

    $site_title = get_bloginfo('name');
    $meta_title = $title . ' ' . $sep . ' ' . $site_title;

    return $meta_title;
}

function tognox_register_api_hooks() {
    // Add the plaintext content to GET requests for individual posts
    register_rest_field(
        'main_projects',
        'presentation',
        array(
            'get_callback' => function($post) {
                return isset($meta['presentation'][0]) ? unserialize($meta['presentation'][0]) : '';
            },
        )
    );

    register_rest_field(
        'main_projects',
        'citations',
        array(
            'get_callback' => function($post) {
                $meta = get_post_meta($post['id']);
                $related_citation_ids = isset($meta['related_citations']) ? unserialize($meta['related_citations'][0]) : [];
                return tognox_get_citations_data($related_citation_ids);
            },
        )
    );

    register_rest_field(
        'resources',
        'meta',
        array(
            'get_callback' => function($post) {
                $meta = get_post_meta($post['id']);
                $return_meta = [];

                switch ($meta['resource_type'][0]) {
                    case 'file': {
                        $return_meta['file_url'] = isset($meta['related-file'][0]) && $meta['related-file'][0]
                            ? wp_get_attachment_url($meta['related-file'][0])
                            : '';
                        $return_meta['button_text'] = $meta['button-text'][0] ? $meta['button-text'][0] : '';
                        break;
                    }
                    case 'gist': {
                        $return_meta['gist_id'] = $meta['gist-id'][0] ? $meta['gist-id'][0] : '';

                        break;
                    }
                    case 'github': {
                         $return_meta['github_url'] = $meta['github-url'][0] ? $meta['github-url'][0] : '';
                    }
                    case 'video': {
                        $return_meta['video_url'] = 'https://www.youtube.com/embed/' . $meta['video-id'][0];
                    }
                }

                return $return_meta;
            },
        )
    );

    register_rest_field(
        'resources',
        'template_type',
        array(
            'get_callback' => function($post) {
                $meta = get_post_meta($post['id']);
                return $meta['resource_type'][0];
            },
        )
    );

    $tagged_post_types = ['page', 'post', 'main_projects', 'resources'];

    register_rest_field(
        $tagged_post_types,
        'tags',
        array(
            'get_callback' => function($post) {
                $tags = wp_get_post_tags($post['id']);
                $tags_response = [];
                foreach ($tags as $tag) {
                    $tags_response[] = [
                        'id' => $tag->term_id,
                        'name' => $tag->name,
                        'slug' => $tag->slug
                    ];
                }
                return $tags_response;
            },
        )
    );

    register_rest_field(
        'page',
        'carousel_items',
        array(
            'get_callback' => function($post) {
                $carousel_posts = get_field('carousel_items', $post['id']);
                $carousel_items = [];
                foreach($carousel_posts as $carousel_post) {
                    $image_attributes = wp_get_attachment_image_src(
                        get_post_thumbnail_id($carousel_post->ID),
                        'homepage-carousel'
                    );
                    $carousel_items[] = [
                        'id' => $carousel_post->ID,
                        'description' => get_the_excerpt($carousel_post->ID),
                        'image_meta' => [
                            'alt' => get_the_title($carousel_post->ID),
                            'height' => $image_attributes[2],
                            'url' => $image_attributes[0],
                            'width' => $image_attributes[1]
                        ],
                        'title' => get_the_title($carousel_post->ID)
                    ];
                }
                return $carousel_items;
            },
        )
    );

    register_rest_field(
        'page',
        'quotation',
        array(
            'get_callback' => function($post) {
                $meta = get_post_meta($post['id']);
                return [
                    'quote' => isset($meta['quote'][0]) ? $meta['quote'][0] : null,
                    'attribution' => isset($meta['attribution'][0]) ? $meta['attribution'][0] : null
                ];
            },
        )
    );

    register_rest_field(
        'page',
        'blurb',
        array(
            'get_callback' => function($post) {
                return [ 'rendered' => get_field('blurb', $post['id']) ];
            },
        )
    );

    $all_post_types = get_post_types(
        [
            'public' => true,
            'exclude_from_search' => false
       ],
       'names'
    );

    register_rest_field(
        $all_post_types,
        'seo',
        array(
            'get_callback' => function($post) {
                $meta = get_post_meta($post['id']);
                $description = $meta['_yoast_wpseo_metadesc'][0]
                    ? $meta['_yoast_wpseo_metadesc'][0]
                    : strip_tags(get_the_excerpt($post['id']));
                $title = $meta['_yoast_wpseo_title'][0]
                    ? $meta['_yoast_wpseo_title'][0]
                    : get_the_title($post['id']);

                $seo = [
                    'description' => $description,
                    'title' => $title
                ];

                return $seo;
            },
        )
    );

    register_rest_route(
        'wp/v2',
        '/ui',
        [
            [
                'methods'   => WP_REST_Server::READABLE,
                'callback'  => function ($request) {
                    $frontpage_id = get_option( 'page_on_front' );
                    $theme_options = get_option('theme_options');
                    $site_description = get_bloginfo('description');
                    $site_title = get_bloginfo('name');
                    $seo_seperator = '-';

                    if (class_exists(WPSEO_Option_Titles)) {
                        $seo_titles = get_option('wpseo_titles');
                        $seo_serperator_key = $seo_titles['separator'];
                        $seo_seperator_options = WPSEO_Option_Titles::get_instance()->get_separator_options();
                        if (isset($seo_serperator_key) && isset($seo_seperator_options[$seo_serperator_key])) {
                            $seo_seperator = $seo_seperator_options[$seo_serperator_key];
                        }
                    }

                    return [
                        'frontpage' => get_post_field('post_name', $frontpage_id),
                        'ga_id' => $theme_options['ga_id'],
                        'site_description' => $site_description,
                        'site_title' => $site_title,
                        'seo_title_format' => '%s ' . $seo_seperator . ' ' . $site_title
                    ];
                }
            ]
        ]
    );
}

add_action( 'rest_api_init', 'tognox_register_api_hooks' );
