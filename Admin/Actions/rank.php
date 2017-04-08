<?php
	session_start();
    if(isset($_SESSION["username"]) == FALSE){
        header("Location: ../login.html");
    }
	require_once("../../includes/dbconnect.php");
	require_once("../../includes/functions.php");
	require_once("../../includes/permissons.php");
	$p = new Permissons($_SESSION["rank"], $connection);
	$type = "rank";
	if($_GET['confirm']){
		$p->hasPermisson(['Admin']);
		$stmt = $connection->prepare("Update Ranks Set Enabled = 1 Where id = ?");
		$stmt->bind_param("i", $_GET['confirm']);
		$stmt->execute();
		$stmt->close();
		header('Location: ../index.php');
		exit();
	}elseif(isset($_POST['Delete'])){
		$p->hasPermisson(['Rank_Delete']);
		$stmt = $connection->prepare("Select Name From Ranks Where id = ?");
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->bind_result($name);
		$stmt->fetch();
		$stmt->close();
		$stmt = $connection->prepare("Delete From Ranks Where id = ?");
		$stmt->bind_param("i", $_POST['Delete']);
		$stmt->execute();
		$stmt->close();
		$action="deleted";
		insertActivity($connection, $name, $_SESSION['id'], NULL, $type, $action);
		header("Location: ../ranks.php");
	}else{
		$p->hasPermisson(['Rank_Create', 'Rank_Edit']);
		$time = NULL;
		$enabled = 1;
		$premissonsPosted = implode(',', $_POST['Premissons']);
		//Get the premissons of the rank before it is changed
		$stmt = $connection->prepare("Select Premissons, PreviousPermissons, enabled From Ranks Where id = ?");
		$stmt->bind_param("i", $_POST['Id']);
		$stmt->execute();
		$stmt->bind_result($premissons, $previousPermissons, $previousStatus);
		$stmt->fetch();
		$stmt->close();
		//Check if changed the ranks permisons
		if($premissons != $premissonsPosted){
			//Check if setting back to previous premissons
			if($premissonsPosted == $previousPermissons){
				$enabled = 1;
			}else{
				//Check to see if they are creating person with their permisson
				$userPremissons = userPermissons($_SESSION['rank'], $connection);
				$userPremissons = explode(",", $userPremissons);
				$userPremissons = getDissolved($userPremissons, $connection);
				$postedPremissons = getDissolved($_POST['Premissons'], $connection);
				$differentPremissons = array_diff($postedPremissons, $userPremissons);	
				if($differentPremissons != []){
					$enabled = 0;
					if($_POST['Id'] == $_SESSION["rank"]){
						header("Location: ../ranks.php?refer");
						exit();
					}
				}
			}
		}
		if($previousStatus == 0){
			$premissons = $previousPermissons;
		}
		$stmt = $connection->prepare("INSERT INTO Ranks (Id, Name, Premissons, Modified, Created, UserId, Enabled, PreviousPermissons) Values (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE Name=Values(Name), Premissons=Values(Premissons), Modified=Values(Modified), UserId=Values(UserId), Enabled=Values(Enabled), PreviousPermissons=Values(PreviousPermissons)");
		$stmt->bind_param("issssiis", $_POST['Id'], $_POST['Name'], $premissonsPosted, $time, $time, $_SESSION['id'], $enabled, $premissons);
		$stmt->execute();
		$action = $_POST['Id'] == "" ? "created" : "modified";
		$id = $connection->insert_id;
		insertActivity($connection, $_POST['Name'], $_SESSION['id'], intval($id), $type, $action);
		header("Location: ../ranks.php");
	}
?>