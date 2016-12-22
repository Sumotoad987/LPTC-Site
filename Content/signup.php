<?php
	require_once("../includes/dbconnect.php");
	if($_POST['authCode'] == NULL){
		header("Location: ../index.html");
	}
	$stmt=$connection->prepare("Select AuthCode from Users WHERE AuthCode = ?");
	$stmt->bind_param("s", $_POST['authCode']);
	$stmt->execute();
	$stmt->bind_result($authCode);
	$stmt->fetch();
	$stmt->close();
	if($authCode == ""){
		header("Location: ../index.html");
		exit();
	}
    include("../includes/PasswordHash.php");
    $hasher = new PasswordHash(8, false);
    if (strlen($password) > 72) { die("Password must be 72 characters or less"); }
    // The $hash variable will contain the hash of the password
    $hash = $hasher->HashPassword($_POST['password']);
    if (strlen($hash) >= 20) {
       	$stmt=$connection->prepare("Update Users Set Username = ?, HashedPassword = ?, AuthCode = NULL WHERE AuthCode = ?");
       	$stmt->bind_param("sss", $_POST['username'], $hash, $_POST['authCode']);
       	$stmt->execute();
       	$stmt->close();
       	header("Location: ../Admin/");
       	exit();
    } else {
        echo("Sorry please try that again"); 
    }
?>
