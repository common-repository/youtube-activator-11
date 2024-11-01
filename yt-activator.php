<?php
/*
Plugin Name: Youtube Activator
Plugin URI: http://www.omreport.de
Description: This Plugin can activate bundled Youtube videos on the time a post gets released!
Version: 1.0
Author: Andre Alpar
License: Free
*/

global $wpdb;

global $cookie_switch_prefs_table;

global $cookie_switch_tracking_table;


$yt_credentials_table = $wpdb->prefix . "yt_credentials";

$yt_video_accesskey = "yt_activator_video";

$yt_username = '';

$yt_password = '';

$yt_apikey = '';


$applicationId = 'Youtube Activator 1.0';
  
$clientId = 'http://yoursite.com';



function yt_set_video_public( $post_ID )  
{
   global $wpdb, $yt_username, $yt_password, $yt_apikey, $applicationId, $clientId;
  
  set_include_path(get_include_path() . ':'. dirname(realpath(__FILE__)). '/library');
  
  $video_id = explode(':', get_post_meta($post_ID, 'yt_activator_video_id', true));
  
  wp_mail( get_settings('admin_email'), "Videos have been set public!", 'Video: ' . implode(', ', $video_id) );

  require_once 'Zend/Loader.php'; // the Zend dir must be in your include_path
  Zend_Loader::loadClass('Zend_Gdata_YouTube');
  
  Zend_Loader::loadClass('Zend_Gdata_AuthSub');
  Zend_Loader::loadClass('Zend_Gdata_ClientLogin'); 
  
  $authenticationURL= 'https://www.google.com/accounts/ClientLogin';
  $httpClient = 
    Zend_Gdata_ClientLogin::getHttpClient(
                $username = $yt_username,
                $password = $yt_password,
                $service = 'youtube',
                $client = null,
                $source = 'MySource', // a short string identifying your application
                $loginToken = null,
                $loginCaptcha = null,
                $authenticationURL
    );
  
  

  
  $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $yt_apikey);
  
  
  $yt->setMajorProtocolVersion(2);
  
  
  foreach($video_id as $video) {
  
    $videoEntry = $yt->getVideoEntry($video, null, true);
    
    if($videoEntry->isVideoPrivate()) {
      
      $putUrl = $videoEntry->getEditLink();
      
      $videoEntry->setVideoPublic();
    
    
      $yt->updateEntry($videoEntry, $putUrl->getHref());
      
    }
    
    else {
      continue; #no work needs to be done
    }
  
  }
  
  
  


  return $post_ID;
}
add_action('publish_post', 'yt_set_video_public', 99);



/* Add the admin boxes* */

add_action( 'admin_init', 'yt_activator_add_custom_box', 1 ); 
add_action( 'save_post', 'yt_activator_save_postdata' );


function yt_activator_add_custom_box() {
    add_meta_box( 
        'myplugin_sectionid',
        __( 'Link Youtube Video', 'yt_activator_textdomain' ),
        'yt_activator_inner_custom_box',
        'post' #only for post, not for pages
    );

}

/* Prints the box content */
function yt_activator_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'yt_activator_37r83728fhs8c' );

  // The actual fields for data entry
  echo '<label for="yt_activator_video_id">';
       _e("Youtube Video IDs (seperate by colon (:) )", 'yt_activator_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="yt_activator_video_id" name="yt_activator_video_id" value="'.htmlspecialchars(get_post_meta($post->ID, 'yt_activator_video_id', true)).'" size="25" />';
}

/* When the post is saved, saves our custom data */
function yt_activator_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['yt_activator_37r83728fhs8c'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'post' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }


  // OK, we're authenticated: we need to find and save the data

  
  // Just call update, in case of nonexistence, automatically add_post_meta will be called
  update_post_meta($post_id, 'yt_activator_video_id', $_POST['yt_activator_video_id']); #data is automatically sanitized by WP
}
