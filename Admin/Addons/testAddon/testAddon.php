<?php
	
	$api = new api();
	$api->add_action("getTitle", function(){
		//This is a function so the varible we are truing to edit is outside the function so we need to say that it is that varible we want
		global $title;
		$title = "Hello Tom";
	});
	
?>