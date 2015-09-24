<?php
/**
* Plugin Name: Alpha Media - School Closings
* Description: Allows School Closings to be displayed if they are closed /delayed using a shortcode.
* Version: 1.0
* Author: Mark Gleason
* Author URI: http://gleason309.com
* License: GPL12
*/
include(dirname(__FILE__) .'/function-closings.php');
//Scripts & Stylesheets
  add_action( 'init', 'closings_enque_script_styles' );
function closings_enque_script_styles() {
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'school_closings_script', plugins_url() . '/schoolClosings/js/script.js' );
  wp_enqueue_style( 'school_closings', plugins_url() . '/schoolClosings/css/style.css' );
}

// Starting the Shortcode Function for the School Closings / Delays
  add_shortcode('closings', 'school_closings_shortcode');
function school_closings_shortcode() {

$args = array(
  'post_type' => 'closings',
  'orderby'=> 'title', 
  'order'      => 'ASC'
);
//Starting the While Loop
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
  echo '<div class="school_name">';
  the_title();
  echo '</div>';
  echo '<div class="closed_title">';
  global $post;
if ( 'yes' == get_post_meta($post->ID, 'closing_id', true) ) {
  echo 'CLOSED';
}else{
  echo '';
}
  echo '</div>';
  echo '<div class="delayed_title">';
if ( 'yes' == get_post_meta($post->ID, 'delayed_id', true) ) {
  echo get_post_meta( get_the_ID(), 'message_id', true );
}else{
  echo '';
}
  echo '</div>';
//return; // no posts found
endwhile; //End the While Loop
					
// Restore original Post Data
  wp_reset_postdata();
}// End the Shortcode Function for the School Closings / Delays
?>