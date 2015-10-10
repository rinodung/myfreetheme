<?php  
defined('ABSPATH') or die("Cannot access pages directly."); 
    global $wpdb;
    include 'settings.php';




	$langs = array(
					"LANG" 		=> "English",
					"de"		=> "German",
					"el"		=> "Greek",
					"ar"		=> "Arabic",
					"es"		=> "Spanish",
					"fa"		=> "Persian-Farsi",
					"bg"		=> "Bulgarian",
					"ca"		=> "Catalan",
					"da"		=> "Danish",
					"cs"		=> "Czech",
					"fr"		=> "French",
					"hu"		=> "Hungarian",
					"it"		=> "Italian",
					"jp"		=> "Japanese",
					"ko"		=> "Korean",
					"nl"		=> "Dutch",
					"no"		=> "Norwegian",
					"pl"		=> "Polish",
					"pt_BR"		=> "Brazilian Portuguese",
					"sk"		=> "Slovak",
					"sl"		=> "Slovenian",
					"sv"		=> "Swedish",
					"tr"		=> "Turkish",
					"vi"		=> "Vietnamese",
					"zh_CN"		=> "Simplified Chinese",
					"zh_TW"		=> "Traditional Chinese"
					);



	//form processing

	if( isset($_POST["action"]) ){
			if( $_POST["action"] == "save" ){

				$option_lang = $_POST["option_lang"];
				$option_view = $_POST["option_view"];
				$option_sync = $_POST["option_sync"];


				update_option( "red_fm_lang", $option_lang );
				update_option( "red_fm_view", $option_view );
				update_option( "red_fm_media_sync", $option_sync );

			}elseif( $_POST["action"] == "modify_defaults_permissions" ){//end if


					$modify_access = $_POST["option_access"];
					update_option( "red_fm_default_access", $modify_access );

                                $wpdb->update(
                                    $table_name,
                                    array(
                                    	
                                        'access' =>  $modify_access
                                    ),
                                    array( 'meta' => 'red_fm_default' ),
                                    array(
                                        '%s'
                                    ),
                                    array( '%s' )
                                );


			}elseif( $_POST["action"] == "modify_allow_default"  ){
					$post_allow_default = $_POST["option_allow_default"];
					update_option( "red_fm_create_default_folders", $post_allow_default);

			}//end elseif
	}//end if


    $lang = "LANG";
    if( get_option( "red_fm_lang" ) ) {
    	$lang = get_option( "red_fm_lang" );
	}

    $dview = "icons";
    if( get_option( "red_fm_view" ) ) {
    	$dview = get_option( "red_fm_view" );
	}


	//red_fm_media_sync
    $msync = "1";

	$msync = get_option( "red_fm_media_sync" );
	
?>

<H3>Filemanager Settings:</H3>
<form action="<?php echo admin_url("admin.php?page=red_fm_settings"); ?>" method="POST">
<table>
	<input type="hidden" name="action" value="save">
<tbody class="form-table">
	<tr>
		<td>Filemanager Language:</td>
		<td>
			    <select name="option_lang">

			    	<?php foreach($langs as $key=>$value){ ?>
			    		<?php 

			    			if($lang == $key){
			    				$sel = "selected";
			    			}else{
			    				$sel = "";
			    			}	
			    		?>
			    		<option value="<?php echo $key; ?>" <?php echo $sel; ?> ><?php echo $value; ?></option>
			    	<?php } ?>

			    </select>


		</td>
	</tr>

	<tr>
		<td>Default UI View:</td>

		<td>
		<select name="option_view">
			<option value="icons" <?php if($dview == "icons") echo "selected"; ?> >Icons</option>
			<option value="list" <?php if($dview == "list") echo "selected"; ?> >List</option>
		</select>
		
	</td>

	</tr>



	<tr>
		<td>Sync With Media Manager:</td>

		<td>
		<select name="option_sync">
			<option value="1" <?php if($msync == "1") echo "selected"; ?> >Enable</option>
			<option value="0" <?php if($msync == "0") echo "selected"; ?> >Disable</option>
		</select>
		<small style="color:green">Allows uploaded images to synchronize with WordPress Media Manager</small>
	</td>

	</tr>




	<tr>
		<td> <input type="submit" name="submit" value="Save" class="button button-primary menu-save"> </td>
	</tr>

</tbody>	


</form>





</table>

<br>
<hr>
<br/>

<h3>Modify Default Folders Permissions:</h3>




    <form action="<?php echo admin_url("admin.php?page=red_fm_settings"); ?>" method="POST">
            <input type="hidden" name="action" value="modify_defaults_permissions">
                <select name="option_access">
                	<?php  
                		$default_perm = get_option("red_fm_default_access");

                	?>

                    <option value="r" <?php if($default_perm == "r") echo "selected"; ?>>Read</option>
                    <option value="rw" <?php if($default_perm == "rw") echo "selected"; ?>>Read/Write</option>



                </select>
             <input type="submit" name="submit" value="Change" class="button button-primary menu-save">   
    </form>

    <small style="color:green">Sets Permissions For The Default Folders For All Users.</small>

<br><br>
<hr>


<h3>Allow Default Folders For Registered Users:</h3>

    <form action="<?php echo admin_url("admin.php?page=red_fm_settings"); ?>" method="POST">
            <input type="hidden" name="action" value="modify_allow_default">
                <select name="option_allow_default">
                	<?php  
                		$allow_default_folders = get_option("red_fm_create_default_folders");

                	?>

                    <option value="1" <?php if($allow_default_folders == "1") echo "selected"; ?>>Enable</option>
                    <option value="0" <?php if($allow_default_folders == "0") echo "selected"; ?>>Disable</option>



                </select>
             <input type="submit" name="submit" value="Change" class="button button-primary menu-save">   
    </form>

    <small style="color:green">Filemanager Adds Folder For Each Registered User, You can Disable This Behavior Here.</small>