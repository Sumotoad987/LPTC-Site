<?php
	session_start();
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$type = "user";
	if(isset($_POST['Delete'])){
		$p->hasPermisson(["User_Delete"]);
		$stmt = $connection->prepare("Delete From Users Where id = ?");
		$stmt->bind_param('i', $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$action="deleted";
		$name = isset($_POST['username']) ? $_POST['email'] : $_POST['username'];
		insertActivity($connection, $name, $_SESSION['id'], NULL, $type, $action);
	}else{
		$p->hasPermisson(["User_Edit"]);
		$time = NULL;
		$stmt = $connection->prepare("UPDATE Users Set Email=?, Username=?, Rank=?, Modified = ?, UserId = ? Where id=?");
		$stmt->bind_param("ssssii", $_POST['email'], $_POST['username'], $_POST['rank'], $time, $_SESSION['id'], $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$id = $connection->insert_id;
		$action = "edited";
		insertActivity($connection, $_POST['username'], $_SESSION['id'], intval($id), $type, $action);
	}
	header("Location: ../users.php")
?>