<?php
	
	$filters = array();
	
	class api{
		
		function add_action($name, $function){
			global $filters;
			$filters[$name] = $function;
			// $_SESSION['filters'] = $this->filters;
			// var_dump("Finished adding");
		}
		
		function do_actions($name){
			global $filters;
			if(array_key_exists($name, $filters)){
				$filters[$name]();
			}
		}
		
		private function toPath($path){
			$path = explode("Admin", $path)[1];
			$down = substr_count($path, '/');
			$returnPath = "";
			for($i = 0; $i<$down; $i++){
				$returnPath .= '../';
			}
			return($returnPath);
		}
		
		function accessDenied(){
			$path = toPath(getcwd());
			header("Location: {$path}index.php?denied");
			exit();
		}
		
	}
	
?>