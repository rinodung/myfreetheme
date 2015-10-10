<?php  
defined('ABSPATH') or die("Cannot access pages directly."); 

?>

<style type="text/css">
.red_pag_button a{
	text-decoration: none;
	margin-right: 10px;
}
</style>

<?php
    global $wpdb;
    include( plugin_dir_path( __FILE__ ) . 'settings.php');

//form submits:


//add folder
if( isset($_POST["add_folder"]) ){

$addfolder_folder = esc_sql( base64_decode( $_POST["option_folder"] ) );
$addfolder_access = esc_sql( $_POST["option_access"] );
$addfolder_id = esc_sql( $_GET["id"] );

    
    $query = "SELECT * FROM `" . $table_name . "` WHERE `folder` = '$addfolder_folder' AND `type` = '$addfolder_id' ";
    $results = $wpdb->get_results($query);

    if( sizeof($results) > 0){

                $wpdb->update(
                    $table_name,
                    array(
                        'folder' => $addfolder_folder,
                        'type'   =>  $addfolder_id,
                        'access' =>  $addfolder_access  
                    ),
                    array( 'folder' => $addfolder_folder, 'type'   =>  $addfolder_id ),
                    array(
                        '%s',   
                        '%s',
                        '%s'
                    ),
                    array( '%s', '%s' )
                );


    }else{

                    $wpdb->insert(
                            $table_name,
                            array(
                                'folder' => $addfolder_folder,
                                'type'   =>  $addfolder_id,
                                'access' =>  $addfolder_access,
                                'meta'   => ''
                            ),
                            array(
                                '%s',
                                '%s',
                                '%s',
                                '%s'
                            )
                        );


    }//end of else


}
//end of add folder


//delete folder
if( isset($_GET["perform"]) ){

$delfolder_folder = esc_sql( base64_decode( $_GET["folder_delete"] ) );
$delfolder_id = esc_sql( $_GET["id"] );

    $query = "DELETE FROM `" . $table_name . "` WHERE `folder` = '$delfolder_folder' AND `type` = '$delfolder_id' ";
    $wpdb->query($query);

}
//end of delete folder

//users pagination

	$users_offset = 0;
	$users_limit = 10;

	$pag_next = $users_offset;
	$page_prev = 0;

	if( isset($_GET["offset"]) ){
		$users_offset = $_GET["offset"];
		$pag_next = $users_offset + $users_limit;
		$page_prev = $users_offset - $users_limit;

		if($page_prev < 0){
			$page_prev = 0;
		}

	}else{

		$pag_next = $users_offset + $users_limit;
		$page_prev = $users_offset - $users_limit;

		if($page_prev < 0){
			$page_prev = 0;
		}

	}


    $blogusers = get_users("offset=$users_offset&number=$users_limit");
    $total = count_users(); 
    $total_users = $total['total_users'];

    $total_this = $users_offset * $users_limit;

    $isnext = 0;


    if( $total_this < $total_users ){
    	$isnext = 1;
    }

    if($total_users < $users_limit){
        $isnext = 0;
    }
?>

<h2> Users </h2>

<div class="red_pag_button">

<?php if( $users_offset != 0 ) { ?>	 <a href="<?php echo admin_url("admin.php?page=red_fm_manager_users&offset=$page_prev"); ?>">&#8592; Prev</a>  <?php } ?>
<?php if($isnext == 1){ ?> 	<a href="<?php echo admin_url("admin.php?page=red_fm_manager_users&offset=$pag_next"); ?>">Next &#8594; </a> <?php } ?>
	
</div>

<table class="widefat">
<thead>
    <tr style="background-color:#F5F5F5;">
    	<th>User</th>
        <th>Role</th>
        <th>Folders</th>      
    </tr>
</thead>
<tfoot>
    <tr style="background-color:#F5F5F5;">
    	<th>User</th>
        <th>Role</th>
        <th>Folders</th>      

    </tr>
</tfoot>
<tbody>
    

    <?php foreach($blogusers as $key=>$value) { ?>
    <?php  
    	$usrdata = get_userdata( $value->ID );
    	
    ?>
     <tr>
     <td><?php echo $value->user_nicename ?></td>
     <td> <?php echo $usrdata->roles[0]; ?> </td>
     <td><a href="<?php echo admin_url("admin.php?page=red_fm_manager_users&offset=$users_offset&action=view_folders&id=$value->ID"); ?>">Folders</a></td>

     </tr>

     <?php } ?>

   
</tbody>
</table>



<?php if( isset( $_GET["action"] ) ){ ?>
    <?php if($_GET["action"] == "view_folders"){ ?>
        <?php
             $id=0;
             $id= esc_sql( $_GET["id"] );

             $query = "SELECT * FROM `" . $table_name . "` WHERE `type` = '$id' ";

             $allow_default_folders = get_option("red_fm_create_default_folders");

             if($allow_default_folders == "0"){
                    $query = "SELECT * FROM `" . $table_name . "` WHERE `type` = '$id' AND `meta` <> 'red_fm_default' ";
             }

             $results = $wpdb->get_results($query);
 
            $usrdata = get_userdata( $id );
        
        ?>




<hr>

<br/>

<h3> <?php echo $usrdata->user_nicename ?>'s Folders:  </h3>

<table class="widefat">
<thead>
    <tr style="background-color:#F5F5F5;">
        <th>Folder</th>
        <th>Access</th>
        <th>Action</th>      
    </tr>
</thead>
<tfoot>
    <tr style="background-color:#F5F5F5;">
        <th>Folder</th>
        <th>Access</th>
        <th>Action</th> 
    </tr>
</tfoot>
<tbody>
    

    <?php foreach($results as $key=>$value){ ?>
         <tr>
             <td><?php echo red_getFolderName( $value->folder, $directory_temp); ?></td>
             <td> <?php echo red_defineAccess( $value->access ); ?> </td>
             <td><a href="<?php echo admin_url("admin.php?page=red_fm_manager_users&offset=$users_offset&action=view_folders&id=$id&perform=delete&folder_delete=". base64_encode($value->folder) ); ?>">Delete</a></td>
         </tr>
     <?php } ?>

   
</tbody>
</table>

<br/>

<h3>Add/Edit Folder:</h3>
<form action="<?php echo admin_url("admin.php?page=red_fm_manager_users&offset=$users_offset&action=view_folders&id=$id"); ?>" method="POST">
        
        <input type="hidden" name="add_folder" value="1">
        <select name="option_folder">

        <?php foreach($directory_names as $key=>$value){ ?>

        <option value="<?php echo base64_encode($directory_list[$key]); ?>"><?php echo $value; ?></option>  

        <?php } ?>

    </select>

    <select name="option_access">
        <option value="r">Read</option>
        <option value="rw">Read/Write</option>
    </select>

    <input type="submit" class="button button-primary menu-save" value="Add Folder">

</form>




    <?php } ?> <!-- if $_GET .. view folders -->

<?php } ?>    <!-- isset action -->