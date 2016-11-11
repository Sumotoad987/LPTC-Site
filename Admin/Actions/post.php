<?php
	session_start();
    if(isset($_SESSION["username"]) == FALSE){
        header("Location: ../");
    }
	require_once("../../includes/dbconnect.php");
	$title = $_POST['Title'];
	$content = $_POST['Content'];
	$tags = $_POST['tags'];
	if(isset($_POST['id'])){
		$int = (int)$_POST['id'];
		$stmt = $connection->prepare("UPDATE Posts SET title=?, content=?, Tags=? WHERE id = ?");
		$stmt->bind_param("sssi", $title, $content, $tags, $int);
	}else{
		$stmt = $connection->prepare('INSERT INTO Posts (title, content, username, Tags) Values (?, ?, ?, ?) ON DUPLICATE KEY UPDATE');
		$stmt->bind_param("ssss", $title, $content, $_SESSION["username"], $tags);	
	}
	$stmt->execute();
	$URL="../posts.php";
	echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
	echo "<script type='text/javascript'>document.location.href='{$URL}';</script>"
?>