<?php
	session_start();
    if(isset($_SESSION["username"]) == FALSE){
        header("Location: ../");
    }
    $type = "post";
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	if(isset($_POST['Delete'])){
		$p->hasPermisson(['Post_Delete']);
		$stmt = $connection->prepare("Select Name From Posts Where id = ?");
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->bind_result($name);
		$stmt->fetch();
		$stmt->close();
		$stmt = $connection->prepare('Delete From Posts Where id = ?');
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->close();
		$action = "deleted";
		insertActivity($connection, $name, $_SESSION['id'], NULL, $type, $action);
		header("Location: ../posts.php");
	}else{
		$title = $_POST['Title'];
		$content = $_POST['Content'];
		$tags = $_POST['tags'];
		$time = NULL;
		if(isset($_POST['id'])){
			$p->hasPermisson(['Post_Edit']);
			$int = (int)$_POST['id'];
			$stmt = $connection->prepare("UPDATE Posts SET Name=?, content=?, UserId=?, Tags=?, Modified=? WHERE id = ?");
			$stmt->bind_param("ssissi", $title, $content, $_SESSION['id'] ,$tags, $time, $int);
			$action = "modified";
			insertActivity($connection, $title, $_SESSION['id'], $int, $type, $action);
		}else{
			$p->hasPermisson(['Post_Create']);
			$stmt = $connection->prepare('INSERT INTO Posts (Name, content, UserId, Tags, Created, Modified) Values (?, ?, ?, ?, ?, ?)');
			$stmt->bind_param("ssisss", $title, $content, $_SESSION["id"], $tags, $time, $time);	
			$action = "created";
			insertActivity($connection, $title, $_SESSION['id'], $int, $type, $action);
		}
		$stmt->execute();
		$URL="../posts.php";
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
		echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
	}
?>