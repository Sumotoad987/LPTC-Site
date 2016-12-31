<?php
	require_once("../../includes/dbconnect.php");
	$stmt = $connection->prepare("UPDATE Users Set Email=?, Username=?, Rank=? Where id=?");
	$stmt->bind_param("sssi", $_POST['email'], $_POST['username'], $_POST['rank'], $_POST['id']);
	$stmt->execute();
	$stmt->close();
	header("Location: ../users.php")
?>