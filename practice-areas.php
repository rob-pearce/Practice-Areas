<?php

/*
Plugin Name: Law Firm Practice Areas
Plugin URI: http://www.lmhtechnology.com/law-firm-practice-areas/
Description: The Law Firm Practice Areas Plugin is used to store information related to a Law Firm's Practice Areas. The plugin creates a custom post type and stores custom information related to the various areas the firm specializes in.
Version: 1.0
Author: Rob Pearce rob@lmhtechnology.com
Author URI: http://www.lmhtechnology.com/
License: GPL2
*/


/********************************************************************************************
* lmh_attorney_practice_areas Post Type
*********************************************************************************************/
class lmh_attorney_practice_areas {

	function lmh_attorney_practice_areas() {
		add_action('init',array($this,'create_post_type'));
	}

	function create_post_type() {
		$labels = array(
			'name' => 'Practice Areas',
			'singular_name' => 'Practice Area',
			'add_new' => 'Add New Practice Area',
			'all_items' => 'All Practice Areas',
			'add_new_item' => 'Add New Practice Area',
			'edit_item' => 'Edit Practice Area',
			'new_item' => 'New Practice Area',
			'view_item' => 'View Practice Area',
			'search_items' => 'Search Practice Areas',
			'not_found' =>  'No practice areas found',
			'not_found_in_trash' => 'No practice areas found in trash',
			'parent_item_colon' => 'Parent Practice Area:',
			'menu_name' => 'Practice Areas'
		);
		$args = array(
			'labels' => $labels,
			'description' => "Listing of the various Practice Areas the firm specializes in.",
			'public' => true,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'show_in_menu' => true,
			'show_in_admin_bar' => true,
			'menu_position' => 20,
			'menu_icon' => 'dashicons-list-view',
			'capability_type' => 'post',
			'hierarchical' => true,
			'supports' => array('title','editor','thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'practice-areas', 'with_front' => ''),
			'query_var' => true,
			'can_export' => true
		);

		register_post_type('lmh_att_pract_areas',$args);
	}
}

$lmh_attorney_practice_areas = new lmh_attorney_practice_areas();


/*********************************************************************************************
 * Helper function to return an array of Practice Area Posts
 *********************************************************************************************/
function lmh_pa_retrieve_practice_area_posts(){
	$practice_area_args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'lmh_att_pract_areas',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);

	$practice_area_posts = get_posts( $practice_area_args );
	 if (count($practice_area_posts) === 0) {
		 return array('No posts available.');
	 } else {
		 return $practice_area_posts;
	 }


}

/*******************************************************************************
 * Custom function to provide an image URL for featured image. If an image is
 * defined return the image for use as a URL. If the Case does not have a
 * featured image defined, use a default image saved in
 * the plugin ./assets/images/ directory.
 *******************************************************************************/
function lmh_pa_retrieve_practice_area_featured_image($post_object) {
	// Test if the post has a Featured Image
	if ( has_post_thumbnail( $post_object ) === true ) {

		// There is a featured image, return a call to use in a background URL
		$page_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), array(
			5600,
			1000
		), false, '' );

		return $page_image[0];

	} else {
		// There is not a defined featured image, use default white background image stored in the theme directory
		$page_image = plugins_url( 'assets/images/bg-white.jpg', __FILE__ );

		return $page_image;

	}
}

