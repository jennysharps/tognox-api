<?php


 // let's create the function for the custom type
function custom_post_publications() { 
	 // creating (registering) the custom type 
	register_post_type( 'main_publications', // (http: //codex.wordpress.org/Function_Reference/register_post_type)
	 	 // let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Publications', 'post type general name'), // This is the Title of the Group
			'all_items' => __('All Publications'),
			'singular_name' => __('Publication', 'post type singular name'), // This is the individual type
			'add_new' => __('Add New', 'custom post type item'), // The add new menu item
			'add_new_item' => __('Add New Publication'), // Add New Display Title
			'edit' => __( 'Edit' ), // Edit Dialog
			'edit_item' => __('Edit Publication'), // Edit Display Title
			'new_item' => __('New Publication'), // New Display Title
			'view_item' => __('View Publication'), // View Display Title
			'search_items' => __('Search Publications'), // Search Custom Type Title 
			'not_found' =>  __('Nothing found in the Database.'), // This displays if there are no entries yet 
			'not_found_in_trash' => __('Nothing found in Trash'), // This displays if there is nothing in the trash
			'parent_item_colon' => ''
			), // end of arrays
			'description' => __( 'This is a content type for publications.' ), // Custom Type Description
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, // this is what order you want it to appear in on the left hand side menu 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', // the icon for the custom post type menu
			'rewrite' => array( 'slug' => 'publications', 'with_front' => false ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'permalink_epmask' => 'EP_PERMALINK & EP_YEAR', 
			'has_archive' => 'publications',
			//'register_meta_box_cb' => 'custom_publication_metaboxes',
			// the next one is important, it tells what's enabled in the post editor
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky'),
			'taxonomies' => array('post_tag'),
			'show_in_rest' => true,
			'rest_base' => 'publications'
	 	) // end of options
	); // end of register post type
	
	
	// this ads your post categories to your custom post type
	// register_taxonomy_for_object_type('category', 'main_publications');
	// this ads your post tags to your custom post type
	//register_taxonomy_for_object_type('post_tag', 'main_publications');
	
} 
// adding the function to the Wordpress init
add_action( 'init', 'custom_post_publications');
