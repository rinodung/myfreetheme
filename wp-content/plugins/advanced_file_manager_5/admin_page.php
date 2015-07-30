<?php 
	error_reporting(0);
	defined('ABSPATH') or die("Cannot access pages directly."); 


	global $wpdb;

	include( plugin_dir_path( __FILE__ ) . 'settings.php');


	 $red_current_user = wp_get_current_user();
	 $red_current_id = $red_current_user->ID;
	 $red_fm_role = $red_current_user->roles[0];

	 //get users folders
	 $query = "SELECT * FROM `" . $table_name . "` WHERE `type` = '$red_current_id' OR `type` = '$red_fm_role'";
	 $results = $wpdb->get_results($query);
	 
	 //both are empty
	 
	 
	 if( sizeof($results) == 0){
	 	echo "<h3>No Folders Have been Assigned to you.</h3>";
	 	exit();
	 }
	 include "filemanager_string.php";
	 echo $fm_string;
 ?>