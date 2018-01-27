<?php
	session_start();
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$type = "user";
	if(isset($_GET['confirm'])){
		$p->hasPermisson(['Admin']);
		//Change the rank
		$stmt = $connection->prepare("Update Users Set Rank = RequestedRank, RequestedRank = NULL Where id = ?");
		$stmt->bind_param("i", $_GET['confirm']);
		$stmt->execute();
		$stmt->close();
		//Check if a email should be sent
		$stmt = $connection->prepare("Select Subject, Message, Headers From Email Where ReceiverId = ?");
		$stmt->bind_param("i", $_GET['confirm']);
		$stmt->execute();
		$stmt->bind_result($subject, $message, $headers);
		$stmt->fetch();
		$stmt->close();
		if($subject != ""){
			//Get the users email
			$emailStmt = $connection->prepare("Select Email From Users Where id = ?");
			$emailStmt->bind_param("i", $_GET['confirm']);
			$emailStmt->execute();
			$emailStmt->bind_result($email);
			$emailStmt->fetch();
			mail($email, $subject, $message, $headers);
		}
		header("Location: ../index.php");
		exit();
	}
	elseif(isset($_POST['Delete'])){
		$p->hasPermisson(["User_Delete"]);
		$stmt = $connection->prepare("Delete From Users Where id = ?");
		$stmt->bind_param('i', $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$action="deleted";
		$name = isset($_POST['username']) ? $_POST['email'] : $_POST['username'];
		insertActivity($connection, $name, $_SESSION['id'], NULL, $type, $action);
	}else{
		$p->hasPermisson(["User_Edit"]);
		$requestedRank == NULL;
		$authorized = areAuthorized($_SESSION['rank'], $_POST['rank'], $connection);
		if($authorized == FALSE){
			#Get rank of user
			$requestedRank = $_POST['rank'];
			$stmt = $connection->prepare("Select Rank From Users Where id = ?");
			$stmt->bind_param("i", $_POST['id']);
			$stmt->execute();
			$stmt->bind_result($userRank);
			$stmt->fetch();
			$stmt->close();
			$_POST['rank'] = $userRank; 
		}
		$stmt = $connection->prepare("UPDATE Users Set Email=?, Username=?, Rank=?, Modified = ?, UserId = ?, RequestedRank = ? Where id=?");
		$stmt->bind_param("ssssiii", $_POST['email'], $_POST['username'], $_POST['rank'], $time, $_SESSION['id'], $requestedRank, $_POST['id']);
		$stmt->execute();
		$stmt->close();
		$id = $connection->insert_id;
		$action = "edited";
		insertActivity($connection, $_POST['username'], $_SESSION['id'], intval($_POST['id']), $type, $action);
		if($_SESSION['id'] == $_POST['id']){
			$_SESSION['rank'] = $_POST['rank'];
		}
	}
	header("Location: ../users.php")
?>