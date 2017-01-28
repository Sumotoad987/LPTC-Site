<?php
	session_start();
	$_SESSION["username"] = "";
    $_SESSION["email"] = "";
    $_SESSION['rank'] = "";
    header("Location: ../index.php")
?>