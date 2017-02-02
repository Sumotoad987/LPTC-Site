<?php

	//API that makes sure user has correct permisson to access page
	
	function toPath($path){
		$path = explode("Admin", $path)[1];
		$down = substr_count($path, '/');
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
			}	
		}
		
		public function hasPermisson($permissons){
			//Get permissons user has
			$stmt = $this->connection->prepare("Select Premissons From Ranks Where Name = ?");
			$stmt->bind_param("s", $this->rank);
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
				$current = getcwd();
				$path = toPath($current);
				header("Location: {$path}/index.php?denied");
				die();
			}else{
				return true;
			}
		}
	
	}
	

?>