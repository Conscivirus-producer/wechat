<?php
/**
 * This is just an example of how a file could be processed from the
 * upload script. It should be tailored to your own requirements.
 */

// Only accept files with these extensions
$openid = "";
$success = true;
$error     = 'No file uploaded.';
if($_POST){
	$openid = $_POST["openid"];
	$uploadType = $_POST["type"];
	$count = $_POST["count"];
	if($_FILES["file"]["error"] > 0){
        //echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        $success = false;
    }else{
    	$fileName = $_FILES["file"]["name"];
    	$type = $_FILES["file"]["type"];
    	$error    = $_FILES['file']['error'];
    	$name     = basename($fileName);
    	$extension = pathinfo($name, PATHINFO_EXTENSION);
        //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        //echo "Type: " . $_FILES["file"]["type"] . "<br />";
        //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
        if (file_exists("upload/" . $_FILES["file"]["name"])){
            //echo $_FILES["file"]["name"] . " already exists. ";
            $success = false;
        }else{
        	if($uploadType == "image"){
            	if(!move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $openid . "_headimage".".".$extension)){ 
     				//echo '移动文件失败！';
     				$success = false;   
    			}
    		}else if($uploadType == "certificate"){
    			if(!move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $openid . "_certificate_".$count.".".$extension)){ 
     				//echo '移动文件失败！';
     				$success = false;   
    			}
    		}  
            //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }
    }
}

echo json_encode(array(
	'name'  => $name,
	'error' => $error,
));
die();
