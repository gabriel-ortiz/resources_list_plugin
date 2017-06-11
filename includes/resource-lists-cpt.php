<?php

//Exit if accessed directly
if(!defined( 'ABSPATH')){
    exit;
}

class resource_list_CPT{
    
    
    public function __construct(){
    	
         //init the taxonomy, which is used to group together records
        add_action( 'init', [ $this, 'create_resource_lists' ], 0 );   	
    	
    	//init the custom post type for record items
        add_action( 'init', [ $this, 'resource_list_generator' ], 0 );          
        

    }
    
// Register Custom Post Type
	function resource_list_generator() {
	
		$labels = array(
			'name'                  => _x( 'List Records', 'Post Type General Name', 'resource_list' ),
			'singular_name'         => _x( 'List Record', 'Post Type Singular Name', 'resource_list' ),
			'menu_name'             => __( 'Custom Resource Lists', 'resource_list' ),
			'name_admin_bar'        => __( 'Custom Resource Lists', 'resource_list' ),
			'archives'              => __( 'Record Archives', 'resource_list' ),
			'attributes'            => __( 'Record Attributes', 'resource_list' ),
			'parent_item_colon'     => __( 'Parent Record', 'resource_list' ),
			'all_items'             => __( 'All Records', 'resource_list' ),
			'add_new_item'          => __( 'New Records', 'resource_list' ),
			'add_new'               => __( 'Add New Record', 'resource_list' ),
			'new_item'              => __( 'New Record', 'resource_list' ),
			'edit_item'             => __( 'Edit Record', 'resource_list' ),
			'update_item'           => __( 'Update Record', 'resource_list' ),
			'view_item'             => __( 'View Record', 'resource_list' ),
			'view_items'            => __( 'View Records', 'resource_list' ),
			'search_items'          => __( 'Search Records', 'resource_list' ),
			'not_found'             => __( 'Not found', 'resource_list' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'resource_list' ),
			'featured_image'        => __( 'Featured Image', 'resource_list' ),
			'set_featured_image'    => __( 'Set featured image', 'resource_list' ),
			'remove_featured_image' => __( 'Remove featured image', 'resource_list' ),
			'use_featured_image'    => __( 'Use as featured image', 'resource_list' ),
			'insert_into_item'      => __( 'Insert into item', 'resource_list' ),
			'uploaded_to_this_item' => __( 'Uploaded to this record', 'resource_list' ),
			'items_list'            => __( 'Items list', 'resource_list' ),
			'items_list_navigation' => __( 'Items list navigation', 'resource_list' ),
			'filter_items_list'     => __( 'Filter items list', 'resource_list' ),
		);
		$rewrite = array(
			'slug'                  => 'resource-list-record',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'List Record', 'resource_list' ),
			'description'           => __( 'Individual resource list records', 'resource_list' ),
			'labels'                => $labels,
			'supports'              => array( 'author' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-book',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
			'rest_base'             => 'resource-list-record',
		);
		register_post_type( 'resource_list_item', $args );
	
	}
  
// Register Custom Taxonomy
public function create_resource_lists() {

	$labels = array(
		'name'                       => _x( 'Resource Lists', 'Taxonomy General Name', 'resource-list' ),
		'singular_name'              => _x( 'Resource List', 'Taxonomy Singular Name', 'resource-list' ),
		'menu_name'                  => __( 'Manage Resource Lists', 'resource-list' ),
		'all_items'                  => __( 'All Resource Lists', 'resource-list' ),
		'parent_item'                => __( 'Parent Lists', 'resource-list' ),
		'parent_item_colon'          => __( 'Parent List:', 'resource-list' ),
		'new_item_name'              => __( 'New Resource List', 'resource-list' ),
		'add_new_item'               => __( 'Add New Resource LIst', 'resource-list' ),
		'edit_item'                  => __( 'Edit Resource List', 'resource-list' ),
		'update_item'                => __( 'Update Resource List', 'resource-list' ),
		'view_item'                  => __( 'View Resource List', 'resource-list' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'resource-list' ),
		'add_or_remove_items'        => __( 'Add or remove records', 'resource-list' ),
		'choose_from_most_used'      => __( 'Choose from the most used list', 'resource-list' ),
		'popular_items'              => __( 'Popular Lists', 'resource-list' ),
		'search_items'               => __( 'Search Lists', 'resource-list' ),
		'not_found'                  => __( 'List not found', 'resource-list' ),
		'no_terms'                   => __( 'No items in list', 'resource-list' ),
		'items_list'                 => __( 'Items list', 'resource-list' ),
		'items_list_navigation'      => __( 'Items list navigation', 'resource-list' ),
	);
	$rewrite = array(
		'slug'                       => 'resource-list',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'resource_list_parent', array( 'resource_list_item' ), $args );

}


	
}//end of class resource_list_CPT

