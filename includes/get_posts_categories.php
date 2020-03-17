<?php
/**
 * Get All Categories
 *
 * @param none
 * @return array returns an array of category objects
 * @since 0.2.0
 */

function bre_get_categories() {

  // set an empty array
  $bre_categories = array();

  // get all categories as objects
  $categories = get_categories( array(
    'orderby' => 'name',
    'order'   => 'ASC'
) );
  
  // Loop through each category and get its data
  foreach($categories as $cat){
    $bre_cat_obj = new stdClass();

  	$bre_cat_obj->name = $cat->name;
    $bre_cat_obj->slug = $cat->slug;
    $bre_cat_obj->description = $cat->description;
    $bre_cat_obj->count = $cat->count;

    // push the data to the array
    array_push($bre_categories, $bre_cat_obj);
  }

  /*
   *
   * Register Rest API Endpoint
   *
   */

  register_rest_route( 'better-rest-endpoints/v1', '/categories/', array(
    'methods' => 'GET',
    'callback' => function ( WP_REST_Request $request ) use($bre_categories) {
      return $bre_categories;
    },
  ));
}

/*
 *
 * Add action for categories
 *
 */
add_action( 'rest_api_init', 'bre_get_categories' );