<?php
	
	/* 
		MANAGER:
		
		Manages the addons for each page.
			-Loads the Manifests and stores what pages they affect
			-Loads the addons
	*/
	
	class Manager{
		
		// Searches a multidimensional array for the needle and then returns that elements parent key
		private function searchMulti( $needle, $haystack){
			$i = 0;
			foreach($haystack as $hay){
				foreach($hay as $straw){
					if($straw == $needle){
						return($i);
					}
				}
				$i += 1;
			}
			return false;
		}
		
		//Gets all the json files in the Addon directory and its subdirectory and stores they manifest files	
		
		private function getManifests(){
			$di = new RecursiveDirectoryIterator("../Admin/Addons");
			$it = new RecursiveIteratorIterator($di);
			$files = array();	
			foreach($it as $file){
				if(pathinfo($file, PATHINFO_EXTENSION) == "json"){
					$files[] = $file;
				}
			}
			return($files);
		}
		
		//Takes a manifest file, loads it json and returns the pages it affects
		
		private function affectedPages($file){
			$manifest = file_get_contents($file);
			$manifestDecoded = json_decode($manifest);
			return($manifestDecoded->{'content_scripts'}->{'matches'});
		}
		
		//Loads the addons that need to be loaded for the page calling this
		
		function loadAddons(){
			//__DIR__ gives the path of this file(the included file) not the file including it so this line will get that file	
			$trace = debug_backtrace();
			$callingFile = explode("/", $trace[0]['file']);
			$callingFile = end($callingFile);
			/* 
				***Gets the parent index of the addon that is for this page***
				Since $pages is like [[a.php, b.php], [c.php]] and $addons is like [1.php, 2.php] we need to get the parent index
			*/
			$index = $this->searchMulti($callingFile, $this->pages);
			if($index !== false){
				//Changes working directory
				$currentwd = getcwd();
				chdir(__DIR__);
				$manifest = $this->addons[$index];
				//Decodes the json file to get the php that should be run
				$decoded = json_decode(file_get_contents($manifest));
				$scripts = $decoded->{'content_scripts'}->{'scripts'};
				//Gets the location of the addon
				$path = $manifest->getPath();
				//Includes the addon
				foreach($scripts as $script){
					include($path . '/' . $script);
				}
				chdir($currentwd);
			}
		}
		
		//Setups the Manager class
		function __construct(){
			$currentwd = getcwd();
			chdir(__DIR__);
			//Define the varibles
			$this->addons = $this->getManifests();
			$this->pages = array();
			//Get the affected pages for each addon
			foreach($this->addons as $addon){
				$this->pages[] = $this->affectedPages($addon);
			}
			chdir($currentwd);
		}
		
	
	}

?>