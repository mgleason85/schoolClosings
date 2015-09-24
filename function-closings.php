<?php
//Custom Post For School Closings and Delays
//Registers the post type
  add_action( 'init', 'register_cpt_closings' );
function register_cpt_closings() {
$labels = array( 
  'name' => _x( 'School / Business Closings', 'closings' ),
  'singular_name' => _x( 'School / Business Closing', 'closings' ),
  'add_new' => _x( 'Add New', 'closings' ),
  'add_new_item' => _x( 'Add New School', 'closings' ),
  'edit_item' => _x( 'Edit Closing', 'closings' ),
  'new_item' => _x( 'New Closing', 'closings' ),
  'view_item' => _x( 'View Closing', 'closings' ),
  'search_items' => _x( 'Search Closings', 'closings' ),
  'not_found' => _x( 'No Closings found', 'closings' ),
  'not_found_in_trash' => _x( 'No Closings found in Trash', 'closings' ),
  'parent_item_colon' => _x( 'Parent Closing:', 'closings' ),
  'menu_name' => _x( 'School / Business Closings', 'closings' ),
 );
	
$args = array( 
  'labels' => $labels,
  'hierarchical' => false,
  'description' => 'A closings for my website',
  'supports' => array( 'title'),
  'public' => true,
  'show_ui' => true,
  'show_in_menu' => true,
	        
  'show_in_nav_menus' => true,
  'publicly_queryable' => true,
  'exclude_from_search' => false,
  'has_archive' => true,
  'query_var' => true,
  'can_export' => true,
  'rewrite' => true,
  'capability_type' => 'post'
);
  register_post_type( 'closings', $args );
}//End Registers the post type

//Adding Sub-Menu for Shortcode
  add_action('admin_menu' , 'register_settings'); 
function register_settings() {
  add_submenu_page('edit.php?post_type=closings', 'Shortcode', 'Shortcode', 'edit_posts', basename(__FILE__), 'settings');
  add_action('admin_init', 'settings_store');
}
function settings_store() {
  register_setting('settings', 'service_thing_you_want_to_save');
  register_setting('settings', 'service_other_thing_you_want_to_save');
}
function settings() {
  echo ' <div class="settings_box"> ';
  echo ' <div class="settings_box_title"> ';
  echo ' <h2>Shortcode:</h2> ';
  echo ' </div> ';
  echo ' <p>[closings]</p> ';
  $path = plugins_url( basename( __DIR__ ) . '/SchoolClosingsDoc.pdf' );
  echo ' <a href="' . $path .' " target="_blank"><p>Documentation</p></a> ';
  echo ' </div> ';
} //END Shortcode Menu
	
// Checkbox Meta Boxes
  add_action("admin_init", "checkbox_init");

function checkbox_init(){
	                       // $id            $title       $callback      $screen   $context     $priority
  add_meta_box("closing", "Closed ?", "closing", "closings", "normal", "high");
  add_meta_box("delayed", "Delayed / Message ?", "delayed", "closings", "normal", "high");
  add_meta_box("message_delayed", "Message:", "message_delayed", "closings", "normal", "high");
}

function closing(){
  global $post;
  $custom = get_post_custom($post->ID);
  $closing_id = $custom["closing_id"][0];
?>

  <label for="closing_id">Check for yes</label>
<?php $closing_id_value = get_post_meta($post->ID, 'closing_id', true);
  if($closing_id_value == "yes") $closing_id_checked = 'checked="checked"'; 
?>
  <input type="checkbox" name="closing_id" id="closing_id" value="yes" <?php echo $closing_id_checked; ?> />
<?php

}
function delayed(){
  global $post;
  $custom = get_post_custom($post->ID);
  $delayed_id = $custom["delayed_id"][0];
?>

  <div id="delayed_div">
  <label for="delayed_id">Check for yes</label>
<?php $delayed_id_value = get_post_meta($post->ID, 'delayed_id', true);
  if($delayed_id_value == "yes") $delayed_id_checked = 'checked="checked"'; 
?>
  <input type="checkbox" name="delayed_id" id="delayed_id" value="yes" <?php echo $delayed_id_checked; ?> />
  </div>
<?php
}
function message_delayed(){
  global $post;
  $custom = get_post_custom($post->ID);
  $message_id = $custom["message_id"][0];
?>
  <div id="delayed_message_div">
  <label for="time_id">Add your Message here:</label>
<?php $message_id_value = get_post_meta($post->ID, 'message_id', true);
?>
  <input type="text" name="message_id" id="message_id" placeholder="<?php echo get_post_meta( get_the_ID(), 'message_id', true ); ?>" />
  </div>
<?php
}//End Checkbox Meta Boxes

// Save Meta Details
  add_action('save_post', 'save_details');
function save_details(){
  global $post;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
  }
  update_post_meta($post->ID, "closing_id", $_POST["closing_id"]);
  update_post_meta($post->ID, "delayed_id", $_POST["delayed_id"]);
  update_post_meta($post->ID, "message_id", $_POST["message_id"]);
}//End Save Meta Details


