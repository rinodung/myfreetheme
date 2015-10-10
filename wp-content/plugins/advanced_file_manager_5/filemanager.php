<?php
/*

Plugin Name: Advanced File Manager (Share On Theme123.Net)

Plugin URI: http://codecanyon.net/item/file-manager-plugin-for-wordpress/2640424

Description: Advanced WP File manager let you are your users access files and folders they have been assigned, it has features like Image and text editing, shared folders, group folder access, front-end and backend folders access, you can let the file manager be used by non-logged-in users too, you can make it work like a download manager for the frontend users and much more.

Version: 5.3.4

Author: RedHawk Studio

Author URI: http://www.redhawk-studio.com


-----elfinder
Copyright (c) 2009-2012, Studio 42

All rights reserved.



Redistribution and use in source and binary forms, with or without

modification, are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright

      notice, this list of conditions and the following disclaimer.

    * Redistributions in binary form must reproduce the above copyright

      notice, this list of conditions and the following disclaimer in the

      documentation and/or other materials provided with the distribution.

    * Neither the name of the Studio 42 Ltd. nor the

      names of its contributors may be used to endorse or promote products

      derived from this software without specific prior written permission.



THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND

ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED

WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE

DISCLAIMED. IN NO EVENT SHALL "STUDIO 42" BE LIABLE FOR ANY DIRECT, INDIRECT,

INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT

LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR

PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF

LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE

OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF

ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/
//08000 3030
error_reporting(0);
defined('ABSPATH') or die("Cannot access pages directly."); 

//updates server:
require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_812( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));



add_action('init', 'filemanager_connector5', 10);

function filemanager_connector5(){



    if( $_GET["red_fm_connect"] == "true" ){

        include 'php/connector.php';

    }

}


//plugin url
define('RED_FM_URL', plugin_dir_url( __FILE__ ));
//define('RED_FM_PATH', dirname(__FILE__) );
$plugin_dir_path = dirname(__FILE__);
//echo get_home_path();

add_action('admin_menu', 'red_fm_menu');

function red_fm_menu() {


	add_menu_page('File Manager', 'File Manager', 'read', 'red_fm_manager', 'red_fm_main_page');

	//if admin, make a sub menu for settings
	if (is_admin() ) {
		 add_submenu_page( 'red_fm_manager', 'FM Users', 'Users', 'manage_options', 'red_fm_manager_users', 'red_fm_users_page' );
		 add_submenu_page('red_fm_manager', 'User Groups', 'User Groups', 'manage_options', 'red_fm_groups', 'red_fm_groups_page');
     add_submenu_page('red_fm_manager', 'Front-End Access', 'Front-End Access', 'manage_options', 'red_fm_front', 'red_fm_front_page');
	   add_submenu_page('red_fm_manager', 'Settings', 'Settings', 'manage_options', 'red_fm_settings', 'red_fm_settings_page');
  } 

	//add_menu_page('FileManager', 'File Manager Test', 'subscriber', 'red_fm_view', 'red_fm_view_page');
	
}

function red_fm_main_page(){
	include "admin_page.php";
}

function red_fm_users_page(){
	include "admin_users_page.php";
}

function red_fm_view_page(){
	include "filemanager_view.php";
}

function red_fm_groups_page(){
	include "groups_settings.php";
}

function red_fm_front_page(){
  include "front_settings.php";
}

function red_fm_settings_page(){
  include "filemanager_settings.php";
}


//activattion

register_activation_hook( __FILE__, 'red_fm_activate' );

function red_fm_activate() {
   global $wpdb;
   include "settings.php";

   //$table_name = $wpdb->prefix . "red_file_manager";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  folder VARCHAR(255) DEFAULT '' NOT NULL,
  type VARCHAR(32) DEFAULT '' NOT NULL,
  access VARCHAR(8) DEFAULT '' NOT NULL,
  meta VARCHAR(255) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );


   if( !get_option( "red_fm_lang" ) ) {
        update_option( "red_fm_lang", "LANG" );
    }
 
   if( !get_option( "red_fm_view" ) ) {
        update_option( "red_fm_view", "icons" );
    }

   if( !get_option( "red_fm_media_sync" ) ) {
        update_option( "red_fm_media_sync", "1" );
    }

    if( !get_option("red_fm_default_access") ){
          update_option( "red_fm_default_access", 'r' );
    }

    if( !get_option("red_fm_create_default_folders") ){
          update_option( "red_fm_create_default_folders", '1');
    }   


//make folders for all users

    $default_perm = get_option("red_fm_default_access");
    $allow_default_folders = get_option("red_fm_create_default_folders");

$upload_dir = wp_upload_dir();
$users = get_users(array('order' => 'ASC'));


if($allow_default_folders == 1){
      foreach ($users as $user){
          
          $newdir = str_replace("\\", "/", $upload_dir['basedir'].'/'.$user->user_login.'/');
          $newurl = str_replace("\\", "/", $upload_dir['baseurl'].'/'.$user->user_login.'/');
          
          //$stringthis = $newdir."~".$newurl;
          if(!is_dir ($newdir))
          {
              mkdir($newdir, 0777);
          }//end if

          $newdir = rtrim($newdir, "/");

        $query = "SELECT * FROM `" . $table_name . "` WHERE `folder` = '$newdir' AND `meta` = 'red_fm_default' ";
        $results = $wpdb->get_results($query);

        if( sizeof($results) == 0 ){


                          $wpdb->insert(
                                  $table_name,
                                  array(
                                          'folder' =>  $newdir,
                                          'type'   =>  $user->id,
                                          'access' =>  $default_perm,
                                          'meta'   =>   'red_fm_default'
                                  ),
                                  array(
                                      '%s',
                                      '%s',
                                      '%s',
                                      '%s'
                                  )
                              );

        }//end else
              
      }//end of foreach
}//end of if


}//end of ffunction


function filemanager_frontcode( $atts ) {

  // Attributes
  extract( shortcode_atts(
    array(
      'foldername' => '',
      'groups' => '',
      'access' => '',
    ), $atts )
  );

  //return $foldername . " " . $groups . " " . $access;
  
  return shortcode_display($foldername, $groups, $access);

}//end of function
add_shortcode( 'filemanager', 'filemanager_frontcode' );


function shortcode_display($foldername, $groups, $access){
      $red_front_end = 1;

      $defaults = 0;
      $access_all = 0;
      if($foldername == ''){
        $defaults = 1;
      }elseif(trim($foldername) == '*'){
          $access_all = 1;
      }
      include "filemanager_string.php";
      return $fm_string;
}




//users column


add_filter('manage_users_columns', 'red_fm_users_column');
add_filter('manage_users_custom_column', 'red_fm_users_custom', 10, 3);

function red_fm_users_column($columns) {
        $columns['red_fm_folder'] = '<span style="color:brown;">File Manager</span>';
        return $columns;

}

function red_fm_users_custom($empty='', $column_name, $id) {
  if( $column_name == 'red_fm_folder' ) {
    return "<a href='admin.php?page=red_fm_manager_users&offset=0&action=view_folders&id=" . $id . "' >Folders</a>";

      }
}

//new register users get folders

add_action('user_register', 'filemanager5_registration_save');

function filemanager5_registration_save($user_id) 
{

  $allow_default_folders = get_option("red_fm_create_default_folders");

  if($allow_default_folders == 0){
    return;
  }

    global $wpdb;
    include "settings.php";
    $upload_dir = wp_upload_dir();
    $user = get_userdata($user_id);
    $newdir = str_replace("\\", "/", $upload_dir['basedir'].'/'.$user->user_login.'/');
    $newurl = str_replace("\\", "/", $upload_dir['baseurl'].'/'.$user->user_login.'/');
      $default_perm = get_option("red_fm_default_access");
    //$stringthis = $newdir."~".$newurl;
    
    if(!is_dir ($newdir))
    {
        mkdir($newdir, 0777);
    }


    $newdir = rtrim($newdir, "/");

  $query = "SELECT * FROM `" . $table_name . "` WHERE `folder` = '$newdir' AND `meta` = 'red_fm_default' ";
  $results = $wpdb->get_results($query);

        if( sizeof($results) == 0 ){


                          $wpdb->insert(
                                  $table_name,
                                  array(
                                          'folder' =>  $newdir,
                                          'type'   =>  $user->id,
                                          'access' =>  $default_perm,
                                          'meta'   =>   'red_fm_default'
                                  ),
                                  array(
                                      '%s',
                                      '%s',
                                      '%s',
                                      '%s'
                                  )
                              );

        }//end else
}
