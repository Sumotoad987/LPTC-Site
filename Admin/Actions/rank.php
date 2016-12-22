<?php
	session_start();
    if(isset($_SESSION["username"]) == FALSE){
        header("Location: ../login.html");
    }
	require_once("../../includes/dbconnect.php");
	$premissons = implode(',', $_POST['Premissons']);
	$stmt = $connection->prepare("INSERT INTO Ranks (`Id`, `Name`, `Premissons`) Values (?, ?, ?) ON DUPLICATE KEY UPDATE `Name`=Values(`Name`), `Premissons`=Values(`Premissons`)");
	$stmt->bind_param("iss", $_POST['Id'], $_POST['Name'], $premissons);
	$stmt->execute();
	header("Location: ../ranks.php")
?>