<?php
session_start();
if(isset($_SESSION["username"]) == TRUE){
   	require_once("../../includes/random_compat/lib/random.php");
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$p->hasPermisson(["User_Invite"]);
	function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$&*:;'){
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}
	$stmt = $connection->prepare("INSERT INTO Users (Email, Rank, AuthCode, Created, Modified, UserId) Values (?, ?, ?, ?, ?, ?)");
	$authCode = random_str("50");
	$time = NULL;
	$stmt->bind_param("sssssi", $_POST["email"], $_POST['rank'], $authCode, $time, $time, $_SESSION['id']);
	if(!$stmt->execute()){
		trigger_error("there was an error....".$connection->error, E_USER_WARNING);
	}
	$id = $connection->insert_id;
	$type = "user";
	$action = "invited";		
	insertActivity($connection, $_POST['email'], $_SESSION['id'], intval($id), $type, $action);
	header("Location: ../users.php");
}
 header("Location: ../users.php");
?>