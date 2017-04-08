<?php 
	
	class Manager{
		//Setup
		
		function __construct(){
			$this->addons = array();
			$this->pages = array();
		}
	
		// Searches a multidimensional array for the needle and then returns that elements parent key
		private function getManifest( $needle, $haystack){
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
	
		//Searches all directories in the Addon folder for json file
		private function getPages(){
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
	
		//Given a manifest.json file it gets the pages that this addons affects
		private function affectedPages($file){
			$manifest = file_get_contents($file);
			$manifestDecoded = json_decode($manifest);
			return($manifestDecoded->{'content_scripts'}->{'matches'});
		}
	
		//Include a script without messing up the varibles
		private function includeNoVars($dir){
			include_once($dir);
		}
	
		//Get the output from the addon without getting the varibles
	
		private function includeAddon($manifest){
			$decoded = json_decode(file_get_contents($manifest));
			$scripts = $decoded->{'content_scripts'}->{'scripts'};
			$path = $manifest->getPath();
			$output = array();
			foreach($scripts as $script){
				ob_start();
				$this->includeNoVars($path . '/' . $script);
				$content = ob_get_clean();
				$output[] = $content;
			}
			return($output);
		}
	
		//Runs addons that should be run on this page
		function includeIfNeeded(){
			//__DIR__ gives the path of this file(the included file) not the file including it so this line will get that file	
			$trace = debug_backtrace();
			$callingFile = explode("/", $trace[0]['file']);
			$callingFile = end($callingFile);
			//Gets the parent index of addon that is for this page(pages is multidemensioanl)
			$index = $this->getManifest($callingFile, $this->pages);
			if($index !== false){
				//Gets the manifest file
				$manifest = $this->addons[$index];
				$return = $this->includeAddon($manifest);
				return($return);
			}
			return false;
		}
		/*
		Addon contains file objects of the addons manifest
		Pages contains array of the pages the array affects
		*/
		function setupManager(){
			$this->addons = $this->getPages();
			$this->pages = array();
			foreach($this->addons as $addon){
				$affectedPages = $this->affectedPages($addon);
				$this->pages[] = $affectedPages;
			}
		}
		
	}
	
	$wkdir = getcwd();
	chdir(__DIR__);
	$manager = new Manager;
	// $manager->setupManager();
	chdir($wkdir);
	
?>