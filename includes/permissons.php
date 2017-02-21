<?php

	//API that makes sure user has correct permisson to access page
	
	session_start();
	
	function toPath($path){
		$path = explode("Admin", $path)[1];
		$down = substr_count($path, '/');
		$returnPath = "";
		for($i = 0; $i<$down; $i++){
			$returnPath .= '../';
		}
		return($returnPath);
	}
	
	class Permissons{
	
		function __construct($rank, $connection){
			if(!$rank){
				$path = toPath(getcwd());
				header("Location: {$path}../login.php");
			}else{
				$this->rank = $rank;
				$this->connection = $connection;
				$this->enabled = $_SESSION['enabled'];
			}	
		}
		
		public function hasPermisson($permissons, $act = TRUE){
			//Get permissons user has
			if($this->enabled == 0){
				$stmt = $this->connection->prepare("Select PreviousPermissons From Ranks Where Id = ?");
			}else{
				$stmt = $this->connection->prepare("Select Premissons From Ranks Where Id = ?");
			}
			echo($this->connection->error);
			$stmt->bind_param("i", $this->rank);
			$stmt->execute();
			$stmt->bind_result($user_permissons);
			$stmt->fetch();
			$stmt->close();
			//Get permissons user needs
			$permissonStmt = $this->connection->prepare("Select Inherited From Premissons Where Name = ?");
			for($i=0;$i<count($permissons);$i++){
				$permissonStmt->bind_param("s", $permissons[$i]);
				$permissonStmt->execute();
				$permissonStmt->bind_result($inherited);
				$permissonStmt->fetch();
				if($inherited !== NULL){
					$permissons[] = $inherited;
				}
			}
			$permissonStmt->close();
			//Check to see if they have any
			$intersectingPremissons = array_intersect($permissons, explode(",", $user_permissons));
			if($intersectingPremissons == NULL){
				if($act == TRUE){
					$current = getcwd();
					$path = toPath($current);
					header("Location: {$path}index.php?denied");
					die();
				}else{
					return False;
				}
			}else{
				return true;
			}
		}
	
	}
	

?>