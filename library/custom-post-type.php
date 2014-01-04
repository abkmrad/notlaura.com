<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// let's create the function for the custom type
function custom_post_example() { 
	// creating (registering) the custom type 
	register_post_type( 'custom_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Projects', 'bonestheme'), /* This is the Title of the Group */
			'singular_name' => __('Project', 'bonestheme'), /* This is the individual type */
			'all_items' => __('All Projects', 'bonestheme'), /* the all items menu item */
			'add_new' => __('Add New', 'bonestheme'), /* The add new menu item */
			'add_new_item' => __('Add New Project', 'bonestheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Project', 'bonestheme'), /* Edit Display Title */
			'new_item' => __('New Project', 'bonestheme'), /* New Display Title */
			'view_item' => __('View Project', 'bonestheme'), /* View Display Title */
			'search_items' => __('Search Projects', 'bonestheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is the example custom post type', 'bonestheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'project', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'custom_type', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	
	/* this adds your post categories to your custom post type */
	register_taxonomy_for_object_type('category', 'custom_type');
	/* this adds your post tags to your custom post type */
	register_taxonomy_for_object_type('post_tag', 'custom_type');
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_post_example');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
	// now let's add custom categories (these act like categories)
    register_taxonomy( 'custom_cat', 
    	array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
    		'labels' => array(
    			'name' => __( 'Project Types', 'bonestheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Project Type', 'bonestheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Project Types', 'bonestheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Project Types', 'bonestheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Project Type', 'bonestheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Project Type:', 'bonestheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Project Type', 'bonestheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Project Type', 'bonestheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Project Type', 'bonestheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Project Type', 'bonestheme' ) /* name title for taxonomy */
    			
    		),
    		'show_ui' => true,
    		'query_var' => true,
    		'rewrite' => array( 'slug' => 'portfolio' ),
    	)
    );   
    
	// now let's add custom tags (these act like categories)
    register_taxonomy( 'custom_tag', 
    	array('custom_type'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Skills', 'bonestheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Skill', 'bonestheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Skills', 'bonestheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Skills', 'bonestheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Skill', 'bonestheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Skill:', 'bonestheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Skill', 'bonestheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Skill', 'bonestheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Skill', 'bonestheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Custom Skill', 'bonestheme' ) /* name title for taxonomy */
    		),
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); 

	// Custom paging: Will need to figure this out once more projects are added
	// function portfolio_posts_per_page( $query ) {  
 //        if ( $query->query_vars['post_type'] == 'custom_type' ) $query->query_vars['posts_per_page'] = 1;  
 //        return $query;  
 //    }  
 //    if ( !is_admin() ) add_filter( 'pre_get_posts', 'portfolio_posts_per_page' );  

?>