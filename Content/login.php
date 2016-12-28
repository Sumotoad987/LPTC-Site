<?php

    session_start();
    include("../includes/PasswordHash.php");
    require_once("../includes/dbconnect.php");
    $hasher = new PasswordHash(8, false);
    //Get the username and password
    if (strlen($_POST['password']) > 72) { die("Password must be 72 characters or less"); }
    //Get user info
    $stmt = $connection->prepare("SELECT Username, HashedPassword, Rank FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $stmt->bind_result($username, $password, $rank);
    $stmt->fetch();
    //Check passwords
    $check = $hasher->CheckPassword($_POST['password'], $password);
    if($check){
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $_POST['email'];
        $_SESSION['rank'] = $rank;
        header( 'Location: ../Admin/' );
    }else{
        echo("Incorrect username or password");
    }
    
//    $stmt->execute();
//    $stmt->bind_result($answer);
//    $stmt->fetch();
//    echo($answer);
?>
