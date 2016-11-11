<?php
session_start();
if(isset($_SESSION["username"]) == FALSE){
    header("Location: ../");
}
require_once("../../includes/random_compat/lib/random.php");
require_once("../../includes/dbconnect.php");
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$&*:;'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
$stmt = $connection->prepare("INSERT INTO Users (Email, Rank, AuthCode) Values (?, ?, ?)");
$authCode = random_str("50");
echo($authCode);
echo($_POST["email"]);
echo($_SESSION["username"]);
$stmt->bind_param("sss", $_POST["email"], $_POST['rank'], $authCode);
if(!$stmt->execute()){
	trigger_error("there was an error....".$connection->error, E_USER_WARNING);
}
?>