<?php
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$p->hasPermisson(['Admin']);
	$stmt = $connection->prepare("UPDATE Settings SET Title = ?, Description = ?, Header=? WHERE 1 = 1");
	$stmt->bind_param("sss", $_POST['Title'], $_POST['Description'], $_POST['Header']);
	$stmt->execute();
	if(!$stmt->execute()){
		trigger_error("there was an error....".$connection->error, E_USER_WARNING);
	}
	header("Location: ../settings.php");
?>	