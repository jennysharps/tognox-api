<?php


 // let's create the function for the custom type
function custom_post_resources() {
	 // creating (registering) the custom type
	register_post_type( 'resources', // (http: //codex.wordpress.org/Function_Reference/register_post_type)
	 	 // let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Resources', 'post type general name'), // This is the Title of the Group
			'all_items' => __('All Resources'),
			'singular_name' => __('Resource', 'post type singular name'), // This is the individual type
			'add_new' => __('Add New', 'custom post type item'), // The add new menu item
			'add_new_item' => __('Add New Resource'), // Add New Display Title
			'edit' => __( 'Edit' ), // Edit Dialog
			'edit_item' => __('Edit Resource'), // Edit Display Title
			'new_item' => __('New Resource'), // New Display Title
			'view_item' => __('View Resource'), // View Display Title
			'search_items' => __('Search Resources'), // Search Custom Type Title
			'not_found' =>  __('Nothing found in the Database.'), // This displays if there are no entries yet
			'not_found_in_trash' => __('Nothing found in Trash'), // This displays if there is nothing in the trash
			'parent_item_colon' => ''
			), // end of arrays
			'description' => __( 'This is a content type for Resources.' ), // Custom Type Description
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 9, // this is what order you want it to appear in on the left hand side menu
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/download.png', // the icon for the custom post type menu
			'rewrite' => array( 'slug' => 'resources', 'with_front' => false ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'permalink_epmask' => 'EP_PERMALINK & EP_YEAR',
			'has_archive' => true,
			//'register_meta_box_cb' => 'custom_Download_metaboxes',
			// the next one is important, it tells what's enabled in the post editor
			'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'sticky'),
			'taxonomies' => array('category', 'post_tag')
	 	) // end of options
	); // end of register post type

}
// adding the function to the Wordpress init
add_action( 'init', 'custom_post_resources');


// now let's add custom tags (these act like categories)
function resource_taxonomies() {
    register_taxonomy( 'attachment_types',
	array('resources'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array('hierarchical' => true,    /* if this is false, it acts like tags */
		'label' => __( 'Resource Type' ),
		'labels' => array(
			'name' => __( 'Resource Type' ), /* name of the custom taxonomy */
			'singular_name' => __( 'Resource Type' ), /* single taxonomy name */
			'search_items' =>  __( 'Search Resource Types' ), /* search title for taxomony */
			'popular_items' => __( 'Most Used Resource Types' ),
			'all_items' => __( 'All Resource Types' ), /* all title for taxonomies */
			'edit_item' => __( 'Edit Resource Type' ), /* edit custom taxonomy title */
			'update_item' => __( 'Update Resource Type' ), /* update title for taxonomy */
			'add_new_item' => __( 'Add New Resource Type' ), /* add new title for taxonomy */
			'new_item_name' => __( 'New Resource Type Name' ) /* name title for taxonomy */,
			'add_or_remove_items' => __( 'Add or remove resource type' ),
			'choose_from_most_used' => __( 'Choose from the most used resource types' ),
			'menu_name' => __( 'Types' ),
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'type', 'with_front' => false )
	)
    );
}
add_action( 'init', 'resource_taxonomies', 0 );

/*
// Define additional "post thumbnails". Relies on MultiPostThumbnails to work
if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label' => 'Slider Image',
        'id' => 'Downloads_slider_image',
        'post_type' => 'main_Downloads',
        'priority' => 'high',
        'extra_options' => 'custom_metabox_test_proj'
        )
    );
};

function custom_metabox_test_proj($post_ID = NULL) {

	$meta = get_post_meta( $post_ID, '_slider_order', true );

  	$content = wp_nonce_field( 'test-Downloads-options', 'myplugin_noncename', true, false );

 	$content .= '
 	<div class="Download-slider-custom-fields">
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


function save_Download_postdata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return;

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], 'test-Downloads-options' ) )
      return;

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  $mydata = $_POST['_test_kw_field'];

  update_post_meta( $post_id, '_slider_order', $mydata );
}
add_action( 'save_post', 'save_Download_postdata' );


function main_Downloads_admin_css() {
	global $post_type;

	if ( get_post_type() == 'main_Downloads' || $post_type == 'main_Downloads' ) {

		echo "<link type='text/css' rel='stylesheet' href='" . get_bloginfo('stylesheet_directory') . "/library/css/admin.css' />";
	}
}
add_action('admin_head', 'main_Downloads_admin_css');


function retrieve_Download_slider_images() {
	global $post;

	$args = array(
		'meta_key' => '_slider_order',
		'post_type' => 'main_Downloads',
		'meta_query' => array(
			array(
				'key' => '_main_Downloads_Downloads_slider_image_thumbnail_id',
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

			$retrieved = MultiPostThumbnails::get_the_post_thumbnail_url('main_Downloads', 'Downloads_slider_image');

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