<?php  
defined('ABSPATH') or die("Cannot access pages directly."); 


define('FILE_LEVELS', 3);
define('PLUGIN_URL', plugins_url( '/', __FILE__ ) );
$table_name = $wpdb->prefix . "red_file_manager";


//$directory = substr(ABSPATH, 0, (strlen(ABSPATH)-1));

//$directory = get_home_path();
if(!defined('ABSPATH')){
    $directory = red_get_wp_path();
    $directory = str_replace('\\', '/', $directory);
}else{
    $directory = ABSPATH;
    $directory = str_replace('\\', '/', $directory);
}

if($directory == "//"){
    $directory = "/";
}

$directory_temp = $directory;
//echo $directory;
$directory = rtrim($directory, "/");
$directory = rtrim($directory, "\\");

$levels = FILE_LEVELS;


function listdirs($dir, $init, $levels) {
    $init++;
    static $alldirs = array();
    $dirs = glob($dir . '/*', GLOB_ONLYDIR);


    if (count($dirs) > 0) {
        foreach ($dirs as $d) $alldirs[] = $d;
    }
    foreach ($dirs as $dir){
        if($init < $levels){
                listdirs($dir, $init, $levels);
        }
        
    }
   //print_r($alldirs);
    return $alldirs;
}


$directory_list = listdirs($directory, 0, $levels);
//$directory_list[0] = $directory;
//print_r($directory_list);
$directory_names = array();
//print_r($directory_list);

foreach($directory_list as $key => $value){
   //$directory_names[] =  ltrim($value, $directory);

    $prefix = $directory_temp;
    $str = $value;


    if (substr($str, 0, strlen($prefix)) == $prefix) {
        $directory_names[] = substr($str, strlen($prefix));
    } 

}

//print_r($directory_names);


function red_getFolderName($str, $prefix){
    return  substr($str, strlen($prefix));
}

function red_defineAccess($str){
    if($str == "r"){
        return "Read";
    }elseif($str == "rw"){
        return "Read/Write";
    }
}



function red_get_wp_path()
{
    $base = dirname(__FILE__);
    $path = false;

    if (@file_exists(dirname(dirname($base))."/wp-config.php"))
    {
        $path = dirname(dirname($base))."/";
    }
    else
    if (@file_exists(dirname(dirname(dirname($base)))."/wp-config.php"))
    {
        $path = dirname(dirname(dirname($base)))."/";
    }
    else
    $path = false;

    if ($path != false)
    {
        $path = str_replace("\\", "/", $path);
    }
    return $path;
}



?>