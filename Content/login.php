<?php
//    require("../includes/PasswordHash.php");
//    include("../includes/dbconnect.php");
//    //Setup
//    $hasher = new PasswordHash(8, false);
//    $stored_hash = "*";
//    //Get the hash of the user
//    echo("Hello");
//    if(isset($_POST['email']) and isset($_POST['password'])){
//        echo("Starting");
//        $stmt = $connection->prepare("Select Username, HashedPassword FROM Users");
//        echo("Hello");
////        $stmt->bind_param("s", $_POST['email']);
////        $stmt->execute()'
////        $stmt->bind_result($answer);
////        $stmt->fetch()
////        echo($answer);
//        //Check the pass provided agaisnt hash found
////        $password = $_POST['password'];
////        if(strlen($password > 72)){ die("Password must be 72 charaters or less");}
////        $check = $hasher->ChechPassword($password, $stored_hash);
////        if($check){
////            
////        }else{
////            
////        }
//    }
    session_start();
    include("../includes/PasswordHash.php");
    require_once("../includes/dbconnect.php");
    $hasher = new PasswordHash(8, false);
    //Get the username and password
    if (strlen($_POST['password']) > 72) { die("Password must be 72 characters or less"); }
    //Get user info
    $stmt = $connection->prepare("SELECT Username, HashedPassword FROM Users WHERE Email = ?");
    $stmt->bind_param("s", $_POST['email']);
    $stmt->execute();
    $stmt->bind_result($username, $password);
    $stmt->fetch();
    //Check passwords
    $check = $hasher->CheckPassword($_POST['password'], $password);
    if($check){
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $_POST['email'];
        header( 'Location: ../Admin/' );
    }else{
        echo("Incorrect username or password");
    }
    
//    $stmt->execute();
//    $stmt->bind_result($answer);
//    $stmt->fetch();
//    echo($answer);
?>
