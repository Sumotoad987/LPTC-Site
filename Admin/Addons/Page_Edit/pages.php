<?php

	$api = new api();

	//Get the pages this user is allowed to acces
	function allowedPages(){
		global $connection;
		$allowedPagesStmt = $connection->prepare("Select Pages From Page_Edit Where rankId = ?");
		$allowedPagesStmt->bind_param('i', $_SESSION['rank']);
		$allowedPagesStmt->execute();
		$allowedPagesStmt->bind_result($pages);
		$allowedPagesStmt->fetch();
		$allowedPagesStmt->close();
		return $pages;
	}
	
	//Makes it not show pages which the user cannot access
	$api->add_action("Pages_Select", function(){
		global $sql;
		$pages = allowedPages();
		if($pages != NULL){
			//Convert those pages into the porper format
			$array=array_map('intval', explode(',', $pages));
			$array = implode("','",$array);
			//Change the sql query
			$sql = "Select id, Name, Modified, Parent From Pages WHERE id IN ('$array')";
		}
	});
	
	//Redirects user if they try to access a page they are not allowed
	$api->add_action("isAllowed", function(){
		global $api;
		$pages = explode(",", allowedPages());
		if(isset($_GET['id'])){
			if(!in_array($_GET['id'], $pages)){
				$api->accessDenied();
			}
		}
	});	
	
	$api->add_action("createdPage", function(){
		global $id;
		global $connection;
		$pages = allowedPages();
		$pages .= ',' . (string)$id;
		var_dump($pages);
		$stmt = $connection->prepare("UPDATE Page_Edit Set Pages = ? Where rankId = ?");
		$stmt->bind_param("si", $pages, $_SESSION['rank']);
		$stmt->execute();
		$stmt->close();
	});
?>