<?php
	require_once("../../includes/dbconnect.php");
	session_start();
	if(isset($_POST['addWebsite'])){
		$stmt = $connection->prepare("Insert Into Websites (URL, Description, UserId) Values (?, ?, ?)");
		$stmt->bind_param("sss", $_POST['URL'], $_POST['Description'], $_POST['id']);
		$stmt->execute();
		$stmt->close();
	}elseif(isset($_POST['deleteWebsite'])){
		$stmt = $connection->prepare("Delete From Websites Where id = ?");
		$stmt->bind_param("i", $_POST['deleteWebsite']);
		$stmt->execute();
		$stmt->close();
	}else{
		$stmt = $connection->prepare("Update Users Set Email=?, Username=?, Description=?, Modified = ?, UserId = ? Where id = ?");
		$time = NULL;
		$stmt->bind_param("ssssii", $_POST['email'], $_POST['username'], $_POST['description'], $time,  $_SESSION['id'], $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['email'] = $_POST['email'];
	}
	header("Location: ../profile.php?id={$_SESSION['id']}");
?>