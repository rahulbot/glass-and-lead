<?php

// constants referred to throughout the site
define("CLASSES_DIR","classes/");
define("MENU_CONFIG_FILE","config/menu.txt");
define("CALENDAR_CONFIG_FILE","config/calendar.txt");

// required files for the site to run
require_once(CLASSES_DIR."SimpleMenu.php");
require_once(CLASSES_DIR."SimpleCalendar.php");

//global objects that help render the page
$globalMenu = new SimpleMenu(MENU_CONFIG_FILE);
$calendar = new SimpleCalendar(CALENDAR_CONFIG_FILE);

?>