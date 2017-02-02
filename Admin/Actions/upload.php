<?php
session_start();
require_once("../../includes/permissons.php");
require_once("../../includes/dbconnect.php");
require_once("../../includes/functions.php");
$p = new Permissons($_SESSION["rank"], $connection);
$p->hasPermisson(['Admin']);
$target_dir = "../../images/";
$imageFileType = explode(".", $_FILES["file"]["name"])[1];
$target_file = $target_dir . "favicon." . $imageFileType;
$uploadOk = 1;
// Check if image file is a actual image or fake image
$check = getimagesize($_FILES["file"]["tmp_name"]);    
if($check !== false){
    $uploadOk = 1;        
}else{
	$reason = 0;
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "ico") {
    $reason = 1;
    $uploadOk = 0;
}
if ($uploadOk == 0){
	header("Location: ../settings.php?failed={$reason}");
}else{
	$file_pattern = $target_dir . "favicon.*";
	array_map( "unlink", glob( $file_pattern ) );
	if(isset($_POST['generator'])){
		if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
			$jsonTemplate = '{"favicon_generation": {"api_key": "a7f5c2c11140755fe99ad121417c9e94403a7ee7","master_picture": {"type": "url","url": "{{ url }}","demo": "false"},"files_location": {"type": "root"},"callback": {"type": "url","url": "{{ callback }}","short_url": "false","path_only": "false","custom_parameter": "ref=157539001"}}}';			
			$varibles = array();
			$domain = $_SERVER['HTTP_HOST'];
			$path = $_SERVER['SCRIPT_NAME'];
			$url = $domain . $path;
			$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
			$varibles['url'] = $protocol . rel2abs($target_dir, $url) . "favicon." . $imageFileType;;
			$varibles['callback'] = $protocol . rel2abs("../settings.php", $url);					
			foreach($varibles as $key => $value){
				$jsonTemplate = str_replace('{{ ' . $key . ' }}', $value, $jsonTemplate);
			}			
			header("Location: http://realfavicongenerator.net/api/favicon_generator?json_params=" . $jsonTemplate);
		}
	}else{
		$file_pattern = "../../" . "favicon.*";
		array_map( "unlink", glob( $file_pattern ) );
		if(move_uploaded_file($_FILES['file']['tmp_name'], "../../" . "favicon." . $imageFileType)){
			header("Location: ../settings.php");
		}else{
			$reason = 2;
			header("Location: ../settings.php?failed={$reason}");
		}
	}
}
?>