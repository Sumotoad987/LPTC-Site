<?php
	require_once("../../includes/dbconnect.php");
	$stmt = $connection->prepare("UPDATE Settings SET Title = ?, Description = ? WHERE 1 = 1");
	$stmt->bind_param("ss", $_POST['Title'], $_POST['Description']);
	$stmt->execute();
	if(!$stmt->execute()){
		trigger_error("there was an error....".$connection->error, E_USER_WARNING);
	}
	header("Location: ../settings.php");
?>	