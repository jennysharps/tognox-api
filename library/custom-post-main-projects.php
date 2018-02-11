<?php


 // let's create the function for the custom type
function custom_post_projects() { 
	 // creating (registering) the custom type 
	register_post_type( 'main_projects', // (http: //codex.wordpress.org/Function_Reference/register_post_type)
	 	 // let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Projects', 'post type general name'), // This is the Title of the Group
			'all_items' => __('All Projects'),
			'singular_name' => __('Project', 'post type singular name'), // This is the individual type
			'add_new' => __('Add New', 'custom post type item'), // The add new menu item
			'add_new_item' => __('Add New Project'), // Add New Display Title
			'edit' => __( 'Edit' ), // Edit Dialog
			'edit_item' => __('Edit Project'), // Edit Display Title
			'new_item' => __('New Project'), // New Display Title
			'view_item' => __('View Project'), // View Display Title
			'search_items' => __('Search Projects'), // Search Custom Type Title 
			'not_found' =>  __('Nothing found in the Database.'), // This displays if there are no entries yet 
			'not_found_in_trash' => __('Nothing found in Trash'), // This displays if there is nothing in the trash
			'parent_item_colon' => ''
			), // end of arrays
			'description' => __( 'This is a content type for projects.' ), // Custom Type Description
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, // this is what order you want it to appear in on the left hand side menu 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', // the icon for the custom post type menu
			'rewrite' => array( 'slug' => 'projects', 'with_front' => false ),
			'capability_type' => 'post',
			'hierarchical' => false,
			'permalink_epmask' => 'EP_PERMALINK & EP_YEAR', 
			'has_archive' => 'projects',
			//'register_meta_box_cb' => 'custom_project_metaboxes',
			// the next one is important, it tells what's enabled in the post editor
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky'),
			'taxonomies' => array('post_tag'),
			'show_in_rest' => true,
			'rest_base' => 'projects'
	 	) // end of options
	); // end of register post type
	
	
	// this ads your post categories to your custom post type
	// register_taxonomy_for_object_type('category', 'main_projects');
	// this ads your post tags to your custom post type
	//register_taxonomy_for_object_type('post_tag', 'main_projects');
	
} 
// adding the function to the Wordpress init
add_action( 'init', 'custom_post_projects');
	

// now let's add custom tags (these act like categories)
register_taxonomy( 'project_languages', 
	array('main_projects','main_publications','resources'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array('hierarchical' => false,    /* if this is false, it acts like tags */
		'label' => __( 'Programming Languages Used' ),             
		'labels' => array(
			'name' => __( 'Programming Languages Used' ), /* name of the custom taxonomy */
			'singular_name' => __( 'Programming Language' ), /* single taxonomy name */
			'search_items' =>  __( 'Search Programming Languages' ), /* search title for taxomony */
			'popular_items' => __( 'Most Used Programming Languages' ),
			'all_items' => __( 'All Languages' ), /* all title for taxonomies */
			'edit_item' => __( 'Edit Language' ), /* edit custom taxonomy title */
			'update_item' => __( 'Update Language' ), /* update title for taxonomy */
			'add_new_item' => __( 'Add New Language' ), /* add new title for taxonomy */
			'new_item_name' => __( 'New Language Name' ) /* name title for taxonomy */,
			'add_or_remove_items' => __( 'Add or remove language' ),
			'choose_from_most_used' => __( 'Choose from the most used languages' ),
			'menu_name' => __( 'Languages' ),
		),
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'language', 'with_front' => false )
	)
); 
			
			
// now let's add custom tags (these act like categories)
register_taxonomy( 'project_software', 
	array('main_projects','main_publications'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
	array('hierarchical' => false,    /* if this is false, it acts like tags */
		'label' => __( 'Software Used' ),             
		'labels' => array(
			'name' => __( 'Software Used' ), /* name of the custom taxonomy */
			'singular_name' => __( 'Software' ), /* single taxonomy name */
			'search_items' =>  __( 'Search Software' ), /* search title for taxomony */
			'popular_items' => __( 'Most Used Software' ),
			'all_items' => __( 'All Software' ), /* all title for taxonomies */
			'edit_item' => __( 'Edit Software' ), /* edit custom taxonomy title */
			'update_item' => __( 'Update Software' ), /* update title for taxonomy */
			'add_new_item' => __( 'Add New Software' ), /* add new title for taxonomy */
			'new_item_name' => __( 'New Software Name' ) /* name title for taxonomy */,
			'add_or_remove_items' => __( 'Add or remove software' ),
			'choose_from_most_used' => __( 'Choose from the most used software' ),
			'menu_name' => __( 'Software' ),
		),
		'show_ui' => true,
		'query_var' => true,
		'show_tagcloud' => true,
		'rewrite' => array( 'slug' => 'software', 'with_front' => false )
	)
);


// Define additional "post thumbnails". Relies on MultiPostThumbnails to work
/* if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label' => 'Slider Image',
        'id' => 'projects_slider_image',
        'post_type' => 'main_projects',
        'priority' => 'high',
        'extra_options' => 'custom_metabox_test_proj'
        )
    );
}; 
	
function custom_metabox_test_proj($post_ID = NULL) {

	$meta = get_post_meta( $post_ID, '_slider_order', true );
	
  	// $content = wp_nonce_field( 'test-projects-options', 'myplugin_noncename', true, false );

 	$content = '
 	<div class="project-slider-custom-fields">
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


function save_project_postdata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], 'test-projects-options' ) )
      return;

  if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  $mydata = $_POST['_test_kw_field'];

  update_post_meta( $post_id, '_slider_order', $mydata );
}
add_action( 'save_post', 'save_project_postdata' );
*/

function main_projects_admin_css() {
	global $post_type; 
	
	if ( get_post_type() == 'main_projects' || $post_type == 'main_projects' ) {	

		echo "<link type='text/css' rel='stylesheet' href='" . get_bloginfo('stylesheet_directory') . "/library/css/admin.css' />";
	}
}
add_action('admin_head', 'main_projects_admin_css');


function retrieve_project_slider_images() {
	global $post;
	
	$args = array(
		'meta_key' => '_slider_order',
		'post_type' => 'main_projects',
		'meta_query' => array(
			array(
				'key' => '_main_projects_projects_slider_image_thumbnail_id',
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
			
			$retrieved = MultiPostThumbnails::get_the_post_thumbnail_url('main_projects', 'projects_slider_image');
			
			$attachments[$order] = array( 
				'img_url'=>$retrieved[0], 
				'link'=>get_permalink(),
				'title'=>get_the_title());
		
			endwhile;
		}
		wp_reset_query();
					
		asort($attachments, SORT_NUMERIC);
		return $attachments;
}
