<?php

function custom_post_citations() {

	register_post_type( 'main_citations', // (http: //codex.wordpress.org/Function_Reference/register_post_type)
	 	 // let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Citations', 'post type general name'), // This is the Title of the Group
			'all_items' => __('All Citations'),
			'singular_name' => __('Citation', 'post type singular name'), // This is the individual type
			'add_new' => __('Add New', 'custom post type item'), // The add new menu item
			'add_new_item' => __('Add New Citation'), // Add New Display Title
			'edit' => __( 'Edit' ), // Edit Dialog
			'edit_item' => __('Edit Citation'), // Edit Display Title
			'new_item' => __('New Citation'), // New Display Title
			'view_item' => __('View Citation'), // View Display Title
			'search_items' => __('Search Citations'), // Search Custom Type Title
			'not_found' =>  __('Nothing found in the Database.'), // This displays if there are no entries yet
			'not_found_in_trash' => __('Nothing found in Trash'), // This displays if there is nothing in the trash
			'parent_item_colon' => ''
			), // end of arrays
			'description' => __( 'This is a content type for citations.' ), // Custom Type Description
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, // this is what order you want it to appear in on the left hand side menu
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', // the icon for the custom post type menu
			'rewrite' => array( 'slug' => 'citations', 'with_front' => false ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'permalink_epmask' => 'EP_PERMALINK & EP_YEAR',
			'has_archive' => 'citations',
			//'register_meta_box_cb' => 'custom_citation_metaboxes',
			// the next one is important, it tells what's enabled in the post editor
			'supports' => array( 'title', 'thumbnail', 'excerpt', 'revisions', 'sticky'),
			'taxonomies' => array('post_tag')
	 	) // end of options
	); // end of register post type


	// this ads your post categories to your custom post type
	// register_taxonomy_for_object_type('category', 'main_citations');
	// this ads your post tags to your custom post type
	//register_taxonomy_for_object_type('post_tag', 'main_citations');

}
// adding the function to the Wordpress init
add_action( 'init', 'custom_post_citations');

/*
// Define additional "post thumbnails". Relies on MultiPostThumbnails to work
if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label' => 'Slider Image',
        'id' => 'citations_slider_image',
        'post_type' => 'main_citations',
        'priority' => 'high',
        'extra_options' => 'custom_metabox_test_cite'
        )
    );
};
*/

function custom_metabox_cite($post_ID = NULL) {

	$meta = get_post_meta( $post_ID, '_slider_order', true );

  	$content = wp_nonce_field( 'test-citations-options', 'myplugin_noncename', true, false );

 	$content .= '
 	<div class="citation-slider-custom-fields">
 		<label>Choose Slider Position</label>
 		<select id="_test_kw_field" name="_test_kw_field">
 			<option>None</option>
 		';

	 	foreach (range(1,6) as $number) {
	 		if( $meta == $number ) { $select = ' selected="selected"'; } else { $select = ''; }
		    $content .= '<option' . $select . ' value="' . $number . '">' . $number . '</option>';
		}

		$content .= '
		</select>
 	</div>';

	return $content;
}

function register_custom_metabox_cite() {
    add_meta_box(
        'tognox_citation-details',
        'Citation Details',
        'custom_metabox_cite',
        'main_citations',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'register_custom_metabox_cite' );


/*
function save_citation_postdata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], 'test-citations-options' ) )
      return;

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  $mydata = $_POST['_test_kw_field'];

  update_post_meta( $post_id, '_slider_order', $mydata );
}
add_action( 'save_post', 'save_citation_postdata' );


function main_citations_admin_css() {
	global $post_type;

	if ( get_post_type() == 'main_citations' || $post_type == 'main_citations' ) {

		echo "<link type='text/css' rel='stylesheet' href='" . get_bloginfo('stylesheet_directory') . "/library/css/admin.css' />";
	}
}
add_action('admin_head', 'main_citations_admin_css');


function retrieve_citation_slider_images() {
	global $post;

	$args = array(
		'meta_key' => '_slider_order',
		'post_type' => 'main_citations',
		'meta_query' => array(
			array(
				'key' => '_main_citations_citations_slider_image_thumbnail_id',
				'value' => NULL,
				'compare' => '!='
			)
		)
	);

	$slider_query = new WP_Query($args);
	$attachments = array();

	if( $slider_query->have_posts() ) {
		while ($slider_query->have_posts()) : $slider_query->the_post();

			$order = get_post_meta( $post->ID, '_slider_order', true);

			$retrieved = MultiPostThumbnails::get_the_post_thumbnail_url('main_citations', 'citations_slider_image');

			$attachments[$order] = array(
				'img_url'=>$retrieved[0],
				'link'=>get_permalink(),
				'title'=>get_the_title());

			endwhile;
		}
		wp_reset_query();

		asort($attachments, SORT_NUMERIC);
		return $attachments;
}*/
