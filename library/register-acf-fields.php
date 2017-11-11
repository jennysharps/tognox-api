<?php

/* add_action('acf/register_fields', 'my_register_fields');

  function my_register_fields() {
  //include_once('add-ons/acf-repeater/repeater.php');
  //include_once('add-ons/acf-gallery/gallery.php');
  //include_once('add-ons/acf-flexible-content/flexible-content.php');
  }

  // Options Page
  //include_once( 'add-ons/acf-options-page/acf-options-page.php' );
 */

/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */
if ( function_exists( "register_field_group" ) ) {
    register_field_group(
            array (
                'id' => 'content-carousel',
                'title' => 'Content Carousel',
                'fields' => array (
                    array (
                        'post_type' => array (
                            0 => 'main_projects',
                        ),
                        'taxonomy' => array (
                            0 => 'all',
                        ),
                        'multiple' => 1,
                        'allow_null' => 1,
                        'key' => 'field_51b4fc8531236',
                        'label' => 'Carousel Items',
                        'name' => 'carousel_items',
                        'type' => 'post_object',
                        'instructions' => 'Choose all posts you would like to be featured in the carousel (Shift+click to select multiple posts).',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'page_template',
                            'operator' => '==',
                            'value' => 'front-page.php',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            )
    );

    register_field_group( array (
        'id' => 'acf_quotation',
        'title' => 'Quotation',
        'fields' => array (
            array (
                'default_value' => '',
                'formatting' => 'html',
                'key' => 'field_51d616f61572c',
                'label' => 'Quote',
                'name' => 'quote',
                'type' => 'text',
            ),
            array (
                'default_value' => '',
                'formatting' => 'html',
                'key' => 'field_51d6170b1572d',
                'label' => 'Attribution',
                'name' => 'attribution',
                'type' => 'text',
                'instructions' => 'Who said this?',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'front-page.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ) );

    register_field_group(
            array (
                'id' => 'acf_file-upload',
                'title' => 'File Upload',
                'fields' => array (
                    array (
                        'save_format' => 'object',
                        'library' => 'all',
                        'key' => 'field_51d5650761bbc',
                        'label' => 'Related File',
                        'name' => 'custom_attachment',
                        'type' => 'file',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'jls_citation',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                        0 => 'the_content',
                    ),
                ),
                'menu_order' => 0,
            )
    );

    register_field_group( array (
        'id' => 'acf_github-info',
        'title' => 'GitHub Info',
        'fields' => array (
            array (
                'key' => 'field_51dbdf720cf88',
                'label' => 'URL to related GitHub Repo',
                'name' => 'github_repo',
                'type' => 'text',
                'default_value' => '',
                'formatting' => 'none',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'main_projects',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ) );

    register_field_group( array (
        'id' => 'acf_attached-files',
        'title' => 'Attached Files',
        'fields' => array (
            array (
                'key' => 'field_51df77196c34c',
                'label' => 'File 1 Name',
                'name' => 'file_1_name',
                'type' => 'text',
                'default_value' => 'Resume',
                'formatting' => 'html',
            ),
            array (
                'key' => 'field_51df77e66c34d',
                'label' => 'File 1',
                'name' => 'file_1',
                'type' => 'file',
                'save_format' => 'url',
                'library' => 'all',
            ),
            array (
                'key' => 'field_51df7a026c34e',
                'label' => 'File 2 Name',
                'name' => 'file_2_name',
                'type' => 'text',
                'default_value' => 'CV',
                'formatting' => 'html',
            ),
            array (
                'key' => 'field_51df7a336c34f',
                'label' => 'File 2',
                'name' => 'file_2',
                'type' => 'file',
                'save_format' => 'url',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-template-about.php',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'normal',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ) );

    register_field_group(array (
            'id' => 'acf_resource-options',
            'title' => 'Resource Options',
            'fields' => array (
                    array (
                            'key' => 'field_52b76fb5c1324',
                            'label' => 'Resource Type',
                            'name' => 'resource_type',
                            'type' => 'select',
                            'required' => 1,
                            'choices' => array (
                                'video' => 'Video',
                                'gist' => 'Code (Gist)',
                                'github' => 'Code (Github)',
                                'file' => 'Poster/Presentation',
                            ),
                            'default_value' => '',
                            'allow_null' => 0,
                            'multiple' => 0,
                    ),
                    array (
                            'key' => 'field_52b770e0c1325',
                            'label' => 'Gist ID',
                            'name' => 'gist-id',
                            'type' => 'text',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'none',
                            'maxlength' => '',
                    ),
                    array (
                            'key' => 'field_53b770e0c1326',
                            'label' => 'Github URL',
                            'name' => 'github-url',
                            'type' => 'text',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'none',
                            'maxlength' => '',
                    ),
                    array (
                            'key' => 'field_52ce3d1b63569',
                            'label' => 'Related File',
                            'name' => 'related-file',
                            'type' => 'file',
                            'save_format' => 'object',
                            'library' => 'all',
                    ),
                    array (
                        'key' => 'field_51dbdf720cf23',
                        'label' => 'Download Button Text',
                        'name' => 'button-text',
                        'type' => 'text',
                        'default_value' => '',
                        'formatting' => 'none',
                    ),
                    array (
                            'key' => 'field_52ce3d1b63570',
                            'label' => 'YouTube ID',
                            'name' => 'video-id',
                            'type' => 'text',
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'none',
                            'maxlength' => '',
                    )
            ),
            'location' => array (
                    array (
                            array (
                                    'param' => 'post_type',
                                    'operator' => '==',
                                    'value' => 'resources',
                                    'order_no' => 0,
                                    'group_no' => 0,
                            ),
                    ),
            ),
            'options' => array (
                    'position' => 'normal',
                    'layout' => 'box',
                    'hide_on_screen' => array (
                    ),
            ),
            'menu_order' => 0,
    ));

    register_field_group( array (
        'id' => 'acf_related-citations',
        'title' => 'Related Citations',
        'fields' => array (
            array (
                'key' => 'field_52a4f83e8418a',
                'label' => 'Citations',
                'name' => 'related_citations',
                'type' => 'relationship',
                'instructions' => 'Choose all related citations',
                'return_format' => 'id',
                'post_type' => array (
                    0 => 'jls_citation',
                ),
                'taxonomy' => array (
                    0 => 'all',
                ),
                'filters' => array (
                    0 => 'search',
                ),
                'result_elements' => array (
                    0 => 'post_title',
                ),
                'max' => '',
            ),
            array (
                'key' => 'field_52a4fd73094c1',
                'label' => 'Presentation',
                'name' => 'presentation',
                'type' => 'relationship',
                'instructions' => 'Choose related presentation',
                'return_format' => 'id',
                'post_type' => array (
                    0 => 'jls_citation',
                ),
                'taxonomy' => array (
                    0 => 'all',
                ),
                'filters' => array (
                    0 => 'search',
                ),
                'result_elements' => array (
                    0 => 'post_title',
                ),
                'max' => 1,
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'main_projects',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ) );

    register_field_group( array (
        'id' => 'acf_related-project',
        'title' => 'Related Projects',
        'fields' => array (
            array (
                'key' => 'field_52a4f83e8418b',
                'label' => 'Related Projects',
                'name' => 'related_projects',
                'type' => 'relationship',
                'instructions' => 'Choose all related projects',
                'return_format' => 'id',
                'post_type' => array (
                    0 => 'main_projects',
                ),
                'taxonomy' => array (
                    0 => 'all',
                ),
                'filters' => array (
                    0 => 'search',
                ),
                'result_elements' => array (
                    0 => 'post_title',
                ),
                'max' => '',
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'downloads',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ) );
}
