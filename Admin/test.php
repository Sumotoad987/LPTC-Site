<?php
	session_start();
	
	//Include all the addons
	include("../includes/addon_manager.php");
	include("../includes/addon_api.php");
	
	$manager = new Manager();
	$manager->loadAddons();
	
	// $content = $manager->includeIfNeeded();
// 	var_dump($content);
// 	foreach($content as $addon){
// 		var_dump($addon);
// 	}
	
	$title = "Hello";
	
	$api = new api();
	$api->do_actions("getTitle");
	
	echo("<h1>" . $title . "</h1>");
	
?>