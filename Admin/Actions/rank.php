<?php
	session_start();
    if(isset($_SESSION["username"]) == FALSE){
        header("Location: ../login.html");
    }
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$type = "rank";
	if(isset($_POST['Delete'])){
		$p->hasPermisson(['Rank_Delete']);
		$stmt = $connection->prepare("Select Name From Ranks Where id = ?");
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->bind_result($name);
		$stmt->fetch();
		$stmt->close();
		$stmt = $connection->prepare("Delete From Ranks Where id = ?");
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->close();
		$action="deleted";
		insertActivity($connection, $name, $_SESSION['id'], NULL, $type, $action);
		header("Location: ../ranks.php");
	}else{
		$p->hasPermisson(['Rank_Create', 'Rank_Edit']);
		$time = NULL;
		$premissons = implode(',', $_POST['Premissons']);
		$stmt = $connection->prepare("INSERT INTO Ranks (Id, Name, Premissons, Modified, Created, UserId) Values (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE Name=Values(Name), Premissons=Values(Premissons), Modified=Values(Modified), UserId=Values(UserId)");
		$stmt->bind_param("issssi", $_POST['Id'], $_POST['Name'], $premissons, $time, $time, $_SESSION['id']);
		$stmt->execute();
		$action = $_POST['Id'] == "" ? "created" : "modified";
		$id = $connection->insert_id;
		insertActivity($connection, $_POST['Name'], $_SESSION['id'], intval($id), $type, $action);
		header("Location: ../ranks.php");
	}
?>