<?php
	session_start();
	if($_POST['template'] != "None"){
		$loc = "../../Content/templates/{$_POST['template']}";
		$template = file_get_contents($loc);
		$varibles = array();
		$varibles['title'] = $_POST['Title'];
		$varibles['content'] = $_POST['Content'];
		foreach($varibles as $key => $value){
			$template = str_replace('{{ ' . $key . ' }}', $value, $template);
		}
	}else{
		$template = $_POST['Content'];
	}
	$dir = '../../' . $_POST['Title'] . '.php';
	if(isset($_POST['old'])){
		unlink("../../{$_POST['old']}.php");
	}
	$newpage = fopen($dir, "w");
	fwrite($newpage, $template);
	fclose($newpage);
	require_once("../../includes/dbconnect.php");
	$stmt = $connection->prepare("Insert INTO Pages (id, Name, Template, Publisher) Values (?, ?, ?, ?) ON Duplicate Key Update Name=Values(Name), Template=Values(Template), Publisher=Values(Publisher)");
	echo($connection->error);
	$stmt->bind_param("isss", $_POST['id'], $_POST['Title'], $_POST['template'], $_SESSION["username"]);
	$stmt->execute();
	$stmt->close();
	header("Location: " . $dir);
?> 