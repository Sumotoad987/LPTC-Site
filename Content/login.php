<?php

    session_start();
    include("../includes/PasswordHash.php");
    require_once("../includes/dbconnect.php");
    $hasher = new PasswordHash(8, false);
    //Get the username and password
    if (strlen($_POST['password']) > 72) { die("Password must be 72 characters or less"); }
    //Get user info
    $stmt = $connection->prepare("SELECT id, Username, HashedPassword, Rank FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $stmt->bind_result($id, $username, $password, $rank);
    $stmt->fetch();
    $stmt->close();
    //Check passwords
    $check = $hasher->CheckPassword($_POST['password'], $password);
    if($check){
    	//Check if there rank is enabled
    	$stmt = $connection->prepare("Select Enabled From Ranks Where id = ?");
    	echo($connection->error);
    	$stmt->bind_param("i", $rank);
    	$stmt->execute();
    	$stmt->bind_result($enabled);
    	$stmt->fetch();
    	$stmt->close();
    	//Set the session varibles
    	$_SESSION['id'] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $_POST['email'];
        $_SESSION['rank'] = $rank;
        $_SESSION['enabled'] = $enabled;
        header( 'Location: ../Admin/' );
    }else{
        header('Location: ../login.php?denied');
    }
?>
