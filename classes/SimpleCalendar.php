<?php

/**
 * Parses a simple calendar config file to let you render list of events of some sort
 */
class SimpleCalendar {
 	
 	var $events;			//the parsed calendar file (name=>info)
 	var $configFileName;	//the name of the file to read the menu from
 	
 	/**
 	 * Build and init a simple menu object from the config file specified
 	 */
 	function SimpleCalendar($configFile){
 		$this->parseFromIniFile($configFile);
 	}
 	
 	/**
 	 * Parse a calendar config file.
 	 */
 	function parseFromIniFile($configFile){
 		//init vars to use
 		$this->configFileName = $configFile;
		//and load it up
		$this->events = parse_ini_file($this->configFileName,true);
		//echo "<pre>";print_r($this->events);echo "</pre>";
 	}
 	
 	/** 
 	 * Render the calendar as a simple unordered list.
 	 * @param		indent		optional indent to put before every line, except the first
 	 *							(likey you want to pass in something like "\t\t\t")
	 * @return					a string representation of the top level menu options
	 *							as a simple HTML unordered list, withe one list item per 
	 *							top level menu item
 	 */
 	 function eventsAsDivs($indent=""){
 	 	$out = "<div class=\"calendar\">\n";
		foreach($this->events as $eventDate=>$info){
			$dateParts = split(",",$eventDate);
			$upcoming = true;
			if(count($dateParts)==1) {
				$realDate = strtotime($dateParts[0]);
				$upcoming = $realDate>(time()-2*24*60*60);
				$dateStr = date("M jS - l",$realDate);
			} else {
				$realStartDate = strtotime($dateParts[0]);
				$realEndDate = strtotime($dateParts[1]);
				$upcoming = $realEndDate>(time()-2*24*60*60);				
				$dateStr = date("M jS &",$realStartDate);
				$dateStr.= date(" jS ",$realEndDate);
				$dateStr.= date("- D",$realStartDate);
				$dateStr.= date(" & D",$realEndDate);
			}
			if(!$upcoming) continue;		//skip events in the past
			$out.= $indent."\t<div class=\"event\">\n";
			$out.= $indent."\t\t<div class=\"date\">".$dateStr."</div>\n";
			$out.= $indent."\t\t<div class=\"name\">".$info['name']."</div>\n";
			if(array_key_exists("site",$info)) {
				$out.= $indent."\t\t<div class=\"site\">";
				if(array_key_exists("sitelink",$info)) $out.="<a href=\"".$info['sitelink']."\">";
				$out.= $info['site'];
				if(array_key_exists("sitelink",$info)) $out.="</a>";
				$out.= "</div>\n";
			}
			if(array_key_exists("location",$info)){
				$out.= $indent."\t\t<div class=\"location\">";
				$out.= "<a href=\"http://maps.google.com/maps?q=".$info['location'].",+United+States+of+America&sa=X&oi=map&ct=title\">".$info['location']."</a>";
				$out.= "</div>\n";
			}
			if(array_key_exists("description",$info)){
				$out.= $indent."\t\t<div class=\"location\">";
				$out.= $info['description'];
				$out.= "</div>\n";
			}
			$out.= $indent."\t</div>\n";
		}
 	 	$out.= $indent."</div>\n";
 	 	return $out;
 	 }

}

?>
