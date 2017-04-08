<?php
session_start();
require_once("../../includes/random_compat/lib/random.php");
require_once("../../includes/dbconnect.php");
require_once("../../includes/functions.php");
require_once("../../includes/permissons.php");
$p = new Permissons($_SESSION["rank"], $connection);
$p->hasPermisson(["User_Invite"]);
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$str .= $keyspace[random_int(0, $max)];
	}
	return $str;
}
//Insert user
$authorized = areAuthorized($_SESSION['rank'], $_POST['rank'], $connection);
$requestedRank = NULL;
if($authorized == False){
	$requestedRank = $_POST['rank'];
	$_POST['rank'] = NULL;
}
$stmt = $connection->prepare("INSERT INTO Users (Email, Rank, AuthCode, Created, Modified, UserId, RequestedRank) Values (?, ?, ?, ?, ?, ?, ?)");
$authCode = random_str("50");
$time = NULL;
$stmt->bind_param("sssssii", $_POST["email"], $_POST['rank'], $authCode, $time, $time, $_SESSION['id'], $requestedRank);
if(!$stmt->execute()){
	trigger_error("there was an error....".$connection->error, E_USER_WARNING);
}
$stmt->close();
$id = $connection->insert_id;
$type = "user";
$action = "invited";		
insertActivity($connection, $_POST['email'], $_SESSION['id'], intval($id), $type, $action);
//-------------------Send email
//Get site varibles
///Username
$stmt = $connection->prepare("Select Username From Users Where UserId = ?");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();
///Sitename
$sql = ("Select Title From Settings");
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$title = $row['Title'];
//Setup email varibles
$varibles = array();
$varibles['SiteName'] = $title;
$varibles['User'] = $username;
$varibles['Rank'] = $_POST['rank'];
$varibles['url'] = getenv('HTTP_HOST');
$varibles['message'] = $_POST['message'];
$varibles['authUrl'] = "http://{$varibles['url']}/signup.php?authCode={$authCode}";
//Setup email content
$template = file_get_contents("../../Content/email.html");
foreach($varibles as $key => $value){
	$template = str_replace('{{ ' . $key . ' }}', $value, $template);
}
//Send email
$subject = "You have been invited to join {$varibles['SiteName']}";
$headers = "From:  noreply@{$varibles['url']}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
if($authorized == True){
	mail($_POST["email"], $subject, $template, $headers); 
}else{
	$stmt = $connection->prepare("Insert Into Email (Subject, Message, Headers, ReceiverId) Values (?, ?, ?, ?)");
	echo($connection->error);
	$stmt->bind_param("sssi", $subject, $template, $headers, $id);
	$stmt->execute();
	$stmt->close();
}
header("Location: ../users.php");
?>