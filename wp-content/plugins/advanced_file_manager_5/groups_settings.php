<?php 

defined('ABSPATH') or die("Cannot access pages directly."); 
    

    global $wpdb;
    include( plugin_dir_path( __FILE__ ) . 'settings.php');
	global $wp_roles;
    $red_roles = $wp_roles->get_names();
    $view = "0";


     $red_users_args = array('role'=>'Administrator');
     $red_admins = get_users( $red_users_args );


//actions processing

    if( isset($_POST["action"]) ){

            if($_POST["action"] == "add_folder"){
                $option_role   = base64_decode( $_POST["option_role"] );
                $option_access = $_POST["option_access"];
                $option_folder = base64_decode( $_POST["option_folder"] );


                
                $query = "SELECT * FROM `" . $table_name . "` WHERE `folder` = '$option_folder' AND `type` = '$option_role' ";
                    
                
                    
                $results = $wpdb->get_results($query);

                //already exists
                if( sizeof($results) > 0 ){

                   

                                $wpdb->update(
                                    $table_name,
                                    array(
                                        'folder' => $option_folder,
                                        'type'   =>  $option_role,
                                        'access' =>  $option_access  
                                    ),
                                    array( 'folder' => $option_folder, 'type'   =>  $option_role ),
                                    array(
                                        '%s',   
                                        '%s',
                                        '%s'
                                    ),
                                    array( '%s' )
                                );

                    


                }else{
                    //folder not already assigned
                    //insert into table

                    $wpdb->insert(
                            $table_name,
                            array(
                                'folder' => $option_folder,
                                'type'   => $option_role,
                                'access' => $option_access,
                                'meta'   => ''
                            ),
                            array(
                                '%s',
                                '%s',
                                '%s',
                                '%s'
                            )
                        );



                }//end else

               // wp_redirect( admin_url("admin.php?page=red_fm_groups&action=edit&group=1") );

                ?>
                        <script type="text/javascript">
                         <?php $tempgrp = $_POST["option_role"]; ?>
                         window.location = '<?php echo admin_url("admin.php?page=red_fm_groups&action=edit&group=$tempgrp") ?>';
                        </script>

                <?php


            }


    }// end of if( isset($_POST["action"]) ){ 


//pages

            if($_GET["action"] == "edit"){ 

                                //action
                if( isset($_GET["perform"]) ){
                    if($_GET["perform"] == "delete" ){
                            $del_grp = base64_decode( $_GET["group"] );
                            $del_fldr = base64_decode( $_GET["folder"] );



                            $query = "DELETE FROM `" . $table_name . "` WHERE `folder` = '$del_fldr' AND  `type` = '$del_grp' " ;
                            
                            $wpdb->query($query);

                    }
                }


                $view = base64_decode( $_GET["group"] );

                

                $query = "SELECT * FROM `" . $table_name . "` WHERE `type` = '$view' ";
                 
                $group_folders_results = $wpdb->get_results($query);




            }//ends if($_GET["action"])







?>



<h2>Group Folders</h2>
<table class="widefat">
<thead>
    <tr style="background-color:#F5F5F5;">
        <th>Group</th>
        <th>Folders</th>      
       <!-- <th>Action</th> -->
    </tr>
</thead>
<tfoot>
    <tr style="background-color:#F5F5F5;">
        <th>Group</th>
        <th>Folders</th>      
       <!-- <th>Action</th> -->
    </tr>
</tfoot>
<tbody>
   

    <?php foreach($red_roles as $key=>$value) { ?>
        <?php $group_hash = base64_encode($value); ?>
     <tr>
     <td><?php echo $value; ?></td>
     <td><a href="<?php echo admin_url("admin.php?page=red_fm_groups&action=edit&group={$group_hash}"); ?>"><?php echo 'Show Folders'; ?></a></td>
     <!--<td><a href="#">Edit</a></td>-->
     </tr>

     <?php } ?>

   
</tbody>
</table>

<hr>





<!-- Groups Folders Table -->
<?php if($view != "0"){ ?>



<h2> <?php echo $view; ?>'s Folders</h2>

<table class="widefat">
<thead>
    <tr style="background-color:#F5F5F5;">
        <th>Folder</th>
        <th>Access</th>      
        <th>Actions</th>
    </tr>
</thead>
<tfoot>
    <tr style="background-color:#F5F5F5;">
        <th>Folder</th>
        <th>Folders</th>      
        <th>Actions</th>
    </tr>
</tfoot>
<tbody>
    
    <?php 
        $group_hash = base64_encode( $view ); 
    ?>
    <?php foreach($group_folders_results as $key=>$value) { ?>
        <?php $folder_hash = base64_encode($value->folder); ?>
     <tr>
     <td><?php echo red_getFolderName( $value->folder, $directory_temp); ?></td>
     <td> <?php echo red_defineAccess( $value->access ); ?> </td>
     <td><a href="<?php echo admin_url("admin.php?page=red_fm_groups&action=edit&perform=delete&group={$group_hash}&folder={$folder_hash}"); ?>">Delete</a></td>
     </tr>

     <?php } ?>

   
</tbody>
</table>




<?php } ?>







<hr>


<?php if($view != "0"){ ?>
<h2>Add Folder</h2>

<form action="<?php echo admin_url("admin.php?page=red_fm_groups"); ?>" method="POST">
    <input type="hidden" name="action" value="add_folder">
    <select name="option_role">
        <?php foreach($red_roles as $key=>$value) { ?>

            <?php if( $view == $value ) {?>
            <option value="<?php echo base64_encode($value); ?>"> <?php echo $value; ?> </option>
            <?php } ?>

        <?php } ?>
    </select>

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
<?php } ?>


