<?php

define("MENU_URL","url");
define("MENU_PAGES","pages");
define("MENU_NAME","name");
define("MENU_TREE","tree");

/**
 * Parses a simple menu config file to let you render menus of some sort
 */
class SimpleMenu {
 	
 	var $menu;				//the parsed menu (name=>url,pages*
 	var $pages;				//map from page to where it is in hierarchy
 	var $configFileName;	//the name of the file to read the menu from
 	
 	/**
 	 * Build and init a simple menu object from the config file specified
 	 */
 	function SimpleMenu($configFile){
 		$this->parseFromTxtFile($configFile);
 	}
 	
 	/**
 	 * Parse a custom menu config file.
 	 */
 	function parseFromTxtFile($configFile){
 		//init vars to use
 		$this->configFileName = $configFile;
		$this->menu = array();	//the menu hierarchy
		$this->pages = array();
		$menuItems = file($this->configFileName);
		$lastGItem="";
		foreach($menuItems as $item){
			if($item[0]=="#") continue;			//# is comment
			if(trim($item)=="") continue;		//skip empty lines
			$parts = explode("|",$item);		//split to get human text
			if(count($parts)!=2) continue;		//skip malformed lines
			list($fileName,$menuName) = $parts;	//pull parts into variables
			//add it to the menu hierarchy map
			$subPage = ($fileName[0]<'0'); 	//global items start with with space or tab
			$fileName = trim($fileName);
			$menuName = trim($menuName);
			if($subPage){			//handle sub items
				$this->menu[$lastGItem][MENU_PAGES][$menuName]=array(MENU_URL=>$fileName);		
			} else {				//handle global level items
				$fileName = trim($fileName);
				$this->menu[$menuName] = array(MENU_URL=>$fileName,MENU_PAGES=>array());
				$lastGItem = $menuName;	//add subs under here
			}
			//add it to the page lookup map
			if($subPage){
				$this->pages[$fileName]=array(MENU_NAME=>$menuName,MENU_TREE=>array($lastGItem,$menuName));		
			} else {				//handle global level items
				$this->pages[$fileName]=array(MENU_NAME=>$menuName,MENU_TREE=>array($lastGItem));		
			}
		}
		//echo "<pre>";print_r($this->menu);echo "</pre>"; 
 	}
 	
 	/** 
 	 * Render the menu as a simple unordered list (with the current one marked as selected).
 	 * @param		thisPage	the file name of the current page (to mark one menu item as
 	 *							selected)
 	 * @param		indent		optional indent to put before every line, except the first
 	 *							(likey you want to pass in something like "\t\t\t")
	 * @return					a string representation of the top level menu options
	 *							as a simple HTML unordered list, withe one list item per 
	 *							top level menu item
 	 */
 	 function topLevelAsList($thisPage,$indent=""){
		//now build the list
 	 	$out = "<ul>\n";
		foreach($this->menu as $menuName=>$menuInfo){
			$out.= $indent."\t<li";
			if($menuInfo[MENU_URL]==$thisPage) $out.=" class=\"selected\" ";
			$out.="><a href=\"".$menuInfo[MENU_URL]."\">$menuName</a></li>\n";
		}
 	 	$out.= $indent."</ul>\n";
 	 	return $out;
 	 }

}

?>
